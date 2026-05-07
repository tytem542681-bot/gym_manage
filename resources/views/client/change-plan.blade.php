@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-900">Change Membership Plan</h1>
            <a href="{{ route('client.dashboard') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7l7-7"></path>
                </svg>
                Back to Dashboard
            </a>
        </div>
    </div>

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M12 12h4.01M16 12h4M8 12H4.01"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-6">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Current Membership</h2>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Current Plan</p>
                            <p class="text-lg font-medium text-gray-900">{{ $memberProfile->membership_plan ?: 'No active plan' }}</p>
                        </div>
                        <div class="flex flex-col">
                            <p class="text-sm text-gray-500 mb-1">Status</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                {{ $memberProfile->status === 'active' ? 'bg-green-100 text-green-800' : 
                                   ($memberProfile->status === 'expired' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($memberProfile->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('client.change-plan.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Select New Plan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($availablePlans as $plan => $price)
                            <div class="plan-card relative" data-plan="{{ $plan }}">
                                <input type="radio" id="plan_{{ $plan }}" name="new_plan" value="{{ $plan }}" 
                                    class="sr-only" {{ $memberProfile->membership_plan === $plan ? 'checked disabled' : '' }}>
                                <label for="plan_{{ $plan }}" class="block rounded-lg border-2 p-6 cursor-pointer transition-all duration-200
                                    {{ $memberProfile->membership_plan === $plan ? 'border-blue-500 bg-blue-50 cursor-not-allowed' : 'border-gray-200 hover:border-blue-300 hover:bg-gray-50' }}">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center mb-2">
                                                <p class="text-lg font-semibold text-gray-900">{{ $plan }}</p>
                                                @if($memberProfile->membership_plan === $plan)
                                                    <span class="ml-2 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        Current Plan
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-sm font-medium text-gray-700">₱{{ number_format($price, 2) }}/month</p>
                                        </div>
                                        <div class="flex-shrink-0 ml-4">
                                            <div class="radio-circle w-6 h-6 rounded-full border-2 
                                                {{ $memberProfile->membership_plan === $plan ? 'border-blue-500 bg-blue-600' : 'border-gray-300 bg-white' }} 
                                                flex items-center justify-center transition-all duration-200">
                                                @if($memberProfile->membership_plan === $plan)
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    
                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const planCards = document.querySelectorAll('.plan-card');
                        const radioInputs = document.querySelectorAll('input[name="new_plan"]');
                        
                        planCards.forEach(card => {
                            const radio = card.querySelector('input[type="radio"]');
                            const radioCircle = card.querySelector('.radio-circle');
                            const label = card.querySelector('label');
                            
                            if (!radio.disabled) {
                                label.addEventListener('click', function(e) {
                                    e.preventDefault();
                                    
                                    // Clear all selections
                                    planCards.forEach(otherCard => {
                                        const otherRadio = otherCard.querySelector('input[type="radio"]');
                                        const otherCircle = otherCard.querySelector('.radio-circle');
                                        const otherLabel = otherCard.querySelector('label');
                                        
                                        if (!otherRadio.disabled) {
                                            otherRadio.checked = false;
                                            otherCircle.classList.remove('border-blue-500', 'bg-blue-600');
                                            otherCircle.classList.add('border-gray-300', 'bg-white');
                                            otherCircle.innerHTML = '';
                                            otherLabel.classList.remove('border-blue-500', 'bg-blue-50');
                                            otherLabel.classList.add('border-gray-200');
                                        }
                                    });
                                    
                                    // Set current selection
                                    radio.checked = true;
                                    radioCircle.classList.remove('border-gray-300', 'bg-white');
                                    radioCircle.classList.add('border-blue-500', 'bg-blue-600');
                                    radioCircle.innerHTML = '<svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                                    label.classList.remove('border-gray-200');
                                    label.classList.add('border-blue-500', 'bg-blue-50');
                                });
                            }
                        });
                    });
                    </script>
                </div>

                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Notes (Optional)
                    </label>
                    <textarea id="notes" name="notes" rows="3" 
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                        placeholder="Any special requests or notes about this plan change...">{{ old('notes') }}</textarea>
                </div>

                <div class="flex justify-between items-center pt-4">
                    <a href="{{ route('client.dashboard') }}" 
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7l7-7"></path>
                        </svg>
                        Cancel
                    </a>
                    <button type="submit" 
                        class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H4a2 2 0 00-2 2v10a2 2 0 002 2h4"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7h4a2 2 0 012 2v10a2 2 0 01-2 2h-4"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v14"></path>
                        </svg>
                        Change Plan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-blue-900 mb-4">Plan Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-medium text-blue-900 mb-2">Basic Plan - ₱1,499.00/month</h4>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li>Access to gym floor</li>
                    <li>Basic equipment usage</li>
                    <li>Locker room access</li>
                </ul>
            </div>
            <div>
                <h4 class="font-medium text-blue-900 mb-2">Standard Plan - ₱2,499.00/month</h4>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li>All Basic features</li>
                    <li>Group fitness classes</li>
                    <li>Personal trainer consultation</li>
                </ul>
            </div>
            <div>
                <h4 class="font-medium text-blue-900 mb-2">Premium Plan - ₱3,999.00/month</h4>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li>All Standard features</li>
                    <li>Unlimited group classes</li>
                    <li>Personal training sessions</li>
                </ul>
            </div>
            <div>
                <h4 class="font-medium text-blue-900 mb-2">VIP Plan - ₱6,499.00/month</h4>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li>All Premium features</li>
                    <li>Private locker</li>
                    <li>Priority class booking</li>
                    <li>Nutrition consultation</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
