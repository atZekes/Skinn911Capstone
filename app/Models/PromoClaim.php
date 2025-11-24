<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoClaim extends Model
{
    protected $fillable = [
        'user_id',
        'promo_id',
        'quantity_claimed',
        'claimed_at'
    ];

    protected $casts = [
        'claimed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }
}
