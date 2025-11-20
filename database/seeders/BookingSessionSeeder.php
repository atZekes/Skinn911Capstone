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
        // Example users (replace with real user IDs if needed)
        $userIds = DB::table('users')->where('role', 'client')->pluck('id');
        $serviceIds = DB::table('services')->pluck('id');
        $branchIds = DB::table('branches')->pluck('id');
        $branchIdList = $branchIds->toArray();
        $branchCount = count($branchIdList);

        // Get all branch-service prices as a lookup: [branch_id][service_id] => price
        $branchServicePrices = DB::table('branch_service')->get()->groupBy('branch_id')->map(function($group) {
            return $group->keyBy('service_id');
        });
        // Get default service prices as a lookup: [service_id] => price
        $defaultServicePrices = DB::table('services')->pluck('price', 'id');
        // Get default sessions for services: [service_id] => default_sessions
        $serviceDefaultSessions = DB::table('services')->pluck('default_sessions', 'id');
        $timeSlots = ['09:00-10:00', '10:00-11:00', '11:00-12:00', '13:00-14:00', '14:00-15:00', '15:00-16:00', '16:00-17:00'];

        foreach ($userIds as $userId) {
            foreach ($serviceIds as $serviceId) {
                $branch_id = $branchIdList[array_rand($branchIdList)];
                $randomTimeSlot = $timeSlots[array_rand($timeSlots)];
                if (isset($branchServicePrices[$branch_id][$serviceId]) && $branchServicePrices[$branch_id][$serviceId]->price !== null) {
                    $servicePrice = $branchServicePrices[$branch_id][$serviceId]->price;
                } elseif (isset($defaultServicePrices[$serviceId]) && $defaultServicePrices[$serviceId] !== null) {
                    $servicePrice = $defaultServicePrices[$serviceId];
                } else {
                    $servicePrice = 1000;
                }
                // Generate a random date in the past year
                $daysAgo = rand(1, 365);
                $bookingDate = Carbon::now()->subDays($daysAgo);
                // Randomize booking status; include 'active' more often so we have active bookings with sessions
                $statuses = ['completed', 'cancelled', 'refunded', 'active', 'active'];
                $status = $statuses[array_rand($statuses)];

                // map status to payment_status and client session status
                $paymentStatus = 'paid';
                $sessionStatus = 'active';
                $sessionsRemaining = rand(1, 5);
                if ($status === 'refunded') {
                    $paymentStatus = 'refunded';
                    $sessionStatus = 'refunded';
                    $sessionsRemaining = 0;
                } elseif ($status === 'cancelled') {
                    // cancelled bookings keep sessions active but mark payment pending
                    $paymentStatus = 'pending';
                    $sessionStatus = 'active';
                }

                $bookingId = DB::table('bookings')->insertGetId([
                    'user_id' => $userId,
                    'service_id' => $serviceId,
                    'branch_id' => $branch_id,
                    'date' => $bookingDate,
                    'time_slot' => $randomTimeSlot,
                    'status' => $status,
                    'payment_status' => $paymentStatus,
                    'created_at' => $bookingDate,
                    'updated_at' => $bookingDate,
                ]);

                // Create client_package_sessions only for active bookings and only if the service supports multiple sessions
                $svcDefaultSessions = $serviceDefaultSessions[$serviceId] ?? 1;
                if ($status === 'active' && $svcDefaultSessions > 1) {
                    $cpsPaymentStatus = ($paymentStatus === 'refunded') ? 'paid' : $paymentStatus;

                    $totalSess = rand(5, 10);
                    $used = rand(0, min(4, $totalSess));
                    $remaining = max(0, $totalSess - $used);

                    DB::table('client_package_sessions')->insert([
                        'booking_id' => $bookingId,
                        'user_id' => $userId,
                        'service_id' => $serviceId,
                        'branch_id' => $branch_id,
                        'total_sessions' => $totalSess,
                        'sessions_used' => $used,
                        'sessions_remaining' => $remaining,
                        'status' => $remaining > 0 ? 'active' : 'completed',
                        'total_price' => $servicePrice * $totalSess,
                        'payment_status' => $cpsPaymentStatus,
                        'payment_method' => 'cash',
                        'purchase_date' => $bookingDate->copy()->subDays(rand(0, 30)),
                        'expiry_date' => $bookingDate->copy()->addDays(rand(30, 180)),
                        'last_completed_session_date' => $used > 0 ? $bookingDate->copy()->subDays(rand(0, 10)) : null,
                        'created_at' => $bookingDate,
                        'updated_at' => $bookingDate,
                    ]);
                }

                // Create a transaction for each booking and link to booking (guard columns existing on the DB)
                $txData = [
                    'service_id' => $serviceId,
                    'amount' => $servicePrice,
                    'payment_method' => ($paymentStatus === 'refunded') ? 'refund' : 'cash',
                    'created_at' => $bookingDate,
                    'updated_at' => $bookingDate,
                ];
                if (Schema::hasColumn('transactions', 'booking_id')) {
                    $txData['booking_id'] = $bookingId;
                }
                if (Schema::hasColumn('transactions', 'branch_id')) {
                    $txData['branch_id'] = $branch_id;
                }
                if (Schema::hasColumn('transactions', 'staff_id')) {
                    $txData['staff_id'] = null;
                }
                DB::table('transactions')->insert($txData);

                // If purchased_services table exists, add a purchased_services row for client bookings (not walk-ins)
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
                        $psData['branch_id'] = $branch_id;
                    }
                    DB::table('purchased_services')->insert($psData);
                }
            }
        }

        // Additionally, create some active bookings (with sessions) for services that support sessions
        $activeCount = 30;
        $clientIds = $userIds->toArray();
        $eligibleServices = $serviceDefaultSessions->filter(function($s){ return $s > 1; })->keys()->toArray();

        for ($i = 0; $i < $activeCount; $i++) {
            if (empty($clientIds) || empty($eligibleServices)) break;
            $userId = $clientIds[array_rand($clientIds)];
            $serviceId = $eligibleServices[array_rand($eligibleServices)];
            $branch_id = $branchIdList[array_rand($branchIdList)];
            $servicePrice = isset($branchServicePrices[$branch_id][$serviceId]) && $branchServicePrices[$branch_id][$serviceId]->price !== null
                ? $branchServicePrices[$branch_id][$serviceId]->price
                : ($defaultServicePrices[$serviceId] ?? 1000);

            $daysAgo = rand(0, 30);
            $bookingDate = Carbon::now()->subDays($daysAgo);
            $randomTimeSlot = $timeSlots[array_rand($timeSlots)];

            $bookingId = DB::table('bookings')->insertGetId([
                'user_id' => $userId,
                'service_id' => $serviceId,
                'branch_id' => $branch_id,
                'date' => $bookingDate,
                'time_slot' => $randomTimeSlot,
                'status' => 'active',
                'payment_status' => 'paid',
                'created_at' => $bookingDate,
                'updated_at' => $bookingDate,
            ]);

            // Create package sessions using service default_sessions as baseline
            $defaultSess = $serviceDefaultSessions[$serviceId] ?? 5;
            $totalSess = max(1, $defaultSess);
            $used = rand(0, max(0, $totalSess - 1));
            $remaining = max(0, $totalSess - $used);

                DB::table('client_package_sessions')->insert([
                'booking_id' => $bookingId,
                'user_id' => $userId,
                'service_id' => $serviceId,
                'branch_id' => $branch_id,
                'total_sessions' => $totalSess,
                'sessions_used' => $used,
                'sessions_remaining' => $remaining,
                'status' => $remaining > 0 ? 'active' : 'completed',
                'total_price' => $servicePrice * $totalSess,
                'payment_status' => 'paid',
                'payment_method' => 'cash',
                'purchase_date' => $bookingDate->copy()->subDays(rand(0, 30)),
                'expiry_date' => $bookingDate->copy()->addDays(rand(30, 180)),
                'last_completed_session_date' => $used > 0 ? $bookingDate->copy()->subDays(rand(0, 10)) : null,
                'created_at' => $bookingDate,
                'updated_at' => $bookingDate,
            ]);

            $txData = [
                'service_id' => $serviceId,
                'amount' => $servicePrice,
                'payment_method' => 'cash',
                'created_at' => $bookingDate,
                'updated_at' => $bookingDate,
            ];
            if (Schema::hasColumn('transactions', 'booking_id')) {
                $txData['booking_id'] = $bookingId;
            }
            if (Schema::hasColumn('transactions', 'branch_id')) {
                $txData['branch_id'] = $branch_id;
            }
            if (Schema::hasColumn('transactions', 'staff_id')) {
                $txData['staff_id'] = null;
            }
            DB::table('transactions')->insert($txData);

            // purchased_services for these client bookings (only if table exists)
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
                    $psData['branch_id'] = $branch_id;
                }
                DB::table('purchased_services')->insert($psData);
            }
        }

        // Add 20 random walk-in clients and bookings
        $faker = Faker::create();
        for ($i = 0; $i < 20; $i++) {
            $branch_id = $branchIdList[array_rand($branchIdList)];
            $serviceId = $serviceIds->random();

            // determine service price
            if (isset($branchServicePrices[$branch_id][$serviceId]) && $branchServicePrices[$branch_id][$serviceId]->price !== null) {
                $servicePrice = $branchServicePrices[$branch_id][$serviceId]->price;
            } elseif (isset($defaultServicePrices[$serviceId]) && $defaultServicePrices[$serviceId] !== null) {
                $servicePrice = $defaultServicePrices[$serviceId];
            } else {
                $servicePrice = 1000;
            }

            // Create a fake user for the walk-in
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

            $daysAgo = rand(1, 365);
            $bookingDate = Carbon::now()->subDays($daysAgo);
            $randomTimeSlot = $timeSlots[array_rand($timeSlots)];

            $bookingId = DB::table('bookings')->insertGetId([
                'user_id' => $walkinId,
                'service_id' => $serviceId,
                'branch_id' => $branch_id,
                'date' => $bookingDate,
                'time_slot' => $randomTimeSlot,
                'status' => 'completed',
                'payment_status' => 'paid',
                'created_at' => $bookingDate,
                'updated_at' => $bookingDate,
            ]);

            // For walk-ins: we created them as completed by default; skip creating client_package_sessions for these

            // Create a transaction linked to the booking (guard columns)
            $txData = [
                'service_id' => $serviceId,
                'amount' => $servicePrice,
                'payment_method' => 'cash',
                'created_at' => $bookingDate,
                'updated_at' => $bookingDate,
            ];
            if (Schema::hasColumn('transactions', 'booking_id')) {
                $txData['booking_id'] = $bookingId;
            }
            if (Schema::hasColumn('transactions', 'branch_id')) {
                $txData['branch_id'] = $branch_id;
            }
            if (Schema::hasColumn('transactions', 'staff_id')) {
                $txData['staff_id'] = null;
            }
            DB::table('transactions')->insert($txData);
        }
    }
}
