<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Booking;

class BookingReschedule extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $previousDate;
    public $previousTime;

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking, $previousDate = null, $previousTime = null)
    {
        $this->booking = $booking;
        $this->previousDate = $previousDate;
        $this->previousTime = $previousTime;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Skin911 - Booking Rescheduled (ID: #' . $this->booking->id . ')',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-reschedule',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
