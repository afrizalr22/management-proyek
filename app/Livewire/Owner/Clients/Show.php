<?php

namespace App\Livewire\Owner\Clients;

use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public Client $client;

    public function mount(Client $client): void
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User
                && $user->can('view clients'),
            403
        );

        $this->client = $client;
    }

    public function render()
    {
        $client = Client::query()
            ->withCount([
                'projects',

                'projects as active_projects_count' => function ($query) {
                    $query->whereIn('status', [
                        'planning',
                        'on_progress',
                    ]);
                },

                'projects as completed_projects_count' => function ($query) {
                    $query->where('status', 'completed');
                },
            ])
            ->withSum('projects', 'contract_value')
            ->findOrFail($this->client->id);

        $recentProjects = $client->projects()
            ->latest('created_at')
            ->limit(3)
            ->get();

        return view('livewire.owner.clients.show', [
            'client' => $client,
            'recentProjects' => $recentProjects,
        ]);
    }
}