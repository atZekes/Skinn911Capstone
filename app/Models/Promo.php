<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $table = 'promos';
    protected $fillable = [
    'code', 'title', 'description', 'discount', 'start_date', 'end_date', 'active', 'branch_id', 'category'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'active' => 'boolean',
    ];

    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class, 'branch_id');
    }

    public function services()
    {
        return $this->belongsToMany(\App\Models\Service::class, 'promo_service');
    }
}
