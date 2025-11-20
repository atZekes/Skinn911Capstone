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
        // Configuration: Total 1000 bookings
        $totalBookings = 500;
        $packageBookingRatio = 0.4; // 40% packages, 60% services
        $walkinCount = 25; // 100 walk-ins
        $clientBookingCount = $totalBookings - $walkinCount; // 900 client bookings

        $packageBookingsCount = (int)($clientBookingCount * $packageBookingRatio); // ~360 package bookings
        $serviceBookingsCount = $clientBookingCount - $packageBookingsCount; // ~540 service bookings

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
        $branchServicePrices = DB::table('branch_service')->get()->groupBy('branch_id')->map(function($group) {
            return $group->keyBy('service_id');
        });
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

            // Randomly create bookings in past (365 days) OR future (30 days)
            if (rand(0, 1)) {
                // Future booking (next 30 days)
                $daysAhead = rand(0, 30);
                $bookingDate = Carbon::now()->addDays($daysAhead);
                $status = 'active';
            } else {
                // Past booking (last 365 days)
                $daysAgo = rand(1, 365);
                $bookingDate = Carbon::now()->subDays($daysAgo);
                $status = $this->weightedRandom($statuses, $statusWeights);
            }

            [$paymentStatus, $sessionStatus] = $this->getPaymentAndSessionStatus($status);

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
            $sessionsUsed = $status === 'active' ? rand(0, max(0, $totalSessions - 1)) : ($status === 'completed' ? $totalSessions : 0);
            $sessionsRemaining = max(0, $totalSessions - $sessionsUsed);

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
                'status' => $sessionsRemaining > 0 ? 'active' : ($status === 'refunded' ? 'refunded' : 'completed'),
                'total_price' => $package->price ?? 5000,
                'payment_status' => $paymentStatus,
                'payment_method' => 'cash',
                'purchase_date' => $bookingDate->copy()->subDays(rand(0, 30)),
                'expiry_date' => $bookingDate->copy()->addDays(rand(30, 180)),
                'last_completed_session_date' => $sessionsUsed > 0 ? $bookingDate->copy()->subDays(rand(0, 10)) : null,
                'created_at' => $bookingDate,
                'updated_at' => $bookingDate,
            ]);

            DB::table('transactions')->insert([
                'booking_id' => $bookingId,
                'package_id' => $packageId,
                'amount' => $package->price ?? 5000,
                'payment_method' => $paymentStatus === 'refunded' ? 'refund' : 'cash',
                'branch_id' => $branchId,
                'staff_id' => null,
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

            $servicePrice = $this->getServicePrice($serviceId, $branchId, $branchServicePrices, $defaultServicePrices);
            // Randomly create bookings in past (365 days) OR future (30 days)
            if (rand(0, 1)) {
                // Future booking (next 30 days)
                $daysAhead = rand(0, 30);
                $bookingDate = Carbon::now()->addDays($daysAhead);
                $status = 'active';
            } else {
                // Past booking (last 365 days)
                $daysAgo = rand(1, 365);
                $bookingDate = Carbon::now()->subDays($daysAgo);
                $status = $this->weightedRandom($statuses, $statusWeights);
            }

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
            if ($status === 'active' && $defaultSessions > 1) {
                $totalSess = rand(max(2, $defaultSessions), max(2, $defaultSessions) + 5);
                $used = rand(0, max(0, $totalSess - 1));
                $remaining = max(0, $totalSess - $used);

                DB::table('client_package_sessions')->insert([
                    'booking_id' => $bookingId,
                    'user_id' => $userId,
                    'service_id' => $serviceId,
                    'branch_id' => $branchId,
                    'total_sessions' => $totalSess,
                    'sessions_used' => $used,
                    'sessions_remaining' => $remaining,
                    'status' => $remaining > 0 ? 'active' : 'completed',
                    'total_price' => $servicePrice * $totalSess,
                    'payment_status' => $paymentStatus,
                    'payment_method' => 'cash',
                    'purchase_date' => $bookingDate->copy()->subDays(rand(0, 30)),
                    'expiry_date' => $bookingDate->copy()->addDays(rand(30, 180)),
                    'last_completed_session_date' => $used > 0 ? $bookingDate->copy()->subDays(rand(0, 10)) : null,
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
                'staff_id' => null,
                'created_at' => $bookingDate,
                'updated_at' => $bookingDate,
            ]);

            if (Schema::hasTable('purchased_services')) {
                $psData = [
                    'booking_id' => $bookingId,
                    'user_id' => $userId,
                    'service_id' => $serviceId,
                    'price' => $servicePrice,
                    'created_at' => $bookingDate,
                    'updated_at' => $bookingDate,
                ];
                if (Schema::hasColumn('purchased_services', 'branch_id')) {
                    $psData['branch_id'] = $branchId;
                }
                DB::table('purchased_services')->insert($psData);
            }
        }

        $this->command->info("Creating {$walkinCount} walk-in bookings...");

        // Create walk-in bookings
        $faker = Faker::create();
        for ($i = 0; $i < $walkinCount; $i++) {
            $branchId = $branchIds[array_rand($branchIds)];
            $serviceId = $serviceIds[array_rand($serviceIds)];
            $servicePrice = $this->getServicePrice($serviceId, $branchId, $branchServicePrices, $defaultServicePrices);

            $walkinName = $faker->name();
            $walkinEmail = 'walkin_' . Str::slug(strtolower($walkinName)) . '_' . time() . '_' . $i . '@example.test';
            $walkinId = DB::table('users')->insertGetId([
                'name' => $walkinName,
                'email' => $walkinEmail,
                'password' => Hash::make('password'),
                'role' => 'client',
                'created_at' => Carbon::now()->subDays(rand(1, 365)),
                'updated_at' => Carbon::now()->subDays(rand(1, 365)),
            ]);

            // Randomly create walk-in bookings in past (180 days) OR future (30 days)
            if (rand(0, 1)) {
                // Future booking (next 30 days)
                $daysAhead = rand(0, 30);
                $bookingDate = Carbon::now()->addDays($daysAhead);
                $walkinStatus = 'active';
            } else {
                // Past booking (last 180 days)
                $daysAgo = rand(1, 180);
                $bookingDate = Carbon::now()->subDays($daysAgo);
                $walkinStatus = 'completed';
            }

            $bookingId = DB::table('bookings')->insertGetId([
                'user_id' => $walkinId,
                'service_id' => $serviceId,
                'branch_id' => $branchId,
                'date' => $bookingDate,
                'time_slot' => $timeSlots[array_rand($timeSlots)],
                'status' => $walkinStatus,
                'payment_status' => 'paid',
                'created_at' => $bookingDate,
                'updated_at' => $bookingDate,
            ]);

            DB::table('transactions')->insert([
                'booking_id' => $bookingId,
                'service_id' => $serviceId,
                'amount' => $servicePrice,
                'payment_method' => 'cash',
                'branch_id' => $branchId,
                'staff_id' => null,
                'created_at' => $bookingDate,
                'updated_at' => $bookingDate,
            ]);
        }

        $this->command->info("Successfully created 1000 bookings (360 packages, 540 services, 100 walk-ins)");
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

    private function getServicePrice($serviceId, $branchId, $branchServicePrices, $defaultServicePrices)
    {
        if (isset($branchServicePrices[$branchId][$serviceId]) && $branchServicePrices[$branchId][$serviceId]->price !== null) {
            return $branchServicePrices[$branchId][$serviceId]->price;
        }
        return $defaultServicePrices[$serviceId] ?? 1000;
    }
}
