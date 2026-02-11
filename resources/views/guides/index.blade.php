<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl bg-gradient-to-r from-green-200 via-white to-green-200 bg-clip-text text-transparent leading-tight flex items-center gap-3">
            <span class="inline-block animate-pulse-slow">📚</span>
            {{ __('Panduan & Tutorial') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-900 via-green-900 to-emerald-900 min-h-screen relative overflow-hidden">
        <!-- Animated Background Blobs -->
        <div class="absolute top-0 left-0 w-72 h-72 bg-green-700 rounded-full mix-blend-lighten filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute top-0 right-0 w-72 h-72 bg-emerald-600 rounded-full mix-blend-lighten filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-teal-700 rounded-full mix-blend-lighten filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative z-10">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            @if($guides->isEmpty())
                <div class="bg-white bg-opacity-95 backdrop-blur-sm rounded-2xl shadow-xl p-12 text-center border-2 border-green-100 hover:shadow-2xl transition-all duration-300">
                    <div class="text-6xl mb-4 animate-pulse-slow">📚</div>
                    <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-700 to-gray-900 bg-clip-text text-transparent mb-2">Belum Ada Panduan</h3>
                    <p class="text-gray-600">Admin sedang menyiapkan panduan tutorial untuk membantumu. Kembali lagi nanti!</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($guides as $guide)
                    <div class="group bg-white bg-opacity-95 backdrop-blur-sm rounded-2xl shadow-md overflow-hidden hover:shadow-2xl transition-all duration-300 border-2 border-green-100 hover:border-green-400 flex flex-col hover:-translate-y-2">
                        <div class="p-6 flex flex-col flex-1">
                            <!-- Icon & Title -->
                            <div class="flex items-start gap-3 mb-4">
                                <div class="text-4xl group-hover:scale-110 transition-transform duration-300">{{ $guide->icon ?? '📖' }}</div>
                                <h3 class="text-lg font-bold bg-gradient-to-r from-gray-800 to-green-700 bg-clip-text text-transparent flex-1">{{ $guide->title }}</h3>
                            </div>

                            <!-- Description -->
                            <p class="text-gray-600 text-sm mb-4 flex-1 whitespace-pre-wrap leading-relaxed">
                                {{ $guide->description }}
                            </p>

                            <!-- Content Preview if exists -->
                            @if($guide->content)
                                <div class="bg-gradient-to-br from-gray-50 to-green-50 rounded-xl p-4 mb-4 text-sm text-gray-700 max-h-32 overflow-y-auto border-2 border-green-100 shadow-inner">
                                    {!! nl2br(e($guide->content)) !!}
                                </div>
                            @endif

                            <!-- Date -->
                            <div class="text-xs text-gray-500 flex items-center gap-1">
                                📅 {{ $guide->created_at->format('d M Y') }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $guides->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
