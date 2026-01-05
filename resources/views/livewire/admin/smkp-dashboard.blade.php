<div class="space-y-8"
     x-data="smkpDashboard({{ \Illuminate\Support\Js::from($chartData) }})"
>
    {{-- PAGE HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gradient-to-br from-emerald-600 to-emerald-800 rounded-2xl shadow-2xl border border-emerald-500 p-6 text-white">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center border-2 border-white/30 shadow-xl">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-black tracking-tight">SMKP COMPLIANCE VIEW</h1>
                <p class="text-sm font-medium text-emerald-100 italic">Status Kepatuhan Kompetensi & Pelatihan (SMKP Minerba)</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button class="px-6 py-3 bg-white text-emerald-700 rounded-xl text-sm font-black shadow-xl hover:bg-emerald-50 transition-all flex items-center gap-2 group">
                <i class="fas fa-file-pdf text-rose-500 group-hover:scale-110 transition-transform"></i>
                Generate Management Review
            </button>
        </div>
    </div>

    {{-- FILTER SECTION --}}
    <div class="bg-white rounded-2xl shadow-md border border-gray-200 p-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="p-2 bg-gray-100 rounded-lg">
                <i class="fas fa-filter text-gray-600"></i>
            </div>
            <h3 class="text-base font-black text-gray-900 uppercase tracking-tight">Filter Data SMKP</h3>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-600 uppercase tracking-wider">Tipe Filter</label>
                <select wire:model.live="filterType" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                    <option value="year">Tahun</option>
                    <option value="month">Bulan</option>
                    <option value="range">Rentang Tanggal</option>
                </select>
            </div>

            @if($filterType === 'year')
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-600 uppercase tracking-wider">Pilih Tahun</label>
                    <select wire:model.live="filterYear" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                        @foreach($years as $year)
                            <option value="{{ $year['value'] }}">{{ $year['label'] }}</option>
                        @endforeach
                    </select>
                </div>
            @elseif($filterType === 'month')
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-600 uppercase tracking-wider">Pilih Bulan</label>
                    <input type="month" wire:model.live="selectedMonth" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                </div>
            @elseif($filterType === 'range')
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-600 uppercase tracking-wider">Dari Tanggal</label>
                    <input type="date" wire:model.live="filterDateFrom" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-600 uppercase tracking-wider">Sampai Tanggal</label>
                    <input type="date" wire:model.live="filterDateTo" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                </div>
            @endif

            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-600 uppercase tracking-wider">Perusahaan</label>
                <select wire:model.live="filterCompany" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                    <option value="">Semua Perusahaan</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button wire:click="applyFilter" class="flex-1 px-4 py-2.5 bg-emerald-600 text-white rounded-xl text-sm font-black hover:bg-emerald-700 active:scale-95 transition-all shadow-md shadow-emerald-200">
                    <i class="fas fa-check mr-1"></i> Terapkan
                </button>
                <button wire:click="clearFilter" class="px-4 py-2.5 border-2 border-gray-300 rounded-xl text-sm font-black text-gray-600 hover:bg-gray-50 hover:border-gray-400 active:scale-95 transition-all">
                    <i class="fas fa-redo"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- QUICK NAVIGATION --}}
    <div class="sticky top-20 z-30 bg-white rounded-xl shadow-md border border-gray-200 p-3">
        <div class="flex flex-wrap gap-2 items-center justify-center">
            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Jump to:</span>
            @for($i = 1; $i <= 5; $i++)
                <a href="#element{{ $i }}" class="px-3 py-1.5 bg-emerald-50 hover:bg-emerald-500 hover:text-white text-emerald-600 rounded-lg text-xs font-bold transition-all border border-emerald-200 hover:border-emerald-500">
                    Elemen {{ $i }}
                </a>
            @endfor
             <a href="#element6" class="px-3 py-1.5 bg-emerald-50 hover:bg-emerald-500 hover:text-white text-emerald-600 rounded-lg text-xs font-bold transition-all border border-emerald-200 hover:border-emerald-500">
                Elemen 6
            </a>
        </div>
    </div>

    {{-- ELEMENT I - KEBIJAKAN --}}
    <div id="element1" class="scroll-mt-32">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 border-l-4 border-blue-500 shadow-lg">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 rounded-xl bg-blue-500 text-white flex items-center justify-center font-black text-lg shadow-md">I</div>
                <div>
                    <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tight">Elemen I - Kebijakan</h2>
                    <p class="text-sm text-gray-600 font-medium">Sosialisasi Kebijakan K3LH kepada Semua Pekerja</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
                    <h3 class="text-sm font-black text-gray-700 uppercase mb-4 flex items-center gap-2">
                        <i class="fas fa-gauge-high text-blue-500"></i>
                        Sosialisasi Kebijakan (Induksi)
                    </h3>
                    <div class="relative h-48 flex items-center justify-center">
                        <canvas id="gaugeInduction"></canvas>
                    </div>
                    <p class="text-center mt-4 text-lg font-black text-gray-900">
                        {{ $elementI['induction_compliance_percent'] }}% Karyawan Terinduksi
                    </p>
                    <p class="text-center text-xs text-gray-500 mt-1">
                        {{ $elementI['valid_inductions'] }} dari {{ $elementI['total_employees'] }} karyawan internal memiliki induksi valid
                    </p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
                    <h3 class="text-sm font-black text-gray-700 uppercase mb-4 flex items-center gap-2">
                        <i class="fas fa-users text-purple-500"></i>
                        Induksi Tamu & Mitra Hari Ini
                    </h3>
                    <div class="flex flex-col items-center justify-center h-48">
                        <div class="text-8xl font-black text-purple-600">{{ $elementI['guest_inductions_today'] }}</div>
                        <p class="text-sm text-gray-600 font-bold uppercase tracking-wider mt-2">Tamu/Kontraktor</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ELEMENT II - PERENCANAAN --}}
    <div id="element2" class="scroll-mt-32">
        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-2xl p-6 border-l-4 border-emerald-500 shadow-lg">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 rounded-xl bg-emerald-500 text-white flex items-center justify-center font-black text-lg shadow-md">II</div>
                <div>
                    <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tight">Elemen II - Perencanaan</h2>
                    <p class="text-sm text-gray-600 font-medium">Ketercapaian Program Diklat T.A. {{ $filterYear ?? date('Y') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
                    <h3 class="text-sm font-black text-gray-700 uppercase mb-4">Realisasi TNA (Plan vs Actual)</h3>
                    <div class="h-64">
                        <canvas id="sCurveTNA"></canvas>
                    </div>
                    <p class="text-center mt-4 text-lg font-black text-emerald-600">
                        {{ $elementII['plan_vs_actual_percent'] }}% Realisasi
                    </p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
                    <h3 class="text-sm font-black text-gray-700 uppercase mb-4">Top 5 Gap Kompetensi</h3>
                    <div class="h-64">
                        <canvas id="gapChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ELEMENT III - ORGANISASI --}}
    <div id="element3" class="scroll-mt-32">
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-2xl p-6 border-l-4 border-amber-500 shadow-lg">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 rounded-xl bg-amber-500 text-white flex items-center justify-center font-black text-lg shadow-md">III</div>
                <div>
                    <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tight">Elemen III - Organisasi & Personel</h2>
                    <p class="text-sm text-gray-600 font-medium">Kompetensi SDM dan Sertifikasi Wajib</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
                    <h3 class="text-sm font-black text-gray-700 uppercase mb-4">Status Kompetensi Pengawas</h3>
                    <div class="h-48">
                        <canvas id="supervisorChart"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
                    <h3 class="text-sm font-black text-gray-700 uppercase mb-4">Kepatuhan Matrix Jabatan</h3>
                    <div class="h-48">
                        <canvas id="matrixPieChart"></canvas>
                    </div>
                    <p class="text-center mt-4 text-lg font-black text-emerald-600">{{ $elementIII['matrix_compliance_percent'] }}% Compliant</p>
                </div>

                 <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100 flex flex-col justify-center gap-4">
                    <div class="flex justify-between items-center border-b pb-2">
                        <span class="text-xs font-bold text-gray-500 uppercase">Total Pengawas</span>
                        <span class="text-lg font-black text-gray-800">{{ $elementIII['total_supervisors'] }}</span>
                    </div>
                     <div class="flex justify-between items-center border-b pb-2">
                        <span class="text-xs font-bold text-gray-500 uppercase">Sertifikat Valid</span>
                        <span class="text-lg font-black text-emerald-600">{{ $elementIII['valid_certs'] }}</span>
                    </div>
                     <div class="flex justify-between items-center">
                        <span class="text-xs font-bold text-gray-500 uppercase">Sertifikat Expired</span>
                        <span class="text-lg font-black text-rose-600">{{ $elementIII['expired_certs'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ELEMENT IV - IMPLEMENTASI --}}
    <div id="element4" class="scroll-mt-32">
        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-2xl p-6 border-l-4 border-indigo-500 shadow-lg">
             <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 rounded-xl bg-indigo-500 text-white flex items-center justify-center font-black text-lg shadow-md">IV</div>
                <div>
                    <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tight">Elemen IV - Implementasi</h2>
                    <p class="text-sm text-gray-600 font-medium">Pelatihan Risiko Tinggi & Tanggap Darurat</p>
                </div>
            </div>

             <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
                    <h3 class="text-sm font-black text-gray-700 uppercase mb-4">Kesiapan Tim ERT</h3>
                    <div class="flex items-center justify-between mb-4">
                        <div>
                             <p class="text-4xl font-black text-indigo-600">{{ $elementIV['ert_readiness_percent'] }}%</p>
                             <p class="text-xs text-gray-500 font-bold uppercase">Personel Terlatih</p>
                        </div>
                        <div class="text-right">
                             <p class="text-xl font-bold text-gray-800">{{ $elementIV['trained_ert_members'] }} / {{ $elementIV['total_ert_members'] }}</p>
                             <p class="text-xs text-gray-500">Anggota Tim</p>
                        </div>
                    </div>
                     <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $elementIV['ert_readiness_percent'] }}%"></div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
                     <h3 class="text-sm font-black text-gray-700 uppercase mb-4">Training Risiko Tinggi</h3>
                     <div class="space-y-4">
                         @foreach($elementIV['high_risk_trainings'] as $training)
                         <div>
                             <div class="flex justify-between mb-1">
                                 <span class="text-sm font-medium text-gray-700">{{ $training['name'] }}</span>
                                 <span class="text-sm font-bold text-gray-900">{{ $training['trained'] }} Org</span>
                             </div>
                              <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-orange-500 h-2 rounded-full" style="width: 50%"></div>
                            </div>
                         </div>
                         @endforeach
                     </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ELEMENT V - PEMANTAUAN --}}
    <div id="element5" class="scroll-mt-32">
        <div class="bg-gradient-to-br from-rose-50 to-rose-100 rounded-2xl p-6 border-l-4 border-rose-500 shadow-lg">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 rounded-xl bg-rose-500 text-white flex items-center justify-center font-black text-lg shadow-md">V</div>
                <div>
                    <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tight">Elemen V - Pemantauan & Evaluasi</h2>
                    <p class="text-sm text-gray-600 font-medium">Efektivitas Pelatihan & Tingkat Keberhasilan</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
                    <h3 class="text-sm font-black text-gray-700 uppercase mb-4">Skor Efektivitas Training</h3>
                    <div class="h-64">
                        <canvas id="radarEffectiveness"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
                    <h3 class="text-sm font-black text-gray-700 uppercase mb-4">Tingkat Kegagalan (Fail Rate)</h3>
                    <div class="h-64">
                        <canvas id="failRateTrend"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

     {{-- ELEMENT VI - DOKUMENTASI --}}
    <div id="element6" class="scroll-mt-32">
        <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-2xl p-6 border-l-4 border-slate-500 shadow-lg">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 rounded-xl bg-slate-500 text-white flex items-center justify-center font-black text-lg shadow-md">VI</div>
                <div>
                    <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tight">Elemen VI - Dokumentasi</h2>
                    <p class="text-sm text-gray-600 font-medium">Administrasi & Arsip Pelatihan</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                 <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
                    <h3 class="text-sm font-black text-gray-700 uppercase mb-4">Kelengkapan Data Karyawan</h3>
                     <div class="flex items-end justify-between">
                        <div class="text-5xl font-black text-slate-700">{{ $elementVI['profile_completeness_percent'] }}%</div>
                        <div class="text-right text-sm text-gray-500">
                            {{ $elementVI['complete_profiles'] }} / {{ $elementVI['total_employees'] }} <br> Profil Lengkap
                        </div>
                    </div>
                     <div class="w-full bg-gray-200 rounded-full h-4 mt-4">
                        <div class="bg-slate-600 h-4 rounded-full" style="width: {{ $elementVI['profile_completeness_percent'] }}%"></div>
                    </div>
                </div>

                 <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
                    <h3 class="text-sm font-black text-gray-700 uppercase mb-4">Arsip Digital Training</h3>
                     <div class="flex items-end justify-between">
                        <div class="text-5xl font-black text-slate-700">{{ $elementVI['documentation_percent'] }}%</div>
                         <div class="text-right text-sm text-gray-500">
                            {{ $elementVI['documented_trainings'] }} / {{ $elementVI['total_trainings'] }} <br> Training Terdokumentasi
                        </div>
                    </div>
                     <div class="w-full bg-gray-200 rounded-full h-4 mt-4">
                        <div class="bg-slate-600 h-4 rounded-full" style="width: {{ $elementVI['documentation_percent'] }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('smkpDashboard', (initialData) => ({
            data: initialData,
            charts: {},

            init() {
                this.initCharts();

                // IMPORTANT: Listen for event with data payload to update charts
                Livewire.on('refreshCharts', ({ data }) => {
                    console.log('Refreshing charts with new data:', data);
                    this.data = data;
                    // Small delay to ensure any DOM updates from Livewire render are finished
                    setTimeout(() => {
                        this.initCharts();
                    }, 50);
                });
            },

            initCharts() {
                if (typeof Chart === 'undefined') {
                    console.error('Chart.js is not loaded.');
                    return;
                }

                const destroyChart = (key) => {
                    if (this.charts[key]) {
                        this.charts[key].destroy();
                        this.charts[key] = null;
                    }
                };

                // 1. GAUGE - INDUCTION
                const gaugeCtx = document.getElementById('gaugeInduction');
                if (gaugeCtx) {
                    destroyChart('gauge');
                    this.charts.gauge = new Chart(gaugeCtx, {
                        type: 'doughnut',
                        data: {
                            datasets: [{
                                data: [this.data.elementI.induction_compliance_percent, 100 - this.data.elementI.induction_compliance_percent],
                                backgroundColor: ['#10b981', '#f3f4f6'],
                                borderWidth: 0,
                            }]
                        },
                        options: {
                            circumference: 180,
                            rotation: 270,
                            cutout: '75%',
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false }, tooltip: { enabled: true } }
                        }
                    });
                }

                // 2. S-CURVE
                const sCurveCtx = document.getElementById('sCurveTNA');
                if (sCurveCtx) {
                    destroyChart('sCurve');
                    this.charts.sCurve = new Chart(sCurveCtx, {
                        type: 'line',
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                            datasets: [
                                {
                                    label: 'Target',
                                    data: this.data.elementII.monthly_target,
                                    borderColor: '#3b82f6',
                                    borderWidth: 2,
                                    fill: false,
                                    tension: 0.1
                                },
                                {
                                    label: 'Realisasi',
                                    data: this.data.elementII.monthly_actual,
                                    borderColor: '#10b981',
                                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                    fill: true,
                                    tension: 0.1
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: { y: { beginAtZero: true, max: 100 } }
                        }
                    });
                }

                // 3. GAP CHART
                const gapCtx = document.getElementById('gapChart');
                if (gapCtx) {
                    destroyChart('gap');
                    this.charts.gap = new Chart(gapCtx, {
                        type: 'bar',
                        data: {
                            labels: this.data.elementII.competency_gaps.map(i => i.position),
                            datasets: [{
                                label: 'Gap Kompetensi',
                                data: this.data.elementII.competency_gaps.map(i => i.gap_count),
                                backgroundColor: '#ef4444',
                                borderRadius: 4
                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });
                }

                // 4. SUPERVISOR
                const supervisorCtx = document.getElementById('supervisorChart');
                if (supervisorCtx) {
                    destroyChart('supervisor');
                    this.charts.supervisor = new Chart(supervisorCtx, {
                        type: 'bar',
                        data: {
                            labels: ['Pengawas'],
                            datasets: [
                                { label: 'Certified (POP/POM/POU)', data: [this.data.elementIII.certified_supervisors], backgroundColor: '#10b981', borderRadius: 4 },
                                { label: 'Uncertified', data: [this.data.elementIII.uncertified_supervisors], backgroundColor: '#ef4444', borderRadius: 4 }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: { x: { stacked: true }, y: { stacked: true } }
                        }
                    });
                }

                // 5. MATRIX PIE
                const matrixPieCtx = document.getElementById('matrixPieChart');
                if (matrixPieCtx) {
                    destroyChart('matrix');
                    this.charts.matrix = new Chart(matrixPieCtx, {
                        type: 'pie',
                        data: {
                            labels: ['Compliant', 'Non-Compliant'],
                            datasets: [{
                                data: [this.data.elementIII.matrix_compliance_percent, 100 - this.data.elementIII.matrix_compliance_percent],
                                backgroundColor: ['#10b981', '#f3f4f6'],
                                borderWidth: 0
                            }]
                        },
                        options: { responsive: true, maintainAspectRatio: false }
                    });
                }

                // 6. RADAR
                const radarCtx = document.getElementById('radarEffectiveness');
                if (radarCtx) {
                    destroyChart('radar');
                    this.charts.radar = new Chart(radarCtx, {
                        type: 'radar',
                        data: {
                            labels: ['Kepuasan', 'Ujian', 'Perilaku'],
                            datasets: [{
                                label: 'Skor Efektivitas',
                                data: [
                                    this.data.elementV.satisfaction_score * 20,
                                    this.data.elementV.exam_score,
                                    this.data.elementV.behavior_score * 20
                                ],
                                backgroundColor: 'rgba(139, 92, 246, 0.2)',
                                borderColor: '#8b5cf6',
                                pointBackgroundColor: '#8b5cf6'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: { r: { min: 0, max: 100, ticks: { stepSize: 20 } } }
                        }
                    });
                }

                // 7. FAIL RATE
                const failRateCtx = document.getElementById('failRateTrend');
                if (failRateCtx) {
                    destroyChart('failRate');
                    this.charts.failRate = new Chart(failRateCtx, {
                        type: 'line',
                        data: {
                            labels: this.data.elementV.fail_rate_trend.map(i => i.month),
                            datasets: [{
                                label: 'Fail Rate (%)',
                                data: this.data.elementV.fail_rate_trend.map(i => i.rate),
                                borderColor: '#f43f5e',
                                backgroundColor: 'rgba(244, 63, 94, 0.1)',
                                tension: 0.4,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: { y: { beginAtZero: true } }
                        }
                    });
                }
            }
        }));
    });
</script>
@endpush