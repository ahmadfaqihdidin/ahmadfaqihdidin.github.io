<div class="font-sans text-slate-600">
    {{-- Header --}}
    <div class="mb-10 text-center md:text-left">
        <h1 class="text-4xl font-black text-slate-900 tracking-tight mb-2">Employee Competency Lookup</h1>
        <p class="text-slate-500 font-medium text-lg">Cek profil kompetensi karyawan, gap analysis, dan riwayat training secara real-time.</p>
    </div>

    {{-- Search Box --}}
    <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-100 border border-slate-100 p-8 mb-10 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-full -mr-16 -mt-16 opacity-50 blur-2xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row gap-6 items-end">
            <div class="flex-1 w-full">
                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">NIK Karyawan</label>
                <div class="relative">
                    <input type="text" wire:model="nikSearch" wire:keydown.enter="searchEmployee"
                           placeholder="Masukkan NIK (contoh: EMP001)"
                           class="w-full pl-6 pr-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-lg font-bold text-slate-800 focus:ring-0 focus:border-indigo-500 focus:bg-white transition-all placeholder-slate-300 outline-none">
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                @error('nikSearch') <span class="text-rose-500 text-xs font-bold mt-2 block ml-1">{{ $message }}</span> @enderror
            </div>
            <div class="flex gap-3 w-full md:w-auto">
                <button wire:click="searchEmployee" class="flex-1 md:flex-none px-8 py-4 bg-indigo-600 text-white rounded-2xl font-black text-sm uppercase tracking-widest shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:scale-[1.02] transition-all active:scale-95">
                    Cari Data
                </button>
                @if($showProfile)
                    <button wire:click="clearSearch" class="px-6 py-4 bg-white border-2 border-slate-100 text-slate-400 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-slate-50 hover:text-slate-600 transition-all">
                        Reset
                    </button>
                @endif
            </div>
        </div>

        @if (session()->has('error'))
            <div class="mt-6 bg-rose-50 border-l-4 border-rose-500 text-rose-700 px-6 py-4 rounded-r-xl font-medium text-sm flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('error') }}
            </div>
        @endif
    </div>

    {{-- Profile Display --}}
    @if($showProfile && $employeeData)
        <div class="space-y-8 animate-fadeIn">
            {{-- Employee Info Card --}}
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 p-8 md:p-10 relative overflow-hidden">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
                    <div class="flex items-center gap-6">
                        <div class="w-20 h-20 md:w-24 md:h-24 rounded-3xl bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-3xl md:text-4xl font-black text-slate-400 shadow-inner">
                            {{ substr($employeeData['profile']['name'], 0, 1) }}
                        </div>
                        <div>
                            <h2 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">{{ $employeeData['profile']['name'] }}</h2>
                            <p class="text-lg text-slate-500 font-bold mt-1">{{ $employeeData['profile']['position'] }}</p>
                            <span class="inline-block mt-3 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest {{ $employeeData['profile']['company_type'] === 'INTERNAL' ? 'bg-indigo-50 text-indigo-600' : 'bg-purple-50 text-purple-600' }}">
                                {{ $employeeData['profile']['company_type'] }}
                            </span>
                        </div>
                    </div>

                    {{-- Compliance Score --}}
                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100 text-center min-w-[200px]">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Compliance Rate</p>
                        <div class="relative flex items-center justify-center">
                            <svg class="w-24 h-24 transform -rotate-90">
                                <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="8" fill="transparent" class="text-slate-200" />
                                <circle cx="48" cy="48" r="40" stroke="currentColor" stroke-width="8" fill="transparent"
                                        stroke-dasharray="251.2"
                                        stroke-dashoffset="{{ 251.2 - (251.2 * $employeeData['summary']['compliance_rate'] / 100) }}"
                                        class="{{ $employeeData['summary']['compliance_rate'] >= 80 ? 'text-emerald-500' : ($employeeData['summary']['compliance_rate'] >= 50 ? 'text-amber-500' : 'text-rose-500') }} transition-all duration-1000 ease-out" />
                            </svg>
                            <span class="absolute text-2xl font-black text-slate-800">{{ $employeeData['summary']['compliance_rate'] }}%</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-sm mb-10">
                    <div class="bg-slate-50 p-4 rounded-2xl">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">NIK</p>
                        <p class="font-bold text-slate-700 text-lg">{{ $employeeData['profile']['nik'] }}</p>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-2xl">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Departemen</p>
                        <p class="font-bold text-slate-700 text-lg">{{ $employeeData['profile']['department'] }}</p>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-2xl">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Section</p>
                        <p class="font-bold text-slate-700 text-lg">{{ $employeeData['profile']['section'] }}</p>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-2xl">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Perusahaan</p>
                        <p class="font-bold text-slate-700 text-lg">{{ $employeeData['profile']['company'] }}</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="flex-1 bg-emerald-50/50 p-4 rounded-2xl border border-emerald-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-emerald-800 uppercase tracking-wide">Competencies Fulfilled</span>
                        <span class="text-xl font-black text-emerald-600">{{ $employeeData['summary']['total_completed'] }} <span class="text-emerald-300">/</span> {{ $employeeData['summary']['total_required'] }}</span>
                    </div>
                    <div class="flex-1 bg-rose-50/50 p-4 rounded-2xl border border-rose-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-rose-800 uppercase tracking-wide">Outstanding Gaps</span>
                        <span class="text-xl font-black text-rose-600">{{ $employeeData['summary']['total_gaps'] }}</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Left Column: Gaps & Requirements --}}
                <div class="lg:col-span-1 space-y-8">
                    {{-- Training Gaps --}}
                    @if(count($employeeData['gaps']) > 0)
                        <div class="bg-white rounded-[2rem] shadow-lg border border-rose-100 overflow-hidden">
                            <div class="bg-rose-50 p-6 border-b border-rose-100">
                                <h3 class="text-lg font-black text-rose-900 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    CRITICAL GAPS
                                    <span class="ml-auto bg-rose-200 text-rose-800 text-[10px] px-2 py-1 rounded-full">{{ count($employeeData['gaps']) }}</span>
                                </h3>
                            </div>
                            <div class="p-4 space-y-3">
                                @foreach($employeeData['gaps'] as $gap)
                                    <div class="bg-white border-2 border-rose-50 rounded-2xl p-4 hover:border-rose-200 transition-colors">
                                        <div class="flex justify-between items-start mb-2">
                                            <span class="px-2 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $gap['reason'] === 'expired' ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700' }}">
                                                {{ $gap['reason'] === 'expired' ? 'EXPIRED' : 'MISSING' }}
                                            </span>
                                            <span class="text-[10px] font-black text-slate-300">{{ $gap['competency_code'] }}</span>
                                        </div>
                                        <p class="font-bold text-slate-800 leading-tight">{{ $gap['competency_name'] }}</p>
                                        <p class="text-xs text-slate-400 mt-1 font-medium">{{ $gap['category'] }} • {{ $gap['level'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Required Competencies --}}
                    <div class="bg-white rounded-[2rem] shadow-lg border border-slate-100 overflow-hidden">
                        <div class="bg-slate-50 p-6 border-b border-slate-100">
                            <h3 class="text-lg font-black text-slate-800">REQUIRED MATRIX</h3>
                        </div>
                        <div class="p-2 max-h-[500px] overflow-y-auto custom-scrollbar">
                            @foreach($employeeData['required'] as $comp)
                                <div class="flex items-center justify-between p-4 hover:bg-slate-50 rounded-2xl transition-colors group">
                                    <div class="min-w-0 pr-4">
                                        <p class="font-bold text-slate-700 truncate group-hover:text-indigo-600 transition-colors">{{ $comp['name'] }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">{{ $comp['code'] }} <span class="text-slate-300 mx-1">•</span> {{ $comp['category'] }}</p>
                                    </div>
                                    <span class="shrink-0 px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $comp['level'] === 'REQ' ? 'bg-slate-100 text-slate-600' : 'bg-indigo-50 text-indigo-600' }}">
                                        {{ $comp['level'] }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Right Column: Training History --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-[2rem] shadow-lg border border-slate-100 overflow-hidden h-full">
                        <div class="p-8 border-b border-slate-100 flex justify-between items-center bg-white sticky top-0 z-10">
                            <h3 class="text-xl font-black text-slate-800">TRAINING HISTORY</h3>
                            <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-black">{{ count($employeeData['trainings']) }} Records</span>
                        </div>

                        @if(count($employeeData['trainings']) === 0)
                            <div class="flex flex-col items-center justify-center py-20 text-slate-400">
                                <svg class="w-16 h-16 mb-4 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332 0.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.168 0.477-4.5 1.253"></path></svg>
                                <p class="font-bold text-sm">Belum ada riwayat training tercatat</p>
                            </div>
                        @else
                            <div class="p-6 space-y-4">
                                @foreach($employeeData['trainings'] as $training)
                                    <div class="group bg-white border-2 {{ $training['is_expired'] ? 'border-rose-100 bg-rose-50/10' : 'border-slate-50 hover:border-indigo-100' }} rounded-3xl p-6 transition-all duration-300 hover:shadow-lg hover:shadow-slate-100">
                                        <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
                                            <div>
                                                <div class="flex items-center gap-3 mb-2">
                                                    <span class="px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest {{ $training['is_expired'] ? 'bg-rose-100 text-rose-600' : 'bg-emerald-100 text-emerald-600' }}">
                                                        {{ $training['is_expired'] ? 'EXPIRED' : 'VALID' }}
                                                    </span>
                                                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">{{ $training['competency_code'] }}</span>
                                                </div>
                                                <h4 class="text-lg font-black text-slate-800 group-hover:text-indigo-700 transition-colors">{{ $training['competency_name'] }}</h4>
                                                <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-wide">{{ $training['category'] }}</p>
                                            </div>
                                            @if($training['certificate_url'])
                                                <a href="{{ $training['certificate_url'] }}" target="_blank" class="shrink-0 self-start px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all flex items-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    Certificate
                                                </a>
                                            @endif
                                        </div>

                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-4 border-t {{ $training['is_expired'] ? 'border-rose-100' : 'border-slate-50' }}">
                                            <div>
                                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Execution Date</p>
                                                <p class="font-bold text-slate-700">{{ $training['training_date']->format('d M Y') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Expiry Date</p>
                                                <p class="font-bold {{ $training['is_expired'] ? 'text-rose-500' : 'text-slate-700' }}">{{ $training['expiry_date'] ? $training['expiry_date']->format('d M Y') : 'LIFETIME' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Provider</p>
                                                <p class="font-bold text-slate-700 truncate" title="{{ $training['provider'] }}">{{ $training['provider'] }}</p>
                                            </div>
                                            <div>
                                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Score</p>
                                                <p class="font-black text-lg text-slate-800">{{ $training['score'] ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fadeIn { animation: fadeIn 0.4s ease-out forwards; }
    </style>
</div>
