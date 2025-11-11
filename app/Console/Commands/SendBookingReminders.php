<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Models\User;
use Pusher\Pusher;

class SendBookingReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:send-reminders {--days=1 : Number of days ahead to send reminders for}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send push notification reminders for upcoming bookings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $daysAhead = (int) $this->option('days');

        $this->info("Sending booking reminders for bookings {$daysAhead} day(s) from now...");

        // Get bookings for the specified days ahead
        $targetDate = now()->addDays($daysAhead)->toDateString();

        $bookings = Booking::with(['user', 'service', 'package', 'branch'])
            ->where('date', $targetDate)
            ->where('status', 'active')
            ->whereHas('user', function($query) {
                $query->whereNotNull('email'); // Only users with email addresses
            })
            ->get();

        $this->info("Found {$bookings->count()} bookings for {$targetDate}");

        $sentCount = 0;
        $failedCount = 0;

        foreach ($bookings as $booking) {
            try {
                // Prepare reminder message
                $serviceName = $booking->service ? $booking->service->name : ($booking->package ? $booking->package->name : 'Service');
                $branchName = $booking->branch ? $booking->branch->name : 'Branch';
                $timeSlot = $booking->time_slot;

                $message = "Reminder: You have a {$serviceName} appointment tomorrow at {$branchName} during {$timeSlot}.";

                // Send push notification
                $this->sendPushNotification(
                    $booking->user_id,
                    'Appointment Reminder',
                    $message,
                    'info'
                );

                $this->line("✓ Sent reminder to {$booking->user->email} for booking #{$booking->id}");
                $sentCount++;

            } catch (\Exception $e) {
                $this->error("✗ Failed to send reminder for booking #{$booking->id}: {$e->getMessage()}");
                $failedCount++;
            }
        }

        $this->info("Reminder sending completed: {$sentCount} sent, {$failedCount} failed");
    }

    /**
     * Send push notification to user
     */
    private function sendPushNotification($userId, $title, $message, $type = 'info')
    {
        try {
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                ['cluster' => env('PUSHER_APP_CLUSTER')]
            );

            $pusher->trigger('user-' . $userId, 'notification', [
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'icon' => asset('img/skinlogo.png')
            ]);

        } catch (\Exception $e) {
            throw $e; // Re-throw to be caught by the calling code
        }
    }
}
