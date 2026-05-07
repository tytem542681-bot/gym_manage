<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\GymMember;

class UpdateExpiredMemberships extends Command
{
    protected $signature = 'memberships:update-expired';
    protected $description = 'Update expired memberships based on end dates';

    public function handle()
    {
        $this->info('Updating expired memberships...');
        
        $expiredCount = GymMember::where('end_date', '<', now()->format('Y-m-d'))
            ->where('status', '!=', 'expired')
            ->update(['status' => 'expired']);
            
        $this->info("Updated {$expiredCount} memberships to expired status.");
        
        $this->info('Membership status update completed successfully.');
    }
}
