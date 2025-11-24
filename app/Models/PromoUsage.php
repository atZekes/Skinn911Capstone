<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoUsage extends Model
{
    protected $table = 'promo_usages';

    protected $fillable = [
        'user_id',
        'promo_id',
        'service_id',
        'package_id',
        'booking_id',
        'used_at',
    ];

    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
