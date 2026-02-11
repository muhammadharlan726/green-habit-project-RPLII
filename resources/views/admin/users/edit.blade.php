<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">✏️ Edit User</h1>
        <p class="text-gray-600 text-xs sm:text-sm mt-1">Update informasi pengguna</p>
    </div>

    <div class="max-w-2xl">
        <div class="bg-white rounded-xl shadow-lg p-4 sm:p-6">
            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div>
                    <label for="name" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Full Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-3 sm:px-4 py-2 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition text-sm @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-3 sm:px-4 py-2 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition text-sm @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- XP -->
                <div>
                    <label for="xp" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Experience Points (XP)</label>
                    <input type="number" id="xp" name="xp" value="{{ old('xp', $user->xp) }}" min="0" class="w-full px-3 sm:px-4 py-2 rounded-lg border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition text-sm @error('xp') border-red-500 @enderror">
                    @error('xp')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Is Admin -->
                <div class="flex items-center gap-3 p-4 rounded-lg bg-gray-50 border">
                    <input type="checkbox" id="is_admin" name="is_admin" value="1" @if(old('is_admin', $user->is_admin)) checked @endif class="w-4 h-4 sm:w-5 sm:h-5 rounded text-green-600 focus:ring-2 focus:ring-green-200">
                    <label for="is_admin" class="text-sm sm:text-base font-semibold text-gray-700">Administrator Status</label>
                </div>

                <!-- User Info -->
                <div class="p-3 sm:p-4 rounded-lg bg-blue-50 border border-blue-200 space-y-2">
                    <p class="text-xs sm:text-sm text-blue-800"><strong>Email Verified:</strong> {{ $user->email_verified_at ? 'Yes' : 'No' }}</p>
                    <p class="text-xs sm:text-sm text-blue-800"><strong>Created:</strong> {{ $user->created_at->format('d M Y, H:i') }}</p>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t">
                    <button type="submit" class="flex-1 px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition text-sm sm:text-base">
                        💾 Save Changes
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition text-center text-sm sm:text-base">
                        ❌ Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
