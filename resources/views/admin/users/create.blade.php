<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">➕ Create New User</h1>
        <p class="text-gray-600 text-xs sm:text-sm mt-1">Tambahkan pengguna baru ke sistem</p>
    </div>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6">
            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Full Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full px-3 sm:px-4 py-2 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition text-sm @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full px-3 sm:px-4 py-2 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition text-sm @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Password *</label>
                    <input type="password" id="password" name="password" required class="w-full px-3 sm:px-4 py-2 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition text-sm @error('password') border-red-500 @enderror">
                    <p class="text-gray-500 text-xs mt-1">Minimum 8 characters</p>
                    @error('password')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Confirm Password *</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full px-3 sm:px-4 py-2 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition text-sm">
                </div>

                <!-- Is Admin -->
                <div class="flex items-center gap-3">
                    <input type="checkbox" id="is_admin" name="is_admin" value="1" class="w-4 h-4 sm:w-5 sm:h-5 rounded text-green-600 focus:ring-2 focus:ring-green-200">
                    <label for="is_admin" class="text-sm sm:text-base font-semibold text-gray-700">Make this user an Administrator</label>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t">
                    <button type="submit" class="flex-1 px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition text-sm sm:text-base">
                        ✅ Create User
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition text-center text-sm sm:text-base">
                        ❌ Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
