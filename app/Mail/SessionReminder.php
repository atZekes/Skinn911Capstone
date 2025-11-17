<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\ClientPackageSession;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SessionReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $sessionCredit;
    public $clientName;
    public $serviceName;
    public $sessionsRemaining;
    public $expiryDate;
    public $daysUntilExpiry;
    public $branchName;

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking, ClientPackageSession $sessionCredit)
    {
        $this->booking = $booking;
        $this->sessionCredit = $sessionCredit;
        $this->clientName = $booking->user->name;

        // Get service name from package or service
        if ($booking->package) {
            $this->serviceName = $booking->package->name;
        } elseif ($booking->service) {
            $this->serviceName = $booking->service->name;
        } else {
            $this->serviceName = 'your service';
        }

        $this->sessionsRemaining = $sessionCredit->sessions_remaining;
        $this->branchName = $booking->branch ? $booking->branch->name : 'Skin911';

        // Calculate expiry information
        if ($sessionCredit->expiry_date) {
            $this->expiryDate = \Carbon\Carbon::parse($sessionCredit->expiry_date)->format('F d, Y');
            $this->daysUntilExpiry = now()->diffInDays(\Carbon\Carbon::parse($sessionCredit->expiry_date), false);
        } else {
            $this->expiryDate = null;
            $this->daysUntilExpiry = null;
        }
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = 'Session Credits Reminder - ' . $this->serviceName;

        return $this->subject($subject)
                    ->view('emails.session-reminder')
                    ->with([
                        'clientName' => $this->clientName,
                        'serviceName' => $this->serviceName,
                        'sessionsRemaining' => $this->sessionsRemaining,
                        'expiryDate' => $this->expiryDate,
                        'daysUntilExpiry' => $this->daysUntilExpiry,
                        'branchName' => $this->branchName,
                    ]);
    }
}
