@if(session('success') || session('error') || $errors->any())
    <div x-data="modalNotification()" x-show="show" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
        <!-- Backdrop -->
        <div 
            x-show="show" 
            @click="show = false"
            class="absolute inset-0 bg-black bg-opacity-50 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
        </div>

        <!-- Modal Content -->
        <div 
            x-show="show"
            class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-75"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-75">
            
            @if(session('success'))
                <!-- Success Modal -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 p-8">
                    <div class="flex flex-col items-center text-center">
                        <div class="mb-6 relative">
                            <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center animate-bounce">
                                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-green-800 mb-2">Berhasil!</h3>
                        <p class="text-sm text-green-700 mb-6 leading-relaxed">{{ session('success') }}</p>
                        <button 
                            @click="show = false"
                            class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105">
                            Lanjutkan
                        </button>
                    </div>
                </div>
            @elseif(session('error'))
                <!-- Error Modal -->
                <div class="bg-gradient-to-br from-red-50 to-red-100 p-8">
                    <div class="flex flex-col items-center text-center">
                        <div class="mb-6 relative">
                            <div class="w-20 h-20 bg-red-500 rounded-full flex items-center justify-center animate-pulse">
                                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-red-800 mb-2">Gagal!</h3>
                        <p class="text-sm text-red-700 mb-6 leading-relaxed">{{ session('error') }}</p>
                        <button 
                            @click="show = false"
                            class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105">
                            Tutup
                        </button>
                    </div>
                </div>
            @elseif($errors->any())
                <!-- Validation Error Modal -->
                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-8">
                    <div class="flex flex-col items-center text-center">
                        <div class="mb-6 relative">
                            <div class="w-20 h-20 bg-yellow-500 rounded-full flex items-center justify-center animate-pulse">
                                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-yellow-800 mb-2">Validasi Error!</h3>
                        <ul class="text-sm text-yellow-700 mb-6 text-left list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button 
                            @click="show = false"
                            class="px-6 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105">
                            Coba Lagi
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function modalNotification() {
            return {
                show: true,
                init() {
                    // Prevent showing twice
                    window.modalShown = window.modalShown || false;
                    if (window.modalShown) {
                        this.show = false;
                        return;
                    }
                    window.modalShown = true;
                    
                    // Auto-hide after 5 seconds
                    setTimeout(() => {
                        this.show = false;
                    }, 5000);
                },
                destroy() {
                    window.modalShown = false;
                }
            }
        }
    </script>
@endif
