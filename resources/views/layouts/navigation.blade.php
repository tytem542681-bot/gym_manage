<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-gray-900">GymManage</span>
                    </a>
                </div>

                <div class="hidden space-x-1 sm:ms-8 sm:flex">
                    <a href="{{ route('about') }}" class="px-3 py-2 rounded-md text-sm font-medium 
                        {{ request()->routeIs('about') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        About
                    </a>
                    @guest
                        <a href="{{ route('login') }}" class="px-3 py-2 rounded-md text-sm font-medium 
                            {{ request()->routeIs('login') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="px-3 py-2 rounded-md text-sm font-medium 
                            {{ request()->routeIs('register') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            Register
                        </a>
                    @else
                        
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium 
                                {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('admin.attendance') }}" class="px-3 py-2 rounded-md text-sm font-medium 
                                {{ request()->routeIs('admin.attendance') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                                Attendance
                            </a>
                            <a href="{{ route('admin.activities') }}" class="px-3 py-2 rounded-md text-sm font-medium 
                                {{ request()->routeIs('admin.activities') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                                Activities
                            </a>
                            <a href="{{ route('admin.members.index') }}" class="px-3 py-2 rounded-md text-sm font-medium 
                                {{ request()->routeIs('admin.members.*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                                Members
                            </a>
                            <a href="{{ route('admin.members.create') }}" class="px-3 py-2 rounded-md text-sm font-medium 
                                {{ request()->routeIs('admin.members.create') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                                Add Member
                            </a>
                        @elseif(auth()->user()->role === 'staff')
                            <a href="{{ route('staff.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium 
                                {{ request()->routeIs('staff.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('staff.attendance') }}" class="px-3 py-2 rounded-md text-sm font-medium 
                                {{ request()->routeIs('staff.attendance') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                                Attendance
                            </a>
                            <a href="{{ route('staff.activities') }}" class="px-3 py-2 rounded-md text-sm font-medium 
                                {{ request()->routeIs('staff.activities') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                                Activities
                            </a>
                            <a href="{{ route('staff.members.index') }}" class="px-3 py-2 rounded-md text-sm font-medium 
                                {{ request()->routeIs('staff.members.*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                                View Members
                            </a>
                            <a href="{{ route('staff.members.create') }}" class="px-3 py-2 rounded-md text-sm font-medium 
                                {{ request()->routeIs('staff.members.create') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                                Add Member
                            </a>
                        @elseif(auth()->user()->role === 'client')
                            <a href="{{ route('client.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium 
                                {{ request()->routeIs('client.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('profile.edit') }}" class="px-3 py-2 rounded-md text-sm font-medium 
                                {{ request()->routeIs('profile.edit') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                                Profile
                            </a>
                        @endif
                    @endguest
                </div>
            </div>

            @auth
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <div class="flex items-center space-x-3">
                        <div class="text-right">
                            <div class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</div>
                            <div class="text-xs px-2 py-1 inline-flex font-semibold rounded-full 
                                {{ auth()->user()->role === 'admin' ? 'bg-purple-100 text-purple-800' : 
                                   (auth()->user()->role === 'staff' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                {{ ucfirst(auth()->user()->role) }}
                            </div>
                        </div>
                        <div class="relative">
                            <button @click="open = !open" class="flex items-center justify-center w-8 h-8 text-gray-400 hover:text-gray-600 focus:outline-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-64 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                @if(auth()->user()->role === 'admin')
                                    <div class="px-4 py-3 border-b border-gray-200">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center">
                                                <span class="text-white font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                                <div class="mt-1">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        Administrator
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="py-2">
                                        <div class="px-4 py-2 text-xs text-gray-500 font-semibold uppercase tracking-wider">System Stats</div>
                                        <div class="px-4 py-2 space-y-1">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm text-gray-600">Total Members</span>
                                                <span class="text-sm font-medium text-gray-900">{{ App\Models\GymMember::count() }}</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm text-gray-600">Active Today</span>
                                                <span class="text-sm font-medium text-green-600">{{ App\Models\Attendance::whereDate('created_at', now()->format('Y-m-d'))->count() }}</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm text-gray-600">Last Login</span>
                                                <span class="text-sm font-medium text-gray-900">{{ Auth::user()->last_login ? Auth::user()->last_login->diffForHumans() : 'Never' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="py-1 border-t border-gray-200">
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            Profile Settings
                                        </div>
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                </svg>
                                                Log Out
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endauth

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('about') }}" class="block px-3 py-2 rounded-md text-base font-medium 
                {{ request()->routeIs('about') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                About
            </a>
            @guest
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium 
                    {{ request()->routeIs('login') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    Login
                </a>
                <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-base font-medium 
                    {{ request()->routeIs('register') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    Register
                </a>
            @else
                
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium 
                        {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.attendance') }}" class="block px-3 py-2 rounded-md text-base font-medium 
                        {{ request()->routeIs('admin.attendance') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Attendance
                    </a>
                    <a href="{{ route('admin.activities') }}" class="block px-3 py-2 rounded-md text-base font-medium 
                        {{ request()->routeIs('admin.activities') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Activities
                    </a>
                    <a href="{{ route('admin.members.index') }}" class="block px-3 py-2 rounded-md text-base font-medium 
                        {{ request()->routeIs('admin.members.*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Members
                    </a>
                    <a href="{{ route('admin.members.create') }}" class="block px-3 py-2 rounded-md text-base font-medium 
                        {{ request()->routeIs('admin.members.create') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Add Member
                    </a>
                @elseif(auth()->user()->role === 'staff')
                    <a href="{{ route('staff.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium 
                        {{ request()->routeIs('staff.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('staff.attendance') }}" class="block px-3 py-2 rounded-md text-base font-medium 
                        {{ request()->routeIs('staff.attendance') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Attendance
                    </a>
                    <a href="{{ route('staff.activities') }}" class="block px-3 py-2 rounded-md text-base font-medium 
                        {{ request()->routeIs('staff.activities') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Activities
                    </a>
                    <a href="{{ route('staff.members.index') }}" class="block px-3 py-2 rounded-md text-base font-medium 
                        {{ request()->routeIs('staff.members.*') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        View Members
                    </a>
                    <a href="{{ route('staff.members.create') }}" class="block px-3 py-2 rounded-md text-base font-medium 
                        {{ request()->routeIs('staff.members.create') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Add Member
                    </a>
                @elseif(auth()->user()->role === 'client')
                    <a href="{{ route('client.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium 
                        {{ request()->routeIs('client.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-base font-medium 
                        {{ request()->routeIs('profile.edit') ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        Profile
                    </a>
                @endif
            @endguest
        </div>

        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <div class="font-medium text-base text-gray-900">{{ Auth::user()->name }}</div>
                            <div class="text-xs px-2 py-1 inline-flex font-semibold rounded-full 
                                {{ auth()->user()->role === 'admin' ? 'bg-purple-100 text-purple-800' : 
                                   (auth()->user()->role === 'staff' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                {{ ucfirst(auth()->user()->role) }}
                            </div>
                        </div>
                    </div>
                </div>

                @if(auth()->user()->role === 'admin')
                    <div class="mt-3 px-4 py-2 bg-gray-50 border-t border-gray-200">
                        <div class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-2">Admin Details</div>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Email</span>
                                <span class="text-sm font-medium text-gray-900 text-right">{{ Auth::user()->email }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Role</span>
                                <span class="text-xs px-2 py-1 inline-flex font-semibold rounded-full bg-purple-100 text-purple-800">
                                    Administrator
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Members</span>
                                <span class="text-sm font-medium text-gray-900">{{ App\Models\GymMember::count() }}</span>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-900">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profile Settings
                        </div>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-red-600 hover:bg-gray-100 hover:text-red-900">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Log Out
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
