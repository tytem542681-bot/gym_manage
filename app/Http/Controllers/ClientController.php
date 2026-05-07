<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GymMember;
use App\Models\MembershipHistory;
use App\Models\Attendance;
use Carbon\Carbon;

class ClientController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $memberProfile = GymMember::where('contact_number', $user->email)->first();

        if (!$memberProfile) {
            return view('client.dashboard', ['memberProfile' => null, 'recentAttendance' => collect()]);
        }

        $memberProfile->days_remaining = $memberProfile->status === 'active' && $memberProfile->end_date && Carbon::now()->lt($memberProfile->end_date)
            ? Carbon::now()->diffInDays($memberProfile->end_date)
            : 0;

        $memberProfile->is_expired = ($memberProfile->status === 'expired' || ($memberProfile->end_date && Carbon::now()->gt($memberProfile->end_date)));

        $recentAttendance = $memberProfile->attendances()
            ->orderBy('check_in_date', 'desc')
            ->take(5)
            ->get();

        return view('client.dashboard', compact('memberProfile', 'recentAttendance'));
    }

    public function membershipHistory()
    {
        $user = auth()->user();
        $memberProfile = GymMember::where('contact_number', $user->email)->first();
        
        if (!$memberProfile) {
            return redirect()->route('client.dashboard')->with('error', 'Membership profile not found.');
        }
        
        $history = $memberProfile->membershipHistory;
        
        return view('client.membership-history', compact('memberProfile', 'history'));
    }

    public function selectPlan()
    {
        $user = auth()->user();
        $memberProfile = GymMember::where('contact_number', $user->email)->first();

        if (!$memberProfile || $memberProfile->status !== 'pending_plan') {
            return redirect()->route('client.dashboard');
        }

        return view('client.select-plan', compact('memberProfile'));
    }

    public function selectPlanStore(Request $request)
    {
        $request->validate([
            'membership_plan' => 'required|in:Basic,Standard,Premium,VIP',
        ]);

        $user = auth()->user();
        $memberProfile = GymMember::where('contact_number', $user->email)->first();

        if (!$memberProfile || $memberProfile->status !== 'pending_plan') {
            return redirect()->route('client.dashboard');
        }

$memberProfile->update([
            'membership_plan' => $request->membership_plan,
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'status' => 'active',
        ]);

        MembershipHistory::create([
            'gym_member_id' => $memberProfile->id,
            'new_plan' => $request->membership_plan,
            'change_type' => 'initial',
            'effective_date' => now(),
            'notes' => 'Initial plan selection by client',
        ]);

        return redirect()->route('client.dashboard')->with('success', 'Welcome! Your membership is active. Enjoy your gym!');
    }

    public function showChangePlan()
    {
        $user = auth()->user();
        $memberProfile = GymMember::where('contact_number', $user->email)->first();
        
if (!$memberProfile) {
            return redirect()->route('client.dashboard')->with('error', 'No membership found.');
        }

        $availablePlans = [
            'Basic' => 1499.00,
            'Standard' => 2499.00,
            'Premium' => 3999.00,
            'VIP' => 6499.00,
        ];
        
        return view('client.change-plan', compact('memberProfile', 'availablePlans'));
    }

    public function changePlan(Request $request)
    {
        $request->validate([
            'new_plan' => 'required|string|in:Basic,Standard,Premium,VIP',
            'notes' => 'nullable|string|max:500',
        ]);
        
        $user = auth()->user();
        $memberProfile = GymMember::where('contact_number', $user->email)->first();
        
        if (!$memberProfile) {
            return redirect()->route('client.dashboard')->with('error', 'Membership profile not found.');
        }
        
        $availablePlans = [
            'Basic' => 1499.00,
            'Standard' => 2499.00,
            'Premium' => 3999.00,
            'VIP' => 6499.00,
        ];
        
        $previousPlan = $memberProfile->membership_plan;
        $newPlan = $request->new_plan;
        $newPrice = $availablePlans[$newPlan];
        
        if ($previousPlan === $newPlan) {
            return redirect()->route('client.change-plan')->with('error', 'Please select a different plan.');
        }
        
        $changeType = 'new';
        if ($memberProfile->membership_plan) {
            $changeType = $this->determineChangeType($previousPlan, $newPlan, $availablePlans);
        }
        
        MembershipHistory::create([
            'gym_member_id' => $memberProfile->id,
            'previous_plan' => $previousPlan,
            'new_plan' => $newPlan,
            'previous_price' => $previousPlan ? $availablePlans[$previousPlan] : null,
            'new_price' => $newPrice,
            'effective_date' => Carbon::now()->toDateString(),
            'notes' => $request->notes,
            'change_type' => $changeType,
        ]);
        
        $memberProfile->update([
            'membership_plan' => $newPlan,
        ]);
        
        return redirect()->route('client.membership-history')->with('success', 'Membership plan changed successfully!');
    }
    
    public function profile()
    {
        $user = auth()->user();
        return view('client.profile', compact('user'));
    }

    public function attendance()
    {
        $user = auth()->user();
        $memberProfile = GymMember::where('contact_number', $user->email)->first();
        
        if (!$memberProfile) {
            return redirect()->route('client.dashboard')->with('error', 'Membership profile not found.');
        }
        
        $attendance = $memberProfile->attendance;
        $recentAttendance = $memberProfile->attendances()
            ->orderBy('check_in_date', 'desc')
            ->take(10)
            ->get();
        
        return view('client.attendance', compact('memberProfile', 'attendance', 'recentAttendance'));
    }

    public function support()
    {
        $user = auth()->user();
        return view('client.support', compact('user'));
    }

    public function checkIn(Request $request)
    {
        $request->validate([
            'activity_type' => 'required|string|in:workout,class,personal_training,swimming,other',
            'notes' => 'nullable|string|max:500',
        ]);
        
        $user = auth()->user();
        $memberProfile = GymMember::where('contact_number', $user->email)->first();
        
        if (!$memberProfile) {
            return redirect()->route('client.dashboard')->with('error', 'Membership profile not found.');
        }
        
        Attendance::create([
            'gym_member_id' => $memberProfile->id,
            'check_in_date' => now()->toDateString(),
            'check_in_time' => now(),
            'activity_type' => $request->activity_type,
            'notes' => $request->notes,
        ]);
        
return redirect()->route('client.attendance')->with('success', 'Checked in successfully! Time: ' . now()->format('h:i A'));
    }
    
    public function checkOut(Request $request)
    {
        $request->validate([
            'attendance_id' => 'required|exists:attendance,id',
        ]);
        
        $user = auth()->user();
        $memberProfile = GymMember::where('contact_number', $user->email)->first();
        
        if (!$memberProfile) {
            return redirect()->route('client.dashboard')->with('error', 'Membership profile not found.');
        }
        
        $attendance = Attendance::where('id', $request->attendance_id)
            ->where('gym_member_id', $memberProfile->id)
            ->whereNull('check_out_date')
            ->first();
            
        if (!$attendance) {
            return redirect()->route('client.dashboard')->with('error', 'No active check-in found to check out from.');
        }
        
        $checkOutTime = now();
        $checkInTime = $attendance->check_in_time;
        $durationHours = $checkInTime->diffInMinutes($checkOutTime) / 60;
        
        $attendance->update([
            'check_out_date' => $checkOutTime->toDateString(),
            'check_out_time' => $checkOutTime,
            'duration_hours' => round($durationHours, 2),
        ]);
        
return redirect()->route('client.attendance')->with('success', 'Checked out successfully! Duration: ' . number_format($durationHours, 2) . ' hrs');
    }
    
    private function determineChangeType($previousPlan, $newPlan, $availablePlans)
    {
        if (!$previousPlan) {
            return 'new';
        }
        
        $previousPrice = $availablePlans[$previousPlan];
        $newPrice = $availablePlans[$newPlan];
        
        if ($newPrice > $previousPrice) {
            return 'upgrade';
        } elseif ($newPrice < $previousPrice) {
            return 'downgrade';
        } else {
            return 'renewal';
        }
    }
}
