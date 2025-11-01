<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Package extends Model
{
    protected $fillable = ['name', 'description', 'price', 'branch_id', 'active'];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'package_service')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Total duration (in hours) of this package based on included services.
     * Preference order for per-service duration used in sum:
     * 1) package_service pivot duration (if present)
     * 2) branch_service.duration for the package's branch (admin assigned)
     * 3) service.duration (global)
     */
    public function getDurationAttribute()
    {
        $total = 0;
        $branchId = $this->branch_id;
        foreach ($this->services as $s) {
            $qty = $s->pivot->quantity ?? 1;
            // Package-level pivot may contain duration if we add it later; check first
            $pkgPivotDuration = $s->pivot->duration ?? null;
            if ($pkgPivotDuration) {
                $dur = $pkgPivotDuration;
            } else {
                // check branch_service table for admin-assigned duration
                $branchDur = null;
                if ($branchId) {
                    try {
                        $branchDur = DB::table('branch_service')->where('branch_id', $branchId)->where('service_id', $s->id)->value('duration');
                    } catch (\Exception $e) {
                        $branchDur = null;
                    }
                }
                $dur = $branchDur ?? ($s->duration ?? 1);
            }
            $total += ($dur * $qty);
        }
        return $total;
    }
}
