@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
            <div class="flex justify-center mb-8">
                <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </div>
            </div>
            
            <h1 class="text-5xl font-bold text-gray-900 mb-6">Gym Membership Management System</h1>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                Manage your gym members efficiently with our comprehensive management system. 
                Track memberships, monitor attendance, and grow your fitness business.
            </p>
            
            @guest
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg shadow-lg transition duration-200">
                        Get Started
                    </a>
                    <a href="{{ route('login') }}" class="bg-white hover:bg-gray-50 text-blue-600 font-semibold py-3 px-8 rounded-lg border-2 border-blue-600 transition duration-200">
                        Login
                    </a>
                </div>
            @else
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-8 rounded-lg shadow-lg transition duration-200">
                            Admin Dashboard
                        </a>
                    @else
                        <a href="{{ route('staff.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg shadow-lg transition duration-200">
                            Staff Dashboard
                        </a>
                    @endif
                </div>
            @endguest
        </div>
    </div>
</div>


<div class="bg-gradient-to-r from-blue-600 to-indigo-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold text-white mb-2">500+</div>
                <div class="text-blue-100 text-lg">Gyms Managed</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-white mb-2">50K+</div>
                <div class="text-blue-100 text-lg">Active Members</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-white mb-2">99.9%</div>
                <div class="text-blue-100 text-lg">Uptime</div>
            </div>
        </div>
    </div>
</div>
@endsection
