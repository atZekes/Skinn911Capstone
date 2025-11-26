<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class BookingSessionSeeder extends Seeder
{
    public function run(): void
    {
        // Configuration: Total 100 completed bookings
        $totalBookings = 100;
        $packageBookingRatio = 0.4; // 40% packages, 60% services
        $walkinCount = 0; // 0 walk-ins
        $clientBookingCount = $totalBookings - $walkinCount; // 100 client bookings

        $packageBookingsCount = (int)($clientBookingCount * $packageBookingRatio); // ~40 package bookings
        $serviceBookingsCount = $clientBookingCount - $packageBookingsCount; // ~60 service bookings

        // Get data - ONLY email verified clients for bookings
        $userIds = DB::table('users')
            ->where('role', 'client')
            ->whereNotNull('email_verified_at')
            ->pluck('id')
            ->toArray();
        $serviceIds = DB::table('services')->pluck('id')->toArray();
        $packageIds = DB::table('packages')->pluck('id')->toArray();
        $branchIds = DB::table('branches')->pluck('id')->toArray();

        if (empty($userIds)) {
            $this->command->warn('No email-verified client users found. Skipping seeder.');
            return;
        }

        if (empty($branchIds)) {
            $this->command->warn('No branches found. Skipping seeder.');
            return;
        }

        // Get branch-service prices
        $defaultServicePrices = DB::table('services')->pluck('price', 'id');
        $serviceDefaultSessions = DB::table('services')->pluck('default_sessions', 'id');

        // Get package data
        $packageData = DB::table('packages')->get()->keyBy('id');

        $timeSlots = ['09:00-10:00', '10:00-11:00', '11:00-12:00', '13:00-14:00', '14:00-15:00', '15:00-16:00', '16:00-17:00'];
        $statuses = ['completed', 'cancelled', 'refunded', 'active'];
        $statusWeights = [60, 15, 5, 20]; // 60% completed, 20% active, 15% cancelled, 5% refunded

        $this->command->info("Creating {$packageBookingsCount} package bookings...");

        // Create package bookings
        for ($i = 0; $i < $packageBookingsCount; $i++) {
            if (empty($packageIds)) break;

            $userId = $userIds[array_rand($userIds)];
            $packageId = $packageIds[array_rand($packageIds)];
            $branchId = $branchIds[array_rand($branchIds)];
            $package = $packageData[$packageId];

            // All bookings are past completed bookings
            $daysAgo = rand(1, 365);
            $bookingDate = Carbon::now()->subDays($daysAgo);
            $status = 'completed';

            [$paymentStatus, $sessionStatus] = $this->getPaymentAndSessionStatus($status);

            // Calculate total package price based on service table prices only
            $packageServiceRows = DB::table('package_service')->where('package_id', $packageId)->get();
            $totalPackagePrice = 0;
            foreach ($packageServiceRows as $ps) {
                // Use capped service price for package components
                $totalPackagePrice += $this->getServicePrice($ps->service_id, $defaultServicePrices);
            }
            if ($totalPackagePrice == 0) {
                $totalPackagePrice = $package->price ?? 5000;
            }

            $bookingId = DB::table('bookings')->insertGetId([
                'user_id' => $userId,
                'package_id' => $packageId,
                'branch_id' => $branchId,
                'date' => $bookingDate,
                'time_slot' => $timeSlots[array_rand($timeSlots)],
                'status' => $status,
                'payment_status' => $paymentStatus,
                'created_at' => $bookingDate,
                'updated_at' => $bookingDate,
            ]);

            // Create package session
            $totalSessions = max(1, $package->total_sessions ?? 5);
            $sessionsUsed = $totalSessions; // All completed
            $sessionsRemaining = 0;

            // Get first service from package for service_id
            $packageServices = DB::table('package_service')->where('package_id', $packageId)->first();
            $serviceIdForSession = $packageServices ? $packageServices->service_id : ($serviceIds[0] ?? 1);

            DB::table('client_package_sessions')->insert([
                'booking_id' => $bookingId,
                'user_id' => $userId,
                'service_id' => $serviceIdForSession,
                'branch_id' => $branchId,
                'total_sessions' => $totalSessions,
                'sessions_used' => $sessionsUsed,
                'sessions_remaining' => $sessionsRemaining,
                'status' => 'completed',
                'total_price' => $totalPackagePrice,
                'payment_status' => $paymentStatus,
                'payment_method' => 'cash',
                'purchase_date' => $bookingDate->copy()->subDays(rand(0, 30)),
                'expiry_date' => $bookingDate->copy()->addDays(rand(30, 180)),
                'last_completed_session_date' => $bookingDate->copy()->subDays(rand(0, 10)),
                'created_at' => $bookingDate,
                'updated_at' => $bookingDate,
            ]);

            DB::table('transactions')->insert([
                'booking_id' => $bookingId,
                'package_id' => $packageId,
                'amount' => $totalPackagePrice,
                'payment_method' => $paymentStatus === 'refunded' ? 'refund' : 'cash',
                'branch_id' => $branchId,
                // staff_id removed
                'created_at' => $bookingDate,
                'updated_at' => $bookingDate,
            ]);
        }

        $this->command->info("Creating {$serviceBookingsCount} service bookings...");

        // Create service bookings
        for ($i = 0; $i < $serviceBookingsCount; $i++) {
            if (empty($serviceIds)) break;

            $userId = $userIds[array_rand($userIds)];
            $serviceId = $serviceIds[array_rand($serviceIds)];
            $branchId = $branchIds[array_rand($branchIds)];

            $servicePrice = $this->getServicePrice($serviceId, $defaultServicePrices);
            // All bookings are past completed bookings
            $daysAgo = rand(1, 365);
            $bookingDate = Carbon::now()->subDays($daysAgo);
            $status = 'completed';

            [$paymentStatus, $sessionStatus] = $this->getPaymentAndSessionStatus($status);

            $bookingId = DB::table('bookings')->insertGetId([
                'user_id' => $userId,
                'service_id' => $serviceId,
                'branch_id' => $branchId,
                'date' => $bookingDate,
                'time_slot' => $timeSlots[array_rand($timeSlots)],
                'status' => $status,
                'payment_status' => $paymentStatus,
                'created_at' => $bookingDate,
                'updated_at' => $bookingDate,
            ]);

            // Create session tracking for multi-session services
            $defaultSessions = $serviceDefaultSessions[$serviceId] ?? 1;
            if ($defaultSessions > 1) {
                $totalSess = rand(max(2, $defaultSessions), max(2, $defaultSessions) + 5);
                $used = $totalSess; // All completed
                $remaining = 0;

                DB::table('client_package_sessions')->insert([
                    'booking_id' => $bookingId,
                    'user_id' => $userId,
                    'service_id' => $serviceId,
                    'branch_id' => $branchId,
                    'total_sessions' => $totalSess,
                    'sessions_used' => $used,
                    'sessions_remaining' => $remaining,
                    'status' => 'completed',
                    'total_price' => $servicePrice * $totalSess,
                    'payment_status' => $paymentStatus,
                    'payment_method' => 'cash',
                    'purchase_date' => $bookingDate->copy()->subDays(rand(0, 30)),
                    'expiry_date' => $bookingDate->copy()->addDays(rand(30, 180)),
                    'last_completed_session_date' => $bookingDate->copy()->subDays(rand(0, 10)),
                    'created_at' => $bookingDate,
                    'updated_at' => $bookingDate,
                ]);
            }

            DB::table('transactions')->insert([
                'booking_id' => $bookingId,
                'service_id' => $serviceId,
                'amount' => $servicePrice,
                'payment_method' => $paymentStatus === 'refunded' ? 'refund' : 'cash',
                'branch_id' => $branchId,
                'created_at' => $bookingDate,
                'updated_at' => $bookingDate,
            ]);

            if (Schema::hasTable('purchased_services')) {
                $serviceName = DB::table('services')->where('id', $serviceId)->value('name');
                $psData = [
                    'booking_id' => $bookingId,
                    'user_id' => $userId,
                    'service_id' => $serviceId,
                    'price' => $servicePrice,
                    'promo_code' => null,
                    'description' => $serviceName,
                    'status' => 'active',
                    'total_sessions' => 1,
                    'sessions_used' => 1, // Completed
                    'sessions_remaining' => 0,
                    'session_status' => 'completed',
                    'created_at' => $bookingDate,
                    'updated_at' => $bookingDate,
                ];
                if (Schema::hasColumn('purchased_services', 'branch_id')) {
                    $psData['branch_id'] = $branchId;
                }
                DB::table('purchased_services')->insert($psData);
            }
        }

        // Walk-ins are removed from seeding by setting $walkinCount = 0.

        $this->command->info("Successfully created {$totalBookings} completed bookings ({$packageBookingsCount} packages, {$serviceBookingsCount} services, {$walkinCount} walk-ins)");
    }

    private function weightedRandom(array $values, array $weights): string
    {
        $totalWeight = array_sum($weights);
        $random = rand(1, $totalWeight);
        $sum = 0;
        foreach ($values as $i => $value) {
            $sum += $weights[$i];
            if ($random <= $sum) {
                return $value;
            }
        }
        return $values[0];
    }

    private function getPaymentAndSessionStatus(string $status): array
    {
        // Only 'pending' and 'paid' are allowed for payment_status
        if ($status === 'refunded' || $status === 'cancelled') {
            return ['pending', $status];
        } elseif ($status === 'completed') {
            return ['paid', 'completed'];
        } else { // active
            return ['paid', 'active'];
        }
    }

    private function getServicePrice($serviceId, $defaultServicePrices)
    {
        $price = $defaultServicePrices[$serviceId] ?? 1000;
        // Cap the price at 10,000
        return min($price, 10000);
    }
}
