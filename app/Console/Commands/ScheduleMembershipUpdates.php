<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GymMember;
use Illuminate\Support\Facades\Log;

class ScheduleMembershipUpdates extends Command
{
    protected $signature = 'schedule:membership-updates';
    protected $description = 'Schedule and run membership status updates';

    public function handle()
    {
        $this->info('Starting membership status update process...');
        
        $expiredCount = GymMember::where('end_date', '<', now()->format('Y-m-d'))
            ->where('status', 'active')
            ->update(['status' => 'expired']);
            
        $expiringSoonCount = GymMember::where('end_date', '>', now()->format('Y-m-d'))
            ->where('end_date', '<=', now()->addDays(7)->format('Y-m-d'))
            ->where('status', 'active')
            ->count();
            
        Log::info("Updated {$expiredCount} memberships to expired status.");
        Log::info("Found {$expiringSoonCount} memberships expiring soon.");
        
        $this->info("Membership updates completed:");
        $this->info("- {$expiredCount} memberships marked as expired");
        $this->info("- {$expiringSoonCount} memberships expiring within 7 days");
        
        return 0;
    }
}
