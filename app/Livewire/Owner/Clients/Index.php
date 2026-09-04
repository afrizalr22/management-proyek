<?php

namespace App\Livewire\Owner\Clients;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $status = '';

    public string $sort = 'latest';

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
        $clients = Client::query()
            ->withCount([
                'projects',
                'quotations',
            ])
            ->when(
                $this->search !== '',
                function ($query) {
                    $search = '%'.$this->search.'%';

                    $query->where(function ($query) use ($search) {
                        $query
                            ->where('company_name', 'like', $search)
                            ->orWhere('contact_person', 'like', $search)
                            ->orWhere('email', 'like', $search)
                            ->orWhere('phone', 'like', $search)
                            ->orWhere('city', 'like', $search);
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
                fn ($query) => $query->latest()
            )
            ->when(
                $this->sort === 'oldest',
                fn ($query) => $query->oldest()
            )
            ->when(
                $this->sort === 'company_asc',
                fn ($query) => $query->orderBy('company_name')
            )
            ->when(
                $this->sort === 'company_desc',
                fn ($query) => $query->orderByDesc('company_name')
            )
            ->paginate(10);

        return view('livewire.owner.clients.index', [
            'clients' => $clients,
        ]);
    }
}