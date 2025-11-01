<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'service_id', 'branch_id', 'package_id', 'date', 'time_slot', 'status', 'is_walkin', 'walkin_name', 'walkin_phone', 'walkin_email', 'payment_method', 'payment_status', 'payment_data'
    ];

    protected $casts = [
        'payment_data' => 'array',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function service() { return $this->belongsTo(Service::class); }
    public function package() { return $this->belongsTo(\App\Models\Package::class); }
    public function branch() { return $this->belongsTo(Branch::class); }
}
