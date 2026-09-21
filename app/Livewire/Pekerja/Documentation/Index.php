<?php

namespace App\Livewire\Pekerja\Documentation;

use App\Models\Documentation;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    private const CATEGORIES = [
        'progress',
        'material',
        'safety',
        'obstacle',
        'other',
    ];

    private const SORT_OPTIONS = [
        'newest',
        'oldest',
        'title',
        'task',
    ];

    #[Url(except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $task = '';

    #[Url(except: '')]
    public string $category = '';

    #[Url(except: 'newest')]
    public string $sort = 'newest';

    public function mount(): void
    {
        $this->authenticatedWorker();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedTask(): void
    {
        $this->resetPage();
    }

    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    public function updatedSort(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {

        $this->sort = 'newest';

        $this->resetPage();
    }

    /**
     * Query dasar yang selalu dibatasi pada Pekerja login.
     */
    private function documentationQuery(): Builder
    {
        return Documentation::query()
            ->where(
                'user_id',
                $this->authenticatedWorker()->id
            );
    }

    /**
     * Memastikan pengguna adalah Pekerja aktif.
     */
    private function authenticatedWorker(): User
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User
                && $user->hasRole('pekerja')
                && $user->isActive(),
            403
        );

        return $user;
    }

    public function render()
    {
        $worker = $this->authenticatedWorker();

        $search = trim($this->search);

        $selectedTaskId =
            ctype_digit($this->task)
                ? (int) $this->task
                : null;

        $selectedCategory =
            in_array(
                $this->category,
                self::CATEGORIES,
                true
            )
                ? $this->category
                : null;

        $selectedSort =
            in_array(
                $this->sort,
                self::SORT_OPTIONS,
                true
            )
                ? $this->sort
                : 'newest';

        $documentations = $this
            ->documentationQuery()
            ->with([
                'task:id,project_id,task_code,title,location',
                'project:id,project_code,project_name,location',
                'dailyReport:id,report_number',
            ])
            ->when(
                $search !== '',
                function (Builder $query) use ($search): void {
                    $query->where(
                        function (Builder $searchQuery) use ($search): void {
                            $searchQuery
                                ->where(
                                    'title',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'description',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'original_name',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhereHas(
                                    'task',
                                    function (Builder $taskQuery) use ($search): void {
                                        $taskQuery
                                            ->where(
                                                'title',
                                                'like',
                                                "%{$search}%"
                                            )
                                            ->orWhere(
                                                'task_code',
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
                                                'project_name',
                                                'like',
                                                "%{$search}%"
                                            )
                                            ->orWhere(
                                                'project_code',
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
            )
            ->when(
                $selectedTaskId,
                fn (Builder $query) => $query->where(
                    'task_id',
                    $selectedTaskId
                )
            )
            ->when(
                $selectedCategory,
                fn (Builder $query) => $query->where(
                    'category',
                    $selectedCategory
                )
            )
            ->when(
                $selectedSort === 'oldest',
                fn (Builder $query) => $query
                    ->oldest('documentation_date')
                    ->oldest('taken_at')
                    ->oldest('id')
            )
            ->when(
                $selectedSort === 'title',
                fn (Builder $query) => $query
                    ->orderBy('title')
                    ->latest('documentation_date')
                    ->latest('id')
            )
            ->when(
                $selectedSort === 'task',
                fn (Builder $query) => $query
                    ->orderByRaw(
                        'CASE WHEN task_id IS NULL THEN 1 ELSE 0 END'
                    )
                    ->orderBy('task_id')
                    ->latest('documentation_date')
                    ->latest('id')
            )
            ->when(
                $selectedSort === 'newest',
                fn (Builder $query) => $query
                    ->latest('documentation_date')
                    ->latest('taken_at')
                    ->latest('id')
            )
            ->paginate(9);

        $taskOptions = $this
            ->documentationQuery()
            ->whereNotNull('task_id')
            ->with('task:id,task_code,title')
            ->select('task_id')
            ->distinct()
            ->get()
            ->pluck('task')
            ->filter()
            ->unique('id')
            ->sortBy('title')
            ->values();

        $categoryCounts = $this
            ->documentationQuery()
            ->selectRaw(
                'category, COUNT(*) as total'
            )
            ->groupBy('category')
            ->pluck(
                'total',
                'category'
            );

        return view(
            'livewire.pekerja.documentation.index',
            [
                'worker' => $worker,

                'documentations' => $documentations,

                'taskOptions' => $taskOptions,

                'categoryCounts' => $categoryCounts,

                'totalDocumentations' => $categoryCounts->sum(),
            ]
        );
    }
}
