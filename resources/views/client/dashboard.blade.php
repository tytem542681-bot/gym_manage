@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Welcome, {{ auth()->user()->name }}!</h1>
        <p class="text-gray-600 mt-2">Manage your gym membership and track your fitness journey.</p>
    </div>

@if($memberProfile)
        @include('components.membership-status')

        <!-- Status Banner -->
        @if($memberProfile->status === 'expired')
        <div class="bg-red-600 rounded-xl p-6 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold">Membership Expired</h2>
                    <p class="text-red-200">Your membership expired on {{ \Carbon\Carbon::parse($memberProfile->end_date)->format('F j, Y') }}</p>
                </div>
                <a href="{{ route('client.renew') }}" class="px-6 py-3 bg-white text-red-600 font-bold rounded-lg hover:bg-gray-100">
                    Renew Now
                </a>
            </div>
        </div>
        @elseif($memberProfile->status === 'inactive')
        <div class="bg-yellow-600 rounded-xl p-6 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold">Membership Inactive</h2>
                    <p class="text-yellow-200">Check in to reactivate your membership</p>
                </div>
                <a href="{{ route('client.attendance') }}" class="px-6 py-3 bg-white text-yellow-600 font-bold rounded-lg hover:bg-gray-100">
                    Check In
                </a>
            </div>
        </div>
        @elseif($memberProfile->membership_plan !== 'pending')
        <div class="bg-green-600 rounded-xl p-6 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold">{{ $memberProfile->membership_plan }} Plan</h2>
                    <p class="text-green-200">Valid until {{ \Carbon\Carbon::parse($memberProfile->end_date)->format('F j, Y') }}</p>
                </div>
                <span class="px-4 py-2 bg-green-500 rounded-full font-medium">
                    {{ ucfirst($memberProfile->status) }}
                </span>
            </div>
        </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <p class="text-sm text-gray-500 mb-1">Plan</p>
                <p class="text-xl font-bold text-gray-900">{{ $memberProfile->membership_plan }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <p class="text-sm text-gray-500 mb-1">Days Remaining</p>
<p class="text-xl font-bold {{ $memberProfile->status === 'active' && now()->lt($memberProfile->end_date) ? 'text-green-600' : 'text-red-600' }}">
                    @if($memberProfile->status === 'active' && now()->lt($memberProfile->end_date))
                        {{ number_format(now()->diffInDays($memberProfile->end_date), 1) }}
                    @else
                        0.0
                    @endif
                </p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <p class="text-sm text-gray-500 mb-1">Member Since</p>
                <p class="text-xl font-bold text-gray-900">{{ \Carbon\Carbon::parse($memberProfile->start_date)->format('M d, Y') }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <p class="text-sm text-gray-500 mb-1">Member ID</p>
                <p class="text-xl font-bold text-gray-900">#{{ str_pad($memberProfile->id, 4, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Personal Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Personal Information</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-xs text-gray-500">Full Name</p>
                        <p class="text-sm font-medium text-gray-900">{{ $memberProfile->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Age</p>
                        <p class="text-sm font-medium text-gray-900">{{ $memberProfile->age }} years</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Gender</p>
                        <p class="text-sm font-medium text-gray-900">{{ ucfirst($memberProfile->gender) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Contact</p>
                        <p class="text-sm font-medium text-gray-900">{{ $memberProfile->contact_number }}</p>
                    </div>
                </div>
            </div>

            <!-- Membership Details -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Membership Details</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-xs text-gray-500">Start Date</p>
                        <p class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($memberProfile->start_date)->format('F d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">End Date</p>
                        <p class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($memberProfile->end_date)->format('F d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Status</p>
                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full
                            {{ $memberProfile->status === 'active' ? 'bg-green-100 text-green-800' : 
                               ($memberProfile->status === 'expired' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ ucfirst($memberProfile->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Quick Links</h3>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('client.profile') }}" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                        <svg class="w-5 h-5 text-gray-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="text-sm font-medium text-gray-900">My Profile</span>
                    </a>
                    <a href="{{ route('client.membership-history') }}" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                        <svg class="w-5 h-5 text-gray-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3v-4l3-3M3 21h18M3 10h18"></path>
                        </svg>
                        <span class="text-sm font-medium text-gray-900">History</span>
                    </a>
                    <a href="{{ route('client.change-plan') }}" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                        <svg class="w-5 h-5 text-gray-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0 0V6"></path>
                        </svg>
                        <span class="text-sm font-medium text-gray-900">Change Plan</span>
                    </a>
                    <a href="{{ route('client.attendance') }}" class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100">
                        <svg class="w-5 h-5 text-gray-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <span class="text-sm font-medium text-gray-900">Attendance</span>
                    </a>
                </div>
            </div>
        </div>
    @else
        <!-- No Profile -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Membership Found</h3>
            <p class="text-gray-600 mb-4">Contact gym staff to set up your membership.</p>
            <a href="{{ route('client.support') }}" class="text-blue-600 hover:text-blue-800">Contact Support</a>
        </div>
    @endif
</div>
@endsection
