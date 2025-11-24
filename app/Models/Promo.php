<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $table = 'promos';
    protected $fillable = [
    'code', 'title', 'description', 'discount', 'start_date', 'end_date', 'active', 'branch_id', 'category', 'image', 'quantity_available', 'max_claims_per_user'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'active' => 'boolean',
    ];

    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class, 'branch_id');
    }

    public function services()
    {
        return $this->belongsToMany(\App\Models\Service::class, 'promo_service');
    }

    public function claims()
    {
        return $this->hasMany(\App\Models\PromoClaim::class);
    }

    public function usages()
    {
        return $this->hasMany(\App\Models\PromoUsage::class);
    }

    public function getDaysLeftAttribute()
    {
        if (!$this->end_date) {
            return null;
        }

        $now = now()->startOfDay();
        $endDate = \Carbon\Carbon::parse($this->end_date)->startOfDay();

        if ($endDate->isPast()) {
            return 0;
        }

        return $now->diffInDays($endDate);
    }

    public function getIsExpiredAttribute()
    {
        return $this->end_date && \Carbon\Carbon::parse($this->end_date)->isPast();
    }

    public function getExpirationMessageAttribute()
    {
        if ($this->is_expired) {
            return 'Expired';
        }

        if (!$this->end_date) {
            return null;
        }

        $daysLeft = $this->days_left;

        if ($daysLeft === 0) {
            return 'Expires today - Claim now!';
        } elseif ($daysLeft === 1) {
            return '1 day left - Claim now!';
        } elseif ($daysLeft <= 7) {
            return $daysLeft . ' days left - Claim now!';
        }

        return null;
    }

    public function getTotalClaimsAttribute()
    {
        return $this->claims()->sum('quantity_claimed');
    }

    public function getRemainingQuantityAttribute()
    {
        if ($this->quantity_available === null) {
            return null; // unlimited
        }
        if ($this->quantity_available === 0) {
            return 0; // no availability
        }
        return max(0, $this->quantity_available - $this->total_claims);
    }

    public function getIsAvailableAttribute()
    {
        if (!$this->active || $this->is_expired) {
            return false;
        }

        if ($this->quantity_available === 0) {
            return false; // 0 means no availability
        }

        if ($this->quantity_available !== null && $this->remaining_quantity <= 0) {
            return false; // limited quantity exhausted
        }

        return true;
    }

    public function canUserClaim($userId = null)
    {
        // Require a valid user id
        if (!$userId) {
            return false;
        }

        // Promo must be available
        if (!$this->is_available) {
            return false;
        }

        // Enforce single-claim-per-user: if the user already has any claim record, disallow further claims
        $hasAnyClaim = $this->claims()->where('user_id', $userId)->exists();
        if ($hasAnyClaim) {
            return false;
        }

        // If no existing claim, allow claim (this enforces one-per-user regardless of max_claims_per_user)
        return true;
    }

    public function getAvailabilityMessageAttribute()
    {
        if (!$this->is_available) {
            if ($this->quantity_available === 0) {
                return 'No availability';
            }
            if ($this->quantity_available !== null && $this->remaining_quantity <= 0) {
                return 'Out of stock';
            }
            return 'Unavailable';
        }

        if ($this->quantity_available === null) {
            return 'Unlimited availability';
        }

        return $this->remaining_quantity . ' available';
    }
}
