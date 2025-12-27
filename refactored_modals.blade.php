<div>
    {{-- 1. Competency Management Modal --}}
    @if($showCompetencyModal)
    @teleport('#modals')
    <!-- Modal Backdrop -->
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75 backdrop-blur-sm"
                 wire:click.self="$set('showCompetencyModal', false)"
                 aria-hidden="true"></div>

            <!-- Modal Panel -->
            <div class="relative inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl sm:p-8">

                <!-- Header -->
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900" id="modal-title">
                            {{ $isEditCompetency ? 'Edit' : 'Tambah' }} Kompetensi
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Definisikan kriteria keahlian baru dalam kamus sistem.
                        </p>
                    </div>
                    <button wire:click="$set('showCompetencyModal', false)" type="button" class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-lg p-2.5 ml-auto inline-flex items-center transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Form -->
                <form wire:submit.prevent="saveCompetency" class="space-y-6">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label class="block mb-2 text-xs font-semibold tracking-wider text-gray-500 uppercase">Kode Kompetensi</label>
                            <input type="text" wire:model="compCode" {{ $isEditCompetency ? 'disabled' : '' }}
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 {{ $isEditCompetency ? 'opacity-50 cursor-not-allowed' : '' }}"
                                   placeholder="e.g. COMP-001">
                            @error('compCode') <span class="block mt-1 text-xs font-medium text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block mb-2 text-xs font-semibold tracking-wider text-gray-500 uppercase">Kategori</label>
                            <select wire:model="compCategory" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5">
                                <option value="TEKNIS">TEKNIS</option>
                                <option value="K3">K3</option>
                                <option value="SOFT">SOFT SKILL</option>
                                <option value="WAJIB">WAJIB</option>
                                <option value="SKKNI">SKKNI</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block mb-2 text-xs font-semibold tracking-wider text-gray-500 uppercase">Nama Kompetensi</label>
                        <input type="text" wire:model="compName" placeholder="Contoh: Teknik Pengelasan Dasar (SMAW)"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5">
                        @error('compName') <span class="block mt-1 text-xs font-medium text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label class="block mb-2 text-xs font-semibold tracking-wider text-gray-500 uppercase">Masa Berlaku</label>
                            <div class="relative">
                                <input type="number" wire:model="compValidity" placeholder="0"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 pr-16">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <span class="text-xs font-bold text-gray-400">BULAN</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block mb-2 text-xs font-semibold tracking-wider text-gray-500 uppercase">Level Target</label>
                            <select wire:model="compLevel" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5">
                                <option value="Basic">Basic (Tingkat 1)</option>
                                <option value="Intermediate">Intermediate (Tingkat 2)</option>
                                <option value="Advanced">Advanced (Tingkat 3)</option>
                                <option value="Specialist">Specialist (Tingkat 4)</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full px-5 py-3 text-sm font-bold text-white uppercase tracking-widest transition-colors bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 shadow-lg shadow-emerald-200/50">
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endteleport
    @endif

    {{-- 2. Standard Mapping Modal (Job & K3) --}}
    @if($showStandardModal)
    @teleport('#modals')
    <div class="fixed inset-0 z-50 overflow-hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="absolute inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm transition-opacity"
             wire:click.self="$set('showStandardModal', false)"></div>

        <div class="fixed inset-0 flex items-center justify-center p-4 sm:p-6">
            <div class="relative w-full max-w-6xl h-full max-h-[90vh] bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row">

                @php
                    $isK3 = $standardType === 'k3';
                    $themeColorClass = $isK3 ? 'rose' : 'emerald'; // For logic
                    // Static classes for better readability/maintainability, though dynamic works too.
                    $bannerClass = $isK3 ? 'from-rose-600 to-rose-700' : 'from-emerald-600 to-emerald-700';
                    $btnClass = $isK3 ? 'bg-rose-600 hover:bg-rose-700 focus:ring-rose-300' : 'bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-300';
                    $lightBgClass = $isK3 ? 'bg-rose-50 text-rose-700' : 'bg-emerald-50 text-emerald-700';
                @endphp

                {{-- Sidebar --}}
                <div class="hidden md:flex flex-col justify-between w-80 p-8 bg-gradient-to-br {{ $bannerClass }} text-white shrink-0">
                    <div>
                        <div class="flex items-center justify-center w-16 h-16 mb-8 bg-white/20 backdrop-blur-md rounded-2xl shadow-inner">
                            @if($isK3)
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04m17.236 0a11.955 11.955 0 01-4.782 9.58 11.955 11.955 0 01-12.456 0 11.955 11.955 0 01-4.782-9.58L12 5.954l8.618-3.04z"></path></svg>
                            @else
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            @endif
                        </div>
                        <h3 class="text-3xl font-extrabold leading-tight">
                            {{ $isEditStandard ? 'Edit' : 'Tambah' }}<br>
                            <span class="opacity-75">{{ strtoupper($standardType) }}</span> Standard
                        </h3>
                        <p class="mt-4 text-sm font-medium opacity-80 leading-relaxed">
                            Tentukan persyaratan kompetensi minimum untuk klasifikasi jabatan atau kluster ini untuk memastikan standar operasional.
                        </p>
                    </div>

                    <div class="pt-8 border-t border-white/20">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="relative flex h-3 w-3">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
                            </span>
                            <span class="text-xs font-bold uppercase tracking-widest opacity-75">Auto-Validation</span>
                        </div>
                        <div class="p-4 rounded-xl bg-black/20 backdrop-blur-sm border border-white/10">
                            <p class="text-xs italic leading-relaxed opacity-90">
                                "Matriks kompetensi karyawan akan diperbarui secara real-time berdasarkan standard yang Anda simpan di sini."
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Main Content --}}
                <div class="flex flex-col flex-1 bg-white relative">
                    <!-- Close Button (Mobile/Desktop) -->
                    <button wire:click="$set('showStandardModal', false)" class="absolute top-6 right-6 z-10 p-2 text-gray-400 bg-gray-50 rounded-lg hover:bg-red-50 hover:text-red-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>

                    <div class="flex-1 overflow-y-auto p-6 md:p-10">
                        <form wire:submit.prevent="saveStandard" class="h-full flex flex-col">
                            <!-- Top Form -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-6 mb-8">
                                <div class="lg:col-span-6">
                                    <label class="block mb-2 text-xs font-bold tracking-wider text-gray-500 uppercase">Nama Jabatan / Cluster</label>
                                    <input type="text" wire:model="stdPosition"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-{{ $isK3 ? 'rose' : 'emerald' }}-500 focus:border-{{ $isK3 ? 'rose' : 'emerald' }}-500 block w-full p-3"
                                           placeholder="Contoh: OPERATOR FORKLIFT">
                                    @error('stdPosition') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div class="lg:col-span-3">
                                    <label class="block mb-2 text-xs font-bold tracking-wider text-gray-500 uppercase">Seksi (Section)</label>
                                    <input type="text" wire:model="stdSection"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-{{ $isK3 ? 'rose' : 'emerald' }}-500 focus:border-{{ $isK3 ? 'rose' : 'emerald' }}-500 block w-full p-3"
                                           placeholder="Opsional">
                                </div>
                                <div class="lg:col-span-3">
                                    <label class="block mb-2 text-xs font-bold tracking-wider text-gray-500 uppercase">Departemen</label>
                                    <input type="text" wire:model="stdDepartment" list="dept_list"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-{{ $isK3 ? 'rose' : 'emerald' }}-500 focus:border-{{ $isK3 ? 'rose' : 'emerald' }}-500 block w-full p-3">
                                    <datalist id="dept_list">
                                        @foreach($departments as $dept) <option value="{{ $dept }}"> @endforeach
                                    </datalist>
                                </div>
                            </div>

                            <!-- Competency List Box -->
                            <div class="flex flex-col flex-1 bg-gray-50 rounded-2xl border border-gray-200 overflow-hidden">
                                <div class="px-6 py-4 border-b border-gray-200 bg-white flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 {{ $lightBgClass }} rounded-lg">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                        </div>
                                        <h4 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Matriks Kompetensi Wajib</h4>
                                    </div>
                                    <button type="button" wire:click="addCompetencyToStandard" class="inline-flex items-center px-4 py-2 text-xs font-bold uppercase tracking-wider text-{{ $isK3 ? 'rose' : 'emerald' }}-600 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 hover:text-{{ $isK3 ? 'rose' : 'emerald' }}-700 transition-all">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        Tambah Item
                                    </button>
                                </div>

                                <div class="flex-1 overflow-y-auto p-4 space-y-3">
                                    @foreach($stdSelectedCompetencies as $idx => $item)
                                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 bg-white p-4 rounded-xl border border-gray-200 shadow-sm group hover:border-{{ $isK3 ? 'rose' : 'emerald' }}-300 transition-all">
                                            <div class="flex-1 w-full">
                                                <select wire:model="stdSelectedCompetencies.{{ $idx }}.code" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-{{ $isK3 ? 'rose' : 'emerald' }}-500 focus:border-{{ $isK3 ? 'rose' : 'emerald' }}-500 block w-full p-2.5">
                                                    <option value="">-- Pilih Kompetensi --</option>
                                                    @foreach($availableCompetencies as $c)
                                                        @if($isK3 && $c->category !== 'K3') @continue @endif
                                                        <option value="{{ $c->code }}">{{ $c->code }} - {{ $c->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="w-full sm:w-48">
                                                <select wire:model="stdSelectedCompetencies.{{ $idx }}.level" class="bg-{{ $isK3 ? 'rose' : 'emerald' }}-50 border border-transparent text-{{ $isK3 ? 'rose' : 'emerald' }}-900 text-sm rounded-lg focus:ring-{{ $isK3 ? 'rose' : 'emerald' }}-500 focus:border-{{ $isK3 ? 'rose' : 'emerald' }}-500 block w-full p-2.5 font-semibold">
                                                    <option value="REQ">REQUIRED (WAJIB)</option>
                                                    <option value="ADV">ADVANCED (MAHIR)</option>
                                                </select>
                                            </div>
                                            <button type="button" wire:click="removeCompetencyFromStandard({{ $idx }})" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    @endforeach

                                    @if(empty($stdSelectedCompetencies))
                                        <div class="flex flex-col items-center justify-center py-12 text-center text-gray-400">
                                            <svg class="w-16 h-16 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            <p class="text-sm font-medium">Belum ada kompetensi yang ditambahkan.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Footer -->
                    <div class="p-6 border-t border-gray-100 bg-gray-50 flex items-center justify-end gap-4">
                        <button wire:click="$set('showStandardModal', false)" type="button" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 transition-colors">
                            Batal
                        </button>
                        <button wire:click="saveStandard" type="button" class="px-5 py-2.5 text-sm font-bold text-white {{ $btnClass }} rounded-lg shadow-lg shadow-{{ $isK3 ? 'rose' : 'emerald' }}-200/50 transition-all uppercase tracking-wider">
                            Simpan Standard
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endteleport
    @endif

    {{-- 3. Import CSV Modal --}}
    @if($showImportModal)
    @teleport('#modals')
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75 backdrop-blur-sm"
                 wire:click.self="$set('showImportModal', false)"></div>

            <div class="relative inline-block w-full max-w-md p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl sm:p-8">
                <!-- Header -->
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Import Data</h3>
                        <p class="mt-1 text-sm text-gray-500">Bulk upload data via file CSV.</p>
                    </div>
                    <button wire:click="$set('showImportModal', false)" class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-lg p-2 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form wire:submit.prevent="processImport" class="space-y-6">
                    <!-- File Drop Zone -->
                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 hover:border-emerald-500 transition-all group relative overflow-hidden">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <div class="mb-3 p-3 rounded-full bg-gray-100 group-hover:bg-emerald-50 group-hover:text-emerald-500 transition-colors">
                                    <svg class="w-8 h-8 text-gray-400 group-hover:text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                </div>
                                @if($csvFile)
                                    <p class="mb-1 text-sm font-bold text-emerald-600">{{ $csvFile->getClientOriginalName() }}</p>
                                    <p class="text-xs text-gray-500">Siap untuk diproses</p>
                                @else
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                                    <p class="text-xs text-gray-500">CSV, XLS up to 10MB</p>
                                @endif
                            </div>
                            <input type="file" wire:model="csvFile" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        </label>
                    </div>

                    <!-- Options -->
                    <div class="space-y-3">
                         <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide">Metode Sinkronisasi</label>
                         <div class="space-y-2">
                             <div class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                 <input id="mode-add" type="radio" wire:model="importMode" value="tambahan" class="w-4 h-4 text-emerald-600 focus:ring-emerald-500 border-gray-300">
                                 <label for="mode-add" class="ml-3 w-full cursor-pointer">
                                     <span class="block text-sm font-medium text-gray-900">Update / Tambahkan</span>
                                     <span class="block text-xs text-gray-500">Hanya memperbarui atau menambah data baru.</span>
                                 </label>
                             </div>
                             <div class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                 <input id="mode-overwrite" type="radio" wire:model="importMode" value="semua" class="w-4 h-4 text-emerald-600 focus:ring-emerald-500 border-gray-300">
                                 <label for="mode-overwrite" class="ml-3 w-full cursor-pointer">
                                     <span class="block text-sm font-medium text-gray-900">Timpa (Overwrite)</span>
                                     <span class="block text-xs text-gray-500">Hapus semua data lama dan ganti dengan file ini.</span>
                                 </label>
                             </div>
                         </div>
                    </div>

                    <button type="submit" wire:loading.attr="disabled" class="w-full px-5 py-3 text-sm font-bold text-white uppercase tracking-widest bg-gray-900 rounded-lg hover:bg-black focus:ring-4 focus:ring-gray-300 shadow-lg disabled:opacity-50 transition-all">
                        <span wire:loading.remove>Eksekusi Import</span>
                        <span wire:loading class="flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2 animate-spin text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Memproses...
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endteleport
    @endif
</div>
