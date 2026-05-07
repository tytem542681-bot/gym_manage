<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GymMember;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UpdateInactiveMemberships extends Command
{
    protected $signature = 'memberships:update-inactive';
    protected $description = 'Update inactive memberships based on 3-day attendance gaps';

    public function handle()
    {
        $this->info('Updating inactive memberships based on attendance...');
        
        $members = GymMember::where('status', 'active')->get();
        
        $inactiveCount = 0;
        
        foreach ($members as $member) {
            if ($this->hasNoAttendanceForThreeDays($member)) {
                $member->status = 'inactive';
                $member->save();
                $inactiveCount++;
                
                $this->line("Member {$member->name} marked as inactive (3 days no attendance)");
            }
        }
        
        Log::info("Updated {$inactiveCount} memberships to inactive status due to 3-day attendance gaps.");
        
        $this->info("Membership inactivity update completed: {$inactiveCount} members marked as inactive.");
        
        return 0;
    }
    
    private function hasNoAttendanceForThreeDays($member)
    {
        $threeDaysAgo = Carbon::now()->subDays(3);
        
        $lastAttendance = $member->attendances()
            ->where('check_in_date', '>=', $threeDaysAgo->format('Y-m-d'))
            ->orderBy('check_in_date', 'desc')
            ->first();
            
        return !$lastAttendance;
    }
}
