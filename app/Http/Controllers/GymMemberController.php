<?php

namespace App\Http\Controllers;

use App\Models\GymMember;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GymMemberController extends Controller
{
    public function index()
    {
        $query = GymMember::query();
        
        if (request('search')) {
            $searchTerm = request('search');
            $query->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('contact_number', 'like', '%' . $searchTerm . '%')
                  ->orWhere('membership_plan', 'like', '%' . $searchTerm . '%');
        }
        
        if (request('status')) {
            $query->where('status', request('status'));
        }
        
        $members = $query->latest()->paginate(10);
        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:120',
            'gender' => 'required|in:male,female,other',
            'contact_number' => 'required|email|unique:gym_members,contact_number|max:255',
            'membership_plan' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,expired,inactive',
        ]);

        $gymMember = GymMember::create($validated);

        if (! \App\Models\User::where('email', $validated['contact_number'])->exists()) {
            $password = '123';
            \App\Models\User::create([
                'name' => $validated['name'],
                'email' => $validated['contact_number'],
                'password' => \Illuminate\Support\Facades\Hash::make($password),
                'role' => 'client',
            ]);
            $message = 'Member created with login: ' . $validated['contact_number'] . ' / Password: ' . $password;
        } else {
            $message = 'Member created successfully. User account already exists.';
        }

        return redirect()->route('members.index')
            ->with('success', $message);
    }

    public function show(GymMember $member)
    {
        return view('members.show', compact('member'));
    }

    public function edit(GymMember $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, GymMember $member)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:1|max:120',
            'gender' => 'required|in:male,female,other',
            'contact_number' => 'required|email|max:255|unique:gym_members,contact_number,' . $member->id,
            'membership_plan' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,expired,inactive',
        ]);

        $oldEmail = $member->contact_number;
        $member->update($validated);

        if ($oldEmail != $validated['contact_number']) {
            $user = \App\Models\User::where('email', $oldEmail)->first();
            if ($user) {
                $user->update(['email' => $validated['contact_number']]);
            }
        }

        return redirect()->route('members.index')
            ->with('success', 'Member updated successfully.');
    }

    public function destroy(GymMember $member)
    {
        $member->delete();

        return redirect()->route('members.index')
            ->with('success', 'Member deleted successfully.');
    }
}
