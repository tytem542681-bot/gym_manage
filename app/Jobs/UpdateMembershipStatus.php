<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\GymMember;

class UpdateMembershipStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $expiredCount = GymMember::where('end_date', '<', now()->format('Y-m-d'))
            ->where('status', '!=', 'expired')
            ->update(['status' => 'expired']);
            
        \Log::info("Updated {$expiredCount} memberships to expired status.");
    }
}
