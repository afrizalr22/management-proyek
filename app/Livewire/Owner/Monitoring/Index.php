<?php

namespace App\Livewire\Owner\Monitoring;

use App\Models\Project;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url(as: 'q', except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $status = '';

    #[Url(as: 'mandor', except: '')]
    public string $mandorId = '';

    #[Url(except: 'latest')]
    public string $sort = 'latest';

    public function mount(): void
    {
        Gate::authorize(
            'view-any projects'
        );

        $this->normalizeFilters();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->normalizeFilters();
        $this->resetPage();
    }

    public function updatedMandorId(): void
    {
        $this->resetPage();
    }

    public function updatedSort(): void
    {
        $this->normalizeFilters();
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset([
            'search',
            'status',
            'mandorId',
        ]);

        $this->sort = 'latest';

        $this->resetPage();
    }

    private function normalizeFilters(): void
    {
        $validStatuses = [
            '',
            'planning',
            'in_progress',
            'completed',
            'on_hold',
            'cancelled',
            'delayed',
        ];

        $validSorts = [
            'latest',
            'oldest',
            'progress_desc',
            'progress_asc',
            'deadline_asc',
            'deadline_desc',
            'name_asc',
            'name_desc',
        ];

        if (
            !in_array(
                $this->status,
                $validStatuses,
                true
            )
        ) {
            $this->status = '';
        }

        if (
            !in_array(
                $this->sort,
                $validSorts,
                true
            )
        ) {
            $this->sort = 'latest';
        }

        if (
            $this->mandorId !== ''
            && !ctype_digit($this->mandorId)
        ) {
            $this->mandorId = '';
        }
    }

    private function projectQuery(): Builder
    {
        return Project::query()
            ->with([
                'client:id,company_name',

                'mandor:id,name,email,phone',

                'tasks' => fn ($query) => $query
                    ->select([
                        'id',
                        'project_id',
                        'task_code',
                        'title',
                        'status',
                        'progress',
                        'due_at',
                        'updated_at',
                    ])
                    ->orderByDesc('updated_at')
                    ->orderByDesc('id'),
            ])
            ->withCount([
                'workers as active_workers_count' =>
                    fn ($query) => $query
                        ->where(
                            'project_workers.status',
                            'active'
                        ),

                'tasks',

                'dailyReports as reports_count',

                'documentations as photos_count',

                'dailyReports as issues_count' =>
                    fn ($query) => $query
                        ->whereNotNull('obstacles')
                        ->where(
                            'obstacles',
                            '!=',
                            ''
                        ),
            ])
            ->when(
                trim($this->search) !== '',
                function (Builder $query): void {
                    $search = trim(
                        $this->search
                    );

                    $query->where(
                        function (
                            Builder $query
                        ) use ($search): void {
                            $query
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
                                )
                                ->orWhereHas(
                                    'client',
                                    fn (Builder $query) =>
                                        $query->where(
                                            'company_name',
                                            'like',
                                            "%{$search}%"
                                        )
                                )
                                ->orWhereHas(
                                    'mandor',
                                    fn (Builder $query) =>
                                        $query->where(
                                            'name',
                                            'like',
                                            "%{$search}%"
                                        )
                                );
                        }
                    );
                }
            )
            ->when(
                $this->status !== '',
                function (Builder $query): void {
                    if (
                        $this->status ===
                        'delayed'
                    ) {
                        $query
                            ->whereNotNull(
                                'end_date'
                            )
                            ->whereDate(
                                'end_date',
                                '<',
                                today()
                            )
                            ->whereNotIn(
                                'status',
                                [
                                    'completed',
                                    'cancelled',
                                ]
                            );

                        return;
                    }

                    $query->where(
                        'status',
                        $this->status
                    );
                }
            )
            ->when(
                $this->mandorId !== '',
                fn (Builder $query) =>
                    $query->where(
                        'mandor_id',
                        (int) $this->mandorId
                    )
            );
    }

    private function projects(): LengthAwarePaginator
    {
        $query = $this->projectQuery();

        match ($this->sort) {
            'oldest' =>
                $query->orderBy('id'),

            'progress_desc' =>
                $query
                    ->orderByDesc('progress')
                    ->orderByDesc('id'),

            'progress_asc' =>
                $query
                    ->orderBy('progress')
                    ->orderByDesc('id'),

            'deadline_asc' =>
                $query
                    ->orderByRaw(
                        'CASE WHEN end_date IS NULL THEN 1 ELSE 0 END'
                    )
                    ->orderBy('end_date')
                    ->orderByDesc('id'),

            'deadline_desc' =>
                $query
                    ->orderByRaw(
                        'CASE WHEN end_date IS NULL THEN 1 ELSE 0 END'
                    )
                    ->orderByDesc('end_date')
                    ->orderByDesc('id'),

            'name_asc' =>
                $query->orderBy(
                    'project_name'
                ),

            'name_desc' =>
                $query->orderByDesc(
                    'project_name'
                ),

            default =>
                $query->orderByDesc('id'),
        };

        return $query
            ->paginate(6)
            ->withQueryString();
    }

    private function statistics(): array
    {
        $baseQuery = Project::query();

        return [
            'total' =>
                (clone $baseQuery)->count(),

            'in_progress' =>
                (clone $baseQuery)
                    ->whereIn(
                        'status',
                        [
                            'in_progress',
                            'ongoing',
                        ]
                    )
                    ->count(),

            'completed' =>
                (clone $baseQuery)
                    ->where(
                        'status',
                        'completed'
                    )
                    ->count(),

            'delayed' =>
                (clone $baseQuery)
                    ->whereNotNull('end_date')
                    ->whereDate(
                        'end_date',
                        '<',
                        today()
                    )
                    ->whereNotIn(
                        'status',
                        [
                            'completed',
                            'cancelled',
                        ]
                    )
                    ->count(),
        ];
    }

    private function mandors(): Collection
    {
        return User::query()
            ->role('mandor')
            ->whereHas('managedProjects')
            ->withCount('managedProjects')
            ->orderBy('name')
            ->get([
                'id',
                'name',
            ]);
    }

    public function render()
    {
        return view(
            'livewire.owner.monitoring.index',
            [
                'projects' =>
                    $this->projects(),

                'statistics' =>
                    $this->statistics(),

                'mandors' =>
                    $this->mandors(),
            ]
        );
    }
}