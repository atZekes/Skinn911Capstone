<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

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
}
