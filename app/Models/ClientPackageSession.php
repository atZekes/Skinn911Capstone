<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ClientPackageSession extends Model
{
    protected $table = 'client_package_sessions';

    protected $fillable = [
        'booking_id',
        'user_id',
        'service_id',
        'branch_id',
        'total_sessions',
        'sessions_used',
        'sessions_remaining',
        'status',
        'total_price',
        'payment_status',
        'payment_method',
        'purchase_date',
        'expiry_date',
        'notes',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'expiry_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the client who owns this package
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the service this package is for
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the branch where this package was purchased
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // ==================== HELPER METHODS ====================

    /**
     * Check if package can book a session
     */
    public function canBookSession()
    {
        return $this->sessions_remaining > 0
            && $this->status === 'active'
            && !$this->isExpired();
    }

    /**
     * Check if package has expired
     */
    public function isExpired()
    {
        if (!$this->expiry_date) {
            return false;
        }
        return now()->greaterThan($this->expiry_date);
    }

    /**
     * Deduct one session credit when booking
     */
    public function deductSession()
    {
        if (!$this->canBookSession()) {
            throw new \Exception('Cannot book session: No credits remaining or package expired');
        }

        $this->sessions_used++;
        $this->sessions_remaining--;

        // Mark as completed if no credits left
        if ($this->sessions_remaining == 0) {
            $this->status = 'completed';
        }

        $this->save();
    }

    /**
     * Refund one session credit when cancelling
     */
    public function refundSession()
    {
        if ($this->sessions_used <= 0) {
            throw new \Exception('No sessions to refund');
        }

        $this->sessions_used--;
        $this->sessions_remaining++;

        // Reactivate if was completed
        if ($this->status === 'completed') {
            $this->status = 'active';
        }

        $this->save();
    }

    /**
     * Get progress percentage
     */
    public function getProgressPercentageAttribute()
    {
        if ($this->total_sessions == 0) return 0;
        return round(($this->sessions_used / $this->total_sessions) * 100);
    }

    /**
     * Get days until expiry
     */
    public function getDaysUntilExpiryAttribute()
    {
        if (!$this->expiry_date) return null;
        return now()->diffInDays($this->expiry_date, false);
    }

    /**
     * Get price per session
     */
    public function getPricePerSessionAttribute()
    {
        if ($this->total_sessions == 0) return 0;
        return round($this->total_price / $this->total_sessions, 2);
    }

    // ==================== SCOPES ====================

    /**
     * Scope for active packages
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->where('sessions_remaining', '>', 0);
    }

    /**
     * Scope for expiring soon (within 30 days)
     */
    public function scopeExpiringSoon($query)
    {
        return $query->whereNotNull('expiry_date')
                    ->where('expiry_date', '>', now())
                    ->where('expiry_date', '<=', now()->addDays(30));
    }

    /**
     * Scope for low credits (2 or less remaining)
     */
    public function scopeLowCredits($query)
    {
        return $query->where('sessions_remaining', '>', 0)
                    ->where('sessions_remaining', '<=', 2);
    }

    /**
     * Scope for specific branch
     */
    public function scopeForBranch($query, $branchId)
    {
        return $query->where('branch_id', $branchId);
    }
}
