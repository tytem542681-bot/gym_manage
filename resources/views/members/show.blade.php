@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Member Details</h1>
        <p class="text-gray-600 mt-2">View detailed information about {{ $member->name }}.</p>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $member->name }}</h2>
                    <span class="mt-2 px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                        {{ $member->status === 'active' ? 'bg-green-100 text-green-800' : 
                           ($member->status === 'expired' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                        {{ ucfirst($member->status) }}
                    </span>
                </div>
                
                @if(auth()->user()->role === 'admin')
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.members.edit', $member) }}" 
                           class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                            Edit Member
                        </a>
                        <form action="{{ route('admin.members.destroy', $member) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this member?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                                Delete
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Personal Information</h3>
                    
                    <div class="flex">
                        <span class="text-gray-500 w-32">Age:</span>
                        <span class="text-gray-800 font-medium">{{ $member->age }} years</span>
                    </div>
                    
                    <div class="flex">
                        <span class="text-gray-500 w-32">Gender:</span>
                        <span class="text-gray-800 font-medium">{{ ucfirst($member->gender) }}</span>
                    </div>
                    
<div class="flex">
                        <span class="text-gray-500 w-32">Email:</span>
                        <span class="text-gray-800 font-medium">{{ $member->contact_number }}</span>
                        <p class="text-xs text-gray-500 ml-32 -mt-1">Client login email. Password generated on creation.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Membership Information</h3>
                    
                    <div class="flex">
                        <span class="text-gray-500 w-32">Plan:</span>
                        <span class="text-gray-800 font-medium">{{ $member->membership_plan }}</span>
                    </div>
                    
                    <div class="flex">
                        <span class="text-gray-500 w-32">Start Date:</span>
                        <span class="text-gray-800 font-medium">{{ $member->start_date->format('F d, Y') }}</span>
                    </div>
                    
                    <div class="flex">
                        <span class="text-gray-500 w-32">End Date:</span>
                        <span class="text-gray-800 font-medium">{{ $member->end_date->format('F d, Y') }}</span>
                    </div>
                    
                    <div class="flex">
                        <span class="text-gray-500 w-32">Duration:</span>
                        <span class="text-gray-800 font-medium">
                            {{ $member->start_date->diffInDays($member->end_date) }} days
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Additional Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-gray-50 p-4 rounded">
                        <p class="text-sm text-gray-500">Member Since</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $member->created_at->format('F d, Y') }}</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded">
                        <p class="text-sm text-gray-500">Days Remaining</p>
                        <p class="text-lg font-semibold text-gray-800">
                            @if($member->status === 'active')
                                {{ max(0, now()->diffInDays($member->end_date)) }} days
                            @else
                                Expired
                            @endif
                        </p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded">
                        <p class="text-sm text-gray-500">Last Updated</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $member->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 flex space-x-4">
        <a href="{{ auth()->user()->role === 'admin' ? route('admin.members.index') : route('staff.members.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
            Back to Members
        </a>
        
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.members.edit', $member) }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                Edit Member
            </a>
        @endif
    </div>
</div>
@endsection
