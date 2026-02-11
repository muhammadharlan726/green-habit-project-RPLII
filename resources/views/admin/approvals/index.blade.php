<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">✅ Approval Management</h1>
        <p class="text-gray-600 text-xs sm:text-sm mt-1">Kelola verifikasi dan riwayat misi pengguna</p>
    </div>

    <!-- Tab Navigation -->
    <div class="mb-6 flex gap-4 border-b border-gray-200">
        <a href="#pending" onclick="showTab('pending')" id="pending-tab" class="pending-tab px-4 py-3 font-semibold text-gray-600 border-b-2 border-transparent hover:border-green-600 cursor-pointer transition">
            ⏳ Pending Approvals ({{ $pendingApprovals->total() }})
        </a>
        <a href="#history" onclick="showTab('history')" id="history-tab" class="history-tab px-4 py-3 font-semibold text-gray-600 border-b-2 border-transparent hover:border-green-600 cursor-pointer transition">
            📋 History
        </a>
    </div>

    <!-- Pending Approvals Section -->
    <div id="pending-section" class="tab-section">
        @if($pendingApprovals->isEmpty())
            <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                <div class="text-6xl mb-4">✨</div>
                <p class="text-gray-600 text-lg font-semibold">Tidak ada misi yang menunggu verifikasi</p>
                <p class="text-gray-500 text-sm mt-2">Semua bukti foto sudah diverifikasi!</p>
            </div>
        @else
            <div class="grid gap-6">
                @foreach($pendingApprovals as $approval)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-yellow-500">
                        <div class="p-4 sm:p-6">
                            <!-- Header Info -->
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                                <div>
                                    <h3 class="text-lg sm:text-xl font-bold text-gray-800">{{ $approval->mission_title }}</h3>
                                    <p class="text-gray-600 text-xs sm:text-sm">
                                        Submitted by: <span class="font-semibold">{{ $approval->user_name }}</span> ({{ $approval->user_email }})
                                    </p>
                                    <p class="text-gray-500 text-xs">
                                        📅 {{ \Carbon\Carbon::parse($approval->created_at)->format('d M Y H:i') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <div class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-bold">
                                        ⏳ Pending
                                    </div>
                                    <div class="mt-2 text-sm font-bold text-green-700">
                                        +{{ $approval->points_reward }} XP
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <p class="text-gray-700 text-xs sm:text-sm mb-4">{{ $approval->mission_description }}</p>

                            <!-- Evidence Display -->
                            @if($approval->evidence)
                                <div class="mb-4">
                                    <p class="text-xs sm:text-sm font-semibold text-gray-700 mb-2">📸 Evidence Photo:</p>
                                    <img src="{{ asset('storage/' . $approval->evidence) }}" alt="Evidence" class="max-w-full sm:max-w-md rounded-lg border border-gray-300 max-h-96 object-cover">
                                </div>
                            @endif

                            <!-- Notes -->
                            @if($approval->notes)
                                <div class="mb-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                                    <p class="text-xs sm:text-sm font-semibold text-gray-700 mb-1">💬 User Notes:</p>
                                    <p class="text-xs sm:text-sm text-gray-700">{{ $approval->notes }}</p>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row gap-3">
                                <form method="POST" action="{{ route('admin.approvals.approve', $approval->pivot_id) }}" style="flex: 1;">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition text-xs sm:text-sm">
                                        ✅ Approve (+{{ $approval->points_reward }} XP)
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.approvals.reject', $approval->pivot_id) }}" style="flex: 1;" onsubmit="return confirm('Yakin ingin menolak misi ini?');">
                                    @csrf
                                    <textarea name="notes" placeholder="Alasan penolakan (opsional)..." class="w-full mb-2 px-3 py-2 border border-gray-300 rounded-lg text-xs" rows="2"></textarea>
                                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition text-xs sm:text-sm">
                                        ❌ Reject
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $pendingApprovals->links() }}
            </div>
        @endif
    </div>

    <!-- History Section -->
    <div id="history-section" class="tab-section hidden">
        @if($historyApprovals->isEmpty())
            <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                <div class="text-6xl mb-4">📋</div>
                <p class="text-gray-600 text-lg font-semibold">Tidak ada riwayat verifikasi</p>
                <p class="text-gray-500 text-sm mt-2">Belum ada misi yang disetujui atau ditolak.</p>
            </div>
        @else
            <div class="grid gap-6">
                @foreach($historyApprovals as $history)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 {{ $history->status === 'approved' ? 'border-green-500' : 'border-red-500' }}">
                        <div class="p-4 sm:p-6">
                            <!-- Header Info -->
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                                <div>
                                    <h3 class="text-lg sm:text-xl font-bold text-gray-800">{{ $history->mission_title }}</h3>
                                    <p class="text-gray-600 text-xs sm:text-sm">
                                        User: <span class="font-semibold">{{ $history->user_name }}</span> ({{ $history->user_email }})
                                    </p>
                                    <p class="text-gray-500 text-xs">
                                        📅 {{ \Carbon\Carbon::parse($history->updated_at)->format('d M Y H:i') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    @if($history->status === 'approved')
                                        <div class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">
                                            ✅ Approved
                                        </div>
                                        <div class="mt-2 text-sm font-bold text-green-700">
                                            +{{ $history->points_reward }} XP
                                        </div>
                                    @else
                                        <div class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-bold">
                                            ❌ Rejected
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Description -->
                            <p class="text-gray-700 text-xs sm:text-sm mb-4">{{ $history->mission_description }}</p>

                            <!-- Evidence Display -->
                            @if($history->evidence)
                                <div class="mb-4">
                                    <p class="text-xs sm:text-sm font-semibold text-gray-700 mb-2">📸 Evidence Photo:</p>
                                    <img src="{{ asset('storage/' . $history->evidence) }}" alt="Evidence" class="max-w-full sm:max-w-md rounded-lg border border-gray-300 max-h-96 object-cover">
                                </div>
                            @endif

                            <!-- Notes/Rejection Reason -->
                            @if($history->notes)
                                <div class="p-3 {{ $history->status === 'approved' ? 'bg-blue-50 border-blue-200' : 'bg-red-50 border-red-200' }} rounded-lg border">
                                    <p class="text-xs sm:text-sm font-semibold {{ $history->status === 'approved' ? 'text-blue-700' : 'text-red-700' }} mb-1">
                                        {{ $history->status === 'approved' ? '💬 User Notes:' : '❌ Alasan Penolakan:' }}
                                    </p>
                                    <p class="text-xs sm:text-sm {{ $history->status === 'approved' ? 'text-blue-700' : 'text-red-700' }}">{{ $history->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $historyApprovals->links('pagination::tailwind', ['paginator' => $historyApprovals, 'path' => request()->url(), 'query' => request()->query()]) }}
            </div>
        @endif
    </div>

    <script>
        function showTab(tab) {
            // Hide all sections
            document.getElementById('pending-section').classList.add('hidden');
            document.getElementById('history-section').classList.add('hidden');
            
            // Remove active styling from all tabs
            document.getElementById('pending-tab').classList.remove('border-b-2', 'border-green-600', 'text-green-600', 'font-bold');
            document.getElementById('history-tab').classList.remove('border-b-2', 'border-green-600', 'text-green-600', 'font-bold');
            
            // Show selected section
            document.getElementById(tab + '-section').classList.remove('hidden');
            
            // Add active styling to selected tab
            document.getElementById(tab + '-tab').classList.add('border-b-2', 'border-green-600', 'text-green-600', 'font-bold');
        }

        // Show pending by default
        showTab('pending');
    </script>
</x-admin-layout>
