<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipHistory extends Model
{
    protected $table = 'membership_history';
    
    protected $fillable = [
        'gym_member_id',
        'previous_plan',
        'new_plan',
        'previous_price',
        'new_price',
        'effective_date',
        'notes',
        'change_type',
    ];

    protected $casts = [
        'previous_price' => 'decimal:2',
        'new_price' => 'decimal:2',
        'effective_date' => 'date',
    ];

    public function gymMember()
    {
        return $this->belongsTo(GymMember::class);
    }
}
