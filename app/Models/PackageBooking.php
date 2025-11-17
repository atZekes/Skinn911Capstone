<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Package Booking Model
 * Represents a multi-session service package purchased by a client
 * Acts as prepaid credits - sessions scheduled one at a time
 */
class PackageBooking extends Model
{
    protected $fillable = [
        'user_id',
        'service_id',
        'branch_id',
        'total_credits',
        'used_credits',
        'remaining_credits',
        'status',
        'total_price',
        'payment_status',
        'payment_method',
        'expiry_date',
        'notes',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    /**
     * Relationships
     */

    // Client who purchased this package
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Service this package is for
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    // Branch where package was purchased
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    // Individual scheduled sessions from this package
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Helper Methods
     */

    // Check if package has remaining credits
    public function hasRemainingCredits(): bool
    {
        return $this->remaining_credits > 0 && $this->status === 'active';
    }

    // Check if package is expired
    public function isExpired(): bool
    {
        return $this->expiry_date && now()->greaterThan($this->expiry_date);
    }

    // Deduct one credit when session is scheduled
    public function deductCredit(): void
    {
        if ($this->hasRemainingCredits()) {
            $this->increment('used_credits');
            $this->decrement('remaining_credits');

            // Auto-complete package if all credits used
            if ($this->remaining_credits === 0) {
                $this->update(['status' => 'completed']);
            }
        }
    }

    // Refund one credit if session is cancelled
    public function refundCredit(): void
    {
        if ($this->used_credits > 0) {
            $this->decrement('used_credits');
            $this->increment('remaining_credits');

            // Reactivate package if it was completed
            if ($this->status === 'completed') {
                $this->update(['status' => 'active']);
            }
        }
    }

    // Get progress percentage
    public function getProgressPercentageAttribute(): float
    {
        if ($this->total_credits === 0) return 0;
        return round(($this->used_credits / $this->total_credits) * 100, 1);
    }

    // Get price per session
    public function getPricePerSessionAttribute(): float
    {
        if ($this->total_credits === 0) return 0;
        return round($this->total_price / $this->total_credits, 2);
    }

    /**
     * Scopes
     */

    // Get only active packages
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                     ->where('remaining_credits', '>', 0);
    }

    // Get packages near completion (2 or fewer sessions remaining)
    public function scopeNearCompletion($query)
    {
        return $query->where('status', 'active')
                     ->where('remaining_credits', '<=', 2)
                     ->where('remaining_credits', '>', 0);
    }

    // Get expiring soon packages (within 30 days)
    public function scopeExpiringSoon($query)
    {
        return $query->where('status', 'active')
                     ->whereNotNull('expiry_date')
                     ->whereBetween('expiry_date', [now(), now()->addDays(30)]);
    }
}
