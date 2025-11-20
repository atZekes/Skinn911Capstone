<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'package_booking_id', 'service_id', 'branch_id', 'package_id', 'date', 'time_slot', 'status', 'is_walkin', 'walkin_name', 'walkin_phone', 'walkin_email', 'payment_method', 'payment_status', 'payment_data'
    ];

    protected $casts = [
        'payment_data' => 'array',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function service() { return $this->belongsTo(Service::class); }
    public function package() { return $this->belongsTo(\App\Models\Package::class); }
    public function branch() { return $this->belongsTo(Branch::class); }
    public function purchasedServices() { return $this->hasMany(\App\Models\PurchasedService::class); }
    public function transactions() { return $this->hasMany(\App\Models\Transaction::class); }

    // Link to multi-session package (if this booking is part of a package)
    public function packageBooking() {
        return $this->belongsTo(\App\Models\PackageBooking::class);
    }

    // Client package sessions for this booking
    public function clientPackageSessions()
    {
        return $this->hasMany(\App\Models\ClientPackageSession::class);
    }

    // Check if this booking is part of a package
    public function isPackageSession(): bool
    {
        return $this->package_booking_id !== null;
    }

    /**
     * Check if this booking has multi-session credits
     */
    public function hasSessionCredits(): bool
    {
        return $this->clientPackageSessions()->exists();
    }

    /**
     * Get total remaining sessions for this booking
     */
    public function getRemainingSessionsCount(): int
    {
        return $this->clientPackageSessions()->sum('sessions_remaining');
    }

    /**
     * Get total sessions purchased
     */
    public function getTotalSessionsCount(): int
    {
        return $this->clientPackageSessions()->sum('total_sessions');
    }

    /**
     * Check if booking can be marked as complete
     * (payment confirmed and all sessions used OR single session service)
     */
    public function canComplete(): bool
    {
        // Payment must be confirmed
        if ($this->payment_status !== 'paid') {
            return false;
        }

        // If has session credits, all must be used
        if ($this->hasSessionCredits()) {
            return $this->getRemainingSessionsCount() === 0;
        }

        // Single-session bookings can be completed immediately after payment
        return true;
    }

    /**
     * Mark one session as complete (deduct from remaining sessions)
     */
    public function markSessionComplete(): bool
    {
        $session = $this->clientPackageSessions()
            ->where('sessions_remaining', '>', 0)
            ->where('status', 'active')
            ->first();

        if ($session) {
            $session->deductSession();
            return true;
        }

        return false;
    }

    /**
     * Check if booking can be cancelled or refunded
     */
    public function canCancelOrRefund(): bool
    {
        // Cannot cancel/refund if any sessions have been used
        if ($this->hasSessionCredits()) {
            $totalSessions = $this->getTotalSessionsCount();
            $remainingSessions = $this->getRemainingSessionsCount();

            // If any session was used, cannot cancel
            if ($remainingSessions < $totalSessions) {
                return false;
            }
        }

        // Cannot cancel if payment already confirmed as paid
        if ($this->payment_status === 'paid') {
            return false;
        }

        return $this->status === 'active' || $this->status === 'pending';
    }

    /**
     * Ensure package/session records exist for this booking when payment is confirmed.
     * Creates PackageBooking and ClientPackageSession rows based on the booked service/package
     */
    public function ensurePackageSessionsExist()
    {
        // If already have client package sessions for this booking, do nothing
        $existing = \App\Models\ClientPackageSession::where('booking_id', $this->id)->exists();
        if ($existing) return;

        // If booking referenced a package (client selected a Package)
        if ($this->package_id) {
            $pkg = \App\Models\Package::with('services')->find($this->package_id);
            if ($pkg) {
                // Compute total credits as sum of per-service sessions * quantity
                $totalCredits = 0;
                foreach ($pkg->services as $svc) {
                    $qty = $svc->pivot->quantity ?? 1;
                    $pkgSessions = $svc->pivot->sessions ?? null;
                    if ($pkgSessions !== null) {
                        $sessionCount = $pkgSessions;
                    } else {
                        $branchDefault = \Illuminate\Support\Facades\DB::table('branch_service')
                            ->where('branch_id', $this->branch_id)
                            ->where('service_id', $svc->id)
                            ->value('default_sessions');
                        $sessionCount = $branchDefault ?? ($svc->default_sessions ?? 1);
                    }
                    $totalCredits += ($sessionCount * $qty);
                }

                // Create a PackageBooking for the client
                try {
                    $pkgBooking = \App\Models\PackageBooking::create([
                        'user_id' => $this->user_id,
                        'service_id' => $pkg->services->first()->id ?? null,
                        'branch_id' => $this->branch_id,
                        'total_credits' => $totalCredits,
                        'used_credits' => 0,
                        'remaining_credits' => $totalCredits,
                        'status' => 'active',
                        'total_price' => $pkg->price ?? 0,
                        'payment_status' => $this->payment_status ?? 'paid',
                        'payment_method' => $this->payment_method ?? null,
                        'expiry_date' => null,
                    ]);
                    // Associate booking->package_booking_id
                    $this->package_booking_id = $pkgBooking->id;
                    $this->save();
                } catch (\Exception $e) {
                    // swallow to avoid breaking booking flow
                }

                // Create per-service client package sessions
                foreach ($pkg->services as $svc) {
                    $qty = $svc->pivot->quantity ?? 1;
                    $pkgSessions = $svc->pivot->sessions ?? null;
                    if ($pkgSessions !== null) {
                        $sessionCount = $pkgSessions;
                    } else {
                        $branchDefault = \Illuminate\Support\Facades\DB::table('branch_service')
                            ->where('branch_id', $this->branch_id)
                            ->where('service_id', $svc->id)
                            ->value('default_sessions');
                        $sessionCount = $branchDefault ?? ($svc->default_sessions ?? 1);
                    }
                    $total = $sessionCount * $qty;
                    Log::info('Booking package session debug', [
                        'booking_id' => $this->id,
                        'service_id' => $svc->id,
                        'package_id' => $this->package_id,
                        'sessions_from_pivot' => $pkgSessions,
                        'sessions_used' => $sessionCount,
                        'quantity' => $qty,
                        'total_sessions_created' => $total
                    ]);
                    if ($total <= 0) continue;
                    try {
                        \App\Models\ClientPackageSession::create([
                            'booking_id' => $this->id,
                            'user_id' => $this->user_id,
                            'service_id' => $svc->id,
                            'branch_id' => $this->branch_id,
                            'total_sessions' => $total,
                            'sessions_used' => 0,
                            'sessions_remaining' => $total,
                            'status' => 'active',
                            'total_price' => ($svc->price ?? 0) * $qty,
                            'payment_status' => $this->payment_status ?? 'paid',
                            'payment_method' => $this->payment_method ?? null,
                            'purchase_date' => now(),
                            'expiry_date' => now()->addMonths(6),
                        ]);
                    } catch (\Exception $e) {
                        // swallow errors
                    }
                }
            }
        } else {
            // Single service booking - check if service uses multiple sessions
            if ($this->service_id) {
                $svc = \App\Models\Service::find($this->service_id);
                if ($svc) {
                    // Determine branch-specific default
                    $branchDefault = \Illuminate\Support\Facades\DB::table('branch_service')
                        ->where('branch_id', $this->branch_id)
                        ->where('service_id', $svc->id)
                        ->value('default_sessions');
                    $defaultSessions = $branchDefault ?? ($svc->default_sessions ?? 1);
                    if ($defaultSessions > 1) {
                        try {
                            \App\Models\ClientPackageSession::create([
                                'booking_id' => $this->id,
                                'user_id' => $this->user_id,
                                'service_id' => $svc->id,
                                'branch_id' => $this->branch_id,
                                'total_sessions' => $defaultSessions,
                                'sessions_used' => 0,
                                'sessions_remaining' => $defaultSessions,
                                'status' => 'active',
                                'total_price' => $this->purchasedServices()->sum('price') ?? 0,
                                'payment_status' => $this->payment_status ?? 'paid',
                                'payment_method' => $this->payment_method ?? null,
                                'purchase_date' => now(),
                                'expiry_date' => now()->addMonths(6),
                            ]);
                        } catch (\Exception $e) {
                            // swallow
                        }
                    }
                }
            }
        }
    }

    /**
     * Booted model events to automatically create session/package records
     * whenever a booking is created as paid or when payment_status updates to paid.
     */
    protected static function booted()
    {
        static::created(function ($booking) {
            try {
                if ($booking->payment_status === 'paid') {
                    $booking->ensurePackageSessionsExist();
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('Booking.created hook ensurePackageSessionsExist failed', ['booking_id' => $booking->id, 'error' => $e->getMessage()]);
            }
        });

        static::updated(function ($booking) {
            try {
                // If payment_status was changed to paid, create sessions
                if ($booking->wasChanged('payment_status') && $booking->payment_status === 'paid') {
                    $booking->ensurePackageSessionsExist();
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('Booking.updated hook ensurePackageSessionsExist failed', ['booking_id' => $booking->id, 'error' => $e->getMessage()]);
            }
        });
    }
}
