@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 space-y-8">
        <div>
            <div class="mx-auto h-20 w-20 bg-blue-600 rounded-2xl flex items-center justify-center mb-6">
                <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 text-center">Welcome! Choose Your Plan</h2>
            <p class="mt-2 text-lg text-gray-600 text-center">Select a membership plan to get started with your gym journey.</p>
        </div>

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('client.select-plan-action') }}" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Membership Plans</label>
                <div class="space-y-3">
                    <div class="relative">
                        <select name="membership_plan" required class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none bg-white shadow-sm">
                            <option value="">Choose your plan</option>
                            <option value="Basic">Basic - ₱500/month</option>
                            <option value="Standard">Standard - ₱800/month</option>
                            <option value="Premium">Premium - ₱1,200/month</option>
                            <option value="VIP">VIP - ₱2,000/month</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 px-2 flex items-center">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50 transition duration-300 transform hover:-translate-y-0.5">
                    <span class="text-lg">Start Membership</span>
                </button>
            </div>
        </form>

        <div class="text-center text-sm text-gray-500 space-y-2">
            <p>Your membership starts immediately upon selection!</p>
            <p>You can upgrade/downgrade plans anytime from dashboard.</p>
        </div>
    </div>
</div>
@endsection

