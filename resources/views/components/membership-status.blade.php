@if($memberProfile && $memberProfile->status === 'expired')
    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="text-red-800 font-semibold">Membership Expired</h3>
                <p class="text-red-600 text-sm">Your membership expired on {{ \Carbon\Carbon::parse($memberProfile->end_date)->format('F d, Y') }}</p>
                <p class="text-red-600 text-sm mt-2">Please <a href="{{ route('client.change-plan') }}" class="underline font-medium">renew your membership</a> to continue accessing gym facilities.</p>
            </div>
        </div>
    </div>
@endif

@if($memberProfile && $memberProfile->status === 'inactive')
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2 2m0 0v4l3 3m0-4l-3-3m3 3v4m0-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="text-gray-800 font-semibold">Membership Inactive</h3>
                <p class="text-gray-600 text-sm">Your membership has been marked as inactive due to no gym visits for 3 consecutive days.</p>
                <p class="text-gray-600 text-sm mt-2">Please <a href="{{ route('client.attendance') }}" class="underline font-medium">check in</a> to reactivate your membership.</p>
            </div>
        </div>
    </div>
@endif

@if($memberProfile && $memberProfile->status === 'active' && $memberProfile->end_date->diffInDays(now()) <= 7)
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m0-4l-3-3m3 3v4m0-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="text-yellow-800 font-semibold">Membership Expiring Soon</h3>
                <p class="text-yellow-600 text-sm">Your membership will expire on {{ \Carbon\Carbon::parse($memberProfile->end_date)->format('F d, Y') }}</p>
<p class="text-yellow-600 text-sm mt-2">{{ number_format($memberProfile->end_date->diffInDays(now()), 1) }} days remaining. <a href="{{ route('client.change-plan') }}" class="underline font-medium">Renew now</a> to avoid interruption.</p>
            </div>
        </div>
    </div>
@endif
