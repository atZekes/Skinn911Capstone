<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\LinkPurchasedServicesToBookings::class,
        \App\Console\Commands\SendBookingReminders::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Send booking reminders daily at 9 AM for bookings happening tomorrow
        $schedule->command('bookings:send-reminders')
                ->dailyAt('09:00')
                ->withoutOverlapping()
                ->runInBackground();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
