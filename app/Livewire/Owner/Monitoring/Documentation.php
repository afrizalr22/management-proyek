<?php

namespace App\Livewire\Owner\Monitoring;

use App\Models\Documentation as DocumentationModel;
use App\Models\Project;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Documentation extends Component
{
    use WithPagination;

    public Project $project;

    #[Url(as: 'q', except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $category = '';

    #[Url(except: '')]
    public string $date = '';

    #[Url(except: 'latest')]
    public string $sort = 'latest';

    public function mount(Project $project): void
    {
        Gate::authorize('view projects');

        $this->project = $project;
    }

    protected function rules(): array
    {
        return [
            'search' => [
                'nullable',
                'string',
                'max:255',
            ],

            'category' => [
                'nullable',
                Rule::in([
                    '',
                    'progress',
                    'material',
                    'safety',
                    'obstacle',
                    'other',
                ]),
            ],

            'date' => [
                'nullable',
                'date',
            ],

            'sort' => [
                'required',
                Rule::in([
                    'latest',
                    'oldest',
                    'title_asc',
                    'title_desc',
                ]),
            ],
        ];
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCategory(): void
    {
        $this->validateOnly('category');
        $this->resetPage();
    }

    public function updatedDate(): void
    {
        $this->validateOnly('date');
        $this->resetPage();
    }

    public function updatedSort(): void
    {
        $this->validateOnly('sort');
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset([
            'search',
            'category',
            'date',
            'sort',
        ]);

        $this->sort = 'latest';

        $this->resetValidation();
        $this->resetPage();
    }

    public function render()
    {
        $this->validate();

        $documentations = DocumentationModel::query()
            ->where(
                'project_id',
                $this->project->id
            )
            ->with([
                'task:id,task_code,title',
                'dailyReport:id,report_number',
                'user:id,name',
            ])
            ->when(
                filled($this->search),
                function ($query): void {
                    $search = trim($this->search);

                    $query->where(
                        function ($query) use ($search): void {
                            $query
                                ->where(
                                    'title',
                                    'like',
                                    '%'.$search.'%'
                                )
                                ->orWhere(
                                    'description',
                                    'like',
                                    '%'.$search.'%'
                                )
                                ->orWhere(
                                    'original_name',
                                    'like',
                                    '%'.$search.'%'
                                )
                                ->orWhereHas(
                                    'task',
                                    fn ($query) => $query
                                        ->where(
                                            'title',
                                            'like',
                                            '%'.$search.'%'
                                        )
                                        ->orWhere(
                                            'task_code',
                                            'like',
                                            '%'.$search.'%'
                                        )
                                )
                                ->orWhereHas(
                                    'user',
                                    fn ($query) => $query
                                        ->where(
                                            'name',
                                            'like',
                                            '%'.$search.'%'
                                        )
                                );
                        }
                    );
                }
            )
            ->when(
                filled($this->category),
                fn ($query) => $query->where(
                    'category',
                    $this->category
                )
            )
            ->when(
                filled($this->date),
                fn ($query) => $query->whereDate(
                    'documentation_date',
                    $this->date
                )
            )
            ->when(
                $this->sort === 'latest',
                fn ($query) => $query
                    ->orderByDesc('documentation_date')
                    ->orderByDesc('taken_at')
                    ->orderByDesc('id')
            )
            ->when(
                $this->sort === 'oldest',
                fn ($query) => $query
                    ->orderBy('documentation_date')
                    ->orderBy('taken_at')
                    ->orderBy('id')
            )
            ->when(
                $this->sort === 'title_asc',
                fn ($query) => $query
                    ->orderBy('title')
                    ->orderByDesc('id')
            )
            ->when(
                $this->sort === 'title_desc',
                fn ($query) => $query
                    ->orderByDesc('title')
                    ->orderByDesc('id')
            )
            ->paginate(12);

        $totalDocumentations = DocumentationModel::query()
            ->where(
                'project_id',
                $this->project->id
            )
            ->count();

        $categoryStatistics = DocumentationModel::query()
            ->where(
                'project_id',
                $this->project->id
            )
            ->selectRaw(
                'category, COUNT(*) as total'
            )
            ->groupBy('category')
            ->pluck(
                'total',
                'category'
            );

        return view(
            'livewire.owner.monitoring.documentation',
            [
                'documentations' =>
                    $documentations,

                'totalDocumentations' =>
                    $totalDocumentations,

                'categoryStatistics' =>
                    $categoryStatistics,
            ]
        );
    }
}