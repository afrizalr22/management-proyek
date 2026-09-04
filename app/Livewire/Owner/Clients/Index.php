<?php

namespace App\Livewire\Owner\Clients;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    public bool $showDeleteModal = false;

    public ?int $selectedClientId = null;

    public string $selectedClientName = '';

    public int $selectedProjectsCount = 0;

    public int $selectedQuotationsCount = 0;

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

    public function confirmDelete(int $clientId): void
{
    $user = Auth::user();

    abort_unless(
        $user instanceof User && $user->can('delete clients'),
        403
    );

    $client = Client::query()
        ->withCount([
            'projects',
            'quotations',
        ])
        ->findOrFail($clientId);

    $this->selectedClientId = $client->id;
    $this->selectedClientName = $client->company_name;
    $this->selectedProjectsCount = $client->projects_count;
    $this->selectedQuotationsCount = $client->quotations_count;
    $this->showDeleteModal = true;
}

public function cancelDelete(): void
{
    $this->resetDeleteModal();
}

public function deleteClient(): void
{
    $user = Auth::user();

    abort_unless(
        $user instanceof User && $user->can('delete clients'),
        403
    );

    if ($this->selectedClientId === null) {
        $this->resetDeleteModal();

        return;
    }

    $client = Client::query()
        ->withCount([
            'projects',
            'quotations',
        ])
        ->find($this->selectedClientId);

    if (!$client) {
        $this->resetDeleteModal();

        session()->flash('notification', [
            'type' => 'error',
            'message' => 'Data client tidak ditemukan.',
        ]);

        return;
    }

    if (
        $client->projects_count > 0 ||
        $client->quotations_count > 0
    ) {
        $this->resetDeleteModal();

        session()->flash('notification', [
            'type' => 'error',
            'message' => 'Client tidak dapat dihapus karena sudah memiliki quotation atau proyek.',
        ]);

        return;
    }

    try {
        $companyName = $client->company_name;

        $client->delete();

        $this->resetDeleteModal();
        $this->resetPage();

        session()->flash('notification', [
            'type' => 'delete',
            'message' => "Client {$companyName} berhasil dihapus.",
        ]);
    } catch (QueryException) {
        $this->resetDeleteModal();

        session()->flash('notification', [
            'type' => 'error',
            'message' => 'Client tidak dapat dihapus karena masih digunakan oleh data lain.',
        ]);
    }
}

private function resetDeleteModal(): void
{
    $this->showDeleteModal = false;
    $this->selectedClientId = null;
    $this->selectedClientName = '';
    $this->selectedProjectsCount = 0;
    $this->selectedQuotationsCount = 0;
}
}