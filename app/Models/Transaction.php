<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_id', 'amount', 'payment_method', 'branch_id', 'booking_id', 'package_id'
    ];
    public function service() { return $this->belongsTo(Service::class); }
    public function branch() { return $this->belongsTo(Branch::class); }
    // staff_id removed
    public function package() { return $this->belongsTo(Package::class, 'package_id'); }
}
