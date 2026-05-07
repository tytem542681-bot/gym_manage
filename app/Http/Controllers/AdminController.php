<?php

namespace App\Http\Controllers;

use App\Models\GymMember;
use App\Models\Attendance;
use App\Models\MembershipHistory;
use Illuminate\Http\Request;

class AdminController extends Controller
{
public function dashboard()
    {
        $totalMembers = GymMember::count();
        $activeMembers = GymMember::where('status', 'active')->count();
        $expiredMembers = GymMember::where('status', 'expired')->count();
        $inactiveMembers = GymMember::where('status', 'inactive')->count();
        $recentMembers = GymMember::latest()->take(10)->get();
        
        $newThisMonth = GymMember::whereMonth('created_at', now()->month)->count();
        $revenue = 4250;
        $retention = $totalMembers > 0 ? round(($activeMembers / $totalMembers) * 100) : 0;

        return view('admin.dashboard', compact(
            'totalMembers',
            'activeMembers', 
            'expiredMembers',
            'inactiveMembers',
            'recentMembers',
            'newThisMonth',
            'revenue',
            'retention'
        ));
    }

    public function attendance()
    {
$query = Attendance::with('gymMember');
        if (request('search')) {
            $query->whereHas('gymMember', function ($q) {
                $q->where('name', 'like', '%' . request('search') . '%');
            });
        }
        $attendance = $query->orderBy('check_in_date', 'desc')
            ->orderBy('check_in_time', 'desc')
            ->paginate(15);
        
$todayQuery = clone $query;
        $todayAttendance = $todayQuery->whereDate('check_in_date', now()->toDateString())->count();
        $weeklyQuery = clone $query;
        $weeklyAttendance = $weeklyQuery->whereBetween('check_in_date', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $monthlyQuery = clone $query;
        $monthlyAttendance = $monthlyQuery->whereMonth('check_in_date', now()->month)->count();

        return view('admin.attendance', compact('attendance', 'todayAttendance', 'weeklyAttendance', 'monthlyAttendance'));
    }

    public function activities()
    {
$query = MembershipHistory::with('gymMember');
        if (request('search')) {
            $query->whereHas('gymMember', function ($q) {
                $q->where('name', 'like', '%' . request('search') . '%');
            });
        }
        $activities = $query->orderBy('effective_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        $recentChanges = MembershipHistory::whereDate('effective_date', '>=', now()->subDays(7))->count();
        $upgrades = MembershipHistory::where('change_type', 'upgrade')->count();
        $downgrades = MembershipHistory::where('change_type', 'downgrade')->count();

        return view('admin.activities', compact('activities', 'recentChanges', 'upgrades', 'downgrades'));
    }
}
