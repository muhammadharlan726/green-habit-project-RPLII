<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'GreenHabit') }} - Admin</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        
        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-gray-900 via-green-900 to-emerald-900">
        <!-- Modal Notification -->
        <x-modal-notification />
        
        <div x-data="{ sidebarOpen: true }" class="flex h-screen overflow-hidden">
            <!-- Modern Sidebar Navigation -->
            <div class="flex flex-col h-full">
                <!-- Sidebar Mobile Toggle -->
                <div class="md:hidden fixed top-0 left-0 right-0 z-40 flex items-center justify-between h-16 bg-gradient-to-r from-gray-800 via-green-800 to-gray-800 text-white px-4 shadow-lg">
                    <h1 class="text-lg font-bold">🌱 GreenHabit</h1>
                    <button @click="sidebarOpen = !sidebarOpen" class="text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <!-- Sidebar Menu -->
                <aside class="fixed md:static inset-y-0 left-0 z-30 w-64 bg-gradient-to-b from-gray-800 via-green-800 to-gray-900 text-white overflow-y-auto pt-16 md:pt-0 transition-transform duration-300 md:translate-x-0 flex flex-col h-full md:h-screen shadow-2xl" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
                    <div class="hidden md:block p-6 border-b border-green-700 bg-gradient-to-r from-gray-800 to-green-900 shadow-lg">
                        <h1 class="text-2xl font-bold text-white">🛡️ Admin</h1>
                        <p class="text-xs text-green-200">Panel Manajemen</p>
                    </div>

                    <div class="md:p-6 p-4 flex-1 flex flex-col">
                        <!-- User Profile Section -->
                        <div class="mb-8 pb-6 border-b border-green-500">
                            <div class="flex items-center gap-3">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-12 h-12 rounded-full object-cover border-2 border-green-300 shadow-lg">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-green-400 flex items-center justify-center text-white font-bold shadow-lg">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-sm">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-400">Administrator</p>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Menu -->
                        <nav class="space-y-1 flex-1">
                            <a href="{{ route('admin.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->route()->getName() === 'admin.index' ? 'bg-white bg-opacity-20 border-l-4 border-white shadow-lg' : 'text-green-100 hover:bg-white hover:bg-opacity-10' }}">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                                <span>Dashboard</span>
                            </a>

                            <div class="pt-4 border-t border-green-500">
                                <p class="text-xs font-semibold text-green-200 uppercase px-4 mb-3">Management</p>
                                
                                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ str_contains(request()->route()->getName(), 'admin.users') ? 'bg-green-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                                    </svg>
                                    <span>Manage Users</span>
                                </a>

                                <a href="{{ route('admin.missions.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ str_contains(request()->route()->getName(), 'admin.missions') ? 'bg-green-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Manage Missions</span>
                                </a>

                                <a href="{{ route('admin.guides.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ str_contains(request()->route()->getName(), 'admin.guides') ? 'bg-green-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.669 0-3.218.51-4.5 1.385A7.968 7.968 0 009 4.804z"></path>
                                    </svg>
                                    <span>Manage Guides</span>
                                </a>

                                <a href="{{ route('admin.approvals.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ str_contains(request()->route()->getName(), 'admin.approvals') ? 'bg-green-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Pending Approvals</span>
                                </a>

                                <a href="{{ route('admin.rewards.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ str_contains(request()->route()->getName(), 'admin.rewards') ? 'bg-green-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h1.586A2 2 0 007 2h6a2 2 0 011.414.586L15.828 3H17a1 1 0 011 1v2a1 1 0 01-.293.707l-2.414 2.414A1 1 0 0114 9h-4a1 1 0 01-.707-.293L6.879 6.293A1 1 0 016.586 5H4a1 1 0 01-1-1V4zm0 6a1 1 0 011-1h1.586a1 1 0 01.707.293l2.414 2.414A1 1 0 009 12h4a1 1 0 01.707.293l2.414 2.414A1 1 0 0116.414 16H17a1 1 0 011 1v2a1 1 0 01-1 1h-1.172a2 2 0 01-1.414-.586L13.414 18H7a1 1 0 01-.707-.293L3.879 15.293A1 1 0 013.586 15H3a1 1 0 01-1-1v-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Manage Rewards</span>
                                </a>

                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->route()->getName() === 'profile.edit' ? 'bg-green-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Manage Profile</span>
                                </a>
                            </div>
                        </nav>
                    </div>

                    <!-- Logout -->
                    <div class="mt-auto p-4 border-t border-green-500 bg-green-900 bg-opacity-50">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-red-500 hover:bg-opacity-20 transition font-semibold">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </aside>

                <!-- Overlay for mobile -->
                <div 
                    x-show="sidebarOpen" 
                    @click="sidebarOpen = false" 
                    class="fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden"
                    x-cloak>
                </div>
            </div>

            <!-- Main Content -->
            <main class="flex-1 overflow-auto w-full bg-gradient-to-br from-gray-900 via-green-900 to-emerald-900 relative">
                <!-- Animated Background Blobs -->
                <div class="absolute inset-0 opacity-20 pointer-events-none">
                    <div class="absolute top-20 left-10 w-72 h-72 bg-green-600 rounded-full mix-blend-lighten filter blur-3xl animate-blob"></div>
                    <div class="absolute top-40 right-10 w-72 h-72 bg-emerald-600 rounded-full mix-blend-lighten filter blur-3xl animate-blob animation-delay-2000"></div>
                    <div class="absolute bottom-20 left-1/2 w-72 h-72 bg-teal-600 rounded-full mix-blend-lighten filter blur-3xl animate-blob animation-delay-4000"></div>
                </div>
                
                <!-- Mobile Header Spacer -->
                <div class="md:hidden h-16"></div>
                
                <!-- Top Header Bar (Desktop) -->
                <div class="hidden md:flex items-center justify-between h-16 bg-gradient-to-r from-gray-900 via-green-900 to-gray-900 border-b-2 border-green-800 px-6 sticky top-0 z-20 shadow-xl">
                    <div>
                        <h2 class="text-xl font-semibold bg-gradient-to-r from-green-200 via-white to-green-200 bg-clip-text text-transparent">Admin Dashboard</h2>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 text-white hover:text-green-200 transition">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-full object-cover border-2 border-green-600 shadow-md">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-green-600 flex items-center justify-center text-white text-sm font-bold shadow-md">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                                <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Modal Notification -->
                <x-modal-notification />

                <!-- Page Content -->
                <div class="p-4 md:p-8 w-full relative z-10">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>