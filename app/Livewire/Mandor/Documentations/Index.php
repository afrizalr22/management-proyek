<?php

namespace App\Livewire\Mandor\Documentations;

use App\Models\Documentation;
use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public Project $project;

    public string $search = '';

    public string $category = '';

    public string $taskFilter = '';

    public string $sort = 'newest';

    public int $perPage = 9;

    protected $queryString = [
        'search' => [
            'except' => '',
        ],

        'category' => [
            'except' => '',
        ],

        'taskFilter' => [
            'except' => '',
            'as' => 'task',
        ],

        'sort' => [
            'except' => 'newest',
        ],
    ];

    public function mount(
        Project $project
    ): void {
        $this->authorizeProject($project);

        $this->project = $project;
    }

    public function updated(
    string $property
    ): void {
        if (
            in_array(
                $property,
                [
                    'search',
                    'category',
                    'taskFilter',
                    'sort',
                    'perPage',
                ],
                true
            )
        ) {
            $this->resetPage();
        }
    }

    public function resetFilters(): void
    {
        $this->reset([
            'search',
            'category',
            'taskFilter',
        ]);

        $this->sort = 'newest';

        $this->resetPage();
    }

    public function render()
    {
        $this->authorizeProject(
            $this->project
        );

        $documentationQuery = Documentation::query()
            ->where(
                'project_id',
                $this->project->id
            )
            ->with([
                'task:id,project_id,task_code,title,location',
                'dailyReport:id,project_id,report_number,status',
                'user:id,name,email,status',
            ]);

        $this->applySearch(
            $documentationQuery
        );

        $this->applyCategoryFilter(
            $documentationQuery
        );

        $this->applyTaskFilter(
            $documentationQuery
        );

        $this->applySorting(
            $documentationQuery
        );

        $documentations = $documentationQuery
            ->paginate($this->perPage);

        $documentations
            ->getCollection()
            ->transform(
                function (
                    Documentation $documentation
                ): Documentation {
                    $photoExists = filled(
                        $documentation->photo
                    ) && Storage::disk('public')
                        ->exists(
                            $documentation->photo
                        );

                    $documentation->setAttribute(
                        'photo_exists',
                        $photoExists
                    );

                    $documentation->setAttribute(
                        'photo_url',
                        $photoExists
                            ? Storage::disk('public')->url(
                                $documentation->photo
                            )
                            : null
                    );

                    return $documentation;
                }
            );

        $categories = Documentation::query()
            ->where(
                'project_id',
                $this->project->id
            )
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $tasks = $this->project
            ->tasks()
            ->whereHas('documentations')
            ->orderBy('title')
            ->get([
                'id',
                'project_id',
                'task_code',
                'title',
            ]);

        $totalDocumentations = Documentation::query()
            ->where(
                'project_id',
                $this->project->id
            )
            ->count();

        return view(
            'livewire.mandor.documentations.index',
            [
                'documentations' => $documentations,
                'categories' => $categories,
                'tasks' => $tasks,
                'totalDocumentations' => $totalDocumentations,
                'filteredDocumentations' => $documentations->total(),

                'hasActiveFilters' => filled($this->search)
                || filled($this->category)
                || filled($this->taskFilter)
                || $this->sort !== 'newest',
            ]
        );
    }

    private function applySearch(
        Builder $query
    ): void {
        $keyword = trim(
            $this->search
        );

        if ($keyword === '') {
            return;
        }

        $escapedKeyword = addcslashes(
            $keyword,
            '%_\\'
        );

        $searchTerm = '%' . $escapedKeyword . '%';

        $query->where(
            function (Builder $query) use (
                $searchTerm
            ): void {
                $query
                    ->where(
                        'title',
                        'like',
                        $searchTerm
                    )
                    ->orWhere(
                        'description',
                        'like',
                        $searchTerm
                    )
                    ->orWhere(
                        'original_name',
                        'like',
                        $searchTerm
                    )
                    ->orWhere(
                        'category',
                        'like',
                        $searchTerm
                    )
                    ->orWhereHas(
                        'task',
                        function (
                            Builder $taskQuery
                        ) use (
                            $searchTerm
                        ): void {
                            $taskQuery
                                ->where(
                                    'task_code',
                                    'like',
                                    $searchTerm
                                )
                                ->orWhere(
                                    'title',
                                    'like',
                                    $searchTerm
                                )
                                ->orWhere(
                                    'location',
                                    'like',
                                    $searchTerm
                                );
                        }
                    )
                    ->orWhereHas(
                        'user',
                        fn (Builder $userQuery) =>
                            $userQuery->where(
                                'name',
                                'like',
                                $searchTerm
                            )
                    )
                    ->orWhereHas(
                        'dailyReport',
                        fn (Builder $reportQuery) =>
                            $reportQuery->where(
                                'report_number',
                                'like',
                                $searchTerm
                            )
                    );
            }
        );
    }

    private function applyCategoryFilter(
        Builder $query
    ): void {
        if ($this->category === '') {
            return;
        }

        $query->where(
            'category',
            $this->category
        );
    }

    private function applyTaskFilter(
        Builder $query
    ): void {
        if ($this->taskFilter === '') {
            return;
        }

        if (! ctype_digit($this->taskFilter)) {
            $query->whereRaw('1 = 0');

            return;
        }

        $query->where(
            'task_id',
            (int) $this->taskFilter
        );
    }

    private function applySorting(
    Builder $query
    ): void {
        match ($this->sort) {
            'oldest' => $query
                ->orderBy('documentation_date')
                ->orderBy('taken_at')
                ->orderBy('id'),

            'title' => $query
                ->orderBy('title')
                ->orderByDesc('documentation_date')
                ->orderByDesc('id'),

            default => $query
                ->orderByDesc('documentation_date')
                ->orderByDesc('taken_at')
                ->orderByDesc('id'),
        };
    }

    private function authorizeProject(
        Project $project
    ): void {
        abort_unless(
            (int) $project->mandor_id
                === (int) Auth::id(),
            403
        );
    }
}