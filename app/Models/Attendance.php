<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance';
    
    protected $fillable = [
        'gym_member_id',
        'check_in_date',
        'check_in_time',
        'check_out_date',
        'check_out_time',
        'duration_hours',
        'activity_type',
        'notes',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime',
        'duration_hours' => 'decimal:2',
    ];

    public function gymMember()
    {
        return $this->belongsTo(GymMember::class);
    }
}
