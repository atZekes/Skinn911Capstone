<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_id', 'amount', 'payment_method', 'branch_id', 'staff_id'
    ];
    public function service() { return $this->belongsTo(Service::class); }
    public function branch() { return $this->belongsTo(Branch::class); }
    public function staff() { return $this->belongsTo(User::class, 'staff_id'); }
}
