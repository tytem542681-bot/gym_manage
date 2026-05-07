@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-900">Support</h1>
            <a href="{{ route('client.dashboard') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7l7-7"></path>
                </svg>
                Back to Dashboard
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8a7 7 0 11-8 0 7 7 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4 text-center">Contact Support</h3>
            <div class="space-y-4">
                <div>
                    <h4 class="font-medium text-gray-900 mb-2">Get Help Fast</h4>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 002 2h3a2 2 0 002 2v3a2 2 0 002 2h-2a2 2 0 012 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h5 class="text-sm font-medium text-gray-900">Live Chat Support</h5>
                                <p class="text-sm text-gray-600">Available during gym hours</p>
                                <p class="text-xs text-gray-500">Monday - Friday: 6:00 AM - 9:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="font-medium text-gray-900 mb-2">Email Support</h4>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8a7 7 0 11-8 0 7 7 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h5 class="text-sm font-medium text-gray-900">Email Us</h5>
                                <p class="text-sm text-gray-600">support@gymmanage.com</p>
                                <p class="text-xs text-gray-500">Response within 24 hours</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="font-medium text-gray-900 mb-2">Phone Support</h4>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 002 2h6a2 2 0 002 2v3a2 2 0 002 2h-2a2 2 0 012 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h5 class="text-sm font-medium text-gray-900">Call Us</h5>
                                <p class="text-sm text-gray-600">+1 (555) 123-4567</p>
                                <p class="text-xs text-gray-500">Available during gym hours</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4 text-center">Help Resources</h3>
            <div class="space-y-4">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h4 class="font-medium text-blue-900 mb-2">Frequently Asked Questions</h4>
                    <div class="space-y-3">
                        <div>
                            <h5 class="text-sm font-medium text-blue-900">How do I cancel my membership?</h5>
                            <p class="text-sm text-blue-700">You can cancel your membership anytime through your profile settings or by contacting our support team.</p>
                        </div>
                        <div>
                            <h5 class="text-sm font-medium text-blue-900">Can I freeze my membership?</h5>
                            <p class="text-sm text-blue-700">Yes, you can freeze your membership for up to 3 months. Contact support for details.</p>
                        </div>
                        <div>
                            <h5 class="text-sm font-medium text-blue-900">How do I upgrade my plan?</h5>
                            <p class="text-sm text-blue-700">Visit the Change Plan section in your dashboard to upgrade or downgrade your membership.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <h4 class="font-medium text-yellow-900 mb-2">Gym Rules & Policies</h4>
                    <div class="space-y-2">
                        <div class="flex items-start">
                            <svg class="w-4 h-4 text-yellow-500 mr-2 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m6 4h6m2 5H7a2 2 0 01-2 2v2a2 2 0 002 2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707L19.586 16H7a2 2 0 01-2-2v-5a2 2 0 00-2-2h-2M9 5a2 2 0 012 2h2a2 2 0 012 2"></path>
                            </svg>
                            <div>
                                <h5 class="text-sm font-medium text-yellow-900">Important Rules</h5>
                                <ul class="text-sm text-yellow-700 space-y-1 list-disc list-inside ml-4">
                                    <li>Always bring your membership card</li>
                                    <li>Wear appropriate gym attire</li>
                                    <li>Follow equipment safety guidelines</li>
                                    <li>Respect time limits on equipment</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
