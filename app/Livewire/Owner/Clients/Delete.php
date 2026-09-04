<?php

namespace App\Livewire\Owner\Clients;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Delete extends Component
{
    public Client $client;

    public int $projectsCount = 0;

    public int $quotationsCount = 0;

    public function mount(Client $client): void
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User && $user->can('delete clients'),
            403
        );

        $this->client = $client;

        $this->refreshRelationCounts();
    }

    public function delete(): void
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User && $user->can('delete clients'),
            403
        );

        $this->refreshRelationCounts();

        if ($this->hasRelatedData()) {
            session()->flash(
                'error',
                'Client tidak dapat dihapus karena sudah memiliki quotation atau proyek.'
            );

            $this->redirectRoute(
                'owner.clients.show',
                ['client' => $this->client->id],
                navigate: true
            );

            return;
        }

        try {
            $companyName = $this->client->company_name;

            $this->client->delete();

            session()->flash(
                'success',
                "Client {$companyName} berhasil dihapus."
            );

            $this->redirectRoute(
                'owner.clients.index',
                navigate: true
            );
        } catch (QueryException) {
            session()->flash(
                'error',
                'Client tidak dapat dihapus karena masih digunakan oleh data lain.'
            );

            $this->redirectRoute(
                'owner.clients.show',
                ['client' => $this->client->id],
                navigate: true
            );
        }
    }

    public function hasRelatedData(): bool
    {
        return $this->projectsCount > 0
            || $this->quotationsCount > 0;
    }

    private function refreshRelationCounts(): void
    {
        $this->projectsCount = $this->client
            ->projects()
            ->count();

        $this->quotationsCount = $this->client
            ->quotations()
            ->count();
    }

    public function render()
    {
        return view('livewire.owner.clients.delete');
    }
}