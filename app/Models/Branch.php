<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = [
        'key', 'name', 'address', 'location_detail', 'hours', 'map_src', 'time_slot', 'slot_capacity', 'break_start', 'break_end', 'active', 'contact_number', 'telephone_number', 'operating_days', 'gcash_number', 'gcash_qr'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Hide inactive branches by default.
     */
    // protected static function booted()
    // {
    //     static::addGlobalScope('active', function (Builder $builder) {
    //         $builder->where('active', 1);
    //     });
    // }

    public function services()
    {
        return $this->belongsToMany(\App\Models\Service::class, 'branch_service')
                    ->withPivot('price','active','custom_description','duration')
                    ->withTimestamps();
    }

    /**
     * Generate formatted hours display based on operating days and time slots
     */
    public function getFormattedHoursAttribute()
    {
        // If no operating days set, return null
        if (empty($this->operating_days) || empty($this->time_slot)) {
            return null;
        }

        // Get operating days as array
        $operatingDays = explode(',', $this->operating_days);
        $allDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        // Get time slot
        $timeSlot = $this->time_slot; // e.g., "09:00 - 18:00"

        // Convert to 12-hour format
        if (strpos($timeSlot, ' - ') !== false) {
            [$startTime, $endTime] = explode(' - ', $timeSlot);
            $formattedStart = date('g:i a', strtotime($startTime));
            $formattedEnd = date('g:i a', strtotime($endTime));
            $formattedTimeSlot = $formattedStart . ' - ' . $formattedEnd;
        } else {
            $formattedTimeSlot = $timeSlot;
        }

        // Create groups of consecutive days
        $openDays = [];
        $closedDays = [];

        foreach ($allDays as $day) {
            if (in_array($day, $operatingDays)) {
                $openDays[] = substr($day, 0, 3); // Mon, Tue, etc.
            } else {
                $closedDays[] = substr($day, 0, 3);
            }
        }

        // Generate HTML display with proper formatting
        $html = '<div class="hours-display">';

        // Group consecutive days
        if (!empty($openDays)) {
            $openGrouped = $this->groupConsecutiveDays($openDays);
            foreach ($openGrouped as $group) {
                $html .= '<div class="day-group">';
                $html .= '<span class="days"><strong>' . $group . '</strong>:</span> ';
                $html .= '<span class="hours">' . $formattedTimeSlot . '</span>';
                $html .= '</div>';
            }
        }

        if (!empty($closedDays)) {
            $closedGrouped = $this->groupConsecutiveDays($closedDays);
            foreach ($closedGrouped as $group) {
                $html .= '<div class="day-group">';
                $html .= '<span class="days"><strong>' . $group . '</strong>:</span> ';
                $html .= '<span class="hours">Closed</span>';
                $html .= '</div>';
            }
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Helper method to group consecutive days
     */
    private function groupConsecutiveDays($days)
    {
        if (empty($days)) return [];

        $dayOrder = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $orderedDays = array_values(array_intersect($dayOrder, $days));

        if (empty($orderedDays)) return [];

        if (count($orderedDays) <= 1) {
            return $orderedDays;
        }

        // Simple grouping - if more than 2 consecutive days, group them
        if (count($orderedDays) >= 3 && $this->areConsecutive($orderedDays)) {
            return [$orderedDays[0] . ' - ' . end($orderedDays)];
        }

        return $orderedDays;
    }

    /**
     * Check if days are consecutive
     */
    private function areConsecutive($days)
    {
        $dayOrder = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $indices = array_map(function($day) use ($dayOrder) {
            return array_search($day, $dayOrder);
        }, $days);

        sort($indices);

        for ($i = 1; $i < count($indices); $i++) {
            if ($indices[$i] - $indices[$i-1] !== 1) {
                return false;
            }
        }

        return true;
    }
}
