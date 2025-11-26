<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PurchasedService extends Model
{
    protected $table = 'purchased_services';
    protected $fillable = [
        'user_id', 'service_id', 'booking_id', 'price', 'promo_code', 'description', 'status',
        'total_sessions', 'sessions_used', 'sessions_remaining', 'session_status', 'session_expiry_date', 'branch_id'
    ];

    protected $casts = [
        'session_expiry_date' => 'date',
        'total_sessions' => 'integer',
        'sessions_used' => 'integer',
        'sessions_remaining' => 'integer',
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

    /**
     * Check if this service has multi-session credits
     */
    public function hasSessionCredits(): bool
    {
        return $this->total_sessions > 1;
    }

    /**
     * Check if all sessions for this service are completed
     */
    public function isCompleted(): bool
    {
        return $this->sessions_remaining <= 0;
    }

    /**
     * Mark one session as complete
     */
    public function markSessionComplete(): bool
    {
        if ($this->sessions_remaining > 0 && $this->session_status === 'active') {
            $this->sessions_used++;
            $this->sessions_remaining--;

            if ($this->sessions_remaining <= 0) {
                $this->session_status = 'completed';
            }

            $this->save();
            return true;
        }

        return false;
    }

    /**
     * Check if this service's sessions have expired
     */
    public function isExpired(): bool
    {
        return $this->session_expiry_date && Carbon::parse($this->session_expiry_date)->isPast();
    }

    /**
     * Get remaining sessions count
     */
    public function getRemainingSessions(): int
    {
        return max(0, $this->sessions_remaining);
    }

    /**
     * Initialize sessions when purchased service is created
     */
    protected static function booted()
    {
        static::creating(function ($purchasedService) {
            if (!$purchasedService->total_sessions) {
                // Get default sessions from service
                $service = Service::find($purchasedService->service_id);
                $defaultSessions = $service ? ($service->default_sessions ?? 1) : 1;

                $purchasedService->total_sessions = $defaultSessions;
                $purchasedService->sessions_used = 0;
                $purchasedService->sessions_remaining = $defaultSessions;
                $purchasedService->session_status = 'active';

                // Set expiry date (default 1 year from now)
                $purchasedService->session_expiry_date = Carbon::now()->addYear();
            }
        });
    }
}
