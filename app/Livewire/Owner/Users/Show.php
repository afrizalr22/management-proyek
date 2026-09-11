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

    /**
     * Mengubah seluruh Project pengguna menjadi
     * struktur data yang seragam.
     */
    private function projectRecords(): Collection
    {
        if ($this->user->hasRole('mandor')) {
            return $this->user->managedProjects
                ->map(fn ($project): array => [
                    'id' => $project->id,
                    'code' => $project->project_code,
                    'name' => $project->project_name,
                    'client' =>
                        $project->client?->name
                        ?? $project->client?->company_name
                        ?? '-',
                    'role' => 'Mandor',
                    'status' => $project->status,
                    'start_date' => $project->start_date,
                    'end_date' => $project->end_date,
                    'assignment_status' => null,
                    'joined_at' => null,
                    'ended_at' => null,
                ])
                ->values();
        }

        if ($this->user->hasRole('pekerja')) {
            return $this->user->projectAssignments
                ->filter(
                    fn ($assignment): bool =>
                        $assignment->project !== null
                )
                ->map(fn ($assignment): array => [
                    'id' => $assignment->project->id,
                    'code' =>
                        $assignment->project->project_code,
                    'name' =>
                        $assignment->project->project_name,
                    'client' =>
                        $assignment->project->client?->name
                        ?? $assignment->project
                            ->client?->company_name
                        ?? '-',
                    'role' => 'Pekerja',
                    'status' =>
                        $assignment->project->status,
                    'start_date' =>
                        $assignment->project->start_date,
                    'end_date' =>
                        $assignment->project->end_date,
                    'assignment_status' =>
                        $assignment->status,
                    'joined_at' =>
                        $assignment->joined_at,
                    'ended_at' =>
                        $assignment->ended_at,
                ])
                ->values();
        }

        return collect();
    }

    /**
     * Project yang sedang aktif ditangani pengguna.
     */
    private function activeProjects(
        Collection $projectRecords
    ): Collection {
        return $projectRecords
            ->filter(function (array $project): bool {
                $projectIsActive = in_array(
                    $project['status'] ?? null,
                    [
                        'planning',
                        'on_progress',
                    ],
                    true
                );

                if (!$projectIsActive) {
                    return false;
                }

                /*
                 * Mandor dianggap aktif berdasarkan
                 * status Project.
                 */
                if (
                    ($project['role'] ?? null)
                    === 'Mandor'
                ) {
                    return true;
                }

                /*
                 * Pekerja harus masih memiliki
                 * penugasan aktif.
                 */
                return (
                    $project['assignment_status']
                    ?? null
                ) === 'active';
            })
            ->values();
    }

    /**
     * Riwayat hanya berisi Project yang benar-benar
     * telah diselesaikan.
     */
    private function projectHistory(
        Collection $projectRecords
    ): Collection {
        return $projectRecords
            ->filter(
                fn (array $project): bool =>
                    ($project['status'] ?? null)
                    === 'completed'
            )
            ->values();
    }

    private function recentActivities(): Collection
    {
        $activities = collect();

        if ($this->user->hasRole('mandor')) {
            foreach (
                $this->user->managedProjects
                as $project
            ) {
                $activities->push([
                    'title' =>
                        'Ditugaskan sebagai Mandor',

                    'description' =>
                        $project->project_name,

                    'date' =>
                        $project->created_at,

                    'color' =>
                        'blue',
                ]);
            }
        }

        if ($this->user->hasRole('pekerja')) {
            foreach (
                $this->user->projectAssignments
                as $assignment
            ) {
                $projectStatus =
                    $assignment->project?->status;

                $title = match (true) {
                    $assignment->status ===
                        'active' =>
                        'Ditugaskan ke Project',

                    $projectStatus ===
                        'completed' =>
                        'Project Telah Selesai',

                    default =>
                        'Penugasan Project Diakhiri',
                };

                $color = match (true) {
                    $assignment->status ===
                        'active' =>
                        'green',

                    $projectStatus ===
                        'completed' =>
                        'blue',

                    default =>
                        'gray',
                };

                $activities->push([
                    'title' =>
                        $title,

                    'description' =>
                        $assignment
                            ->project
                            ?->project_name
                        ?? 'Project tidak ditemukan',

                    'date' =>
                        $assignment->status ===
                        'inactive'
                            ? (
                                $assignment->ended_at
                                ?? $assignment->updated_at
                            )
                            : (
                                $assignment->joined_at
                                ?? $assignment->created_at
                            ),

                    'color' =>
                        $color,
                ]);
            }
        }

        $activities->push([
            'title' =>
                'Akun Pengguna Dibuat',

            'description' =>
                'Pengguna terdaftar dalam sistem.',

            'date' =>
                $this->user->created_at,

            'color' =>
                'blue',
        ]);

        return $activities
            ->filter(
                fn (array $activity): bool =>
                    !empty($activity['date'])
            )
            ->sortByDesc('date')
            ->take(5)
            ->values();
    }

    public function render()
    {
        $role =
            $this->user->roles
                ->first()
                ?->name
            ?? '-';

        $projectRecords =
            $this->projectRecords();

        $activeProjects =
            $this->activeProjects(
                $projectRecords
            );

        $projectHistory =
            $this->projectHistory(
                $projectRecords
            );

        /*
         * Total Project hanya menghitung Project
         * yang masih aktif atau sudah selesai.
         *
         * Penugasan yang dibatalkan sebelum Project
         * selesai tidak ikut dihitung.
         */
        $totalProjects = $activeProjects
            ->concat($projectHistory)
            ->filter(
                fn (array $project): bool =>
                    !empty($project['id'])
            )
            ->unique('id')
            ->count();

        return view(
            'livewire.owner.users.show',
            [
                'role' =>
                    $role,

                'activeProjects' =>
                    $activeProjects,

                'projectHistory' =>
                    $projectHistory,

                'totalProjects' =>
                    $totalProjects,

                'recentActivities' =>
                    $this->recentActivities(),
            ]
        );
    }
}