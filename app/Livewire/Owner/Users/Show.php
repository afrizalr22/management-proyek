<?php

namespace App\Livewire\Owner\Users;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Show extends Component
{
    public User $user;

    public function mount(User $user): void
    {
        $this->authorizeViewUser();

        $this->user = $user;

        $this->loadUserData();
    }

    private function authorizeViewUser(): void
    {
        Gate::authorize('view users');
    }

    private function loadUserData(): void
    {
        $this->user->load([
            'roles:id,name',

            'managedProjects' => fn ($query) => $query
                ->with('client')
                ->latest('id'),

            'projectAssignments' => fn ($query) => $query
                ->with([
                    'project.client',
                    'assignedBy:id,name',
                ])
                ->latest('id'),
        ]);
    }

    private function projectHistory(): Collection
    {
        if ($this->user->hasRole('mandor')) {
            return $this->user->managedProjects
                ->map(fn ($project): array => [
                    'id' => $project->id,
                    'code' => $project->project_code,
                    'name' => $project->project_name,
                    'client' => $project->client?->name
                        ?? $project->client?->company_name
                        ?? '-',
                    'role' => 'Mandor',
                    'status' => $project->status,
                    'start_date' => $project->start_date,
                    'end_date' => $project->end_date,
                    'assignment_status' => null,
                    'joined_at' => null,
                    'ended_at' => null,
                ]);
        }

        if ($this->user->hasRole('pekerja')) {
            return $this->user->projectAssignments
                ->map(fn ($assignment): array => [
                    'id' => $assignment->project?->id,
                    'code' => $assignment->project?->project_code,
                    'name' => $assignment->project?->project_name
                        ?? 'Project tidak ditemukan',
                    'client' => $assignment->project?->client?->name
                        ?? $assignment->project?->client?->company_name
                        ?? '-',
                    'role' => 'Pekerja',
                    'status' => $assignment->project?->status,
                    'start_date' => $assignment->project?->start_date,
                    'end_date' => $assignment->project?->end_date,
                    'assignment_status' => $assignment->status,
                    'joined_at' => $assignment->joined_at,
                    'ended_at' => $assignment->ended_at,
                ]);
        }

        return collect();
    }

    private function recentActivities(): Collection
    {
        $activities = collect();

        if ($this->user->hasRole('mandor')) {
            foreach ($this->user->managedProjects as $project) {
                $activities->push([
                    'title' => 'Ditugaskan sebagai Mandor',
                    'description' => $project->project_name,
                    'date' => $project->created_at,
                    'color' => 'blue',
                ]);
            }
        }

        if ($this->user->hasRole('pekerja')) {
            foreach ($this->user->projectAssignments as $assignment) {
                $activities->push([
                    'title' => $assignment->status === 'active'
                        ? 'Ditugaskan ke Project'
                        : 'Penugasan Project Selesai',
                    'description' => $assignment->project?->project_name
                        ?? 'Project tidak ditemukan',
                    'date' => $assignment->status === 'inactive'
                        ? ($assignment->ended_at ?? $assignment->updated_at)
                        : ($assignment->joined_at ?? $assignment->created_at),
                    'color' => $assignment->status === 'active'
                        ? 'green'
                        : 'gray',
                ]);
            }
        }

        $activities->push([
            'title' => 'Akun Pengguna Dibuat',
            'description' => 'Pengguna terdaftar dalam sistem.',
            'date' => $this->user->created_at,
            'color' => 'blue',
        ]);

        return $activities
            ->filter(fn (array $activity): bool => !empty($activity['date']))
            ->sortByDesc('date')
            ->take(5)
            ->values();
    }

    public function render()
    {
        $role = $this->user->roles->first()?->name ?? '-';

        return view('livewire.owner.users.show', [
            'role' => $role,
            'projectHistory' => $this->projectHistory(),
            'recentActivities' => $this->recentActivities(),
        ]);
    }
}