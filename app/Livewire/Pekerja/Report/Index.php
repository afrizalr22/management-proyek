<?php

namespace App\Livewire\Pekerja\Report;

use App\Models\DailyReport;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $status = '';

    public string $period = '';

    public string $sort = 'newest';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function updatedPeriod(): void
    {
        $this->resetPage();
    }

    public function updatedSort(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset([
            'search',
            'status',
            'period',
        ]);

        $this->sort = 'newest';

        $this->resetPage();
    }

    public function render()
    {
        $baseQuery = $this->reportQuery();

        $reports = $this
            ->applyFilters(
                clone $baseQuery
            )
            ->with([
                'task:id,project_id,task_code,title,location',
                'project:id,project_code,project_name,location',
            ])
            ->when(
                $this->sort === 'oldest',
                fn (Builder $query) => $query
                    ->orderBy('report_date')
                    ->orderBy('id'),
                fn (Builder $query) => $query
                    ->orderByDesc('report_date')
                    ->orderByDesc('id')
            )
            ->paginate(5);

        $now = now('Asia/Jakarta');

        $statistics = [
            'total' => (clone $baseQuery)->count(),

            'current_month' => (clone $baseQuery)
                ->whereBetween(
                    'report_date',
                    [
                        $now->copy()->startOfMonth()->toDateString(),
                        $now->copy()->endOfMonth()->toDateString(),
                    ]
                )
                ->count(),

            'approved' => (clone $baseQuery)
                ->where(
                    'status',
                    'approved'
                )
                ->count(),

            'submitted' => (clone $baseQuery)
                ->where(
                    'status',
                    'submitted'
                )
                ->count(),
        ];

        return view(
            'livewire.pekerja.report.index',
            [
                'reports' => $reports,
                'statistics' => $statistics,
            ]
        );
    }

    private function reportQuery(): Builder
    {
        return DailyReport::query()
            ->where(
                'user_id',
                Auth::id()
            );
    }

    private function applyFilters(
        Builder $query
    ): Builder {
        $search = trim(
            $this->search
        );

        if ($search !== '') {
            $query->where(
                function (Builder $query) use ($search): void {
                    $query
                        ->where(
                            'report_number',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'activities',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhereHas(
                            'task',
                            function (Builder $taskQuery) use ($search): void {
                                $taskQuery
                                    ->where(
                                        'task_code',
                                        'like',
                                        "%{$search}%"
                                    )
                                    ->orWhere(
                                        'title',
                                        'like',
                                        "%{$search}%"
                                    )
                                    ->orWhere(
                                        'location',
                                        'like',
                                        "%{$search}%"
                                    );
                            }
                        )
                        ->orWhereHas(
                            'project',
                            function (Builder $projectQuery) use ($search): void {
                                $projectQuery
                                    ->where(
                                        'project_code',
                                        'like',
                                        "%{$search}%"
                                    )
                                    ->orWhere(
                                        'project_name',
                                        'like',
                                        "%{$search}%"
                                    )
                                    ->orWhere(
                                        'location',
                                        'like',
                                        "%{$search}%"
                                    );
                            }
                        );
                }
            );
        }

        if (
            in_array(
                $this->status,
                [
                    'draft',
                    'submitted',
                    'revision',
                    'approved',
                ],
                true
            )
        ) {
            $query->where(
                'status',
                $this->status
            );
        }

        $now = now('Asia/Jakarta');

        if ($this->period === 'current_month') {
            $query->whereBetween(
                'report_date',
                [
                    $now->copy()->startOfMonth()->toDateString(),
                    $now->copy()->endOfMonth()->toDateString(),
                ]
            );
        }

        if ($this->period === 'last_month') {
            $lastMonth = $now
                ->copy()
                ->subMonth();

            $query->whereBetween(
                'report_date',
                [
                    $lastMonth->copy()->startOfMonth()->toDateString(),
                    $lastMonth->copy()->endOfMonth()->toDateString(),
                ]
            );
        }

        if ($this->period === 'last_three_months') {
            $query->whereBetween(
                'report_date',
                [
                    $now
                        ->copy()
                        ->subMonths(2)
                        ->startOfMonth()
                        ->toDateString(),

                    $now
                        ->copy()
                        ->endOfMonth()
                        ->toDateString(),
                ]
            );
        }

        return $query;
    }
}