<div wire:init="load">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-black text-gray-900 tracking-tight mb-2">Matrix Kompetensi</h1>
        <p class="text-gray-500 font-medium">Matrix mapping kompetensi karyawan, jabatan, dan K3 secara komprehensif</p>
    </div>

    {{-- Advanced Filters & Controls --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8 flex flex-wrap items-center gap-6">
        {{-- Search --}}
        <div class="relative flex-1 min-w-[280px]">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" wire:model.live.debounce.500ms="search" placeholder="Cari karyawan, jabatan..."
                   class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-emerald-500 focus:bg-white focus:border-emerald-500 transition-all placeholder-gray-400">
        </div>

        {{-- Company Filter (Checklist Dropdown) --}}
        <div x-data="{ open: false, search: '' }" class="relative" @click.away="open = false">
            <button @click="open = !open" type="button" class="group px-5 py-3 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-700 flex items-center gap-3 hover:bg-gray-50 hover:border-gray-300 focus:ring-2 focus:ring-emerald-500 transition-all">
                <span>Perusahaan ({{ count($selectedCompanies) ?: 'Semua' }})</span>
                <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute top-full mt-2 left-0 w-72 bg-white border border-gray-100 rounded-2xl shadow-xl z-50 p-4 flex flex-col gap-3 origin-top-left" style="display: none;">

                <input type="text" x-model="search" placeholder="Cari perusahaan..."
                       class="w-full px-4 py-2 text-xs font-semibold bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition-all">

                <div class="max-h-64 overflow-y-auto space-y-1 custom-scrollbar pr-1">
                    @foreach($availableCompanies as $company)
                        <label x-show="'{{ strtolower($company->name) }}'.includes(search.toLowerCase())"
                               class="flex items-center gap-3 p-2.5 hover:bg-emerald-50 rounded-xl cursor-pointer transition-colors group">
                            <input type="checkbox" wire:model.live="selectedCompanies" value="{{ $company->id }}" class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-gray-300 group-hover:border-emerald-400">
                            <span class="text-xs font-bold text-gray-600 group-hover:text-emerald-800">{{ $company->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Competency Filter (Checklist Dropdown) --}}
        <div x-data="{ open: false, search: '' }" class="relative" @click.away="open = false">
            <button @click="open = !open" type="button" class="group px-5 py-3 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-700 flex items-center gap-3 hover:bg-gray-50 hover:border-gray-300 focus:ring-2 focus:ring-emerald-500 transition-all">
                <span>Kompetensi ({{ count($selectedCompetencies) ?: 'Semua' }})</span>
                <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute top-full mt-2 left-0 w-96 bg-white border border-gray-100 rounded-2xl shadow-xl z-50 p-4 flex flex-col gap-4 origin-top-left" style="display: none;">

                <div class="flex items-center justify-between px-1">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Filter Kompetensi</p>
                    <div class="flex gap-3">
                        <button wire:click="$set('selectedCompetencies', {{ $availableCompetencies->pluck('code')->toJson() }})" class="text-[10px] text-emerald-600 font-black hover:text-emerald-700 hover:underline">SELECT ALL</button>
                        <button wire:click="$set('selectedCompetencies', [])" class="text-[10px] text-rose-500 font-black hover:text-rose-600 hover:underline">RESET</button>
                    </div>
                </div>

                <input type="text" x-model="search" placeholder="Cari kode atau nama..."
                       class="w-full px-4 py-2 text-xs font-semibold bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:bg-white outline-none transition-all">

                <div class="max-h-80 overflow-y-auto pr-1 custom-scrollbar">
                    <div class="mb-4 sticky top-0 bg-white z-10 pb-2 border-b border-gray-50">
                        <label class="flex items-center gap-2 p-2.5 bg-emerald-50 border border-emerald-100 rounded-xl cursor-pointer hover:bg-emerald-100 transition-colors">
                            <input type="checkbox" wire:model.live="showOnlyActive" class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-emerald-300">
                            <span class="text-xs font-bold text-emerald-800">Hanya yang memiliki data</span>
                        </label>
                    </div>

                    @foreach($competencyCategories as $cat)
                        <div class="mb-4" x-data="{ count: 0 }" x-init="$nextTick(() => { count = $el.querySelectorAll('label[style*=\'display: block\']').length + $el.querySelectorAll('label:not([style*=\'display: none\'])').length })">
                            <p class="text-[10px] font-black text-gray-400 uppercase mb-2 px-1 tracking-wider">{{ $cat ?: 'Lainnya' }}</p>
                            <div class="space-y-1">
                                @foreach($availableCompetencies->where('category', $cat) as $comp)
                                    <label x-show="'{{ strtolower($comp->code . ' ' . $comp->name) }}'.includes(search.toLowerCase())"
                                           class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg cursor-pointer transition-colors group">
                                        <input type="checkbox" wire:model.live="selectedCompetencies" value="{{ $comp->code }}" class="w-3.5 h-3.5 rounded text-emerald-600 focus:ring-emerald-500 border-gray-300 group-hover:border-emerald-400">
                                        <div class="flex flex-col min-w-0">
                                            <span class="text-xs font-bold text-gray-700 truncate group-hover:text-gray-900">{{ $comp->code }}</span>
                                            <span class="text-[10px] font-medium text-gray-400 truncate group-hover:text-gray-500">{{ $comp->name }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Per Page Selector --}}
        <div class="flex items-center gap-3 bg-gray-50 rounded-xl px-3 py-1.5 border border-gray-200">
            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Show</span>
            <select wire:model.live="perPage" class="bg-transparent border-none text-xs font-bold text-gray-700 py-1.5 pr-8 pl-0 focus:ring-0 cursor-pointer">
                <option value="50">50 Rows</option>
                <option value="100">100 Rows</option>
                <option value="250">250 Rows</option>
                <option value="500">500 Rows</option>
            </select>
        </div>

        {{-- Sync & Matrix Controls --}}
        <div class="flex items-center gap-3 ml-auto">
            <button wire:click="syncJobStandards"
                    class="px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-black uppercase tracking-wider flex items-center gap-2 shadow-lg shadow-emerald-200 hover:shadow-emerald-300 transition-all active:scale-95 group">
                <svg class="w-4 h-4 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Sync Kebutuhan
            </button>
            <div class="flex bg-white rounded-xl border border-gray-200 p-1 shadow-sm">
                <button wire:click="toggleFullScreen" class="p-2.5 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all" title="Toggle Full Screen">
                    @if($isFullScreen)
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9L4 4m0 0l5-5M4 4h10M15 15l5 5m0 0l-5 5m5-5H10"></path>
                        </svg>
                    @else
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                        </svg>
                    @endif
                </button>
                <div class="w-px bg-gray-100 my-1 mx-0.5"></div>
                <button wire:click="loadMatrix" class="p-2.5 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-all" title="Reload Matrix">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Legend --}}
    <div class="flex items-center gap-8 mb-6 px-2">
        <p class="text-[10px] font-black text-gray-300 uppercase tracking-[0.2em]">Legend</p>
        <div class="flex items-center gap-2">
            <span class="flex h-2 w-2 rounded-full bg-emerald-500 ring-2 ring-emerald-100"></span>
            <span class="text-xs font-bold text-gray-500">Kompeten (C)</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="flex h-2 w-2 rounded-full bg-rose-500 ring-2 ring-rose-100"></span>
            <span class="text-xs font-bold text-gray-500">Belum Kompeten (N)</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="flex h-2 w-2 rounded-full bg-sky-500 ring-2 ring-sky-100"></span>
            <span class="text-xs font-bold text-gray-500">Tambahan (Y)</span>
        </div>
    </div>

    <style>
        /* Modern Layout Overrides */
        main .mx-auto.max-w-\[1600px\] { max-width: none !important; width: 100% !important; }
        main { overflow-x: visible !important; }

        .matrix-table { border-spacing: 0; border-collapse: separate; }
        .matrix-table td, .matrix-table th { border-color: #f1f5f9; }

        /* Status Cell Styling */
        .status-cell {
            width: 100%; height: 100%; display: flex; align-items: center;
            justify-content: center; font-weight: 800; font-size: 11px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .status-c { background-color: #10b981; color: white; }
        .status-n { background-color: #f43f5e; color: white; }
        .status-y { background-color: #0ea5e9; color: white; }
        .status-empty { background-color: #f8fafc; color: #cbd5e1; }

        .active-col-highlight { background-color: rgba(16, 185, 129, 0.03) !important; }
        .row-hover-highlight:hover td { background-color: rgba(16, 185, 129, 0.05) !important; }

        /* Vertical Table Header - Optimized */
        .vertical-header {
            height: 140px;
            vertical-align: bottom;
            position: relative;
            padding-bottom: 8px;
            min-width: 28px;
            max-width: 28px;
            border-right: 1px solid #f1f5f9;
        }
        .vertical-text {
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            white-space: nowrap;
            display: inline-block;
            text-align: left;
            margin: 0 auto;
            width: 100%;
            padding-top: 4px;
            max-height: 125px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        /* Custom Scrollbar for Dropdowns */
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 2px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
    </style>

    {{-- Top Pagination --}}
    <div class="flex items-center justify-between mb-4 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
        <div class="flex items-center gap-4">
            <h2 class="text-sm font-bold text-gray-800">Manajemen Matrix</h2>
            <div class="text-[10px] px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-full font-black tracking-wide uppercase">
                Total: {{ $rows->total() }} Data
            </div>
        </div>
        <div>
            {{ $rows->links() }}
        </div>
    </div>

    {{-- Matrix Table --}}
    <div class="{{ $isFullScreen ? 'fixed inset-0 z-[100] bg-slate-50 flex flex-col p-4 md:p-8' : 'h-[calc(100vh-250px)] min-h-[600px] flex flex-col' }}">
        @if($isFullScreen)
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-4">
                    <h1 class="text-2xl font-black text-gray-900 tracking-tight">Matrix Kompetensi <span class="text-emerald-500 text-lg align-top">FS</span></h1>
                </div>
                <button wire:click="toggleFullScreen" class="px-6 py-3 bg-rose-500 hover:bg-rose-600 text-white rounded-xl text-xs font-black uppercase tracking-wider flex items-center gap-2 shadow-lg shadow-rose-200 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Keluar Full Screen
                </button>
            </div>
        @endif

        <div x-data="{ hoverCol: null }" class="bg-white rounded-[1.5rem] shadow-xl border border-slate-200 flex-1 flex flex-col overflow-hidden relative">
            <div class="overflow-auto flex-1 h-0 w-full" style="scrollbar-gutter: stable;">
                    {{-- Employee Matrix --}}
                    <table class="w-full border-separate border-spacing-0 min-w-max matrix-table">
                        <thead class="sticky top-0 z-[60]">
                            {{-- Rotating Headers Row --}}
                            <tr style="height: 140px;">
                                <th class="sticky left-0 top-0 min-w-[30px] z-70 border-b bg-white border-r border-r-slate-100 flex items-end justify-center pb-2 text-[9px] text-slate-300 font-black">#</th>
                                <th class="sticky left-[30px] top-0 min-w-[150px] z-70 border-b bg-white shadow-[1px_0_2px_rgba(0,0,0,0.02)]"></th>
                                <th class="sticky left-[180px] top-0 min-w-[120px] z-70 border-b bg-white shadow-[1px_0_2px_rgba(0,0,0,0.02)]"></th>
                                <th class="sticky left-[300px] top-0 min-w-[120px] z-70 border-b border-r-2 border-r-emerald-500/10 bg-white shadow-[1px_0_2px_rgba(0,0,0,0.02)]"></th>
                                @foreach($headers ?? [] as $i => $header)
                                    <th class="border-b vertical-header bg-white transition-all duration-300 relative z-60"
                                        :class="hoverCol == '{{ $header['code'] }}' ? 'bg-emerald-50 text-emerald-600' : 'text-slate-400'"
                                        @mouseenter="hoverCol = '{{ $header['code'] }}'" @mouseleave="hoverCol = null"
                                        title="{{ $header['name'] }}">
                                        <div class="vertical-text">
                                            <span class="text-[9px] font-bold uppercase tracking-tight leading-none opacity-80">
                                                {{ $header['name'] }}
                                            </span>
                                        </div>
                                    </th>
                                @endforeach
                            </tr>
                            {{-- Column Labels --}}
                            <tr class="sticky top-[140px] z-60 text-[9px] text-slate-400 uppercase font-black tracking-wider">
                                <th class="sticky left-0 py-2 px-1 border-b border-r border-r-slate-100 bg-white text-center z-70"></th>
                                <th class="sticky left-[30px] py-2 px-3 border-b text-left bg-white shadow-[1px_0_2px_rgba(0,0,0,0.02)] z-70">NAMA / NIK</th>
                                <th class="sticky left-[180px] py-2 px-3 border-b text-left bg-white shadow-[1px_0_2px_rgba(0,0,0,0.02)] z-70">SECTION / DEPT</th>
                                <th class="sticky left-[300px] py-2 px-3 border-b border-r-2 border-r-emerald-500/10 bg-white shadow-[1px_0_2px_rgba(0,0,0,0.02)] z-70">JABATAN / PT</th>
                                @foreach($headers ?? [] as $header)
                                    <th class="border-b min-w-[28px] text-center bg-white py-1 transition-colors relative z-60"
                                        :class="hoverCol == '{{ $header['code'] }}' ? 'bg-emerald-50' : 'bg-slate-50/30'"
                                        @mouseenter="hoverCol = '{{ $header['code'] }}'" @mouseleave="hoverCol = null">
                                        <span class="text-[8px] font-black {{ $header['percent'] < 50 ? 'text-rose-500' : 'text-emerald-600' }}">
                                            {{ $header['percent'] }}%
                                        </span>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rows ?? [] as $index => $row)
                                <tr class="row-hover-highlight group transition-colors duration-150 border-b border-slate-50">
                                    <td class="sticky left-0 py-1.5 px-0.5 text-center bg-white font-bold text-slate-300 border-r border-slate-100 z-10 group-hover:bg-emerald-50/10">
                                        <span class="text-[9px]">{{ ($rows->currentPage() - 1) * $rows->perPage() + $index + 1 }}</span>
                                    </td>
                                    <td class="sticky left-[30px] py-1.5 px-3 bg-white z-10 group-hover:bg-emerald-50/10 shadow-[1px_0_2px_rgba(0,0,0,0.02)]">
                                        <div class="flex flex-col select-none">
                                            <span class="text-[10px] font-bold text-slate-700 uppercase tracking-tight truncate max-w-[140px] group-hover:text-emerald-700 transition-colors leading-snug">{{ $row['nama'] ?: 'NONAME' }}</span>
                                            <span class="text-[8px] text-slate-400 font-bold tracking-wider leading-none mt-0.5">{{ $row['nik'] }}</span>
                                        </div>
                                    </td>
                                    <td class="sticky left-[180px] py-1.5 px-3 bg-white z-10 group-hover:bg-emerald-50/10 border-r shadow-[1px_0_2px_rgba(0,0,0,0.02)]">
                                        <div class="flex flex-col select-none">
                                            <span class="text-[9px] font-bold text-slate-600 uppercase truncate max-w-[110px] leading-snug">{{ $row['section'] ?: '-' }}</span>
                                            <span class="text-[8px] text-slate-400 uppercase truncate max-w-[110px] tracking-tight leading-none mt-0.5">{{ $row['dept'] }}</span>
                                        </div>
                                    </td>
                                    <td class="sticky left-[300px] py-1.5 px-3 bg-white border-r-2 border-r-emerald-500/10 z-10 group-hover:bg-emerald-50/10 shadow-[1px_0_2px_rgba(0,0,0,0.02)]">
                                        <div class="flex flex-col select-none">
                                            <span class="text-[9px] font-bold text-emerald-600/90 truncate max-w-[110px] uppercase leading-snug">{{ $row['level'] ?: '-' }}</span>
                                            <span class="text-[8px] font-bold text-slate-400 truncate max-w-[110px] uppercase tracking-tight leading-none mt-0.5">{{ $row['pt'] }}</span>
                                        </div>
                                    </td>
                                    @foreach($headers ?? [] as $header)
                                        <td class="border-r border-slate-50 p-0 h-9 cursor-pointer relative transition-all duration-200 group/cell"
                                            :class="hoverCol == '{{ $header['code'] }}' ? 'active-col-highlight' : ''"
                                            @mouseenter="hoverCol = '{{ $header['code'] }}'" @mouseleave="hoverCol = null"
                                            wire:click="toggleCompetency('{{ $row['nik'] }}', '{{ $header['code'] }}')">
                                            @php
                                                $status = $row['comps'][$header['code']] ?? '';
                                                $sClass = $status === 'C' ? 'status-c' : ($status === 'N' ? 'status-n' : ($status === 'Y' ? 'status-y' : 'status-empty'));
                                            @endphp
                                            <div class="status-cell {{ $sClass }} group-hover/cell:scale-110 group-hover/cell:z-20 group-hover/cell:shadow-md group-hover/cell:rounded-sm transition-all duration-150">
                                                <span class="text-[8px]">{{ $status ?: '·' }}</span>
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                        @empty
                            <tr>
                                <td colspan="100" class="p-12 text-center">
                                    <div class="flex flex-col items-center justify-center opacity-50">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        <p class="text-sm font-bold text-gray-500">No data available.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="px-6 py-4 bg-white border border-gray-100 flex items-center justify-between mt-6 rounded-2xl shadow-sm">
            {{ $rows->links() }}
        </div>
    </div>

    {{-- Loading Overlay --}}
    <div wire:loading class="fixed inset-0 bg-white/80 backdrop-blur-sm flex items-center justify-center z-[200]">
        <div class="bg-white rounded-2xl p-6 shadow-2xl flex flex-col items-center gap-4 animate-bounce-small">
            <div class="relative">
                <div class="w-12 h-12 border-4 border-emerald-100 border-t-emerald-500 rounded-full animate-spin"></div>
            </div>
            <span class="text-xs font-black text-gray-800 uppercase tracking-widest">Memuat Data...</span>
        </div>
    </div>
</div>
