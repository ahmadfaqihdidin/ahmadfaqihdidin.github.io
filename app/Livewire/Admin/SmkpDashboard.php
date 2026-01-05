<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Lazy;
use App\Models\InductionSession;
use App\Models\TrainingRealization;
use App\Models\HseEmployee;
use App\Models\TrainingSchedule;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

#[Lazy]
class SmkpDashboard extends Component
{
    // Filter Properties
    public $filterYear;
    public $filterCompany = '';
    public $filterDateFrom;
    public $filterDateTo;
    public $filterType = 'year'; // year, range, month
    public $selectedMonth;

    // Cache the data for the request lifecycle to avoid double calculation
    protected $chartDataCache = null;

    public function mount()
    {
        $this->filterYear = Carbon::now()->year;
        $this->selectedMonth = Carbon::now()->format('Y-m');
        $this->filterDateFrom = Carbon::now()->startOfYear()->format('Y-m-d');
        $this->filterDateTo = Carbon::now()->endOfYear()->format('Y-m-d');
    }

    public function updated($property)
    {
        // When filters change, dispatch event with NEW data
        $this->dispatch('refreshCharts', data: $this->getChartData());
    }

    public function applyFilter()
    {
        $this->dispatch('refreshCharts', data: $this->getChartData());
    }

    public function clearFilter()
    {
        $this->filterYear = Carbon::now()->year;
        $this->filterCompany = '';
        $this->filterType = 'year';
        $this->selectedMonth = Carbon::now()->format('Y-m');
        $this->filterDateFrom = Carbon::now()->startOfYear()->format('Y-m-d');
        $this->filterDateTo = Carbon::now()->endOfYear()->format('Y-m-d');

        $this->dispatch('refreshCharts', data: $this->getChartData());
    }

    private function getDateRange()
    {
        if ($this->filterType === 'year') {
            return [
                Carbon::createFromDate($this->filterYear, 1, 1)->startOfYear(),
                Carbon::createFromDate($this->filterYear, 12, 31)->endOfYear()
            ];
        } elseif ($this->filterType === 'month') {
            $date = Carbon::createFromFormat('Y-m', $this->selectedMonth);
            return [$date->copy()->startOfMonth(), $date->copy()->endOfMonth()];
        } else {
            return [
                Carbon::parse($this->filterDateFrom),
                Carbon::parse($this->filterDateTo)
            ];
        }
    }

    // Centralized Data Getter
    public function getChartData()
    {
        if ($this->chartDataCache) {
            return $this->chartDataCache;
        }

        $this->chartDataCache = [
            'elementI' => $this->getElementIData(),
            'elementII' => $this->getElementIIData(),
            'elementIII' => $this->getElementIIIData(),
            'elementIV' => $this->getElementIVData(),
            'elementV' => $this->getElementVData(),
            'elementVI' => $this->getElementVIData(),
        ];

        return $this->chartDataCache;
    }

    // =================================================================
    // ELEMENT I - KEBIJAKAN (POLICY)
    // =================================================================

    private function getElementIData()
    {
        [$startDate, $endDate] = $this->getDateRange();
        $now = Carbon::now();

        $employeeQuery = HseEmployee::where('employment_type', 'INTERNAL');
        if ($this->filterCompany) {
            $employeeQuery->where('company_id', $this->filterCompany);
        }

        $totalEmployees = $employeeQuery->count();

        // Optimized: Use select() instead of pluck() for subquery
        $validInductionQuery = InductionSession::where('status', 'LULUS')
            ->where('masa_berlaku', '>', $now)
            ->whereIn('employee_user_id', $employeeQuery->select('employee_id'));

        $validInductions = $validInductionQuery->distinct('employee_user_id')
            ->count('employee_user_id');

        $inductionCompliancePercent = $totalEmployees > 0
            ? round(($validInductions / $totalEmployees) * 100, 1)
            : 0;

        // Induksi Tamu & Mitra
        $guestInductionQuery = InductionSession::whereDate('tanggal_induksi', $now->toDateString())
            ->where('status', 'LULUS')
            ->where(function($q) {
                $q->where('jenis_induksi', 'LIKE', '%Tamu%')
                  ->orWhere('jenis_induksi', 'LIKE', '%Visitor%')
                  ->orWhere('jenis_induksi', 'LIKE', '%Kontraktor%')
                  ->orWhereIn('employee_user_id', HseEmployee::where('employment_type', 'MITRA')
                      ->when($this->filterCompany, function($query) {
                          return $query->where('company_id', $this->filterCompany);
                      })
                      ->select('employee_id')); // Optimized
            });

        $guestInductionsToday = $guestInductionQuery->count();

        return [
            'induction_compliance_percent' => $inductionCompliancePercent,
            'valid_inductions' => $validInductions,
            'total_employees' => $totalEmployees,
            'guest_inductions_today' => $guestInductionsToday,
        ];
    }

    // =================================================================
    // ELEMENT II - PERENCANAAN (PLANNING)
    // =================================================================

    private function getElementIIData()
    {
        [$startDate, $endDate] = $this->getDateRange();
        $year = $this->filterType === 'year' ? $this->filterYear : $startDate->year;

        $scheduleQuery = TrainingSchedule::whereBetween('start_date', [$startDate, $endDate]);
        $realizationQuery = TrainingRealization::where('approval_status', 'approved')
            ->whereBetween('training_date', [$startDate, $endDate]);

        if ($this->filterCompany) {
            $scheduleQuery->where('company_id', $this->filterCompany);
            $realizationQuery->whereHas('employee', function($q) {
                $q->where('company_id', $this->filterCompany);
            });
        }

        $plannedTrainings = $scheduleQuery->count();
        $actualTrainings = $realizationQuery->count();

        $planVsActualPercent = $plannedTrainings > 0
            ? round(($actualTrainings / $plannedTrainings) * 100, 1)
            : 0;

        // Monthly trend for S-Curve
        $monthlyTarget = [8, 17, 25, 33, 42, 50, 58, 67, 75, 83, 92, 100];
        $monthlyActual = [];

        if ($this->filterType === 'year') {
            for ($m = 1; $m <= 12; $m++) {
                $monthStart = Carbon::create($year, $m, 1)->startOfMonth();
                $monthEnd = Carbon::create($year, $m, 1)->endOfMonth();

                if ($monthStart->isFuture()) {
                    $monthlyActual[] = null;
                    continue;
                }

                // Note: keeping count query inside loop for simplicity (12 queries is acceptable)
                $monthlyCount = TrainingRealization::where('approval_status', 'approved')
                    ->whereBetween('training_date', [Carbon::create($year, 1, 1), $monthEnd])
                    ->when($this->filterCompany, function($q) {
                        return $q->whereHas('employee', fn($eq) => $eq->where('company_id', $this->filterCompany));
                    })
                    ->count();

                $actualPct = $plannedTrainings > 0 ? round(($monthlyCount / $plannedTrainings) * 100, 1) : 0;
                $monthlyActual[] = $actualPct;
            }
        } else {
            $monthlyActual = [0, $planVsActualPercent];
        }

        // OPTIMIZED: Gap Kompetensi (Avoid N+1)
        // 1. Fetch all internal employees grouped by job_title, Eager Loading valid competencies
        $employeesByJob = HseEmployee::select('id', 'job_title')
            ->whereNotNull('job_title')
            ->where('employment_type', 'INTERNAL')
            ->with(['competencies' => function($q) {
                $q->wherePivot('status', 'VALID');
            }])
            ->get()
            ->groupBy('job_title');

        // 2. Process the collection
        $competencyGaps = $employeesByJob->map(function($employees, $jobTitle) {
            $totalGap = 0;
            $requiredCount = 10; // Placeholder

            foreach ($employees as $emp) {
                $achievedCount = $emp->competencies->count();
                $totalGap += max(0, $requiredCount - $achievedCount);
            }

            return [
                'position' => $jobTitle,
                'gap_count' => $totalGap,
                'employee_count' => $employees->count(),
            ];
        })
        ->sortByDesc('gap_count')
        ->take(5)
        ->values();

        return [
            'planned_trainings' => $plannedTrainings,
            'actual_trainings' => $actualTrainings,
            'plan_vs_actual_percent' => $planVsActualPercent,
            'monthly_actual' => $monthlyActual,
            'monthly_target' => $monthlyTarget,
            'competency_gaps' => $competencyGaps,
        ];
    }

    // =================================================================
    // ELEMENT III - ORGANISASI & PERSONEL
    // =================================================================

    private function getElementIIIData()
    {
        $now = Carbon::now();

        $supervisors = HseEmployee::where('employment_type', 'INTERNAL')
            ->where(function($q) {
                $q->where('job_title', 'LIKE', '%Foreman%')
                  ->orWhere('job_title', 'LIKE', '%Supervisor%')
                  ->orWhere('job_title', 'LIKE', '%Pengawas%')
                  ->orWhere('job_title', 'LIKE', '%Spv%');
            })
            ->pluck('employee_id'); // Just get IDs

        $totalSupervisors = $supervisors->count();

        // Optimized check using whereIn
        $popCodes = ['POP', 'POM', 'POU'];
        $certifiedSupervisors = TrainingRealization::whereIn('employee_id', $supervisors)
            ->whereIn('competency_code', $popCodes)
            ->where('approval_status', 'approved')
            ->where(function($q) use ($now) {
                $q->whereNull('expiry_date')
                  ->orWhere('expiry_date', '>', $now);
            })
            ->distinct('employee_id')
            ->count('employee_id');

        $allCertificates = TrainingRealization::where('approval_status', 'approved')
            ->whereNotNull('expiry_date')
            ->get();

        $expiredCerts = $allCertificates->where('expiry_date', '<', $now)->count();
        $expiringSoonCerts = $allCertificates->filter(function($cert) use ($now) {
            return $cert->expiry_date >= $now && $cert->expiry_date <= $now->copy()->addDays(30);
        })->count();
        $validCerts = $allCertificates->filter(function($cert) use ($now) {
            return $cert->expiry_date > $now->copy()->addDays(30);
        })->count();

        // Optimized Matrix Compliance (Avoid N+1)
        $employeesWithCompleteMatrix = HseEmployee::where('employment_type', 'INTERNAL')
            ->withCount(['competencies' => function($q) {
                $q->where('status', 'VALID');
            }])
            ->get()
            ->filter(function($emp) {
                $total = 10;
                return ($emp->competencies_count / $total) >= 0.8;
            })
            ->count();

        $totalInternal = HseEmployee::where('employment_type', 'INTERNAL')->count();
        $matrixCompliancePercent = $totalInternal > 0
            ? round(($employeesWithCompleteMatrix / $totalInternal) * 100, 1)
            : 0;

        return [
            'total_supervisors' => $totalSupervisors,
            'certified_supervisors' => $certifiedSupervisors,
            'uncertified_supervisors' => $totalSupervisors - $certifiedSupervisors,
            'expired_certs' => $expiredCerts,
            'expiring_soon_certs' => $expiringSoonCerts,
            'valid_certs' => $validCerts,
            'matrix_compliance_percent' => $matrixCompliancePercent,
            'internal_employees_count' => $totalInternal,
        ];
    }

    // =================================================================
    // ELEMENT IV - IMPLEMENTASI
    // =================================================================

    private function getElementIVData()
    {
        $now = Carbon::now();

        $ertCompetencies = ['ERT', 'RESCUE', 'FIRST_AID', 'FIRE_FIGHTING'];
        $ertEmployees = HseEmployee::where('employment_type', 'INTERNAL')
            ->where(function($q) {
                $q->where('job_title', 'LIKE', '%ERT%')
                  ->orWhere('job_title', 'LIKE', '%Emergency%')
                  ->orWhere('job_title', 'LIKE', '%Rescue%');
            })
            ->pluck('employee_id');

        $totalErtMembers = $ertEmployees->count();

        $trainedErtMembers = TrainingRealization::whereIn('employee_id', $ertEmployees)
            ->whereIn('competency_code', $ertCompetencies)
            ->where('approval_status', 'approved')
            ->where(function($q) use ($now) {
                $q->whereNull('expiry_date')
                  ->orWhere('expiry_date', '>', $now);
            })
            ->distinct('employee_id')
            ->count('employee_id');

        $ertReadinessPercent = $totalErtMembers > 0
            ? round(($trainedErtMembers / $totalErtMembers) * 100, 1)
            : 0;

        // Training Risiko Tinggi
        $highRiskTrainings = [
            ['name' => 'Bekerja di Ketinggian', 'code' => 'HEIGHT_WORK'],
            ['name' => 'Ruang Terbatas (Confined Space)', 'code' => 'CONFINED_SPACE'],
            ['name' => 'Isolasi Energi (LOTO)', 'code' => 'LOTO'],
        ];

        $results = [];
        foreach ($highRiskTrainings as $training) {
            $trained = TrainingRealization::where('competency_code', $training['code'])
                ->where('approval_status', 'approved')
                ->where(function($q) use ($now) {
                    $q->whereNull('expiry_date')
                      ->orWhere('expiry_date', '>', $now);
                })
                ->distinct('employee_id')
                ->count('employee_id');

            $results[] = [
                'name' => $training['name'],
                'code' => $training['code'],
                'trained' => $trained,
                'required' => 0, // Placeholder
            ];
        }

        $operatorPermitCodes = ['SIMPER', 'KIM', 'OPERATOR_LICENSE'];
        $activeOperatorPermits = TrainingRealization::whereIn('competency_code', $operatorPermitCodes)
            ->where('approval_status', 'approved')
            ->where(function($q) use ($now) {
                $q->whereNull('expiry_date')
                  ->orWhere('expiry_date', '>', $now);
            })
            ->distinct('employee_id')
            ->count('employee_id');

        return [
            'total_ert_members' => $totalErtMembers,
            'trained_ert_members' => $trainedErtMembers,
            'ert_readiness_percent' => $ertReadinessPercent,
            'high_risk_trainings' => $results,
            'active_operator_permits' => $activeOperatorPermits,
        ];
    }

    // =================================================================
    // ELEMENT V - PEMANTAUAN & EVALUASI
    // =================================================================

    private function getElementVData()
    {
        $avgSatisfactionScore = 4.2;
        $avgBehaviorScore = 4.5;

        $examScores = InductionSession::where('status', 'LULUS')
            ->whereYear('tanggal_induksi', Carbon::now()->year)
            ->avg('score');

        $avgExamScore = $examScores ?? 85.5;

        [$startDate, $endDate] = $this->getDateRange();

        $totalParticipants = InductionSession::whereBetween('tanggal_induksi', [$startDate, $endDate])
            ->when($this->filterCompany, fn($q) => $q->where('company_id', $this->filterCompany))
            ->count();
        $failedParticipants = InductionSession::where('status', 'TIDAK LULUS')
            ->whereBetween('tanggal_induksi', [$startDate, $endDate])
            ->when($this->filterCompany, fn($q) => $q->where('company_id', $this->filterCompany))
            ->count();

        $failRatePercent = $totalParticipants > 0
            ? round(($failedParticipants / $totalParticipants) * 100, 1)
            : 0;

        $trendEndDate = $endDate->copy();
        $failRateTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = $trendEndDate->copy()->subMonths($i);
            // Aggregate counts first
            $query = InductionSession::whereYear('tanggal_induksi', $month->year)
                ->whereMonth('tanggal_induksi', $month->month)
                ->when($this->filterCompany, fn($q) => $q->where('company_id', $this->filterCompany));

            $monthTotal = (clone $query)->count();
            $monthFailed = (clone $query)->where('status', 'TIDAK LULUS')->count();

            $failRateTrend[] = [
                'month' => $month->format('M Y'),
                'rate' => $monthTotal > 0 ? round(($monthFailed / $monthTotal) * 100, 1) : 0,
            ];
        }

        return [
            'satisfaction_score' => $avgSatisfactionScore,
            'exam_score' => round($avgExamScore, 1),
            'behavior_score' => $avgBehaviorScore,
            'fail_rate_percent' => $failRatePercent,
            'fail_rate_trend' => $failRateTrend,
        ];
    }

    // =================================================================
    // ELEMENT VI - DOKUMENTASI
    // =================================================================

    private function getElementVIData()
    {
        $employees = HseEmployee::where('employment_type', 'INTERNAL')->get();
        $totalEmployees = $employees->count();
        $completeProfiles = $employees->filter(function($emp) {
            return !empty($emp->name)
                && !empty($emp->email)
                && !empty($emp->phone)
                && !empty($emp->job_title)
                && !empty($emp->company_id);
        })->count();

        $profileCompletenessPercent = $totalEmployees > 0
            ? round(($completeProfiles / $totalEmployees) * 100, 1)
            : 0;

        $totalTrainings = TrainingRealization::where('approval_status', 'approved')
            ->whereYear('training_date', Carbon::now()->year)
            ->count();
        $documentedTrainings = TrainingRealization::where('approval_status', 'approved')
            ->whereYear('training_date', Carbon::now()->year)
            ->whereNotNull('certificate_url')
            ->count();

        $documentationPercent = $totalTrainings > 0
            ? round(($documentedTrainings / $totalTrainings) * 100, 1)
            : 0;

        return [
            'total_employees' => $totalEmployees,
            'complete_profiles' => $completeProfiles,
            'profile_completeness_percent' => $profileCompletenessPercent,
            'total_trainings' => $totalTrainings,
            'documented_trainings' => $documentedTrainings,
            'documentation_percent' => $documentationPercent,
        ];
    }

    // Skeleton loading state
    public function placeholder()
    {
        $skeletonItems = '';
        for ($i = 0; $i < 6; $i++) {
            $skeletonItems .= '
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm animate-pulse">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-gray-100 rounded-xl"></div>
                    <div class="flex-1 space-y-2">
                        <div class="h-3 w-20 bg-gray-100 rounded"></div>
                        <div class="h-5 w-32 bg-gray-200 rounded"></div>
                    </div>
                </div>
                <div class="h-2 w-full bg-gray-50 rounded-full overflow-hidden">
                    <div class="h-full bg-gray-200 w-1/3"></div>
                </div>
            </div>';
        }

        return <<<HTML
        <div class="p-8 w-full">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8 animate-pulse">
                <div class="space-y-3">
                    <div class="h-8 w-64 bg-gray-200 rounded-lg"></div>
                    <div class="h-4 w-96 bg-gray-100 rounded-md"></div>
                </div>
                <div class="h-10 w-48 bg-gray-200 rounded-xl"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                {$skeletonItems}
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-pulse">
                <div class="bg-white p-6 rounded-2xl border border-gray-100 h-96"></div>
                <div class="bg-white p-6 rounded-2xl border border-gray-100 h-96"></div>
            </div>
        </div>
        HTML;
    }

    public function render()
    {
        $companies = Company::orderBy('name')->get();

        $inductionYears = InductionSession::selectRaw('YEAR(tanggal_induksi) as year')->distinct()->pluck('year');
        $trainingYears = TrainingRealization::selectRaw('YEAR(training_date) as year')->where('approval_status', 'approved')->distinct()->pluck('year');

        $availableYears = $inductionYears->merge($trainingYears)->unique()->filter()->sortDesc()->values();

        $years = $availableYears->map(function($y) {
            return ['value' => $y, 'label' => $y];
        })->toArray();

        if (empty($years)) {
            $years[] = ['value' => Carbon::now()->year, 'label' => Carbon::now()->year];
        }

        // Get data once
        $chartData = $this->getChartData();

        return view('livewire.admin.smkp-dashboard', [
            'chartData' => $chartData,
            'companies' => $companies,
            'years' => $years,
            'elementI' => $chartData['elementI'],
            'elementII' => $chartData['elementII'],
            'elementIII' => $chartData['elementIII'],
            'elementIV' => $chartData['elementIV'],
            'elementV' => $chartData['elementV'],
            'elementVI' => $chartData['elementVI'],
        ])
        ->layout('components.layouts.admin', ['title' => 'SMKP TRAINING Dashboard']);
    }
}
