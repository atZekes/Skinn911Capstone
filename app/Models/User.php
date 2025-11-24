<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmail as VerifyEmailNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'branch_id',
        'active',
        'mobile_phone',
        'telephone',
        'address',
        'birthday',
        'saved_card_data',
        'preferences',
        'google2fa_secret',
        'google2fa_enabled',
        'google2fa_enabled_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birthday' => 'date',
            'saved_card_data' => 'array',
            'preferences' => 'array',
            'google2fa_enabled' => 'boolean',
            'google2fa_enabled_at' => 'datetime',
        ];
    }

    public function purchased_services()
    {
        return $this->belongsToMany(\App\Models\Service::class, 'purchased_services')
            ->withPivot('price', 'description', 'created_at')
            ->withTimestamps();
    }

    public function bookings()
    {
        return $this->hasMany(\App\Models\Booking::class);
    }

    // Package bookings (multi-session packages purchased)
    public function packageBookings()
    {
        return $this->hasMany(\App\Models\PackageBooking::class);
    }

    // Active packages with remaining credits
    public function activePackages()
    {
        return $this->hasMany(\App\Models\PackageBooking::class)
                    ->where('status', 'active')
                    ->where('remaining_credits', '>', 0);
    }

    public function messages()
    {
        return $this->hasMany(\App\Models\Message::class);
    }

    public function chatMessages()
    {
        return $this->hasMany(\App\Models\ChatMessage::class, 'user_id');
    }

    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class);
    }

    public function notifications()
    {
        return $this->hasMany(\App\Models\Notification::class);
    }

    public function promoClaims()
    {
        return $this->hasMany(\App\Models\PromoClaim::class);
    }

    /**
     * Get total number of visits (completed bookings)
     */
    public function getTotalVisitsAttribute()
    {
        return $this->bookings()
            ->where('status', 'completed')
            ->count();
    }

    /**
     * Get the most recent booking
     */
    public function getLastVisitAttribute()
    {
        return $this->bookings()
            ->where('status', 'completed')
            ->orderBy('date', 'desc')
            ->orderBy('time_slot', 'desc')
            ->first();
    }

    /**
     * Get days since last visit
     */
    public function getDaysSinceLastVisitAttribute()
    {
        $lastVisit = $this->last_visit;
        if (!$lastVisit) {
            return null;
        }

        return now()->diffInDays($lastVisit->date);
    }

    /**
     * Calculate return interval (days between last two visits)
     */
    public function getReturnIntervalAttribute()
    {
        $completedBookings = $this->bookings()
            ->where('status', 'completed')
            ->orderBy('date', 'desc')
            ->orderBy('time_slot', 'desc')
            ->take(2)
            ->get();

        if ($completedBookings->count() < 2) {
            return null;
        }

        $lastVisit = $completedBookings[0];
        $previousVisit = $completedBookings[1];

        return \Carbon\Carbon::parse($previousVisit->date)
            ->diffInDays(\Carbon\Carbon::parse($lastVisit->date));
    }

    /**
     * Check if client is inactive (no visit in specified days)
     */
    public function isInactive($days = 90)
    {
        $daysSinceLastVisit = $this->days_since_last_visit;
        return $daysSinceLastVisit !== null && $daysSinceLastVisit > $days;
    }

    /**
     * Get masked name for privacy (e.g., "John Doe" -> "Jo Do")
     */
    public function getMaskedNameAttribute()
    {
        $nameParts = explode(' ', $this->name);
        $masked = array_map(function($part) {
            return mb_substr($part, 0, 2);
        }, $nameParts);
        return implode(' ', $masked);
    }

    /**
     * Get masked email for privacy (e.g., "john@gmail.com" -> "j***@gmail.com")
     */
    public function getMaskedEmailAttribute()
    {
        $email = $this->email;
        $parts = explode('@', $email);

        if (count($parts) !== 2) {
            return $email;
        }

        $localPart = $parts[0];
        $domain = $parts[1];

        // Keep first character, mask the rest
        $maskedLocal = mb_substr($localPart, 0, 1) . str_repeat('*', min(3, mb_strlen($localPart) - 1));

        return $maskedLocal . '@' . $domain;
    }

    /**
     * Get masked phone for privacy (e.g., "09171234567" -> "0917***4567")
     */
    public function getMaskedPhoneAttribute()
    {
        $phone = $this->mobile_phone;

        if (!$phone || strlen($phone) < 8) {
            return $phone;
        }

        // Keep first 4 and last 4 digits, mask middle
        $start = substr($phone, 0, 4);
        $end = substr($phone, -4);

        return $start . '***' . $end;
    }
}
