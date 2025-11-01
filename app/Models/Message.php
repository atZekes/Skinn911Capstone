<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sender_type',
        'branch_id',
        'message',
        'is_read',
        'forwarded_to_staff',
        'staff_notification_sent',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'forwarded_to_staff' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
