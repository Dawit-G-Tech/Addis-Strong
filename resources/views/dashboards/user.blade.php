<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="space-y-6">
                        <!-- Page Header -->
                        <div class="bg-white shadow-sm rounded-lg p-6">
                            <h1 class="text-3xl font-bold text-gray-900">Welcome to Addis-strong</h1>
                            <p class="text-gray-600 mt-2">Hello {{ auth()->user()->name }}! Ready to start your fitness journey?</p>
                        </div>

                        <!-- Welcome Message -->
                        <div class="bg-gradient-to-r from-blue-50 to-purple-50 border border-blue-200 rounded-lg p-6">
                            <div class="flex items-center">
                                <div class="bg-blue-100 p-3 rounded-full">
                                    <i class="fas fa-heart text-blue-600 text-xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h2 class="text-xl font-semibold text-gray-900">Welcome to Addis-strong Gym!</h2>
                                    <p class="text-gray-600 mt-1">
                                        You're just one step away from accessing our world-class facilities, expert trainers, and supportive community.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Membership Options -->
                        <div class="bg-white shadow-sm rounded-lg p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Choose Your Membership</h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition">
                                    <div class="text-center">
                                        <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="fas fa-calendar-day text-green-600 text-xl"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Basic Monthly</h3>
                                        <p class="text-3xl font-bold text-green-600 mb-2">$29.99</p>
                                        <p class="text-gray-600 text-sm mb-4">Perfect for getting started</p>
                                        <ul class="text-sm text-gray-600 space-y-2 mb-6">
                                            <li><i class="fas fa-check text-green-500 mr-2"></i>Access to gym facilities</li>
                                            <li><i class="fas fa-check text-green-500 mr-2"></i>Basic equipment usage</li>
                                            <li><i class="fas fa-check text-green-500 mr-2"></i>Locker room access</li>
                                        </ul>
                                        <a href="{{ route('memberships.index') }}" class="block w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition text-center">
                                            Choose Plan
                                        </a>
                                    </div>
                                </div>

                                <div class="border-2 border-purple-500 rounded-lg p-6 hover:shadow-md transition relative">
                                    <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                                        <span class="bg-purple-600 text-white px-3 py-1 rounded-full text-sm font-medium">Most Popular</span>
                                    </div>
                                    <div class="text-center">
                                        <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="fas fa-dumbbell text-purple-600 text-xl"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Premium Monthly</h3>
                                        <p class="text-3xl font-bold text-purple-600 mb-2">$49.99</p>
                                        <p class="text-gray-600 text-sm mb-4">Best value for serious fitness</p>
                                        <ul class="text-sm text-gray-600 space-y-2 mb-6">
                                            <li><i class="fas fa-check text-purple-500 mr-2"></i>All Basic features</li>
                                            <li><i class="fas fa-check text-purple-500 mr-2"></i>Group classes included</li>
                                            <li><i class="fas fa-check text-purple-500 mr-2"></i>Personal trainer consultation</li>
                                            <li><i class="fas fa-check text-purple-500 mr-2"></i>Nutrition guidance</li>
                                        </ul>
                                        <a href="{{ route('memberships.index') }}" class="block w-full bg-purple-600 text-white py-2 px-4 rounded-md hover:bg-purple-700 transition text-center">
                                            Choose Plan
                                        </a>
                                    </div>
                                </div>

                                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition">
                                    <div class="text-center">
                                        <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="fas fa-crown text-yellow-600 text-xl"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Elite Annual</h3>
                                        <p class="text-3xl font-bold text-yellow-600 mb-2">$399.99</p>
                                        <p class="text-gray-600 text-sm mb-4">Save 33% with annual plan</p>
                                        <ul class="text-sm text-gray-600 space-y-2 mb-6">
                                            <li><i class="fas fa-check text-yellow-500 mr-2"></i>All Premium features</li>
                                            <li><i class="fas fa-check text-yellow-500 mr-2"></i>Priority booking</li>
                                            <li><i class="fas fa-check text-yellow-500 mr-2"></i>Exclusive events</li>
                                            <li><i class="fas fa-check text-yellow-500 mr-2"></i>Guest passes</li>
                                        </ul>
                                        <a href="{{ route('memberships.index') }}" class="block w-full bg-yellow-600 text-white py-2 px-4 rounded-md hover:bg-yellow-700 transition text-center">
                                            Choose Plan
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="bg-white shadow-sm rounded-lg p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Get Started</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <a href="{{ route('memberships.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                    <i class="fas fa-credit-card text-blue-600 text-xl mr-3"></i>
                                    <div>
                                        <p class="font-medium text-gray-900">Purchase Membership</p>
                                        <p class="text-sm text-gray-600">Choose a plan and start your fitness journey</p>
                                    </div>
                                </a>

                                <a href="#" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                    <i class="fas fa-user-plus text-green-600 text-xl mr-3"></i>
                                    <div>
                                        <p class="font-medium text-gray-900">Apply for Staff Position</p>
                                        <p class="text-sm text-gray-600">Join our team as a trainer or staff member</p>
                                    </div>
                                </a>

                                <a href="#" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                    <i class="fas fa-info-circle text-purple-600 text-xl mr-3"></i>
                                    <div>
                                        <p class="font-medium text-gray-900">Learn More</p>
                                        <p class="text-sm text-gray-600">Discover our facilities and services</p>
                                    </div>
                                </a>

                                <a href="#" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                    <i class="fas fa-calendar-alt text-orange-600 text-xl mr-3"></i>
                                    <div>
                                        <p class="font-medium text-gray-900">Schedule Tour</p>
                                        <p class="text-sm text-gray-600">Visit our gym and meet our team</p>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <!-- Gym Features Preview -->
                        <div class="bg-white shadow-sm rounded-lg p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Why Choose Addis-strong?</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div class="text-center">
                                    <div class="bg-blue-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <i class="fas fa-dumbbell text-blue-600"></i>
                                    </div>
                                    <h3 class="font-medium text-gray-900">Modern Equipment</h3>
                                    <p class="text-sm text-gray-600">State-of-the-art fitness equipment</p>
                                </div>
                                <div class="text-center">
                                    <div class="bg-green-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <i class="fas fa-users text-green-600"></i>
                                    </div>
                                    <h3 class="font-medium text-gray-900">Expert Trainers</h3>
                                    <p class="text-sm text-gray-600">Certified personal trainers</p>
                                </div>
                                <div class="text-center">
                                    <div class="bg-purple-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <i class="fas fa-heart text-purple-600"></i>
                                    </div>
                                    <h3 class="font-medium text-gray-900">Supportive Community</h3>
                                    <p class="text-sm text-gray-600">Motivating fitness community</p>
                                </div>
                                <div class="text-center">
                                    <div class="bg-yellow-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <i class="fas fa-clock text-yellow-600"></i>
                                    </div>
                                    <h3 class="font-medium text-gray-900">24/7 Access</h3>
                                    <p class="text-sm text-gray-600">Flexible workout hours</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
