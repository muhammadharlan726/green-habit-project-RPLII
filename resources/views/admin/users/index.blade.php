<x-admin-layout>
    @php
        $currentSort = request('sort', 'created_at');
        $currentDir = request('direction', 'desc');
        $toggleDir = fn($field) => ($currentSort === $field && $currentDir === 'asc') ? 'desc' : 'asc';
    @endphp

    <div x-data="deleteConfirm()">
        <!-- Delete Confirmation Modal -->
        <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>
            <div @click="showModal = false" class="absolute inset-0 bg-black bg-opacity-50 backdrop-blur-sm"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"></div>
            
            <div x-show="showModal" class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90">
                <div class="bg-gradient-to-br from-red-50 to-red-100 p-6">
                    <div class="flex flex-col items-center text-center">
                        <div class="mb-4 w-16 h-16 bg-red-500 rounded-full flex items-center justify-center animate-bounce">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-red-800 mb-2">Hapus Data?</h3>
                        <p class="text-sm text-red-700 mb-4">
                            Anda yakin ingin menghapus <strong x-text="itemName"></strong> secara permanen? Tindakan ini tidak dapat dibatalkan.
                        </p>
                    </div>
                </div>
                <div class="p-6 flex gap-3">
                    <button @click="showModal = false" class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-lg transition-all duration-200">
                        Batal
                    </button>
                    <form :action="deleteUrl" method="POST" style="display: contents;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex-1 px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Page Header + Actions -->
    <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">👥 Manage Users</h1>
            <p class="text-gray-600 text-sm mt-1">Kelola semua pengguna di sistem</p>
        </div>
        <div class="flex flex-col md:flex-row gap-3 md:items-center">
            <form method="GET" class="flex-1" x-data="{ open: false }">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="w-full rounded-lg border border-gray-200 px-4 py-2.5 focus:border-green-500 focus:ring-2 focus:ring-green-200" @focus="open = true" @click.away="open = false">
                        @if(isset($previewUsers) && $previewUsers->count())
                            <div x-show="open" x-cloak class="absolute z-20 mt-1 w-full bg-white rounded-lg shadow-lg border border-gray-100">
                                <div class="px-3 py-2 text-xs font-semibold text-gray-500">Preview hasil ({{ $previewUsers->count() }})</div>
                                <div class="max-h-64 overflow-auto divide-y">
                                    @foreach($previewUsers as $preview)
                                        <a href="{{ route('admin.users.edit', $preview) }}" class="flex items-center gap-3 px-3 py-3 hover:bg-gray-50">
                                            <div class="w-8 h-8 rounded-full {{ $preview->is_admin ? 'bg-purple-100 text-purple-700' : 'bg-green-100 text-green-700' }} flex items-center justify-center text-xs font-bold">
                                                {{ substr($preview->name, 0, 1) }}
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $preview->name }}</p>
                                                <p class="text-xs text-gray-500 truncate">{{ $preview->email }}</p>
                                            </div>
                                            <div class="ml-auto text-xs font-semibold text-gray-600 flex items-center gap-1">
                                                ⭐ {{ $preview->xp }}
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <select name="role" class="rounded-lg border border-gray-200 px-4 py-2.5 focus:border-green-500 focus:ring-2 focus:ring-green-200 min-w-[140px]">
                        <option value="">Semua Role</option>
                        <option value="admin" @selected(request('role') === 'admin')>Admin</option>
                        <option value="player" @selected(request('role') === 'player')>Player</option>
                    </select>

                    <select name="sort" class="rounded-lg border border-gray-200 px-4 py-2.5 focus:border-green-500 focus:ring-2 focus:ring-green-200 min-w-[140px]">
                        <option value="created_at" @selected($currentSort === 'created_at')>Terbaru</option>
                        <option value="name" @selected($currentSort === 'name')>Nama</option>
                        <option value="email" @selected($currentSort === 'email')>Email</option>
                        <option value="xp" @selected($currentSort === 'xp')>XP</option>
                        <option value="is_admin" @selected($currentSort === 'is_admin')>Role</option>
                    </select>

                    <select name="direction" class="rounded-lg border border-gray-200 px-4 py-2.5 focus:border-green-500 focus:ring-2 focus:ring-green-200 min-w-[120px]">
                        <option value="desc" @selected($currentDir === 'desc')>Desc</option>
                        <option value="asc" @selected($currentDir === 'asc')>Asc</option>
                    </select>

                    <button type="submit" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">
                        🔍 Filter
                    </button>
                </div>
            </form>

            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition whitespace-nowrap">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                </svg>
                Add New User
            </a>
        </div>
    </div>

    <!-- Bulk Actions & Table -->
    <form method="POST" action="{{ route('admin.users.bulk-destroy') }}" x-data="{
        selected: [],
        toggleAll(checked) {
            const boxes = [...document.querySelectorAll('.row-checkbox')];
            boxes.forEach(cb => cb.checked = checked);
            this.selected = checked ? boxes.map(c => c.value) : [];
        },
        syncSelected() {
            this.selected = [...document.querySelectorAll('.row-checkbox:checked')].map(c => c.value);
        }
    }">
        @csrf
        @method('DELETE')

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="flex items-center justify-between px-4 py-3 border-b bg-gray-50">
                <div class="flex items-center gap-3 text-sm text-gray-700">
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" class="rounded border-gray-300" @change="toggleAll($event.target.checked)">
                        <span>Pilih semua</span>
                    </label>
                    <span class="text-gray-400">•</span>
                    <span x-text="selected.length + ' dipilih'"></span>
                </div>
                <div class="flex items-center gap-3">
                    <button type="submit" :disabled="selected.length === 0" class="px-4 py-2 rounded-lg font-semibold text-white bg-red-500 disabled:opacity-50 disabled:cursor-not-allowed hover:bg-red-600 transition" onclick="return confirm('Hapus user yang dipilih?')">
                        🗑️ Bulk Delete
                    </button>
                </div>
            </div>

            <!-- Desktop Table -->
            <div class="overflow-x-auto hidden md:block">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase w-12">
                                <input type="checkbox" class="rounded border-gray-300" @change="toggleAll($event.target.checked)">
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">
                                <a href="{{ route('admin.users.index', array_merge(request()->all(), ['sort' => 'name', 'direction' => $toggleDir('name')])) }}" class="inline-flex items-center gap-1 hover:text-green-700">
                                    Name
                                    @if($currentSort === 'name')
                                        <span>{{ $currentDir === 'asc' ? '▲' : '▼' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">
                                <a href="{{ route('admin.users.index', array_merge(request()->all(), ['sort' => 'email', 'direction' => $toggleDir('email')])) }}" class="inline-flex items-center gap-1 hover:text-green-700">
                                    Email
                                    @if($currentSort === 'email')
                                        <span>{{ $currentDir === 'asc' ? '▲' : '▼' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">
                                <a href="{{ route('admin.users.index', array_merge(request()->all(), ['sort' => 'xp', 'direction' => $toggleDir('xp')])) }}" class="inline-flex items-center gap-1 hover:text-green-700">
                                    XP
                                    @if($currentSort === 'xp')
                                        <span>{{ $currentDir === 'asc' ? '▲' : '▼' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">
                                <a href="{{ route('admin.users.index', array_merge(request()->all(), ['sort' => 'is_admin', 'direction' => $toggleDir('is_admin')])) }}" class="inline-flex items-center gap-1 hover:text-green-700">
                                    Role
                                    @if($currentSort === 'is_admin')
                                        <span>{{ $currentDir === 'asc' ? '▲' : '▼' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">
                                <a href="{{ route('admin.users.index', array_merge(request()->all(), ['sort' => 'created_at', 'direction' => $toggleDir('created_at')])) }}" class="inline-flex items-center gap-1 hover:text-green-700">
                                    Joined
                                    @if($currentSort === 'created_at')
                                        <span>{{ $currentDir === 'asc' ? '▲' : '▼' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-4">
                                    @if($user->id !== auth()->id())
                                        <input type="checkbox" class="rounded border-gray-300 row-checkbox" name="ids[]" value="{{ $user->id }}" @change="syncSelected()">
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($user->avatar)
                                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover border border-gray-300">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-green-600 flex items-center justify-center text-white font-bold">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-500">ID: {{ $user->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600 text-sm">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800">
                                        ⭐ {{ $user->xp }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->is_admin)
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-bold bg-purple-100 text-purple-800">
                                            👑 Admin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800">
                                            🎮 Player
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-600 text-sm">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="px-3 py-2 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 transition text-sm font-semibold">
                                            ✏️ Edit
                                        </a>
                                        @if($user->id !== auth()->id())
                                            <button type="button" @click="openDeleteModal('{{ route('admin.users.destroy', $user) }}', '{{ addslashes($user->name) }}')" class="px-3 py-2 text-sm font-semibold rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition">🗑️ Delete</button>
                                        @else
                                            <span class="px-3 py-2 rounded-lg bg-gray-100 text-gray-400 text-sm font-semibold cursor-not-allowed">
                                                🗑️ Delete
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    Tidak ada pengguna
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards with Swipe Actions -->
            <div class="md:hidden divide-y">
                @forelse($users as $user)
                    <div class="p-4" x-data="{ startX: 0, deltaX: 0, open: false, onTouchStart(e){ this.startX = e.touches[0].clientX; }, onTouchEnd(e){ this.deltaX = e.changedTouches[0].clientX - this.startX; this.open = this.deltaX < -40; } }" @touchstart="onTouchStart($event)" @touchend="onTouchEnd($event)">
                        <div class="bg-gray-50 rounded-lg p-3 shadow-sm relative overflow-hidden">
                            <div class="flex items-center gap-3">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-full object-cover border border-gray-300">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-green-600 flex items-center justify-center text-white font-bold">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-gray-800 truncate">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-xs font-semibold text-yellow-700 bg-yellow-100 px-2 py-1 rounded-full">⭐ {{ $user->xp }}</span>
                                        @if($user->is_admin)
                                            <span class="text-xs font-semibold text-purple-700 bg-purple-100 px-2 py-1 rounded-full">👑 Admin</span>
                                        @else
                                            <span class="text-xs font-semibold text-green-700 bg-green-100 px-2 py-1 rounded-full">🎮 Player</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if($user->id !== auth()->id())
                                        <input type="checkbox" class="rounded border-gray-300 row-checkbox" name="ids[]" value="{{ $user->id }}" @change="syncSelected()">
                                    @endif
                                </div>
                            </div>
                            <div class="mt-3 text-xs text-gray-500">Bergabung: {{ $user->created_at->format('d M Y') }}</div>

                            <div class="mt-3 flex gap-2 transition" :class="open ? 'opacity-100' : 'opacity-0 pointer-events-none'">
                                <a href="{{ route('admin.users.edit', $user) }}" class="flex-1 text-center px-3 py-2 rounded-lg bg-blue-100 text-blue-700 text-sm font-semibold">✏️ Edit</a>
                                @if($user->id !== auth()->id())
                                    <form id="delete-user-{{ $user->id }}-mobile" method="POST" action="{{ route('admin.users.destroy', $user) }}" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <button type="button" @click="openDeleteModal('{{ route('admin.users.destroy', $user) }}', '{{ addslashes($user->name) }}')" class="flex-1 text-center px-3 py-2 rounded-lg bg-red-100 text-red-700 text-sm font-semibold hover:bg-red-200 transition">🗑️ Delete</button>
                                @endif
                            </div>
                            <div class="mt-2 text-[11px] text-gray-400">Geser kiri untuk aksi</div>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500">Tidak ada pengguna</div>
                @endforelse
            </div>
        </div>
    </form>

    <!-- Pagination -->
    <div class="mt-6 flex justify-center">
        {{ $users->onEachSide(1)->links() }}
    </div>

    <script>
        function deleteConfirm() {
            return {
                showModal: false,
                deleteUrl: '',
                itemName: '',
                openDeleteModal(url, name) {
                    this.deleteUrl = url;
                    this.itemName = name;
                    this.showModal = true;
                }
            }
        }
    </script>
    </div>
</x-admin-layout>
