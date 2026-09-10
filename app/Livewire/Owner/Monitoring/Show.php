<?php

namespace App\Livewire\Owner\Monitoring;

use App\Models\Project;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Show extends Component
{
    public Project $project;

    public function mount(Project $project): void
    {
        Gate::authorize('view projects');

        $this->project = $project;
    }

    public function render()
    {
        $project = Project::query()
            ->with([
                'client:id,company_name,contact_person,phone,email,address,city',

                'mandor:id,name,email,phone',

                'tasks' => fn ($query) => $query
                    ->with([
                        'mandor:id,name',
                        'worker:id,name',
                    ])
                    ->orderBy('start_at')
                    ->orderBy('due_at')
                    ->orderBy('id'),

                'progresses' => fn ($query) => $query
                    ->with('user:id,name')
                    ->latest('created_at')
                    ->latest('id'),

                'dailyReports' => fn ($query) => $query
                    ->with([
                        'task:id,task_code,title',
                        'user:id,name',
                        'reviewer:id,name',
                    ])
                    ->latest('report_date')
                    ->latest('id'),

                'documentations' => fn ($query) => $query
                    ->with([
                        'task:id,task_code,title',
                        'user:id,name',
                    ])
                    ->latest('documentation_date')
                    ->latest('id'),
            ])
            ->withCount([
                'tasks',

                'tasks as completed_tasks_count' =>
                    fn ($query) => $query
                        ->where('status', 'completed'),

                'workerAssignments as active_workers_count' =>
                    fn ($query) => $query
                        ->where('status', 'active'),

                'dailyReports',

                'dailyReports as approved_reports_count' =>
                    fn ($query) => $query
                        ->where('status', 'approved'),

                'dailyReports as issues_count' =>
                    fn ($query) => $query
                        ->whereNotNull('obstacles')
                        ->where('obstacles', '!=', ''),

                'documentations',

                'progresses',
            ])
            ->findOrFail($this->project->id);

        $currentTask = $project->tasks
            ->first(
                fn ($task): bool => in_array(
                    $task->status,
                    [
                        'in_progress',
                        'submitted',
                        'revision',
                    ],
                    true
                )
            );

        $currentTask ??= $project->tasks
            ->first(
                fn ($task): bool =>
                    $task->status === 'assigned'
            );

        $isDelayed = $project->end_date
            && $project->end_date->lt(today())
            && ! in_array(
                $project->status,
                [
                    'completed',
                    'cancelled',
                ],
                true
            );

        return view(
            'livewire.owner.monitoring.show',
            [
                'projectData' => $project,
                'currentTask' => $currentTask,
                'isDelayed' => $isDelayed,
            ]
        );
    }
}