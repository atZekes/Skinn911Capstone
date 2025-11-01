<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    // If your table name is not the default 'services', uncomment and set the table name below
    // protected $table = 'services';

    // Define attributes typically present in the services table for clarity
    protected $fillable = [
    'name', 'category', 'description', 'benefits', 'price', 'sessions', 'image', 'branch_id', 'active', 'duration'
    ];

    // Relationship: service belongs to many branches (pivot)
    public function branches()
    {
        return $this->belongsToMany(\App\Models\Branch::class, 'branch_service')
                    ->withPivot('price','active','custom_description','duration')
                    ->withTimestamps();
    }

    // Relationship: optional direct branch (legacy)
    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class, 'branch_id');
    }

    // Scope helper
    public function scopeForBranch($query, $branchId)
    {
        return $query->where('branch_id', $branchId);
    }

    public function promos()
    {
        return $this->belongsToMany(\App\Models\Promo::class, 'promo_service');
    }

}


