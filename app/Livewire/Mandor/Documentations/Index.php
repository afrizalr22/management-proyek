<?php

namespace App\Livewire\Mandor\Documentations;

use App\Models\Documentation;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $projectFilter = '';

    public string $taskFilter = '';

    public string $sort = 'newest';

    public int $perPage = 9;

    protected $queryString = [
        'search' => [
            'except' => '',
        ],

        'projectFilter' => [
            'except' => '',
            'as' => 'project',
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
        ?Project $project = null
    ): void {
        if (! $project) {
            return;
        }

        $this->authorizeProject($project);

        $this->projectFilter = (string) $project->id;
    }

    public function updatedProjectFilter(): void
    {
        $this->taskFilter = '';

        $this->resetPage();
    }

    public function updated(
        string $property
    ): void {
        if (
            in_array(
                $property,
                [
                    'search',
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
            'projectFilter',
            'taskFilter',
        ]);

        $this->sort = 'newest';

        $this->resetPage();
    }

    public function render()
    {
        $documentationQuery = $this
            ->documentationQuery()
            ->with([
                'project:id,project_code,project_name,status',
                'task:id,project_id,task_code,title,location',
                'dailyReport:id,project_id,report_number,status',
                'user:id,name,email,status',
            ]);

        $this->applySearch(
            $documentationQuery
        );

        $this->applyProjectFilter(
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
                            ? asset(
                                'storage/'
                                    .ltrim(
                                        $documentation->photo,
                                        '/'
                                    )
                            )
                            : null
                    );

                    return $documentation;
                }
            );

        $projects = Project::query()
            ->where(
                'mandor_id',
                Auth::id()
            )
            ->whereHas(
                'documentations',
                fn (Builder $query) => $query
                    ->whereNotNull(
                        'daily_report_id'
                    )
                    ->whereHas(
                        'dailyReport',
                        fn (Builder $reportQuery) => $reportQuery
                            ->where(
                                'status',
                                'approved'
                            )
                    )
            )
            ->orderBy('project_name')
            ->get([
                            'id',
                            'project_code',
                            'project_name',
                            'status',
                        ]);

        $tasks = Task::query()
            ->whereHas(
                'project',
                fn (Builder $query) => $query
                    ->where(
                        'mandor_id',
                        Auth::id()
                    )
            )
            ->whereHas(
                'documentations',
                fn (Builder $query) => $query
                    ->whereNotNull(
                        'daily_report_id'
                    )
                    ->whereHas(
                        'dailyReport',
                        fn (Builder $reportQuery) => $reportQuery
                            ->where(
                                'status',
                                'approved'
                            )
                    )
            )
            ->when(
                ctype_digit(
                    $this->projectFilter
                ),
                fn (Builder $query) => $query
                    ->where(
                        'project_id',
                        (int) $this->projectFilter
                    )
            )
            ->orderBy('title')
            ->get([
                'id',
                'project_id',
                'task_code',
                'title',
            ]);

        $totalDocumentations = $this
            ->documentationQuery()
            ->count();

        return view(
            'livewire.mandor.documentations.index',
            [
                'documentations' => $documentations,

                'projects' => $projects,

                'tasks' => $tasks,

                'totalDocumentations' => $totalDocumentations,

                'filteredDocumentations' => $documentations->total(),

                'hasActiveFilters' => filled($this->search)
                || filled($this->projectFilter)
                || filled($this->taskFilter)
                || $this->sort !== 'newest',
            ]
        );
    }

    private function documentationQuery(): Builder
    {
        return Documentation::query()
            ->whereNotNull(
                'daily_report_id'
            )
            ->whereHas(
                'dailyReport',
                fn (Builder $query) => $query
                    ->where(
                        'status',
                        'approved'
                    )
            )
            ->whereHas(
                'project',
                fn (Builder $query) => $query
                    ->where(
                        'mandor_id',
                        Auth::id()
                    )
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

        $searchTerm =
            '%'.$escapedKeyword.'%';

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
                        'project',
                        function (
                            Builder $projectQuery
                        ) use (
                            $searchTerm
                        ): void {
                            $projectQuery
                                ->where(
                                    'project_code',
                                    'like',
                                    $searchTerm
                                )
                                ->orWhere(
                                    'project_name',
                                    'like',
                                    $searchTerm
                                );
                        }
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
                        fn (Builder $userQuery) => $userQuery->where(
                            'name',
                            'like',
                            $searchTerm
                        )
                    )
                    ->orWhereHas(
                        'dailyReport',
                        fn (Builder $reportQuery) => $reportQuery->where(
                            'report_number',
                            'like',
                            $searchTerm
                        )
                    );
            }
        );
    }

    private function applyProjectFilter(
        Builder $query
    ): void {
        if (
            $this->projectFilter === ''
        ) {
            return;
        }

        if (
            ! ctype_digit(
                $this->projectFilter
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

    private function applyTaskFilter(
        Builder $query
    ): void {
        if ($this->taskFilter === '') {
            return;
        }

        if (
            ! ctype_digit(
                $this->taskFilter
            )
        ) {
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
