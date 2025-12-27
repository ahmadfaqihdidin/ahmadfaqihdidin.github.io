<div class="font-sans">
    {{-- Header & Tab Navigation --}}
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Unified Training Management</h1>
                <p class="text-gray-500">Pusat manajemen program, jadwal, dan realisasi kompetensi terpadu.</p>
            </div>

            <div class="flex items-center gap-3">
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari..."
                           class="pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent outline-none transition-all w-64 shadow-sm">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Tabs Navigation --}}
        <div class="flex items-center p-1.5 bg-gray-100 rounded-2xl w-max shadow-inner">
            @php
                $tabs = [
                    'dashboard' => ['icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'label' => 'Dashboard'],
                    'programs' => ['icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168 0.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332 0.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.168 0.477-4.5 1.253', 'label' => 'Programs'],
                    'schedules' => ['icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'label' => 'Schedules'],
                    'realizations' => ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Realizations'],
                    'evaluations' => ['icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z', 'label' => 'Evaluations'],
                    'reports' => ['icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'label' => 'Reports'],
                ];
            @endphp

            @foreach($tabs as $key => $tabInfo)
                <button wire:click="switchTab('{{ $key }}')"
                        class="flex items-center gap-2 px-5 py-2 rounded-xl text-sm font-bold transition-all {{ $activeTab === $key ? 'bg-white text-emerald-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $tabInfo['icon'] }}"></path>
                    </svg>
                    {{ $tabInfo['label'] }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Flash Messages --}}
    @if (session()->has('message'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 mb-6 rounded-r-lg shadow-sm flex items-center gap-3 anim-pulse" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
            <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <p class="text-emerald-700 font-medium text-sm">{{ session('message') }}</p>
        </div>
    @endif

    {{-- Main Tab Content --}}
    <div class="transition-all duration-300">
        @if($activeTab === 'dashboard')
            {{-- Dashboard Content --}}
            <div class="space-y-6">
                {{-- Quick Stats --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm transition-transform hover:scale-[1.02]">
                        <div class="flex items-center gap-4">
                            <div class="p-4 bg-emerald-50 text-emerald-600 rounded-2xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332 0.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.168 0.477-4.5 1.253"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Total Programs</p>
                                <h3 class="text-2xl font-black text-gray-900 leading-none">{{ $stats['total_programs'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm transition-transform hover:scale-[1.02]">
                        <div class="flex items-center gap-4">
                            <div class="p-4 bg-blue-50 text-blue-600 rounded-2xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Active Schedules</p>
                                <h3 class="text-2xl font-black text-gray-900 leading-none">{{ $stats['active_schedules'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm transition-transform hover:scale-[1.02]">
                        <div class="flex items-center gap-4">
                            <div class="p-4 bg-amber-50 text-amber-600 rounded-2xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Pending Approvals</p>
                                <h3 class="text-2xl font-black leading-none text-amber-600">{{ $stats['pending_approvals'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm transition-transform hover:scale-[1.02]">
                        <div class="flex items-center gap-4">
                            <div class="p-4 bg-purple-50 text-purple-600 rounded-2xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none mb-1">Monthly Completions</p>
                                <h3 class="text-2xl font-black text-gray-900 leading-none">{{ $stats['completed_this_month'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {{-- Pending Table Widget --}}
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden lg:col-span-2">
                        <div class="p-5 border-b border-gray-50 flex items-center justify-between bg-gray-50/30">
                            <h4 class="text-sm font-black text-gray-800 uppercase tracking-wider">Pending Realization Approvals</h4>
                            <button wire:click="switchTab('realizations')" class="text-[10px] font-black text-emerald-600 hover:underline tracking-widest uppercase">Lihat Detail →</button>
                        </div>
                        <table class="w-full text-left">
                            <thead class="bg-white text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-50">
                                <tr>
                                    <th class="px-5 py-3">Employee</th>
                                    <th class="px-5 py-3">Competency</th>
                                    <th class="px-5 py-3">Date</th>
                                    <th class="px-5 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-sm">
                                @forelse($pendingApprovals as $item)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-5 py-3">
                                            <div class="font-bold text-gray-800 uppercase tracking-tight text-xs">{{ $item->employee?->name }}</div>
                                            <div class="text-[9px] text-gray-400 font-mono tracking-tighter">{{ $item->employee_id }}</div>
                                        </td>
                                        <td class="px-5 py-3">
                                            <div class="text-[10px] font-bold text-gray-600 truncate max-w-[150px]">{{ $item->competency?->name }}</div>
                                        </td>
                                        <td class="px-5 py-3 text-[10px] text-gray-500 font-bold">{{ $item->training_date->format('d M Y') }}</td>
                                        <td class="px-5 py-3 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <button wire:click="approve({{ $item->id }})" class="p-1.5 text-emerald-500 hover:bg-emerald-50 rounded-lg" title="Approve">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                </button>
                                                <button wire:click="openRejectModal({{ $item->id }})" class="p-1.5 text-rose-500 hover:bg-rose-50 rounded-lg" title="Reject">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="p-8 text-center text-gray-400 text-xs italic">Tidak ada antrian persetujuan</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Activity & Upcoming --}}
                    <div class="space-y-6">
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                            <div class="p-4 border-b border-gray-50 flex items-center justify-between">
                                <h4 class="text-xs font-black text-gray-800 uppercase tracking-widest">Upcoming Schedules</h4>
                            </div>
                            <div class="divide-y divide-gray-50">
                                @forelse($upcomingSchedules as $sch)
                                    <div class="p-4 flex gap-3 hover:bg-gray-50 transition-colors cursor-pointer" wire:click="selectProgram({{ $sch->training_program_id }})">
                                        <div class="w-10 h-10 bg-slate-100 rounded-xl flex flex-col items-center justify-center shrink-0 border border-slate-200">
                                            <span class="text-[11px] font-black text-slate-800 leading-none">{{ $sch->start_date->format('d') }}</span>
                                            <span class="text-[8px] font-bold text-slate-400 uppercase leading-none mt-0.5">{{ $sch->start_date->format('M') }}</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-[11px] font-bold text-gray-800 uppercase truncate leading-tight">{{ $sch->title ?: $sch->trainingProgram?->name }}</p>
                                            <p class="text-[9px] text-gray-400 mt-1 truncate">{{ $sch->location }} • {{ $sch->start_time }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-6 text-center text-gray-400 text-[10px] italic uppercase tracking-widest">Empty Schedules</div>
                                @endforelse
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                            <div class="p-4 border-b border-gray-50 flex items-center justify-between bg-emerald-50/20">
                                <h4 class="text-xs font-black text-emerald-800 uppercase tracking-widest text-[10px]">Real-time Updates</h4>
                                <div class="w-2 h-2 bg-emerald-500 rounded-full animate-ping"></div>
                            </div>
                            <div class="p-4 space-y-4 max-h-[250px] overflow-y-auto custom-scrollbar">
                                @foreach($recentActivities as $act)
                                    <div class="flex gap-3 text-[10px]">
                                        <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center shrink-0 text-emerald-600 border border-emerald-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-gray-600 leading-snug"><span class="font-bold text-gray-800 uppercase">{{ $act->employee?->name }}</span> completed <span class="text-emerald-600 font-bold uppercase">{{ $act->competency?->name }}</span></p>
                                            <p class="text-[9px] text-gray-400 mt-1">{{ $act->updated_at?->diffForHumans() ?? 'Recently' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($activeTab === 'programs')
            {{-- Programs Full Content --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-black text-gray-800 uppercase tracking-tight">Training Programs Catalog</h3>
                        <p class="text-xs text-gray-500 font-medium">Manage master data of training courses and their competency mappings.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button wire:click="openImportModal('program')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-all border border-slate-200">Import</button>
                        <button wire:click="openProgramModal" class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-xs font-bold transition-all shadow-lg shadow-emerald-100 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            NEW PROGRAM
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4">Program Name</th>
                                <th class="px-6 py-4">Duration</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Schedules</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            @foreach($programs as $program)
                                <tr class="hover:bg-gray-50 transition-colors group">
                                    <td class="px-6 py-4">
                                        <p class="font-black text-gray-800 uppercase tracking-tight text-xs">{{ $program->name }}</p>
                                        <p class="text-[10px] text-gray-400 mt-1 italic truncate max-w-sm">{{ $program->description }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-[10px] font-bold">{{ $program->duration_hours }} HOURS</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-0.5 {{ $program->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }} rounded-full text-[10px] font-black tracking-widest">
                                            {{ $program->is_active ? 'ACTIVE' : 'INACTIVE' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button wire:click="selectProgram({{ $program->id }})" class="group/btn relative px-3 py-1 bg-emerald-50 text-emerald-700 rounded-lg text-[10px] font-black border border-emerald-100 hover:bg-emerald-500 hover:text-white transition-all">
                                            {{ $program->schedules_count }} SESSIONS
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button wire:click="openSyllabusModal({{ $program->id }})" class="p-2 text-indigo-500 hover:bg-indigo-50 rounded-xl" title="Syllabus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            </button>
                                            <button wire:click="openProgramModal({{ $program->id }})" class="p-2 text-blue-500 hover:bg-blue-50 rounded-xl" title="Edit"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></button>
                                            <button onclick="confirm('Hapus program ini?') ? @this.call('deleteProgram', {{ $program->id }}) : false" class="p-2 text-rose-500 hover:bg-rose-50 rounded-xl" title="Delete"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">
                    {{ $programs->links() }}
                </div>
            </div>
        @elseif($activeTab === 'schedules')
            {{-- Schedules Full Content --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-black text-gray-800 uppercase tracking-tight">Training Schedules</h3>
                        <p class="text-xs text-gray-500 font-medium">Timeline of scheduled and historic training sessions.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex p-1 bg-gray-100 rounded-xl">
                            <button wire:click="$set('viewMode', 'list')" class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all {{ $viewMode === 'list' ? 'bg-white text-emerald-600 shadow-sm' : 'text-gray-400 hover:text-gray-600' }}">List</button>
                            <button wire:click="$set('viewMode', 'calendar')" class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all {{ $viewMode === 'calendar' ? 'bg-white text-emerald-600 shadow-sm' : 'text-gray-400 hover:text-gray-600' }}">Calendar</button>
                        </div>
                        <select wire:model.live="companyFilter" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-[10px] font-black uppercase text-gray-600 focus:ring-2 focus:ring-emerald-500 outline-none">
                            <option value="">ALL COMPANIES</option>
                            @foreach($allCompanies as $c) <option value="{{ $c->id }}">{{ $c->name }}</option> @endforeach
                        </select>
                        <button wire:click="openScheduleModal" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-lg shadow-blue-100 flex items-center gap-2 uppercase tracking-widest">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Create Schedule
                        </button>
                    </div>
                </div>

                @if($viewMode === 'calendar')
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-8">
                            <h2 class="text-2xl font-black text-gray-800 uppercase tracking-tight">{{ Carbon\Carbon::create($currentYear, $currentMonth)->format('F Y') }}</h2>
                            <div class="flex items-center gap-2">
                                <button wire:click="previousMonth" class="p-2 hover:bg-gray-100 rounded-xl transition-all text-gray-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
                                <button wire:click="$set('currentMonth', {{ now()->month }}); $set('currentYear', {{ now()->year }}); loadCalendarEvents()" class="px-4 py-2 bg-gray-50 text-[10px] font-black uppercase tracking-widest text-gray-500 rounded-xl hover:bg-gray-100">Today</button>
                                <button wire:click="nextMonth" class="p-2 hover:bg-gray-100 rounded-xl transition-all text-gray-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
                            </div>
                        </div>

                        <div class="grid grid-cols-7 gap-px bg-gray-100 rounded-3xl overflow-hidden border border-gray-100 shadow-sm">
                            @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
                                <div class="bg-gray-50 py-3 text-center text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">{{ $dayName }}</div>
                            @endforeach

                            @foreach($this->getCalendarData() as $week)
                                @foreach($week as $day)
                                    <div class="bg-white min-h-[140px] p-3 transition-colors hover:bg-gray-50 group border-t border-gray-50">
                                        @if($day)
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="text-sm font-black {{ $day['isToday'] ? 'bg-emerald-500 text-white w-7 h-7 flex items-center justify-center rounded-full' : 'text-gray-400' }}">{{ $day['day'] }}</span>
                                            </div>
                                            <div class="space-y-1.5">
                                                @foreach($day['events'] as $event)
                                                    <div class="px-2 py-1 rounded-lg text-[9px] font-bold truncate cursor-pointer transition-all hover:scale-[1.02] border
                                                        {{ $event['type'] === 'training' ? 'bg-blue-50 text-blue-700 border-blue-100' : 'bg-purple-50 text-purple-700 border-purple-100' }}"
                                                        title="{{ $event['title'] }}">
                                                        <span class="opacity-60">{{ $event['time'] }}</span> {{ $event['title'] }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="overflow-x-auto">

                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4">Training / Title</th>
                                <th class="px-6 py-4">Execution Date</th>
                                <th class="px-6 py-4">Location</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            @foreach($schedules as $sch)
                                <tr class="hover:bg-gray-50 transition-colors group {{ $sch->start_date->isToday() ? 'bg-amber-50/30' : '' }}">
                                    <td class="px-6 py-4">
                                        <p class="font-black text-gray-800 uppercase tracking-tight text-xs">{{ $sch->title ?: $sch->trainingProgram?->name }}</p>
                                        <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest mt-0.5">{{ $sch->company?->name }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs font-bold text-gray-700">{{ $sch->start_date->format('d M Y') }}</div>
                                        <div class="text-[9px] text-gray-400 uppercase font-bold mt-0.5">{{ $sch->start_time }} - {{ $sch->end_time }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-xs text-gray-600 font-medium">{{ $sch->location }}</p>
                                        <p class="text-[9px] text-gray-400 uppercase font-bold">{{ $sch->instructor }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-tighter
                                            {{ $sch->status === 'completed' ? 'bg-emerald-100 text-emerald-700' : ($sch->status === 'cancelled' ? 'bg-rose-100 text-rose-700' : 'bg-blue-100 text-blue-700') }}">
                                            {{ $sch->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-1 opacity-100">
                                            <button wire:click="openScheduleModal({{ $sch->id }})" class="p-2 text-blue-500 hover:bg-blue-50 rounded-xl" title="Edit"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($viewMode === 'list')
                    <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">
                        {{ $schedules->links() }}
                    </div>
                @endif
                @endif
            </div>
        @elseif($activeTab === 'realizations')

            {{-- Realizations Content --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-black text-gray-800 uppercase tracking-tight">Competency Realizations</h3>
                        <p class="text-xs text-gray-500 font-medium">Tracking and management of employee competency status.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button wire:click="openRealizationModal" class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-xs font-bold transition-all shadow-lg shadow-emerald-100 flex items-center gap-2 uppercase tracking-widest">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add Manual Record
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4">Employee</th>
                                <th class="px-6 py-4">Competency</th>
                                <th class="px-6 py-4">Date / Expiry</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            @foreach($realizations as $item)
                                <tr class="hover:bg-gray-50 transition-colors group">
                                    <td class="px-6 py-4">
                                        <p class="font-black text-gray-800 uppercase tracking-tight text-xs">{{ $item->employee?->name }}</p>
                                        <p class="text-[9px] text-gray-400 font-mono tracking-tighter">{{ $item->employee_id }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-xs font-bold text-gray-700 uppercase tracking-tight">{{ $item->competency?->name }}</p>
                                        <p class="text-[9px] text-emerald-600 font-bold uppercase tracking-widest">{{ $item->competency_code }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs font-bold text-gray-700">{{ $item->training_date->format('d/m/Y') }}</div>
                                        <div class="text-[9px] font-bold {{ $item->isExpired() ? 'text-rose-500' : 'text-gray-400' }} uppercase tracking-widest">
                                            Expiry: {{ $item->expiry_date ? $item->expiry_date->format('d/m/Y') : 'LIFE-TIME' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-0.5 {{ $item->approval_status === 'approved' ? 'bg-emerald-100 text-emerald-700' : ($item->approval_status === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700') }} rounded-full text-[10px] font-black tracking-widest leading-none">
                                            {{ $item->approval_status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-1 opacity-100">
                                            @if($item->approval_status === 'pending')
                                                <button wire:click="approve({{ $item->id }})" class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-xl" title="Approve"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></button>
                                            @endif
                                            <button wire:click="openRealizationModal({{ $item->id }})" class="p-2 text-blue-500 hover:bg-blue-50 rounded-xl" title="Edit"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">
                    {{ $realizations->links() }}
                </div>
            </div>
        @elseif($activeTab === 'evaluations')
            {{-- Evaluations Content --}}
            <div class="space-y-6">
                {{-- Stats Header --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm text-center">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Overall Rating</p>
                        <h3 class="text-2xl font-black text-emerald-600 leading-none">{{ $evaluationStats['avg_overall_rating'] }}<span class="text-sm">/5</span></h3>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm text-center">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Content Quality</p>
                        <h3 class="text-2xl font-black text-blue-600 leading-none">{{ $evaluationStats['avg_content_rating'] }}<span class="text-sm">/5</span></h3>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm text-center">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Instructor Performance</p>
                        <h3 class="text-2xl font-black text-purple-600 leading-none">{{ $evaluationStats['avg_instructor_rating'] }}<span class="text-sm">/5</span></h3>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm text-center">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Responses</p>
                        <h3 class="text-2xl font-black text-gray-900 leading-none">{{ $evaluationStats['total_evaluations'] }}</h3>
                    </div>
                </div>

                {{-- Filters & List --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-50 flex items-center justify-between bg-gray-50/20">
                        <div class="flex items-center gap-4">
                            <select wire:model.live="evalSelectedTraining" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-[10px] font-black uppercase text-gray-600 focus:ring-2 focus:ring-emerald-500 outline-none">
                                <option value="">ALL PROGRAMS</option>
                                @foreach($evalTrainingNames as $name) <option value="{{ $name }}">{{ $name }}</option> @endforeach
                            </select>
                            <select wire:model.live="evalSelectedBatch" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-[10px] font-black uppercase text-gray-600 focus:ring-2 focus:ring-emerald-500 outline-none">
                                <option value="">ALL BATCHES</option>
                                @foreach($evalBatches as $batch) <option value="{{ $batch }}">{{ $batch }}</option> @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">
                                <tr>
                                    <th class="px-6 py-4">Employee</th>
                                    <th class="px-6 py-4">Training / Batch</th>
                                    <th class="px-6 py-4">Overall</th>
                                    <th class="px-6 py-4">Date Submitted</th>
                                    <th class="px-6 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-sm">
                                @foreach($evaluations as $eval)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <p class="font-black text-gray-800 uppercase tracking-tight text-xs">{{ $eval->name }}</p>
                                            <p class="text-[9px] text-gray-400 font-mono tracking-tighter">{{ $eval->nik }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-xs font-bold text-gray-700 uppercase tracking-tight">{{ $eval->training_name }}</p>
                                            <p class="text-[9px] text-blue-600 font-bold uppercase tracking-widest">BATCH: {{ $eval->batch ?? 'N/A' }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-1.5">
                                                <div class="flex gap-0.5">
                                                    @for($i=1; $i<=5; $i++)
                                                        <svg class="w-3 h-3 {{ $i <= $eval->evaluation_overall_rating ? 'text-amber-400 fill-current' : 'text-gray-200' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    @endfor
                                                </div>
                                                <span class="text-[10px] font-black text-gray-500">{{ $eval->evaluation_overall_rating }}/5</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-[10px] font-bold text-gray-500 uppercase">{{ $eval->evaluation_submitted_at->format('d M Y H:i') }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <button wire:click="$set('selectedEvaluationId', '{{ $eval->id }}')" class="px-3 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all">Views Detail</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @elseif($activeTab === 'reports')
            {{-- Reports Tab Content --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-32 flex flex-col items-center justify-center text-center overflow-hidden relative">
                {{-- Decorative background elements --}}
                <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-50 rounded-full -mr-32 -mt-32 opacity-50"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-blue-50 rounded-full -ml-24 -mb-24 opacity-50"></div>

                <div class="relative z-10">
                    <div class="w-24 h-24 bg-linear-to-br from-emerald-50 to-emerald-100 text-emerald-600 rounded-4xl flex items-center justify-center mb-8 mx-auto shadow-inner border border-emerald-100/50 transition-transform hover:scale-110 duration-500">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-800 uppercase tracking-tight">Training Analytics Hub</h3>
                    <p class="text-gray-400 mt-3 max-w-sm text-sm font-medium">Generate comprehensive performance reports and competency matrix analytics for your organization.</p>

                    <div class="mt-10 flex flex-wrap gap-4 justify-center">
                        <a href="{{ route('admin.hse.reports') }}" class="px-8 py-3 bg-emerald-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-emerald-100 hover:bg-emerald-700 transition-all flex items-center gap-2">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                             Monthly Report
                        </a>
                        <button class="px-8 py-3 bg-white border border-gray-200 text-gray-600 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-gray-50 transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            Competency Matrix
                        </button>
                    </div>
                </div>
            </div>
        @endif

    </div>

    {{-- MODALS SECTION --}}

    {{-- Syllabus Modal --}}
    @if($showSyllabusModal)
        <div class="fixed inset-0 z-110 overflow-y-auto" x-data="{ show: false }" x-init="$nextTick(() => show = true)">
            <div class="flex items-center justify-center min-h-screen px-4 py-12">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
                     wire:click="$set('showSyllabusModal', false)"
                     x-show="show"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"></div>

                <div class="relative bg-white rounded-[2.5rem] shadow-2xl max-w-4xl w-full p-8 transform transition-all border border-slate-100 h-full max-h-[90vh] flex flex-col"
                     x-show="show"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95">

                    <div class="flex justify-between items-center mb-6 shrink-0">
                        <div>
                            <h3 class="text-2xl font-black text-gray-900 tracking-tight uppercase">Syllabus Management</h3>
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mt-1">Design course structure and criteria</p>
                        </div>
                        <button wire:click="$set('showSyllabusModal', false)" class="text-gray-400 hover:text-gray-900 transition-colors"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                    </div>

                    <div class="flex-1 overflow-y-auto pr-2 custom-scrollbar space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="md:col-span-2 bg-gray-50/50 p-6 rounded-3xl border border-gray-100 flex flex-col">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Course Description / Overview</label>
                                <textarea wire:model="syllabusDescription" class="w-full bg-transparent border-none p-0 focus:ring-0 text-sm font-medium text-gray-700 placeholder-gray-300 min-h-[100px] leading-relaxed" placeholder="Detailed description of what will be covered..."></textarea>
                            </div>
                            <div class="bg-indigo-50/20 p-6 rounded-3xl border border-indigo-100 flex flex-col justify-center text-center">
                                <label class="block text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-3">Est. Duration</label>
                                <input type="text" wire:model="syllabusDuration" class="w-full bg-transparent border-none p-0 focus:ring-0 text-xl font-black text-indigo-700 placeholder-indigo-200 text-center" placeholder="e.g., 8 JP @ 45 Minute">
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-4 px-2">
                                <h4 class="text-xs font-black text-gray-800 uppercase tracking-[0.2em]">Course Elements</h4>
                                <button wire:click="addElement" class="px-3 py-1.5 bg-indigo-500 text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-indigo-100">+ Add Element</button>
                            </div>

                            <div class="space-y-4">
                                @foreach($elements as $eIndex => $element)
                                    <div class="bg-white border {{ $expandedElements[$eIndex] ?? false ? 'border-indigo-200 ring-4 ring-indigo-50' : 'border-gray-100' }} rounded-3xl transition-all">
                                        <div class="p-5 flex items-center justify-between cursor-pointer" wire:click="$toggle('expandedElements.{{ $eIndex }}')">
                                            <div class="flex items-center gap-5">
                                                <span class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-xs font-black text-gray-400 border border-gray-200 shadow-sm">{{ $eIndex + 1 }}</span>
                                                <input type="text" wire:model.defer="elements.{{ $eIndex }}.name" wire:click.stop=""
                                                       class="bg-transparent border-none p-0 focus:ring-0 text-sm font-black text-gray-800 placeholder-gray-200 uppercase tracking-wide w-80" placeholder="Element Name">
                                            </div>
                                            <div class="flex items-center gap-3">
                                                <button wire:click.stop="removeElement({{ $eIndex }})" class="p-2 text-rose-400 hover:text-rose-600 rounded-xl hover:bg-rose-50 transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                                <svg class="w-6 h-6 text-gray-300 transition-transform {{ $expandedElements[$eIndex] ?? false ? 'rotate-180 text-indigo-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            </div>
                                        </div>

                                        @if($expandedElements[$eIndex] ?? false)
                                            <div class="px-8 pb-8 pt-4 border-t border-gray-50 space-y-8">
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                                    <div class="bg-gray-50/80 p-5 rounded-4xl border border-gray-100/50">
                                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Knowledge Indicator</label>
                                                        <textarea wire:model.defer="elements.{{ $eIndex }}.indicator_knowledge" class="w-full bg-transparent border-none p-0 focus:ring-0 text-xs font-semibold text-gray-600 min-h-[80px] leading-relaxed"></textarea>
                                                    </div>
                                                    <div class="bg-gray-50/80 p-5 rounded-4xl border border-gray-100/50">
                                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Skill Indicator</label>
                                                        <textarea wire:model.defer="elements.{{ $eIndex }}.indicator_skill" class="w-full bg-transparent border-none p-0 focus:ring-0 text-xs font-semibold text-gray-600 min-h-[80px] leading-relaxed"></textarea>
                                                    </div>
                                                    <div class="bg-gray-50/80 p-5 rounded-4xl border border-gray-100/50">
                                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Attitude Indicator</label>
                                                        <textarea wire:model.defer="elements.{{ $eIndex }}.indicator_attitude" class="w-full bg-transparent border-none p-0 focus:ring-0 text-xs font-semibold text-gray-600 min-h-[80px] leading-relaxed"></textarea>
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                                    <div class="bg-slate-50/50 p-5 rounded-3xl border border-slate-100">
                                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Training Material (Knowledge)</label>
                                                        <textarea wire:model.defer="elements.{{ $eIndex }}.material_knowledge" class="w-full bg-transparent border-none p-0 focus:ring-0 text-xs font-medium text-slate-600 min-h-[60px]" placeholder="Specific knowledge materials..."></textarea>
                                                    </div>
                                                    <div class="bg-slate-50/50 p-5 rounded-3xl border border-slate-100">
                                                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Training Material (Skill)</label>
                                                        <textarea wire:model.defer="elements.{{ $eIndex }}.material_skill" class="w-full bg-transparent border-none p-0 focus:ring-0 text-xs font-medium text-slate-600 min-h-[60px]" placeholder="Practical skill exercises..."></textarea>
                                                    </div>
                                                </div>

                                                <div>
                                                    <div class="flex items-center justify-between mb-3">
                                                        <h5 class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Performance Criteria</h5>
                                                        <button wire:click="addCriteria({{ $eIndex }})" class="text-[9px] font-black text-indigo-600 hover:bg-indigo-50 px-2 py-1 rounded-lg uppercase tracking-widest">+ Add Criteria</button>
                                                    </div>
                                                    <div class="space-y-2">
                                                        @foreach($element['criteria'] as $cIndex => $criteria)
                                                            <div class="flex items-center gap-3 bg-gray-50/50 p-3 rounded-2xl border border-gray-100 group">
                                                                <input type="text" wire:model.defer="elements.{{ $eIndex }}.criteria.{{ $cIndex }}.numbering"
                                                                       class="w-12 bg-white border border-gray-100 rounded-lg py-1 px-2 text-[10px] font-black text-gray-500 text-center" placeholder="1.1">
                                                                <input type="text" wire:model.defer="elements.{{ $eIndex }}.criteria.{{ $cIndex }}.criteria"
                                                                       class="flex-1 bg-transparent border-none p-0 focus:ring-0 text-xs font-bold text-gray-700" placeholder="Describe the criteria...">
                                                                <button wire:click="removeCriteria({{ $eIndex }}, {{ $cIndex }})" class="text-rose-300 hover:text-rose-500 opacity-0 group-hover:opacity-100 transition-opacity"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-6 px-2">
                                <h4 class="text-xs font-black text-gray-800 uppercase tracking-[0.2em]">Evidence & Assessment</h4>
                                <button wire:click="addEvidence" class="px-4 py-2 bg-emerald-500 text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-emerald-100">+ Add Evidence</button>
                            </div>
                            <div class="space-y-4">
                                @foreach($evidences as $evIndex => $evidence)
                                    <div class="flex gap-4 items-start bg-gray-50/50 p-5 rounded-3xl border border-gray-100 group">
                                        <div class="w-32 shrink-0">
                                            <label class="block text-[9px] font-black text-gray-400 uppercase mb-2 px-1">Type</label>
                                            <select wire:model.defer="evidences.{{ $evIndex }}.type" class="w-full bg-white border border-gray-200 rounded-xl text-[10px] font-black uppercase text-gray-600 py-2 px-3">
                                                <option value="observation">Observation</option>
                                                <option value="portfolio">Portfolio</option>
                                                <option value="oral">Oral Exam</option>
                                                <option value="written">Written Exam</option>
                                                <option value="demo">Demonstration</option>
                                            </select>
                                        </div>
                                        <div class="flex-1">
                                            <label class="block text-[9px] font-black text-gray-400 uppercase mb-2 px-1">Description of Evidence / Assessment Method</label>
                                            <input type="text" wire:model.defer="evidences.{{ $evIndex }}.description" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2 text-xs font-bold text-gray-700 placeholder-gray-300" placeholder="e.g., Laporan hasil inspeksi lapangan...">
                                        </div>
                                        <button wire:click="removeEvidence({{ $evIndex }})" class="mt-8 p-2 text-rose-300 hover:text-rose-500 opacity-0 group-hover:opacity-100 transition-opacity"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                    </div>
                                @endforeach
                                @if(empty($evidences))
                                    <p class="text-center py-8 text-gray-400 text-[10px] uppercase font-bold tracking-widest italic border-2 border-dashed border-gray-100 rounded-3xl">No Assessment Methods Defined</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="pt-8 border-t border-gray-100 shrink-0 mt-8">
                        <button wire:click="saveSyllabus" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-4xl font-black text-sm uppercase tracking-[0.2em] shadow-2xl shadow-indigo-100 transition-all flex items-center justify-center gap-4 group">
                            <svg class="w-6 h-6 transform group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                            </svg>
                            SAVE SYLLABUS STRUCTURE
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Import Modal with Preview (Consolidated) --}}
    @if($showImportModal)
        <div class="fixed inset-0 z-110 overflow-y-auto" x-data="{ show: false }" x-init="$nextTick(() => show = true)">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
                     wire:click="$set('showImportModal', false)"
                     x-show="show"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"></div>

                <div class="relative bg-white rounded-[2.5rem] shadow-2xl max-w-4xl w-full p-8 transform transition-all border border-slate-100 flex flex-col h-full max-h-[85vh]"
                     x-show="show"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95">

                    <div class="flex justify-between items-center mb-6 shrink-0">
                        <div>
                            <h3 class="text-2xl font-black text-gray-900 tracking-tight uppercase">Import {{ ucfirst($importType) }}</h3>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.2em] mt-1">Bulk data upload from CSV file</p>
                        </div>
                        <button wire:click="$set('showImportModal', false)" class="text-gray-400 hover:text-gray-900"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                    </div>

                    @if(!$showPreview)
                        <div class="flex-1 flex flex-col items-center justify-center p-12 border-2 border-dashed border-gray-100 rounded-4xl bg-gray-50/30">
                            <div class="w-20 h-20 bg-white rounded-3xl shadow-sm border border-gray-50 flex items-center justify-center text-emerald-500 mb-6 group-hover:scale-110 transition-transform">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            </div>
                            <input type="file" wire:model="csvFile" class="hidden" id="csv_import">
                            <label for="csv_import" class="cursor-pointer px-8 py-3 bg-white border border-gray-200 rounded-2xl text-xs font-black uppercase tracking-widest text-gray-600 hover:bg-gray-50 transition-all shadow-sm mb-4">Choose CSV File</label>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Max size 4MB • CSV or TXT only</p>

                            <div class="mt-8 flex gap-4">
                                <button wire:click="previewImport" class="px-10 py-4 bg-emerald-600 text-white rounded-3xl font-black text-sm uppercase tracking-widest shadow-xl shadow-emerald-100 disabled:opacity-50" @if(!$csvFile) disabled @endif>PREVIEW DATA</button>
                            </div>
                        </div>
                    @else
                        <div class="flex-1 overflow-hidden flex flex-col border border-gray-100 rounded-3xl shadow-inner bg-gray-50/20">
                            <div class="p-4 bg-white border-b border-gray-100 flex items-center justify-between shrink-0">
                                <div class="flex items-center gap-4">
                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[10px] font-black">{{ count($importPreview) - count($importErrors) }} VALID</span>
                                    @if(count($importErrors) > 0)
                                        <span class="px-3 py-1 bg-rose-100 text-rose-700 rounded-lg text-[10px] font-black">{{ count($importErrors) }} ERRORS</span>
                                    @endif
                                </div>
                                <button wire:click="$set('showPreview', false)" class="text-[10px] font-bold text-gray-400 hover:text-gray-600 uppercase tracking-widest">Change File</button>
                            </div>
                            <div class="flex-1 overflow-y-auto custom-scrollbar">
                                <table class="w-full text-left">
                                    <thead class="bg-white text-[9px] font-black text-gray-400 uppercase tracking-widest sticky top-0 border-b border-gray-50">
                                        <tr>
                                            <th class="px-5 py-3">LN</th>
                                            <th class="px-5 py-3">Primary Info</th>
                                            <th class="px-5 py-3">Detail</th>
                                            <th class="px-5 py-3">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50 text-[11px]">
                                        @foreach($importPreview as $row)
                                            <tr class="hover:bg-white group transition-colors {{ $row['status'] === 'error' ? 'bg-rose-50/30' : '' }}">
                                                <td class="px-5 py-3 text-gray-300 font-mono">{{ $row['line'] }}</td>
                                                <td class="px-5 py-3">
                                                    @if($importType === 'realization')
                                                        <p class="font-black text-gray-800 uppercase tracking-tight">{{ $row['employee_id'] }}</p>
                                                        <p class="text-[9px] text-gray-400 font-bold uppercase">{{ $row['employee_name'] ?? 'N/A' }}</p>
                                                    @else
                                                        <p class="font-black text-gray-800 uppercase tracking-tight">{{ $row['name'] }}</p>
                                                    @endif
                                                </td>
                                                <td class="px-5 py-3">
                                                    @if($importType === 'realization')
                                                        <p class="font-bold text-indigo-600 uppercase">{{ $row['competency_code'] }}</p>
                                                        <p class="text-[9px] text-gray-400 font-bold uppercase">Date: {{ $row['training_date'] }}</p>
                                                    @else
                                                        <p class="text-gray-500 font-medium">{{ Str::limit($row['description'], 40) }}</p>
                                                    @endif
                                                </td>
                                                <td class="px-5 py-3">
                                                    @if($row['status'] === 'valid')
                                                        <span class="text-emerald-500"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg></span>
                                                    @else
                                                        <div class="text-rose-500" title="{{ implode(', ', $row['errors']) }}">
                                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="pt-6 shrink-0 mt-4">
                            <button wire:click="confirmImport" class="w-full py-4 bg-emerald-600 text-white rounded-3xl font-black text-sm uppercase tracking-[0.2em] shadow-xl shadow-emerald-100 hover:bg-emerald-700 transition-all">CONFIRM & COMMIT IMPORT</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif


    {{-- Schedule Modal --}}
    @if($showScheduleModal)
        <div class="fixed inset-0 z-100 overflow-y-auto" x-data="{ show: false }" x-init="$nextTick(() => show = true)">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
                     wire:click="$set('showScheduleModal', false)"
                     x-show="show"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"></div>

                <div class="relative bg-white rounded-[2.5rem] shadow-2xl max-w-2xl w-full p-8 transform transition-all border border-slate-100"
                     x-show="show"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-black text-gray-900 tracking-tight uppercase">{{ $editingScheduleId ? 'Update' : 'Plan' }} Schedule</h3>
                        <button wire:click="$set('showScheduleModal', false)" class="text-gray-400 hover:text-gray-900"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="col-span-2 bg-gray-50/50 p-5 rounded-3xl border border-gray-100">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Select Training Program</label>
                            <select wire:model="scheduleTrainingId" class="w-full bg-transparent border-none p-0 focus:ring-0 text-sm font-bold text-gray-800">
                                <option value="">-- Choose Program --</option>
                                @foreach($allPrograms as $p) <option value="{{ $p->id }}">{{ $p->name }}</option> @endforeach
                            </select>
                        </div>
                        <div class="col-span-2 bg-gray-50/50 p-5 rounded-3xl border border-gray-100">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Session Title (Optional Override)</label>
                            <input type="text" wire:model="scheduleTitle" class="w-full bg-transparent border-none p-0 focus:ring-0 text-sm font-bold text-gray-800 placeholder-gray-300" placeholder="Specific title for this batch...">
                        </div>
                        <div class="bg-gray-50/50 p-5 rounded-3xl border border-gray-100">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Start Date</label>
                            <input type="date" wire:model="scheduleStartDate" class="w-full bg-transparent border-none p-0 focus:ring-0 text-sm font-bold text-gray-800">
                        </div>
                        <div class="bg-gray-50/50 p-5 rounded-3xl border border-gray-100">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">End Date</label>
                            <input type="date" wire:model="scheduleEndDate" class="w-full bg-transparent border-none p-0 focus:ring-0 text-sm font-bold text-gray-800">
                        </div>
                        <div class="bg-gray-50/50 p-5 rounded-3xl border border-gray-100">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Location / Platform</label>
                            <input type="text" wire:model="scheduleLocation" class="w-full bg-transparent border-none p-0 focus:ring-0 text-sm font-bold text-gray-800 placeholder-gray-300" placeholder="Room or Online Link">
                        </div>
                         <div class="bg-gray-50/50 p-5 rounded-3xl border border-gray-100">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Instructor / Trainer</label>
                            <input type="text" wire:model="scheduleTrainer" class="w-full bg-transparent border-none p-0 focus:ring-0 text-sm font-bold text-gray-800 placeholder-gray-300">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 px-1">Plan Status</label>
                            <div class="flex gap-2">
                                @foreach(['scheduled', 'completed', 'cancelled'] as $st)
                                    <button wire:click="$set('scheduleStatus', '{{ $st }}')" class="flex-1 py-3 px-4 rounded-2xl text-[10px] font-black uppercase tracking-widest border transition-all {{ $scheduleStatus === $st ? 'bg-blue-600 border-blue-600 text-white shadow-lg' : 'bg-white border-gray-100 text-gray-400' }}">{{ $st }}</button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="mt-8">
                        <button wire:click="saveSchedule" class="w-full py-4 bg-blue-600 text-white rounded-3xl font-black text-sm uppercase tracking-[0.2em] shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all">POST SCHEDULE</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Realization Modal --}}
    @if($showRealizationModal)
         <div class="fixed inset-0 z-100 overflow-y-auto" x-data="{ show: false }" x-init="$nextTick(() => show = true)">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
                     wire:click="$set('showRealizationModal', false)"
                     x-show="show"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"></div>

                <div class="relative bg-white rounded-[2.5rem] shadow-2xl max-w-xl w-full p-8 transform transition-all border border-slate-100"
                     x-show="show"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-black text-gray-900 tracking-tight uppercase">{{ $editingRealizationId ? 'Update' : 'Register' }} Realization</h3>
                        <button wire:click="$set('showRealizationModal', false)" class="text-gray-400 hover:text-gray-900"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                    </div>
                    <div class="space-y-4">
                        <div class="bg-gray-50/50 p-5 rounded-3xl border border-gray-100">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Employee Selection</label>
                            <select wire:model="realizationEmployeeBarcode" class="w-full bg-transparent border-none p-0 focus:ring-0 text-sm font-bold text-gray-800">
                                <option value="">-- Choose Employee --</option>
                                @foreach($allEmployees as $emp) <option value="{{ $emp->employee_id }}">{{ $emp->name }} ({{ $emp->employee_id }})</option> @endforeach
                            </select>
                            @error('realizationEmployeeBarcode') <p class="text-[9px] text-rose-500 font-bold uppercase mt-1">Required</p> @enderror
                        </div>
                        <div class="bg-gray-50/50 p-5 rounded-3xl border border-gray-100">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Competency Obtained</label>
                            <select wire:model="realizationCompetencyCode" class="w-full bg-transparent border-none p-0 focus:ring-0 text-sm font-bold text-gray-800">
                                <option value="">-- Choose Competency --</option>
                                @foreach($allCompetencies as $comp) <option value="{{ $comp->code }}">{{ $comp->name }} ({{ $comp->code }})</option> @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50/50 p-5 rounded-3xl border border-gray-100">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Completion Date</label>
                                <input type="date" wire:model="realizationDate" class="w-full bg-transparent border-none p-0 focus:ring-0 text-sm font-bold text-gray-800">
                            </div>
                            <div class="bg-gray-50/50 p-5 rounded-3xl border border-gray-100">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Expiry Date (Blank = Lifetime)</label>
                                <input type="date" wire:model="realizationExpiryDate" class="w-full bg-transparent border-none p-0 focus:ring-0 text-sm font-bold text-gray-800">
                            </div>
                        </div>
                        <div class="bg-gray-50/50 p-5 rounded-3xl border border-gray-100">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Certificate Reference URL</label>
                            <input type="url" wire:model="realizationCertificateUrl" class="w-full bg-transparent border-none p-0 focus:ring-0 text-sm font-medium text-gray-600 placeholder-gray-300" placeholder="https://cloud.storage/cert-abc.pdf">
                        </div>
                    </div>
                    <div class="mt-8">
                        <button wire:click="saveRealization" class="w-full py-4 bg-emerald-600 text-white rounded-3xl font-black text-sm uppercase tracking-[0.2em] shadow-xl shadow-emerald-100 hover:bg-emerald-700 transition-all">RECORD TRAINING</button>
                        <p class="text-center text-[9px] text-gray-400 mt-4 font-bold uppercase tracking-[3px]">Matrix Recalculation is Automatic</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Evaluation Detail Modal --}}
    @if($selectedEvaluationId)
        @php $evalDetail = \App\Models\QuizTest::find($selectedEvaluationId); @endphp
        <div class="fixed inset-0 z-110 overflow-y-auto" x-data="{ show: false }" x-init="$nextTick(() => show = true)">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm"
                     wire:click="$set('selectedEvaluationId', null)"
                     x-show="show"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"></div>

                <div class="relative bg-white rounded-4xl shadow-2xl max-w-2xl w-full p-8 transform transition-all border border-slate-100"
                     x-show="show"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Evaluation Feedback Detail</h3>
                        <button wire:click="$set('selectedEvaluationId', null)" class="text-gray-400 hover:text-gray-900"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                    </div>
                    <div class="space-y-6">
                        <div class="grid grid-cols-2 gap-4 bg-gray-50/50 p-5 rounded-3xl border border-gray-100">
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Participant</p>
                                <p class="text-sm font-bold text-gray-800">{{ $evalDetail->name }} ({{ $evalDetail->nik }})</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Program / Batch</p>
                                <p class="text-sm font-bold text-gray-800 uppercase">{{ $evalDetail->training_name }} / {{ $evalDetail->batch }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            @php
                                $ratingFields = [
                                    'evaluation_content_rating' => 'Content Quality',
                                    'instructor_rating' => 'Instructor Performance',
                                    'evaluation_facility_rating' => 'Facility & Environment',
                                    'evaluation_material_rating' => 'Material Accessibility',
                                    'evaluation_overall_rating' => 'Overall Experience',
                                ];
                            @endphp
                            @foreach($ratingFields as $field => $label)
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 px-1">{{ $label }}</p>
                                    <div class="flex items-center gap-2 bg-white border border-gray-100 p-3 rounded-2xl shadow-sm">
                                        <div class="flex gap-0.5">
                                            @for($i=1; $i<=5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $evalDetail->$field ? 'text-amber-400 fill-current' : 'text-gray-100' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            @endfor
                                        </div>
                                        <span class="text-xs font-black text-gray-700 ml-auto">{{ $evalDetail->$field }}/5</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="bg-blue-50/50 p-6 rounded-3xl border border-blue-100">
                            <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-2">Participant Comments</p>
                            <p class="text-sm font-medium text-blue-900 italic leading-relaxed">"{{ $evalDetail->evaluation_comments ?: 'No additional comments provided.' }}"</p>
                        </div>
                    </div>
                    <div class="mt-8">
                        <button wire:click="$set('selectedEvaluationId', null)" class="w-full py-4 bg-gray-100 text-gray-500 rounded-3xl font-black text-xs uppercase tracking-widest hover:bg-gray-200 transition-all">Close Detail</button>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        @keyframes pulse { 0% { opacity: 1; } 50% { opacity: 0.8; } 100% { opacity: 1; } }
        .anim-pulse { animation: pulse 2s infinite; }
    </style>
</div>
