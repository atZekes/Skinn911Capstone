<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchasedService extends Model
{
    protected $table = 'purchased_services';
    protected $fillable = [
        'user_id', 'service_id', 'booking_id', 'price', 'description', 'status'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
