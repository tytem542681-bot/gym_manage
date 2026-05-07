<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class GymMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'gender',
        'contact_number',
        'membership_plan',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($member) {
            if ($member->end_date && $member->end_date < Carbon::now()->format('Y-m-d')) {
                $member->status = 'expired';
            }
        });
    }

    public function isExpired()
    {
        return $this->end_date && $this->end_date < Carbon::now()->format('Y-m-d');
    }

    public function isExpiringSoon()
    {
        return $this->end_date && Carbon::parse($this->end_date)->diffInDays(Carbon::now()) <= 7;
    }

    public function daysRemaining()
    {
        if (!$this->end_date || $this->isExpired()) {
            return 0;
        }
        
        return max(0, now()->diffInDays(Carbon::parse($this->end_date)));
    }

    public function hasNoAttendanceForThreeDays()
    {
        $threeDaysAgo = Carbon::now()->subDays(3);
        
        $lastAttendance = $this->attendances()
            ->where('check_in_date', '>=', $threeDaysAgo->format('Y-m-d'))
            ->orderBy('check_in_date', 'desc')
            ->first();
            
        return !$lastAttendance;
    }

    public function daysSinceLastAttendance()
    {
        $lastAttendance = $this->attendances()
            ->orderBy('check_in_date', 'desc')
            ->first();
            
        if (!$lastAttendance) {
            return 999;
        }
        
        return Carbon::parse($lastAttendance->check_in_date)->diffInDays(Carbon::now());
    }

    public function membershipHistory()
    {
        return $this->hasMany(MembershipHistory::class)->orderBy('effective_date', 'desc');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class)->orderBy('check_in_date', 'desc');
    }
}
