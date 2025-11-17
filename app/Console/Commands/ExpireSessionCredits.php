<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ClientPackageSession;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ExpireSessionCredits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire session credits that are past 6 months and cancel associated bookings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for expired session credits...');

        // Find all active session credits that have expired (past 6 months)
        $expiredSessions = ClientPackageSession::where('status', 'active')
            ->where('expiry_date', '<=', Carbon::now())
            ->whereNotNull('expiry_date')
            ->get();

        $count = 0;
        foreach ($expiredSessions as $session) {
            try {
                // Mark session as expired
                $session->status = 'expired';
                $session->sessions_remaining = 0;
                $session->save();

                // Find the associated booking and cancel it
                $booking = Booking::where('id', $session->booking_id)->first();
                if ($booking && $booking->status !== 'cancelled' && $booking->status !== 'completed') {
                    $booking->status = 'cancelled';
                    $booking->save();

                    Log::info('Expired session and cancelled booking', [
                        'session_id' => $session->id,
                        'booking_id' => $booking->id,
                        'user_id' => $session->user_id,
                        'expiry_date' => $session->expiry_date
                    ]);

                    // Send notification to client
                    try {
                        $user = $booking->user;
                        if ($user) {
                            // You can send email or push notification here
                            // Mail::to($user->email)->send(new SessionExpiredNotification($booking, $session));
                        }
                    } catch (\Exception $e) {
                        Log::error('Failed to send expiration notification', ['error' => $e->getMessage()]);
                    }
                }

                $count++;
            } catch (\Exception $e) {
                Log::error('Error expiring session credit', [
                    'session_id' => $session->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $this->info("Expired {$count} session credit(s) and cancelled associated bookings.");

        return Command::SUCCESS;
    }
}
