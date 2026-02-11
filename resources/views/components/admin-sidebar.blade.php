@props(['user'])

<div x-data="{ sidebarOpen: true }" class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div :class="sidebarOpen ? 'w-64' : 'w-20'" class="fixed top-0 left-0 h-screen bg-gradient-to-b from-indigo-700 via-indigo-600 to-indigo-800 text-white transition-all duration-300 shadow-2xl z-40">
        
        <!-- Logo Section -->
        <div class="flex items-center justify-between p-4 border-b border-indigo-500 h-16">
            <a href="{{ route('admin.index') }}" class="flex items-center gap-3 hover:opacity-80 transition">
                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center flex-shrink-0 font-bold text-indigo-700">
                    🛡️
                </div>
                <span :class="!sidebarOpen && 'hidden'" class="font-bold text-lg tracking-tight whitespace-nowrap">Admin</span>
            </a>
            <button @click="sidebarOpen = !sidebarOpen" class="p-1 hover:bg-indigo-500 rounded-lg transition text-indigo-100">
                <svg :class="!sidebarOpen && 'rotate-180'" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="mt-8 px-3 space-y-2">
            <!-- Dashboard -->
            <a href="{{ route('admin.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg transition duration-200 {{ request()->routeIs('admin.index') ? 'bg-white bg-opacity-20 shadow-lg border-l-4 border-white' : 'hover:bg-white hover:bg-opacity-10 text-indigo-100' }}">
                <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6z"></path>
                </svg>
                <span :class="!sidebarOpen && 'hidden'" class="font-medium whitespace-nowrap">Dashboard</span>
            </a>

            <!-- Users Management -->
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg transition duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-white bg-opacity-20 shadow-lg border-l-4 border-white' : 'hover:bg-white hover:bg-opacity-10 text-indigo-100' }}">
                <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 12a6 6 0 11-12 0 6 6 0 0112 0zM13 12a1 1 0 100-2 1 1 0 000 2zM15.889 12a3 3 0 11-6 0 3 3 0 016 0zM17 20a1 1 0 100-2 1 1 0 000 2z"></path>
                </svg>
                <span :class="!sidebarOpen && 'hidden'" class="font-medium whitespace-nowrap">Kelola User</span>
            </a>

            <!-- Missions Management -->
            <a href="{{ route('admin.missions.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg transition duration-200 {{ request()->routeIs('admin.missions.*') ? 'bg-white bg-opacity-20 shadow-lg border-l-4 border-white' : 'hover:bg-white hover:bg-opacity-10 text-indigo-100' }}">
                <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v2h16V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                </svg>
                <span :class="!sidebarOpen && 'hidden'" class="font-medium whitespace-nowrap">Kelola Misi</span>
            </a>

            <!-- Rewards Management -->
            <a href="{{ route('admin.rewards.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg transition duration-200 {{ request()->routeIs('admin.rewards.*') ? 'bg-white bg-opacity-20 shadow-lg border-l-4 border-white' : 'hover:bg-white hover:bg-opacity-10 text-indigo-100' }}">
                <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
                <span :class="!sidebarOpen && 'hidden'" class="font-medium whitespace-nowrap">Kelola Reward</span>
            </a>

            <!-- Approvals -->
            <a href="{{ route('admin.approvals.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg transition duration-200 {{ request()->routeIs('admin.approvals.*') ? 'bg-white bg-opacity-20 shadow-lg border-l-4 border-white' : 'hover:bg-white hover:bg-opacity-10 text-indigo-100' }}">
                <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span :class="!sidebarOpen && 'hidden'" class="font-medium whitespace-nowrap">Persetujuan</span>
            </a>

            <!-- Guides Management -->
            <a href="{{ route('admin.guides.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg transition duration-200 {{ request()->routeIs('admin.guides.*') ? 'bg-white bg-opacity-20 shadow-lg border-l-4 border-white' : 'hover:bg-white hover:bg-opacity-10 text-indigo-100' }}">
                <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.448 4.5 1.245V4.804zm0 0C9 4.267 9.447 4 10 4c.553 0 1 .267 1 .804v10A9 9 0 009.5 14c-1.669 0-3.218.448-4.5 1.245V4.804z"></path>
                </svg>
                <span :class="!sidebarOpen && 'hidden'" class="font-medium whitespace-nowrap">Panduan</span>
            </a>

            <!-- Activity History -->
            <a href="{{ route('admin.history') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg transition duration-200 {{ request()->routeIs('admin.history') ? 'bg-white bg-opacity-20 shadow-lg border-l-4 border-white' : 'hover:bg-white hover:bg-opacity-10 text-indigo-100' }}">
                <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 2a1 1 0 011-1h8a1 1 0 011 1v12a1 1 0 110 2h-3v2h3a3 3 0 003-3V2a3 3 0 00-3-3H6a3 3 0 00-3 3v12a3 3 0 003 3h3v-2H5a1 1 0 110-2V2z" clip-rule="evenodd"></path>
                </svg>
                <span :class="!sidebarOpen && 'hidden'" class="font-medium whitespace-nowrap">Aktivitas</span>
            </a>

            <!-- Leaderboard -->
            <a href="{{ route('admin.leaderboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-lg transition duration-200 {{ request()->routeIs('admin.leaderboard') ? 'bg-white bg-opacity-20 shadow-lg border-l-4 border-white' : 'hover:bg-white hover:bg-opacity-10 text-indigo-100' }}">
                <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path>
                </svg>
                <span :class="!sidebarOpen && 'hidden'" class="font-medium whitespace-nowrap">Leaderboard</span>
            </a>
        </nav>

        <!-- Divider -->
        <div class="mx-3 my-6 border-t border-indigo-500"></div>

        <!-- User Profile (Bottom) -->
        <div class="absolute bottom-0 left-0 right-0 p-3 border-t border-indigo-500 bg-indigo-900 bg-opacity-50">
            <div class="flex items-center gap-3">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" class="w-10 h-10 rounded-full object-cover border-2 border-indigo-300 flex-shrink-0">
                @else
                    <div class="w-10 h-10 rounded-full bg-indigo-400 flex items-center justify-center font-bold flex-shrink-0">{{ substr($user->name, 0, 1) }}</div>
                @endif
                <div :class="!sidebarOpen && 'hidden'" class="flex-1 min-w-0">
                    <p class="text-sm font-semibold truncate">{{ $user->name }}</p>
                    <p class="text-xs text-indigo-200 truncate">{{ $user->email }}</p>
                </div>
            </div>
            
            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 mt-2 text-sm font-medium rounded-lg hover:bg-red-500 hover:bg-opacity-20 transition duration-200 text-indigo-100">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span :class="!sidebarOpen && 'hidden'" class="whitespace-nowrap">Log Out</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content Area -->
    <div :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-20'" class="flex-1 transition-all duration-300 w-full">
        <!-- Top Navigation Bar -->
        <div class="sticky top-0 z-30 bg-white border-b border-gray-200 shadow-sm">
            <div class="px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    {{ $slot }}
                </div>
                
                <!-- Mobile Menu Button -->
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 hover:bg-gray-100 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Content -->
        <main class="p-4 sm:p-6 lg:p-8">
            {{ $content ?? '' }}
        </main>
    </div>
</div>

<style>
    /* Smooth scrollbar for sidebar */
    ::-webkit-scrollbar {
        width: 6px;
    }
    ::-webkit-scrollbar-track {
        background: transparent;
    }
    ::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 3px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }
</style>
