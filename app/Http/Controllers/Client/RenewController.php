<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GymMember;
use App\Models\MembershipHistory;
use Carbon\Carbon;

class RenewController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $memberProfile = GymMember::where('contact_number', $user->email)->first();
        
        if (!$memberProfile || $memberProfile->status !== 'expired') {
            return redirect()->route('client.dashboard')->with('error', 'No expired membership found.');
        }

        $availablePlans = [
            'Basic' => 1499.00,
            'Standard' => 2499.00,
            'Premium' => 3999.00,
            'VIP' => 6499.00,
        ];
        
        return view('client.renew', compact('memberProfile', 'availablePlans'));
    }

    public function renew(Request $request)
    {
        $request->validate([
            'new_plan' => 'required|string|in:Basic,Standard,Premium,VIP',
            'duration' => 'required|integer|in:1,3,6,12',
        ]);
        
        $user = auth()->user();
        $memberProfile = GymMember::where('contact_number', $user->email)->first();
        
        if (!$memberProfile || $memberProfile->status !== 'expired') {
            return redirect()->route('client.dashboard')->with('error', 'No expired membership found.');
        }
        
        $availablePlans = [
            'Basic' => 1499.00,
            'Standard' => 2499.00,
            'Premium' => 3999.00,
            'VIP' => 6499.00,
        ];
        
        $previousPlan = $memberProfile->membership_plan;
        $newPlan = $request->new_plan;
        $duration = $request->duration;
        $newPrice = $availablePlans[$newPlan] * $duration;
        
        MembershipHistory::create([
            'gym_member_id' => $memberProfile->id,
            'previous_plan' => $previousPlan,
            'new_plan' => $newPlan,
            'previous_price' => $previousPlan ? $availablePlans[$previousPlan] : null,
            'new_price' => $newPrice,
            'effective_date' => Carbon::now()->toDateString(),
            'notes' => 'Renewal for ' . $duration . ' month(s)',
            'change_type' => 'renewal',
        ]);
        
        $memberProfile->update([
            'membership_plan' => $newPlan,
            'start_date' => now()->toDateString(),
'end_date' => now()->addMonths((int) $duration)->toDateString(),
            'status' => 'active',
        ]);
        
        return redirect()->route('client.dashboard')->with('success', 'Membership renewed successfully! Your membership is now active.');
    }
}
