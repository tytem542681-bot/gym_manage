@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl shadow-xl p-8">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Renew Membership</h1>
            <p class="text-gray-600 mt-2">Your previous plan: {{ $memberProfile->membership_plan }}</p>
        </div>

        <form method="POST" action="{{ route('client.renew') }}">
            @csrf
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">Select Plan</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($availablePlans as $plan => $price)
                        <label class="cursor-pointer">
                            <input type="radio" name="new_plan" value="{{ $plan }}" class="sr-only peer" required>
                            <div class="border-2 border-gray-200 rounded-lg p-4 text-center hover:border-blue-500 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition">
                                <div class="font-bold text-gray-900">{{ $plan }}</div>
                                <div class="text-sm text-gray-600">₱{{ number_format($price, 0) }}/mo</div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">Duration</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach([1 => '1 Month', 3 => '3 Months', 6 => '6 Months', 12 => '12 Months'] as $months => $label)
                        <label class="cursor-pointer">
                            <input type="radio" name="duration" value="{{ $months }}" class="sr-only peer" required>
                            <div class="border-2 border-gray-200 rounded-lg p-4 text-center hover:border-blue-500 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition">
                                <div class="font-bold text-gray-900">{{ $label }}</div>
                                <div class="text-xs text-gray-500">
                                    @if($months == 3) Save 5%
                                    @elseif($months == 6) Save 10%
                                    @elseif($months == 12) Save 20%
                                    @endif
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Note:</span>
                    <span class="text-gray-900">Renewal reactivates your membership with new dates</span>
                </div>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('client.dashboard') }}" class="flex-1 py-3 text-center border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" class="flex-1 py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 transition">
                    Renew Membership
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
