<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800">🔐 Buat Password Baru</h2>
        <p class="text-sm text-gray-600 mt-2">Masukkan password baru untuk akun Anda</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" x-data="{ isAdmin: false }" x-init="
        fetch('{{ route('check.admin.email') }}?email=' + '{{ old('email', $request->email) }}')
            .then(res => res.json())
            .then(data => isAdmin = data.is_admin)
    ">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address (Hidden untuk user, visible untuk info) -->
        <input type="hidden" name="email" value="{{ old('email', $request->email) }}">
        
        <div class="mb-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
            <p class="text-sm text-gray-600">Reset password untuk:</p>
            <p class="font-semibold text-gray-800">{{ old('email', $request->email) }}</p>
            <div x-show="isAdmin" class="mt-2 px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded inline-block">
                🔒 Akun Admin - Keamanan Ekstra
            </div>
        </div>

        <!-- Admin Security: Current Password Required -->
        <div x-show="isAdmin" class="mb-4">
            <x-input-label for="current_password" value="Password Lama (Wajib untuk Admin)" />
            <x-text-input 
                id="current_password" 
                class="block mt-1 w-full" 
                type="password" 
                name="current_password"
                x-bind:required="isAdmin"
                placeholder="Masukkan password lama Anda" />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
            <p class="text-xs text-gray-500 mt-1">* Untuk keamanan akun admin, password lama wajib diisi</p>
        </div>

        <!-- New Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Password Baru" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Konfirmasi Password Baru" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ketik ulang password baru" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <x-primary-button>
                🔑 Reset Password
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
