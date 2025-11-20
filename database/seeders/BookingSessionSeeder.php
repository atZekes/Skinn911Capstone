<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

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

        $serviceData = DB::table('services')->select('id', 'price')->get()->keyBy('id');
        $timeSlots = ['09:00-10:00', '10:00-11:00', '11:00-12:00', '13:00-14:00', '14:00-15:00', '15:00-16:00', '16:00-17:00'];

        foreach ($userIds as $userId) {
            foreach ($serviceIds as $serviceId) {
                $branch_id = $branchIdList[array_rand($branchIdList)];
                $randomTimeSlot = $timeSlots[array_rand($timeSlots)];
                $servicePrice = $serviceData[$serviceId]->price ?? 1000;
                // Generate a random date in the past year
                $daysAgo = rand(1, 365);
                $bookingDate = Carbon::now()->subDays($daysAgo);
                $bookingId = DB::table('bookings')->insertGetId([
                    'user_id' => $userId,
                    'service_id' => $serviceId,
                    'branch_id' => $branch_id,
                    'date' => $bookingDate,
                    'time_slot' => $randomTimeSlot,
                    'status' => 'completed',
                    'created_at' => $bookingDate,
                    'updated_at' => $bookingDate,
                ]);
                DB::table('client_package_sessions')->insert([
                    'booking_id' => $bookingId,
                    'user_id' => $userId,
                    'service_id' => $serviceId,
                    'branch_id' => $branch_id,
                    'total_sessions' => rand(5, 10),
                    'sessions_used' => rand(1, 5),
                    'sessions_remaining' => rand(1, 5),
                    'status' => 'active',
                    'total_price' => $servicePrice * rand(5, 10),
                    'payment_status' => 'paid',
                    'payment_method' => 'cash',
                    'purchase_date' => $bookingDate->copy()->subDays(rand(0, 30)),
                    'expiry_date' => $bookingDate->copy()->addDays(rand(30, 180)),
                    'last_completed_session_date' => $bookingDate->copy()->subDays(rand(0, 10)),
                    'notes' => null,
                    'created_at' => $bookingDate,
                    'updated_at' => $bookingDate,
                ]);
                // Create a transaction for each booking
                DB::table('transactions')->insert([
                    'service_id' => $serviceId,
                    'amount' => $servicePrice,
                    'payment_method' => 'cash',
                    'branch_id' => $branch_id,
                    'staff_id' => null,
                    'created_at' => $bookingDate,
                    'updated_at' => $bookingDate,
                ]);
            }
        }
    }
}
