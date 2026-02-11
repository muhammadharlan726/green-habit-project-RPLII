<nav x-data="{ open: false }" class="bg-gradient-to-r from-gray-800 via-green-800 to-gray-800 border-b border-green-900 shadow-lg sticky top-0 z-50 backdrop-blur-sm bg-opacity-95">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        @if(Auth::user()->is_admin)
                            <span class="font-bold text-xl tracking-tight text-white flex items-center gap-2">
                                🛡️ Admin Panel
                            </span>
                        @else
                            <x-application-logo class="block h-9 w-auto fill-current text-white" />
                        @endif
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    
                    @if(!Auth::user()->is_admin)
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard Player') }}
                        </x-nav-link>
                        <x-nav-link :href="route('guides.index')" :active="request()->routeIs('guides.*')">
                            📚 {{ __('Panduan') }}
                        </x-nav-link>
                        <x-nav-link :href="route('store.index')" :active="request()->routeIs('store.*')">
                            🎁 {{ __('Store') }}
                        </x-nav-link>
                        <x-nav-link :href="route('leaderboard')" :active="request()->routeIs('leaderboard')">
                            🏆 {{ __('Leaderboard') }}
                        </x-nav-link>
                    @endif

                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-green-700 text-sm leading-4 font-medium rounded-md text-white bg-green-900 bg-opacity-50 hover:bg-opacity-70 focus:outline-none transition ease-in-out duration-150 shadow-md">
                            <div class="flex items-center gap-2">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-8 h-8 rounded-full object-cover border border-gray-200">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-xs">👤</div>
                                @endif
                                
                                <div class="text-left">
                                    <div class="font-bold text-white">{{ Auth::user()->name }}</div>
                                    <div class="text-[10px] text-green-200 leading-tight">
                                        {{ Auth::user()->is_admin ? 'Administrator' : 'Pahlawan Bumi' }}
                                    </div>
                                </div>
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile Saya') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

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

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            
            @if(!Auth::user()->is_admin)
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard Player') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('guides.index')" :active="request()->routeIs('guides.*')">
                    📚 {{ __('Panduan') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('store.index')" :active="request()->routeIs('store.*')">
                    🎁 {{ __('Store') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('leaderboard')" :active="request()->routeIs('leaderboard')">
                    🏆 {{ __('Leaderboard') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.index')">
                    📊 Dashboard Admin
                </x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                    👥 Kelola User
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.missions.index')" :active="request()->routeIs('admin.missions.*')">
                    🚀 Kelola Misi
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.history')" :active="request()->routeIs('admin.history')">
                    📜 Riwayat Aktivitas
                </x-responsive-nav-link>
            @endif

        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 flex items-center gap-3">
                @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-10 h-10 rounded-full object-cover border border-gray-300">
                @endif
                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>