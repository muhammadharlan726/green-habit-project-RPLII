<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GreenHabit - RPG Life Tracker</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-900 text-white selection:bg-green-500 selection:text-white">

    <div class="relative flex items-top justify-center min-h-screen sm:items-center sm:pt-0">
        @if (Route::has('login'))
            <div class="fixed top-0 right-0 p-6 text-right z-10">
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-bold text-white hover:text-green-400 transition text-lg border-b-2 border-transparent hover:border-green-400">Log in</a>
                @else
                    <a href="{{ route('login') }}" class="font-bold text-white hover:text-green-400 transition mr-4 text-lg">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-full transition shadow-lg shadow-green-900/50">Daftar Sekarang</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="max-w-7xl mx-auto p-6 lg:p-8 w-full">
            
            <div class="text-center mt-10 mb-20">
                <div class="flex justify-center mb-6">
                    <div class="h-24 w-24 bg-gradient-to-br from-green-400 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-green-500/50 transform hover:rotate-12 transition duration-500 overflow-hidden">
                        <img src="{{ asset('images/TUGAS RPL.png') }}" alt="GreenHabit Logo" class="h-20 w-20 object-contain drop-shadow-xl">
                    </div>
                </div>
                
                <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-4">
                    Green<span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-blue-500">Habit</span>
                </h1>
                
                <p class="text-xl text-gray-400 mb-8 max-w-2xl mx-auto leading-relaxed">
                    Ubah kebiasaan kecilmu menjadi petualangan RPG yang seru. 
                    Selamatkan bumi, kumpulkan XP, dan jadilah 
                    <span class="text-yellow-400 font-bold border-b-2 border-yellow-400">Top Global Legends!</span>
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-500 text-white font-bold text-xl py-4 px-10 rounded-full shadow-lg shadow-green-600/30 transition transform hover:scale-105 hover:-translate-y-1">
                        🎮 Mulai Main
                    </a>
                    <a href="#leaderboard" class="bg-gray-800 hover:bg-gray-700 text-white font-bold text-xl py-4 px-10 rounded-full border border-gray-700 transition flex items-center justify-center gap-2">
                        <span>🏆</span> Lihat Rank
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20 text-center">
                <div class="bg-gray-800/50 backdrop-blur-sm p-8 rounded-3xl border border-gray-700 hover:border-green-500 transition duration-300 group">
                    <h3 class="text-5xl font-extrabold text-white mb-2 group-hover:text-green-400 transition">{{ $totalUsers ?? 0 }}</h3>
                    <p class="text-gray-400 uppercase tracking-widest text-xs font-bold">Pahlawan Bergabung</p>
                </div>
                <div class="bg-gray-800/50 backdrop-blur-sm p-8 rounded-3xl border border-gray-700 hover:border-blue-500 transition duration-300 group">
                    <h3 class="text-5xl font-extrabold text-blue-400 mb-2 group-hover:text-blue-300 transition">{{ $totalXp ?? 0 }}</h3>
                    <p class="text-gray-400 uppercase tracking-widest text-xs font-bold">Total Point Terkumpul</p>
                </div>
                <div class="bg-gray-800/50 backdrop-blur-sm p-8 rounded-3xl border border-gray-700 hover:border-yellow-500 transition duration-300 group">
                    <h3 class="text-5xl font-extrabold text-yellow-400 mb-2 group-hover:text-yellow-300 transition">S1</h3>
                    <p class="text-gray-400 uppercase tracking-widest text-xs font-bold">Season 1: Genesis</p>
                </div>
            </div>

            <div id="leaderboard" class="max-w-3xl mx-auto relative">
                <div class="absolute -top-10 -left-10 w-20 h-20 bg-yellow-500 rounded-full blur-3xl opacity-20"></div>
                <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-blue-500 rounded-full blur-3xl opacity-20"></div>

                <h2 class="text-3xl font-bold text-center mb-8 flex items-center justify-center gap-3 relative z-10">
                    <span class="text-4xl">👑</span> Hall of Fame
                </h2>

                <div class="bg-gray-800 rounded-3xl overflow-hidden shadow-2xl border border-gray-700 relative z-10">
                    @if(isset($topPlayers) && $topPlayers->count() > 0)
                        @foreach($topPlayers as $index => $player)
                        <div class="flex items-center justify-between p-6 border-b border-gray-700 last:border-0 hover:bg-gray-750 transition group">
                            <div class="flex items-center gap-6">
                                <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-full font-bold text-xl shadow-lg
                                    {{ $index == 0 ? 'bg-gradient-to-br from-yellow-300 to-yellow-600 text-black ring-2 ring-yellow-200' : '' }}
                                    {{ $index == 1 ? 'bg-gradient-to-br from-gray-300 to-gray-500 text-black' : '' }}
                                    {{ $index == 2 ? 'bg-gradient-to-br from-orange-400 to-orange-700 text-white' : '' }}">
                                    {{ $index + 1 }}
                                </div>
                                
                                <div>
                                    <h4 class="text-xl font-bold text-white group-hover:text-green-400 transition">{{ $player->name }}</h4>
                                    <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded bg-gray-700 text-gray-300 tracking-wider">
                                        {{ $player->level_name ?? 'Newbie' }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <div class="text-2xl font-bold text-green-400">{{ $player->xp }} <span class="text-sm text-gray-500">XP</span></div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="p-10 text-center text-gray-500">
                            Belum ada pahlawan yang terdaftar. <br> Jadilah yang pertama!
                        </div>
                    @endif
                </div>
                
                <div class="text-center mt-12">
                    <p class="text-gray-500 mb-4">Ingin nama kamu ada di atas?</p>
                    <a href="{{ route('login') }}" class="text-green-400 font-bold hover:text-green-300 hover:underline transition">Login & Selesaikan Misi Sekarang! →</a>
                </div>
            </div>

            <div class="text-center mt-24 pb-10 text-gray-600 text-sm">
                &copy; {{ date('Y') }} GreenHabit Project. <br>
                <span class="text-xs">Built with Laravel</span>
            </div>
        </div>
    </div>
</body>
</html>