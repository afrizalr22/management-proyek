<?php

namespace App\Livewire\Owner\Projects;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Carbon;

class Show extends Component
{
    public Project $project;

    public function mount(Project $project): void
    {
        $this->authorizeViewProject();

        $this->project = $project;

        $this->loadProjectData();
    }

    public function render()
    {
        $statusText = match ($this->project->status) {
            'planning' => 'Perencanaan',
            'on_progress' => 'Sedang Berjalan',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => 'Tidak Diketahui',
        };

        $statusColor = match ($this->project->status) {
            'planning' => 'yellow',
            'on_progress' => 'blue',
            'completed' => 'green',
            'cancelled' => 'red',
            default => 'gray',
        };

        /*
         * Quotation yang project_id-nya menunjuk
         * kepada Project ini menjadi quotation sumber.
         */
        $sourceQuotation = $this->project
            ->quotations
            ->first();
            $activities = collect();

/*
 * Project dibuat.
 */
$activities->push([
    'type' => 'project',
    'title' => 'Project Dibuat',
    'description' => sprintf(
        'Project %s dibuat dan masuk ke tahap perencanaan.',
        $this->project->project_code
    ),
    'actor' => 'Owner',
    'occurred_at' => $this->project->created_at,
]);

/*
 * Quotation disetujui dan menjadi sumber Project.
 */
if ($sourceQuotation) {
    $activities->push([
        'type' => 'quotation',
        'title' => 'Quotation Dihubungkan',
        'description' => sprintf(
            'Quotation %s disetujui dan digunakan sebagai dasar pembuatan Project.',
            $sourceQuotation->quotation_number
        ),
        'actor' => $sourceQuotation->creator?->name
            ?? 'Owner',
        'occurred_at' => $sourceQuotation->approved_at
            ?? $sourceQuotation->updated_at,
    ]);
}

/*
 * Mandor ditugaskan.
 */
if ($this->project->mandor) {
    $activities->push([
        'type' => 'mandor',
        'title' => 'Mandor Ditugaskan',
        'description' => sprintf(
            '%s ditetapkan sebagai Mandor Project.',
            $this->project->mandor->name
        ),
        'actor' => 'Owner',
        'occurred_at' => $this->project->created_at,
    ]);
}

/*
 * Pekerja bergabung dengan Project.
 */
foreach ($this->project->workers as $worker) {
    $activities->push([
        'type' => 'worker',
        'title' => 'Pekerja Ditambahkan',
        'description' => sprintf(
            '%s ditambahkan sebagai anggota tim Project.',
            $worker->name
        ),
        'actor' => 'Owner atau Mandor',
        'occurred_at' => $worker->pivot?->joined_at
            ?? $worker->pivot?->created_at,
    ]);
}

/*
 * Tugas dibuat, dikirim, atau diselesaikan.
 */
foreach ($this->project->tasks as $task) {
    $activities->push([
        'type' => 'task',
        'title' => 'Tugas Dibuat',
        'description' => sprintf(
            'Tugas "%s" dibuat%s.',
            $task->title,
            $task->worker
                ? ' untuk '.$task->worker->name
                : ''
        ),
        'actor' => $task->mandor?->name
            ?? $this->project->mandor?->name
            ?? 'Mandor',
        'occurred_at' => $task->created_at,
    ]);

    if ($task->submitted_at) {
        $activities->push([
            'type' => 'report',
            'title' => 'Tugas Dikirim untuk Diperiksa',
            'description' => sprintf(
                'Pekerjaan "%s" telah dikirim untuk diperiksa Mandor.',
                $task->title
            ),
            'actor' => $task->worker?->name
                ?? 'Pekerja',
            'occurred_at' => $task->submitted_at,
        ]);
    }

    if ($task->completed_at) {
        $activities->push([
            'type' => 'completed',
            'title' => 'Tugas Diselesaikan',
            'description' => sprintf(
                'Pekerjaan "%s" telah dinyatakan selesai.',
                $task->title
            ),
            'actor' => $task->mandor?->name
                ?? 'Mandor',
            'occurred_at' => $task->completed_at,
        ]);
    }
}

/*
 * Laporan harian dikirim dan diperiksa.
 */
foreach ($this->project->dailyReports as $report) {
    $activities->push([
        'type' => 'report',
        'title' => 'Laporan Harian Dibuat',
        'description' => sprintf(
            'Laporan %s telah dikirim%s.',
            $report->report_number,
            $report->task
                ? ' untuk tugas "'.$report->task->title.'"'
                : ''
        ),
        'actor' => $report->user?->name
            ?? 'Pekerja',
        'occurred_at' => $report->submitted_at
            ?? $report->created_at,
    ]);

    if ($report->reviewed_at) {
        $reviewText = match ($report->status) {
            'approved' => 'disetujui',
            'revision' => 'dikembalikan untuk diperbaiki',
            'rejected' => 'ditolak',
            default => 'diperiksa',
        };

        $activities->push([
            'type' => $report->status === 'approved'
                ? 'completed'
                : 'review',
            'title' => 'Laporan Harian Diperiksa',
            'description' => sprintf(
                'Laporan %s telah %s.',
                $report->report_number,
                $reviewText
            ),
            'actor' => $report->reviewer?->name
                ?? 'Mandor',
            'occurred_at' => $report->reviewed_at,
        ]);
    }
}

/*
 * Dokumentasi diunggah.
 */
foreach ($this->project->documentations as $documentation) {
    $activities->push([
        'type' => 'documentation',
        'title' => 'Dokumentasi Ditambahkan',
        'description' => sprintf(
            'Dokumentasi "%s" berhasil diunggah%s.',
            $documentation->title ?: 'Dokumentasi lapangan',
            $documentation->task
                ? ' untuk tugas "'.$documentation->task->title.'"'
                : ''
        ),
        'actor' => $documentation->user?->name
            ?? 'Pekerja',
        'occurred_at' => $documentation->taken_at
            ?? $documentation->created_at,
    ]);
}

/*
 * Progres diperbarui.
 */
foreach ($this->project->progresses as $progress) {
    $activities->push([
        'type' => 'progress',
        'title' => 'Progres Project Diperbarui',
        'description' => sprintf(
            'Progres Project diperbarui menjadi %d%%.%s',
            (int) $progress->progress_percentage,
            $progress->description
                ? ' '.$progress->description
                : ''
        ),
        'actor' => $progress->user?->name
            ?? 'Sistem',
        'occurred_at' => $progress->created_at,
    ]);
}

$activities = $activities
    ->filter(
        fn (array $activity): bool =>
            filled($activity['occurred_at'] ?? null)
    )
    ->map(function (array $activity): array {
        $activity['occurred_at'] = Carbon::parse(
            $activity['occurred_at']
        );

        return $activity;
    })
    ->sortByDesc(
        fn (array $activity): int =>
            $activity['occurred_at']->getTimestamp()
    )
    ->take(12)
    ->values();

        return view('livewire.owner.projects.show', [
            'statusText' => $statusText,
            'statusColor' => $statusColor,
            'sourceQuotation' => $sourceQuotation,
            'activities' => $activities,
        ]);
    }

private function loadProjectData(): void
{
    $this->project->load([
        'client',
        'mandor',

        'workers' => fn ($query) => $query
            ->orderBy('name'),

        'tasks' => fn ($query) => $query
            ->with([
                'worker:id,name,email',
                'mandor:id,name,email',
            ])
            ->orderByDesc('id'),

        'progresses' => fn ($query) => $query
            ->with('user:id,name,email')
            ->latest('id'),

        'dailyReports' => fn ($query) => $query
            ->with([
                'user:id,name,email',
                'reviewer:id,name,email',
                'task:id,title',
            ])
            ->latest('id'),

        'documentations' => fn ($query) => $query
            ->with([
                'user:id,name,email',
                'task:id,title',
            ])
            ->latest('id'),

        'quotations' => fn ($query) => $query
            ->with([
                'creator:id,name,email',

                'items' => fn ($query) => $query
                    ->orderBy('sort_order')
                    ->orderBy('id'),
            ])
            ->latest('id'),
    ]);

    $this->project->loadCount([
        'workers',
        'tasks',
        'dailyReports',
        'documentations',
    ]);
}

    private function authorizeViewProject(): void
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User
                && $user->can('view projects'),
            403
        );
    }
}