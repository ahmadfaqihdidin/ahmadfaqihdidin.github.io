<div class="p-6 bg-gray-50 min-h-screen font-sans">
    <!-- Flash Messages -->
    @if (session('success'))
        <div class="fixed top-4 right-4 z-50 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-lg flex items-start animate-bounce-small" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-emerald-700 font-bold text-sm">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Manajemen Induksi</h1>
            <p class="text-gray-500 font-medium mt-1 text-sm">Total <span class="font-bold text-gray-800">{{ $sessions->total() }}</span> sesi induksi tercatat dalam sistem.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <button wire:click="export" class="px-5 py-2.5 bg-white border border-gray-200 text-emerald-600 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-emerald-50 hover:border-emerald-200 shadow-sm transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Export CSV
            </button>
            <button wire:click="openImportModal" class="px-5 py-2.5 bg-white border border-gray-200 text-amber-600 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-amber-50 hover:border-amber-200 shadow-sm transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Import CSV
            </button>
            @can('create_inductions')
                <button wire:click="openCreateModal" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Sesi
                </button>
            @endcan
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-6">
            <div class="lg:col-span-2">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Pencarian</label>
                <div class="relative">
                    <input type="text" wire:model.live.debounce.500ms="search" placeholder="Cari Nama atau NIK..."
                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-800 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Perusahaan</label>
                <select wire:model.live="companyFilter" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-indigo-500 outline-none cursor-pointer">
                    <option value="">Semua Perusahaan</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Status</label>
                <select wire:model.live="statusFilter" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-indigo-500 outline-none cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="LULUS">Lulus</option>
                    <option value="TIDAK LULUS">Tidak Lulus</option>
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Dari Tanggal</label>
                <input type="date" wire:model.live="dateFrom" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Sampai Tanggal</label>
                <input type="date" wire:model.live="dateTo" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
        </div>
        <div class="mt-6 flex justify-end">
            <button wire:click="resetFilters" class="text-xs font-bold text-indigo-500 hover:text-indigo-700 hover:underline flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Reset Semua Filter
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-50">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Karyawan</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Perusahaan</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Tanggal</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Jenis</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Skor</th>
                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-4 text-center text-[10px] font-black text-gray-400 uppercase tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-50">
                    @forelse($sessions as $session)
                        <tr class="hover:bg-indigo-50/30 transition-colors duration-200 group">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900 text-sm">{{ $session->employee_name }}</div>
                                <div class="text-[10px] font-bold text-gray-400 font-mono mt-0.5">{{ $session->employee_user_id }}</div>
                            </td>
                            <td class="px-6 py-4 text-xs font-medium text-gray-600 uppercase">{{ $session->company?->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-xs font-bold text-gray-500">{{ $session->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 text-[10px] font-bold uppercase rounded-lg tracking-wide">{{ $session->jenis_induksi }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1">
                                    <span class="text-sm font-black {{ $session->score >= 80 ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ $session->score ?? 0 }}
                                    </span>
                                    <span class="text-[10px] text-gray-300 font-bold">/100</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-[10px] font-black rounded-full uppercase tracking-widest border {{ $session->status === 'LULUS' ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-rose-50 text-rose-700 border-rose-100' }}">
                                    {{ $session->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-1 opacity-80 group-hover:opacity-100 transition-opacity">
                                    <button wire:click="viewDetail({{ $session->id }})" class="p-2 text-indigo-500 hover:bg-indigo-50 rounded-xl transition-all" title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    @canany(['edit_inductions', 'edit_inductions_limited'])
                                        <button wire:click="openEditModal({{ $session->id }})" class="p-2 text-amber-500 hover:bg-amber-50 rounded-xl transition-all" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </button>
                                    @endcanany
                                    @can('delete_inductions')
                                        <button wire:click="confirmDelete({{ $session->id }})" class="p-2 text-rose-500 hover:bg-rose-50 rounded-xl transition-all" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center text-gray-400">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-200 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span class="text-xs font-bold uppercase tracking-widest">Tidak ada data ditemukan</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between">
            <div class="text-xs text-gray-500 font-bold">
                Menampilkan {{ $sessions->firstItem() ?? 0 }} - {{ $sessions->lastItem() ?? 0 }} dari {{ $sessions->total() }} data
            </div>
            {{ $sessions->links() }}
        </div>
    </div>

    <!-- Detail Modal -->
    @if($showDetailModal && $selectedSession)
        <div class="fixed inset-0 z-100 overflow-y-auto" x-data="{ show: false }" x-init="$nextTick(() => show = true)">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
                     wire:click="closeModals"
                     x-show="show"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"></div>

                <div class="relative bg-white rounded-[2rem] shadow-2xl max-w-4xl w-full overflow-hidden flex flex-col h-[85vh] transform transition-all"
                     x-show="show"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95">

                    <!-- Modal Header with Tabs -->
                    <div class="px-8 py-6 border-b border-gray-100 bg-white sticky top-0 z-10 shrink-0">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-2xl font-black text-gray-900 uppercase tracking-tight">Detail Sesi Induksi</h3>
                                <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-1">{{ $selectedSession->employee_name }}</p>
                            </div>
                            <button wire:click="closeModals" class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 text-gray-400 hover:bg-rose-50 hover:text-rose-500 transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>

                        <div class="flex gap-2 bg-gray-50 p-1.5 rounded-xl w-fit">
                            <button wire:click="setDetailTab('info')"
                                class="px-5 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all {{ $activeDetailTab === 'info' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-400 hover:text-gray-600' }}">
                                Informasi Umum
                            </button>
                            <button wire:click="setDetailTab('spdk')"
                                class="px-5 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all {{ $activeDetailTab === 'spdk' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-400 hover:text-gray-600' }}">
                                SPDK (Komitmen)
                            </button>
                            <button wire:click="setDetailTab('certificate')"
                                class="px-5 py-2.5 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all {{ $activeDetailTab === 'certificate' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-400 hover:text-gray-600' }}">
                                Sertifikat
                            </button>
                        </div>
                    </div>

                    <!-- Modal Body - Scrollable Content -->
                    <div class="grow overflow-y-auto p-8 bg-gray-50">
                        @if($activeDetailTab === 'info')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                                    <div class="flex items-center gap-3 mb-6">
                                        <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        </div>
                                        <h4 class="text-xs font-black text-gray-800 uppercase tracking-widest">Data Peserta</h4>
                                    </div>
                                    <div class="space-y-5">
                                        <div class="group">
                                            <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Nama Lengkap</span>
                                            <span class="text-sm font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $selectedSession->employee_name }}</span>
                                        </div>
                                        <div class="group">
                                            <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">NIK / ID</span>
                                            <span class="text-sm font-bold text-gray-900 font-mono">{{ $selectedSession->employee_user_id }}</span>
                                        </div>
                                        <div class="group">
                                            <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Perusahaan</span>
                                            <span class="text-sm font-bold text-gray-900">{{ $selectedSession->company?->name ?? 'N/A' }}</span>
                                        </div>
                                        <div class="group">
                                            <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Jabatan</span>
                                            <span class="text-sm font-bold text-gray-900">{{ $selectedSession->jabatan }}</span>
                                        </div>
                                        <div class="group">
                                            <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Kontak</span>
                                            <span class="text-sm font-bold text-gray-900">{{ $selectedSession->email }} <span class="text-gray-300">|</span> {{ $selectedSession->whatsapp ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                                    <div class="flex items-center gap-3 mb-6">
                                        <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <h4 class="text-xs font-black text-gray-800 uppercase tracking-widest">Hasil Induksi</h4>
                                    </div>
                                    <div class="space-y-5">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Jenis Induksi</span>
                                                <span class="px-2 py-1 bg-gray-100 rounded-lg text-xs font-bold text-gray-700">{{ $selectedSession->jenis_induksi }}</span>
                                            </div>
                                            <div class="text-right">
                                                <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Status</span>
                                                <span class="px-3 py-1 rounded-lg text-xs font-black uppercase tracking-widest {{ $selectedSession->status === 'LULUS' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                                    {{ $selectedSession->status }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 flex items-center gap-4">
                                            <div class="flex-1">
                                                <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Skor Akhir</span>
                                                <span class="text-3xl font-black {{ $selectedSession->status === 'LULUS' ? 'text-emerald-600' : 'text-rose-600' }}">
                                                    {{ $selectedSession->score }}<span class="text-sm font-bold text-gray-300">/100</span>
                                                </span>
                                            </div>
                                            <div class="h-10 w-px bg-gray-200"></div>
                                            <div class="flex-1 text-right">
                                                <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Masa Berlaku</span>
                                                <span class="text-sm font-bold text-gray-900">{{ $selectedSession->masa_berlaku ? \Carbon\Carbon::parse($selectedSession->masa_berlaku)->format('d M Y') : '-' }}</span>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                             <div>
                                                 <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Waktu Pre-Test</span>
                                                 <span class="text-xs font-bold text-gray-700 bg-gray-50 px-2 py-1 rounded border border-gray-100 inline-block">{{ $selectedSession->pretest_time ?? 0 }} detik</span>
                                             </div>
                                             <div>
                                                 <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Waktu Post-Test</span>
                                                 <span class="text-xs font-bold text-gray-700 bg-gray-50 px-2 py-1 rounded border border-gray-100 inline-block">{{ $selectedSession->posttest_time ?? 0 }} detik</span>
                                             </div>
                                         </div>
                                         <div>
                                             <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Kode Akses</span>
                                             <span class="font-mono text-xs font-bold text-gray-500 tracking-wider">{{ $selectedSession->kode_akses }}</span>
                                         </div>
                                     </div>
                                 </div>
                            </div>

                        @elseif($activeDetailTab === 'spdk')
                            <!-- SPDK Content -->
                            <div class="bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
                                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-8 text-white relative overflow-hidden">
                                    <div class="relative z-10">
                                        <h4 class="text-2xl font-black uppercase tracking-tight">Komitmen Keselamatan (SPDK)</h4>
                                        <p class="text-blue-100 mt-2 font-medium">Surat Pernyataan Disiplin Karyawan - PT. Ganda Alam Makmur</p>
                                    </div>
                                    <div class="absolute right-0 top-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-10 -mt-10 blur-2xl"></div>
                                </div>
                                <div class="p-8 md:p-10">
                                    <div class="prose max-w-none text-gray-700">
                                        <div class="bg-blue-50/50 border-l-4 border-blue-500 p-6 mb-8 rounded-r-xl italic text-sm font-medium text-blue-900 leading-relaxed">
                                            "Dengan membaca dan menyetujui dokumen ini, Saya bersedia untuk mematuhi dan melaksanakan peraturan yang berlaku di wilayah kerja PT. Ganda Alam Makmur. Apabila saya melanggar, Saya siap menerima sanksi sesuai dengan Matriks Pelanggaran Golden Rules yang berlaku."
                                        </div>

                                        <h5 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-4">Materi Induksi K3LH yang Dipelajari</h5>
                                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2 text-xs font-medium text-gray-600 list-disc pl-5 mb-10">
                                            <li>Kebijakan KPLH & Profil Perusahaan</li>
                                            <li>Bisnis Proses Pertambangan</li>
                                            <li>Dasar Peraturan KPLH & K3</li>
                                            <li>Keselamatan Pertambangan (K3)</li>
                                            <li>Bahaya, Risiko & Kecelakaan</li>
                                            <li>Hierarki Pengendalian Risiko</li>
                                            <li>Pengelolaan Lalu Lintas & LOTO</li>
                                            <li>Pelaporan Kecelakaan</li>
                                            <li>Bantuan Hidup Dasar (BHD)</li>
                                            <li>Penggunaan APAR & Luka Bakar</li>
                                            <li>Golden Rules & Sanksi</li>
                                        </ul>

                                        <h5 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-4">Matriks Pelanggaran Golden Rules</h5>
                                        <div class="border border-gray-100 rounded-2xl overflow-hidden mb-10 shadow-sm">
                                            <table class="w-full text-xs text-left">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th class="px-4 py-3 font-black text-gray-500 uppercase tracking-wider">Jenis Pelanggaran</th>
                                                        <th class="px-4 py-3 font-black text-gray-500 uppercase tracking-wider w-32 text-center">Sanksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-50">
                                                    <tr><td class="px-4 py-3 font-medium">Melanggar rambu lalin, Jarak aman kurang, Main HP saat operasi</td><td class="px-4 py-3 font-bold text-rose-600 text-center bg-rose-50/50">SP 2</td></tr>
                                                    <tr><td class="px-4 py-3 font-medium">Speeding > 30km/jam, Operasi unit rusak kritis, Lalai awasi</td><td class="px-4 py-3 font-bold text-rose-700 text-center bg-rose-50/50">SP 3</td></tr>
                                                    <tr><td class="px-4 py-3 font-medium">Operasi tanpa SIMPER, Alkohol, Sebar info laka di medsos</td><td class="px-4 py-3 font-black text-white bg-rose-600 text-center">PHK</td></tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="flex flex-col md:flex-row justify-between items-end border-t-2 border-dashed border-gray-100 pt-8 gap-8">
                                            <div class="text-xs text-gray-400 space-y-1">
                                                <p>IP Address: <span class="font-mono text-gray-600">{{ $selectedSession->ip_address }}</span></p>
                                                <p>Timestamp: <span class="font-mono text-gray-600">{{ now()->format('d M Y H:i:s') }}</span></p>
                                            </div>
                                            <div class="text-center">
                                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Tanda Tangan Elektronik</p>
                                                <div class="h-24 w-48 border border-gray-200 rounded-xl flex items-center justify-center bg-gray-50 mb-2 overflow-hidden relative group">
                                                    @if($selectedSession->signature)
                                                        <img src="{{ $selectedSession->signature }}" alt="Tanda Tangan" class="h-full object-contain opacity-80 group-hover:opacity-100 transition-opacity">
                                                    @else
                                                        <span class="text-[10px] text-gray-300 font-bold uppercase italic">Menunggu TTD</span>
                                                    @endif
                                                </div>
                                                <p class="text-xs font-bold text-gray-900 uppercase">{{ $selectedSession->employee_name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @elseif($activeDetailTab === 'certificate')
                            <!-- Certificate Mockup -->
                            <div class="bg-gray-100 p-4 md:p-8 rounded-3xl shadow-inner border border-gray-200 grow flex flex-col items-center justify-start overflow-y-auto min-h-[600px]">
                                <!-- Main Certificate Container -->
                                <div class="relative w-full max-w-4xl bg-indigo-900 rounded-xl shadow-2xl overflow-hidden p-1.5 transform hover:scale-[1.01] transition-transform duration-500"
                                     style="aspect-ratio: 297/210; min-height: 480px; background: linear-gradient(135deg, #312e81 0%, #4338ca 100%);">

                                    <!-- Inner White Paper -->
                                    <div class="absolute inset-2 md:inset-4 bg-white rounded-lg flex flex-col items-center justify-between p-8 md:p-12 text-gray-800 shadow-inner"
                                         style="background-image: radial-gradient(#f1f5f9 1px, transparent 1px); background-size: 20px 20px;">

                                        <!-- Corner Accents -->
                                        <div class="absolute top-0 left-0 w-24 h-24 border-t-4 border-l-4 border-indigo-600 rounded-tl-lg opacity-20"></div>
                                        <div class="absolute bottom-0 right-0 w-24 h-24 border-b-4 border-r-4 border-indigo-600 rounded-br-lg opacity-20"></div>

                                        <!-- Certificate Header -->
                                        <div class="text-center z-10 w-full relative">
                                            <div class="w-16 h-16 md:w-20 md:h-20 bg-indigo-900 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl border-4 border-white text-white font-serif text-3xl font-bold">
                                                G
                                            </div>
                                            <h2 class="text-4xl md:text-5xl font-black tracking-widest text-indigo-900 uppercase font-serif">Sertifikat</h2>
                                            <p class="text-indigo-500 font-bold tracking-[0.3em] text-xs md:text-sm mt-2 uppercase">Induksi Keselamatan & Kesehatan Kerja</p>
                                        </div>

                                        <!-- Recipient Information -->
                                        <div class="text-center z-10 w-full space-y-4">
                                            <p class="text-sm md:text-base italic text-gray-400 font-serif">Diberikan kepada:</p>
                                            <div class="py-4 border-b-2 border-gray-100 inline-block px-12">
                                                <h1 class="text-2xl md:text-5xl font-black text-gray-900 uppercase tracking-tight">{{ $selectedSession->employee_name }}</h1>
                                            </div>
                                            <p class="text-gray-500 font-bold tracking-widest text-xs md:text-sm uppercase mt-2">
                                                ID: {{ $selectedSession->employee_user_id }} <span class="text-indigo-300 mx-2">•</span> {{ $selectedSession->company?->name ?? 'N/A' }}
                                            </p>
                                        </div>

                                        <!-- Achievement Details -->
                                        <div class="text-center z-10 w-full">
                                            <p class="text-xs md:text-sm text-gray-500 max-w-2xl mx-auto leading-relaxed font-medium">
                                                Telah menyatakan komitmen dan menyelesaikan seluruh rangkaian materi safety induction dengan hasil evaluasi akhir yang memuaskan.
                                            </p>

                                            <div class="mt-8 flex items-center justify-center gap-8 md:gap-12">
                                                <div class="text-center">
                                                    <span class="block text-[8px] md:text-[10px] uppercase font-black text-gray-300 tracking-widest mb-1">Predikat</span>
                                                    <span class="px-4 py-1 bg-indigo-50 text-indigo-700 rounded-lg font-black text-lg uppercase tracking-wider border border-indigo-100">{{ $selectedSession->status }}</span>
                                                </div>
                                                <div class="text-center">
                                                    <span class="block text-[8px] md:text-[10px] uppercase font-black text-gray-300 tracking-widest mb-1">Skor Akhir</span>
                                                    <span class="text-3xl md:text-4xl font-black text-gray-800">{{ $selectedSession->score }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Footer / Signatures -->
                                        <div class="flex justify-between w-full px-4 md:px-12 mt-4 items-end">
                                            <div class="text-center">
                                                <div class="h-16 flex items-end justify-center pb-2">
                                                    <div class="w-32 border-b border-gray-300"></div>
                                                </div>
                                                <p class="text-[10px] font-black text-gray-900 uppercase tracking-widest">HSE DEPARTMENT</p>
                                                <p class="text-[8px] text-gray-400">PT Ganda Alam Makmur</p>
                                            </div>

                                            <!-- QR Code Placeholder -->
                                            <div class="h-16 w-16 bg-gray-100 border border-gray-200 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zM6 6h2v2H6V6zm0 12h2v2H6v-2zm12-12h2v2h-2V6z"></path></svg>
                                            </div>

                                            <div class="text-center">
                                                <div class="h-16 flex items-end justify-center pb-2 relative">
                                                    @if($selectedSession->signature)
                                                        <img src="{{ $selectedSession->signature }}" alt="Signature" class="h-12 absolute bottom-2 opacity-80 mix-blend-multiply">
                                                    @endif
                                                    <div class="w-32 border-b border-gray-300"></div>
                                                </div>
                                                <p class="text-[10px] font-black text-gray-900 uppercase tracking-widest">PESERTA INDUKSI</p>
                                                <p class="text-[8px] text-gray-400">{{ \Carbon\Carbon::parse($selectedSession->tanggal_induksi)->format('d F Y') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Modal Footer -->
                    <div class="px-8 py-5 bg-white border-t border-gray-100 flex justify-between items-center shrink-0">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center gap-2 px-3 py-1 bg-gray-50 rounded-lg">
                                <span class="w-2 h-2 rounded-full {{ $selectedSession->signature ? 'bg-emerald-500 animate-pulse' : 'bg-rose-500' }}"></span>
                                <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">
                                    {{ $selectedSession->signature ? 'Signed' : 'Unsigned' }}
                                </span>
                            </div>
                        </div>
                        <button wire:click="closeModals" class="px-8 py-3 bg-slate-900 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 hover:shadow-lg transition-all transform active:scale-95">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Form Modal -->
    @if($showFormModal)
        <div class="fixed inset-0 z-100 overflow-y-auto" x-data="{ show: false }" x-init="$nextTick(() => show = true)">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
                     wire:click="closeModals"
                     x-show="show"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"></div>

                <div class="relative bg-white rounded-3xl shadow-2xl max-w-4xl w-full p-8 transform transition-all border border-slate-100"
                     x-show="show"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95">

                    <div class="flex justify-between items-center mb-8">
                        <h3 class="text-2xl font-black text-gray-900 uppercase tracking-tight">{{ $isEditMode ? 'Edit Sesi Induksi' : 'Tambah Sesi Induksi' }}</h3>
                        <button wire:click="closeModals" class="text-gray-400 hover:text-gray-900 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    @if($isLimitedEdit)
                        <div class="mb-6 bg-amber-50 border-l-4 border-amber-400 p-4 rounded-r-xl flex items-start gap-3">
                            <svg class="h-5 w-5 text-amber-400 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            <div>
                                <p class="text-sm font-bold text-amber-800">Mode Edit Terbatas</p>
                                <p class="text-xs text-amber-700 mt-1">Beberapa field sensitif (Tanggal, Skor, Status) dikunci untuk menjaga integritas data.</p>
                            </div>
                        </div>
                    @endif

                    <form wire:submit.prevent="save" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Employee Info -->
                            <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100 space-y-4">
                                <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Informasi Karyawan</h4>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">NIK Karyawan</label>
                                    <input type="text" wire:model="employee_user_id" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold text-gray-800">
                                    @error('employee_user_id') <span class="text-rose-500 text-[10px] font-bold block mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Nama Karyawan</label>
                                    <input type="text" wire:model="employee_name" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold text-gray-800">
                                    @error('employee_name') <span class="text-rose-500 text-[10px] font-bold block mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Perusahaan</label>
                                    <select wire:model="company_id" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold text-gray-800 bg-white">
                                        <option value="">Pilih Perusahaan</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('company_id') <span class="text-rose-500 text-[10px] font-bold block mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Jabatan</label>
                                    <input type="text" wire:model="jabatan" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold text-gray-800">
                                    @error('jabatan') <span class="text-rose-500 text-[10px] font-bold block mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Session & Result Info -->
                            <div class="space-y-4">
                                <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100 space-y-4">
                                    <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Detail Sesi</h4>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Tanggal</label>
                                            <input type="date" wire:model="tanggal_induksi"
                                                class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold text-gray-800 {{ $isLimitedEdit ? 'bg-gray-100 cursor-not-allowed opacity-60' : '' }}"
                                                {{ $isLimitedEdit ? 'disabled' : '' }}>
                                            @error('tanggal_induksi') <span class="text-rose-500 text-[10px] font-bold block mt-1">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Jenis</label>
                                            <select wire:model="jenis_induksi" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold text-gray-800 bg-white">
                                                <option value="">Pilih Jenis</option>
                                                @foreach(['Temporary', 'Visitor', 'Magang', 'NewHire GAM', 'NewHire Mitra', 'PascaCuti GAM', 'PascaCuti Mitra', 'Refresher'] as $opt)
                                                    <option value="{{ $opt }}">{{ $opt }}</option>
                                                @endforeach
                                            </select>
                                            @error('jenis_induksi') <span class="text-rose-500 text-[10px] font-bold block mt-1">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Skor</label>
                                            <input type="number" wire:model="score" min="0" max="100"
                                                class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold text-gray-800 {{ $isLimitedEdit ? 'bg-gray-100 cursor-not-allowed opacity-60' : '' }}"
                                                {{ $isLimitedEdit ? 'disabled' : '' }}>
                                            @error('score') <span class="text-rose-500 text-[10px] font-bold block mt-1">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Status</label>
                                            <select wire:model="status"
                                                class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold text-gray-800 bg-white {{ $isLimitedEdit ? 'bg-gray-100 cursor-not-allowed opacity-60' : '' }}"
                                                {{ $isLimitedEdit ? 'disabled' : '' }}>
                                                <option value="LULUS">LULUS</option>
                                                <option value="TIDAK LULUS">TIDAK LULUS</option>
                                            </select>
                                            @error('status') <span class="text-rose-500 text-[10px] font-bold block mt-1">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Status Tanda Tangan</label>
                                            <select wire:model="ttd_status" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold text-gray-800 bg-white">
                                                <option value="Menunggu">Menunggu</option>
                                                <option value="Disetujui">Disetujui</option>
                                                <option value="Ditolak">Ditolak</option>
                                            </select>
                                            @error('ttd_status') <span class="text-rose-500 text-[10px] font-bold block mt-1">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Masa Berlaku</label>
                                            <input type="date" wire:model="masa_berlaku"
                                                class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold text-gray-800 {{ $isLimitedEdit ? 'bg-gray-100 cursor-not-allowed opacity-60' : '' }}"
                                                {{ $isLimitedEdit ? 'disabled' : '' }}>
                                            @error('masa_berlaku') <span class="text-rose-500 text-[10px] font-bold block mt-1">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Waktu Pre-Test (Detik)</label>
                                            <input type="number" wire:model="pretest_time" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold text-gray-800">
                                            @error('pretest_time') <span class="text-rose-500 text-[10px] font-bold block mt-1">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Waktu Post-Test (Detik)</label>
                                            <input type="number" wire:model="posttest_time" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 text-sm font-bold text-gray-800">
                                            @error('posttest_time') <span class="text-rose-500 text-[10px] font-bold block mt-1">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100">
                                    <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Kontak Tambahan</h4>
                                    <div class="grid grid-cols-2 gap-4">
                                        <input type="email" wire:model="email" placeholder="Email" class="w-full px-4 py-2 border border-gray-200 rounded-xl text-sm font-medium">
                                        <input type="text" wire:model="whatsapp" placeholder="WhatsApp" class="w-full px-4 py-2 border border-gray-200 rounded-xl text-sm font-medium">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-100 flex justify-end gap-4">
                            <button type="button" wire:click="closeModals" class="px-6 py-3 bg-white text-gray-600 rounded-xl font-bold border border-gray-200 hover:bg-gray-50 transition-all">Batal</button>
                            <button type="submit" class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-black text-xs uppercase tracking-widest shadow-lg shadow-indigo-100 hover:bg-indigo-700 hover:shadow-xl transition-all transform active:scale-95">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Import Modal -->
    @if($showImportModal)
        <div class="fixed inset-0 z-100 overflow-y-auto" x-data="{ show: false }" x-init="$nextTick(() => show = true)">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
                     wire:click="closeModals"
                     x-show="show"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"></div>

                <div class="relative bg-white rounded-3xl shadow-2xl max-w-lg w-full p-8 transform transition-all border border-slate-100"
                     x-show="show"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-black text-gray-900 uppercase tracking-tight">Import Data Induksi</h3>
                        <button wire:click="closeModals" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <div class="mb-8">
                        <button wire:click="downloadTemplate" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 hover:underline flex items-center gap-2 group">
                            <div class="p-1.5 bg-indigo-50 rounded-lg group-hover:bg-indigo-100 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            </div>
                            Download Template CSV
                        </button>
                    </div>

                    <form wire:submit.prevent="processImport">
                        <div class="space-y-6">
                            <div class="relative group">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Upload File</label>
                                <div class="border-2 border-dashed border-gray-200 rounded-2xl p-8 text-center hover:border-indigo-400 hover:bg-indigo-50/30 transition-all cursor-pointer relative">
                                    <input type="file" wire:model="csvFile" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <div class="text-gray-400 group-hover:text-indigo-500 transition-colors">
                                        <svg class="w-10 h-10 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                        <p class="text-xs font-bold uppercase tracking-wide">Drag & drop or click to upload</p>
                                        <p class="text-[10px] mt-1 opacity-70">CSV files only</p>
                                    </div>
                                    @if($csvFile)
                                        <div class="absolute inset-0 bg-emerald-50 rounded-2xl flex items-center justify-center border-2 border-emerald-200">
                                            <p class="text-sm font-bold text-emerald-700 flex items-center gap-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                File Selected
                                            </p>
                                        </div>
                                    @endif
                                </div>
                                @error('csvFile') <span class="text-rose-500 text-[10px] font-bold block mt-1">{{ $message }}</span> @enderror
                                <div wire:loading wire:target="csvFile" class="mt-2 text-xs font-bold text-indigo-500 animate-pulse">Sedang mengunggah...</div>
                            </div>

                            <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Metode Sinkronisasi</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <label class="flex items-center gap-3 p-3 bg-white border border-gray-200 rounded-xl cursor-pointer hover:border-indigo-400 transition-all shadow-sm">
                                        <input type="radio" wire:model.live="importMode" value="tambahan" class="w-4 h-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                        <div>
                                            <span class="block text-xs font-bold text-gray-800">Update Tambahan</span>
                                            <span class="block text-[9px] text-gray-400">Hanya data baru</span>
                                        </div>
                                    </label>
                                    <label class="flex items-center gap-3 p-3 bg-white border border-gray-200 rounded-xl cursor-pointer hover:border-indigo-400 transition-all shadow-sm">
                                        <input type="radio" wire:model.live="importMode" value="semua" class="w-4 h-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                        <div>
                                            <span class="block text-xs font-bold text-gray-800">Update Semua</span>
                                            <span class="block text-[9px] text-gray-400">Timpa data ada</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end gap-4">
                            <button type="button" wire:click="closeModals" class="px-6 py-3 bg-white text-gray-600 rounded-xl font-bold border border-gray-200 hover:bg-gray-50 transition-all">Batal</button>
                            <button type="submit" wire:loading.attr="disabled" class="px-8 py-3 bg-emerald-600 text-white rounded-xl font-black text-xs uppercase tracking-widest shadow-lg shadow-emerald-100 hover:bg-emerald-700 hover:shadow-xl transition-all transform active:scale-95 disabled:opacity-50 flex items-center gap-2">
                                <span wire:loading.remove wire:target="processImport">Eksekusi Import</span>
                                <span wire:loading wire:target="processImport" class="flex items-center gap-2">
                                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Memproses...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Modal -->
    @if($showDeleteModal && $selectedSession)
        <div class="fixed inset-0 z-100 overflow-y-auto" x-data="{ show: false }" x-init="$nextTick(() => show = true)">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
                     wire:click="closeModals"
                     x-show="show"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"></div>

                <div class="relative bg-white rounded-3xl shadow-2xl max-w-sm w-full p-8 text-center transform transition-all"
                     x-show="show"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-90 translate-y-4"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-90 translate-y-4">

                    <div class="w-16 h-16 bg-rose-100 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </div>

                    <h3 class="text-xl font-black text-gray-900 mb-2">Hapus Data Induksi?</h3>
                    <p class="text-sm text-gray-500 font-medium leading-relaxed mb-8">Apakah Anda yakin ingin menghapus data milik <br><span class="text-gray-900 font-bold">{{ $selectedSession->employee_name }}</span>? Tindakan ini tidak dapat dibatalkan.</p>

                    <div class="flex gap-3 justify-center">
                        <button wire:click="closeModals" class="px-6 py-3 bg-white border border-gray-200 text-gray-600 rounded-xl font-bold hover:bg-gray-50 transition-all">Batal</button>
                        <button wire:click="deleteSession" class="px-6 py-3 bg-rose-600 text-white rounded-xl font-bold shadow-lg shadow-rose-200 hover:bg-rose-700 transition-all transform active:scale-95">Ya, Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
