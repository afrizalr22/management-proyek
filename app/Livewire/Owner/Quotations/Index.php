<?php

namespace App\Livewire\Owner\Quotations;

use App\Models\Quotation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $status = '';

    public string $sort = 'latest';

    public function mount(): void
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User
                && $user->can('view-any quotations'),
            403
        );
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
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
            'sort',
        ]);

        $this->sort = 'latest';

        $this->resetPage();
    }

    public function render()
    {
        $quotations = Quotation::query()
            ->with([
                'client:id,company_name,contact_person',
                'project:id,project_name',
            ])
            ->when(
                $this->search !== '',
                function ($query) {
                    $search = '%' . trim($this->search) . '%';

                    $query->where(function ($query) use ($search) {
                        $query
                            ->where('quotation_number', 'like', $search)
                            ->orWhere('client_name', 'like', $search)
                            ->orWhere('project_name', 'like', $search)
                            ->orWhereHas(
                                'client',
                                fn ($clientQuery) => $clientQuery
                                    ->where('company_name', 'like', $search)
                                    ->orWhere('contact_person', 'like', $search)
                            )
                            ->orWhereHas(
                                'project',
                                fn ($projectQuery) => $projectQuery
                                    ->where('project_name', 'like', $search)
                            );
                    });
                }
            )
            ->when(
                $this->status !== '',
                fn ($query) => $query->where(
                    'status',
                    $this->status
                )
            )
            ->when(
                $this->sort === 'latest',
                fn ($query) => $query
                    ->latest('quotation_date')
                    ->latest('id')
            )
            ->when(
                $this->sort === 'oldest',
                fn ($query) => $query
                    ->oldest('quotation_date')
                    ->oldest('id')
            )
            ->when(
                $this->sort === 'total_highest',
                fn ($query) => $query
                    ->orderByDesc('grand_total')
            )
            ->when(
                $this->sort === 'total_lowest',
                fn ($query) => $query
                    ->orderBy('grand_total')
            )
            ->paginate(10);

        $statistics = [
            'total' => Quotation::query()->count(),

            'draft' => Quotation::query()
                ->where('status', 'draft')
                ->count(),

            'sent' => Quotation::query()
                ->where('status', 'sent')
                ->count(),

            'approved' => Quotation::query()
                ->where('status', 'approved')
                ->count(),
        ];

        return view('livewire.owner.quotations.index', [
            'quotations' => $quotations,
            'statistics' => $statistics,
        ]);
    }
}