<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800">🔑 Reset Password</h2>
        <p class="text-sm text-gray-600 mt-2">Masukkan email dan password baru Anda</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.store') }}" x-data="{
        isAdmin: false,
        email: '{{ old('email') }}',
        init() {
            this.$watch('email', value => {
                if (value && value.includes('@')) {
                    fetch('{{ route('check.admin.email') }}?email=' + encodeURIComponent(value))
                        .then(res => res.json())
                        .then(data => this.isAdmin = data.is_admin)
                        .catch(() => this.isAdmin = false);
                }
            });
        }
    }">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" x-model="email" required autofocus placeholder="nama@email.com" autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Admin Badge -->
        <div x-show="isAdmin" x-cloak class="mt-2">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                👑 Admin Account - Password lama diperlukan
            </span>
        </div>

        <!-- Current Password (for admin only) -->
        <div x-show="isAdmin" x-cloak class="mt-4">
            <x-input-label for="current_password" value="Password Lama" />
            <x-text-input id="current_password" class="block mt-1 w-full" type="password" name="current_password" autocomplete="current-password" placeholder="Masukkan password lama Anda" />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Password Baru" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" placeholder="Masukkan password baru" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Konfirmasi Password Baru" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Masukkan ulang password baru" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">
                ← Kembali ke Login
            </a>
            <x-primary-button>
                Reset Password
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
