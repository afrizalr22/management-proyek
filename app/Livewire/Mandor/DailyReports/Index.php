<?php

namespace App\Livewire\Mandor\DailyReports;

use App\Models\DailyReport;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public string $search = '';

    #[Url(except: '', as: 'project')]
    public string $projectFilter = '';

    #[Url(except: '')]
    public string $status = '';

    #[Url(except: 'newest')]
    public string $sort = 'newest';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingProjectFilter(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function updatingSort(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset([
            'search',
            'projectFilter',
            'status',
        ]);

        $this->sort = 'newest';

        $this->resetPage();
    }

    public function render()
    {
        $mandor = $this->mandor();

        $projects = Project::query()
            ->where(
                'mandor_id',
                $mandor->id
            )
            ->orderBy('project_name')
            ->get([
                'id',
                'mandor_id',
                'project_code',
                'project_name',
            ]);

        $reportQuery = $this->reportQuery(
            $mandor->id
        )
            ->with([
                'project:id,mandor_id,project_code,project_name',

                'task:id,project_id,task_code,title,status,progress',

                'user:id,name,email,status',

                'reviewer:id,name',
            ])
            ->withCount('documentations');

        $this->applySearch(
            $reportQuery
        );

        $this->applyProjectFilter(
            $reportQuery,
            $projects->pluck('id')->all()
        );

        $this->applyStatusFilter(
            $reportQuery
        );

        $this->applySorting(
            $reportQuery
        );

        $reports = $reportQuery
            ->paginate(6);

        return view(
            'livewire.mandor.daily-reports.index',
            [
                'reports' => $reports,

                'projects' => $projects,

                'statistics' => $this->statistics(
                    $mandor->id
                ),

                'hasActiveFilters' =>
                    filled($this->search)
                    || filled($this->projectFilter)
                    || filled($this->status)
                    || $this->sort !== 'newest',
            ]
        );
    }

    private function mandor(): User
    {
        $mandor = Auth::user();

        abort_unless(
            $mandor instanceof User
                && $mandor->hasRole('mandor'),
            403
        );

        return $mandor;
    }

    private function reportQuery(
        int $mandorId
    ): Builder {
        return DailyReport::query()
            ->whereIn(
                'status',
                [
                    'submitted',
                    'revision',
                    'approved',
                ]
            )
            ->whereHas(
                'project',
                fn (Builder $projectQuery) =>
                    $projectQuery->where(
                        'mandor_id',
                        $mandorId
                    )
            );
    }

    private function statistics(
        int $mandorId
    ): array {
        $query = $this->reportQuery(
            $mandorId
        );

        return [
            'total' => (clone $query)
                ->count(),

            'this_week' => (clone $query)
                ->whereBetween(
                    'report_date',
                    [
                        now()
                            ->startOfWeek()
                            ->toDateString(),

                        now()
                            ->endOfWeek()
                            ->toDateString(),
                    ]
                )
                ->count(),

            'submitted' => (clone $query)
                ->where(
                    'status',
                    'submitted'
                )
                ->count(),

            'revision' => (clone $query)
                ->where(
                    'status',
                    'revision'
                )
                ->count(),

            'approved' => (clone $query)
                ->where(
                    'status',
                    'approved'
                )
                ->count(),

            'with_obstacles' => DailyReport::query()
                ->whereIn(
                    'status',
                    [
                        'submitted',
                        'revision',
                        'approved',
                    ]
                )
                ->whereHas(
                    'project',
                    fn (Builder $projectQuery) =>
                        $projectQuery->where(
                            'mandor_id',
                            $mandorId
                        )
                )
                ->whereNotNull('obstacles')
                ->where(
                    'obstacles',
                    '!=',
                    ''
                )
                ->count(),

            'reported_projects' => (clone $query)
                ->distinct()
                ->count('project_id'),
        ];
    }

    private function applySearch(
        Builder $query
    ): void {
        $search = trim(
            $this->search
        );

        if ($search === '') {
            return;
        }

        $searchValue = '%' . $search . '%';

        $query->where(
            function (Builder $query) use (
                $searchValue
            ): void {
                $query
                    ->where(
                        'report_number',
                        'like',
                        $searchValue
                    )
                    ->orWhere(
                        'activities',
                        'like',
                        $searchValue
                    )
                    ->orWhere(
                        'obstacles',
                        'like',
                        $searchValue
                    )
                    ->orWhere(
                        'notes',
                        'like',
                        $searchValue
                    )
                    ->orWhereHas(
                        'project',
                        function (
                            Builder $projectQuery
                        ) use (
                            $searchValue
                        ): void {
                            $projectQuery
                                ->where(
                                    'project_code',
                                    'like',
                                    $searchValue
                                )
                                ->orWhere(
                                    'project_name',
                                    'like',
                                    $searchValue
                                );
                        }
                    )
                    ->orWhereHas(
                        'task',
                        function (
                            Builder $taskQuery
                        ) use (
                            $searchValue
                        ): void {
                            $taskQuery
                                ->where(
                                    'task_code',
                                    'like',
                                    $searchValue
                                )
                                ->orWhere(
                                    'title',
                                    'like',
                                    $searchValue
                                );
                        }
                    )
                    ->orWhereHas(
                        'user',
                        fn (Builder $userQuery) =>
                            $userQuery->where(
                                'name',
                                'like',
                                $searchValue
                            )
                    );
            }
        );
    }

    private function applyProjectFilter(
        Builder $query,
        array $allowedProjectIds
    ): void {
        if ($this->projectFilter === '') {
            return;
        }

        if (
            ! ctype_digit(
                $this->projectFilter
            )
            || ! in_array(
                (int) $this->projectFilter,
                array_map(
                    'intval',
                    $allowedProjectIds
                ),
                true
            )
        ) {
            $query->whereRaw('1 = 0');

            return;
        }

        $query->where(
            'project_id',
            (int) $this->projectFilter
        );
    }

    private function applyStatusFilter(
        Builder $query
    ): void {
        if ($this->status === '') {
            return;
        }

        if (
            ! in_array(
                $this->status,
                [
                    'submitted',
                    'revision',
                    'approved',
                ],
                true
            )
        ) {
            $query->whereRaw('1 = 0');

            return;
        }

        $query->where(
            'status',
            $this->status
        );
    }

    private function applySorting(
        Builder $query
    ): void {
        match ($this->sort) {
            'oldest' => $query
                ->orderBy('report_date')
                ->orderBy('id'),

            'progress_highest' => $query
                ->orderByDesc('reported_progress')
                ->orderByDesc('report_date')
                ->orderByDesc('id'),

            'progress_lowest' => $query
                ->orderBy('reported_progress')
                ->orderByDesc('report_date')
                ->orderByDesc('id'),

            default => $query
                ->orderByDesc('report_date')
                ->orderByDesc('submitted_at')
                ->orderByDesc('id'),
        };
    }
}