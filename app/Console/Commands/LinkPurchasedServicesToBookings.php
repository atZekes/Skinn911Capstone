<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PurchasedService;
use App\Models\Booking;
use Carbon\Carbon;

class LinkPurchasedServicesToBookings extends Command
{
    protected $signature = 'fix:link-purchased-bookings';
    protected $description = 'Link old purchased_services to their correct bookings by setting booking_id';

    public function handle()
    {
        $count = 0;
        $services = PurchasedService::whereNull('booking_id')->get();
        foreach ($services as $ps) {
            $booking = Booking::where('user_id', $ps->user_id)
                ->where('service_id', $ps->service_id)
                ->whereBetween('created_at', [
                    Carbon::parse($ps->created_at)->subMinutes(5),
                    Carbon::parse($ps->created_at)->addMinutes(5)
                ])
                ->orderBy('created_at', 'asc')
                ->first();
            if ($booking) {
                $ps->booking_id = $booking->id;
                $ps->save();
                $count++;
            }
        }
        $this->info("Linked $count purchased services to bookings.");
    }
}
