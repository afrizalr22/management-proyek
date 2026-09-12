<?php

namespace App\Livewire\Mandor\Projects;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public Project $project;

    public function mount(
        Project $project
    ): void {
        $this->authorizeProject(
            $project
        );

        $this->project = $project;
    }

    private function authorizeProject(
        Project $project
    ): void {
        $mandor = Auth::user();

        abort_unless(
            $mandor instanceof User
                && $mandor->hasRole('mandor')
                && (int) $project->mandor_id
                    === (int) $mandor->id,
            403
        );
    }

    private function loadProjectData(): void
    {
        /*
         * Periksa kembali kepemilikan pada setiap render
         * untuk menghindari manipulasi properti Livewire.
         */
        $this->project->refresh();

        $this->authorizeProject(
            $this->project
        );

        $this->project->load([
            'client',

            'workerAssignments' =>
                fn ($query) => $query
                    ->with([
                        'worker:id,name,email,phone,photo,status',
                    ])
                    ->where(
                        'status',
                        'active'
                    )
                    ->oldest('id'),

            'tasks' =>
                fn ($query) => $query
                    ->with([
                        'worker:id,name,email',
                    ])
                    ->orderBy('start_at')
                    ->orderBy('id'),

            'progresses' =>
                fn ($query) => $query
                    ->with([
                        'user:id,name',
                    ])
                    ->latest('created_at')
                    ->latest('id'),

            'dailyReports' =>
                fn ($query) => $query
                    ->with([
                        'user:id,name',
                        'task:id,title',
                        'documentations:id,daily_report_id,photo',
                    ])
                    ->latest('report_date')
                    ->latest('id'),

            'documentations' =>
                fn ($query) => $query
                    ->with([
                        'user:id,name',
                        'task:id,title',
                    ])
                    ->latest('documentation_date')
                    ->latest('id'),
        ]);

        $this->project->loadCount([
            'tasks',
            'dailyReports',
            'documentations',

            'tasks as completed_tasks_count' =>
                fn ($query) => $query
                    ->whereIn(
                        'status',
                        [
                            'completed',
                            'approved',
                        ]
                    ),

            'workerAssignments as active_workers_count' =>
                fn ($query) => $query
                    ->where(
                        'status',
                        'active'
                    ),
        ]);
    }

    private function summary(): array
    {
        $progress = min(
            100,
            max(
                0,
                (int) $this->project->progress
            )
        );

        $remainingDays = null;

        if ($this->project->end_date) {
            $remainingDays = (int) today()
                ->diffInDays(
                    $this->project->end_date,
                    false
                );
        }

        $isDelayed =
            $remainingDays !== null
            && $remainingDays < 0
            && !in_array(
                $this->project->status,
                [
                    'completed',
                    'cancelled',
                ],
                true
            );

        return [
            'progress' =>
                $progress,

            'remaining_days' =>
                $remainingDays,

            'is_delayed' =>
                $isDelayed,

            'active_workers' =>
                (int) (
                    $this->project
                        ->active_workers_count
                    ?? 0
                ),

            'total_tasks' =>
                (int) (
                    $this->project->tasks_count
                    ?? 0
                ),

            'completed_tasks' =>
                (int) (
                    $this->project
                        ->completed_tasks_count
                    ?? 0
                ),

            'daily_reports' =>
                (int) (
                    $this->project
                        ->daily_reports_count
                    ?? 0
                ),

            'documentations' =>
                (int) (
                    $this->project
                        ->documentations_count
                    ?? 0
                ),
        ];
    }

    public function render()
    {
        $this->loadProjectData();

        return view(
            'livewire.mandor.projects.show',
            [
                'summary' =>
                    $this->summary(),

                'workers' =>
                    $this->project

                        ->workerAssignments,

                'tasks' =>
                    $this->project->tasks,

                'progresses' =>
                    $this->project->progresses,

                'recentReports' =>
                    $this->project
                        ->dailyReports
                        ->take(3),

                'latestDocumentations' =>
                    $this->project
                        ->documentations
                        ->take(5),
            ]
        );
    }
}