<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">📖 Manage Guides</h1>
            <p class="text-gray-600 text-xs sm:text-sm mt-1">Kelola panduan yang akan ditampilkan ke pengguna</p>
        </div>
        <a href="{{ route('admin.guides.create') }}" class="mt-4 md:mt-0 inline-flex items-center gap-2 px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
            </svg>
            Add New Guide
        </a>
    </div>

    <!-- Guides Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs sm:text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left font-bold text-gray-700 uppercase">Icon</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left font-bold text-gray-700 uppercase">Title</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left font-bold text-gray-700 uppercase hidden sm:table-cell">Description</th>
                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left font-bold text-gray-700 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($guides as $guide)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-3 sm:px-6 py-3 sm:py-4 text-center text-lg">{{ $guide->icon ?? '📚' }}</td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4">
                                <span class="font-semibold text-gray-800">{{ $guide->title }}</span>
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4 text-gray-600 hidden sm:table-cell">
                                {{ Str::limit($guide->description, 50) }}
                            </td>
                            <td class="px-3 sm:px-6 py-3 sm:py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.guides.edit', $guide) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 transition text-xs font-semibold">
                                        ✏️ Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.guides.destroy', $guide) }}" onsubmit="return confirm('Yakin ingin menghapus panduan ini?');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200 transition text-xs font-semibold">
                                            🗑️ Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-3 sm:px-6 py-8 text-center text-gray-500">
                                Belum ada panduan. Silakan tambahkan panduan baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-3 sm:px-6 py-4 border-t">
            {{ $guides->links() }}
        </div>
    </div>
</x-admin-layout>
