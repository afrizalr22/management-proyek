<?php

namespace App\Livewire\Mandor\DailyReports;

use App\Models\DailyReport;
use App\Models\Documentation;
use App\Models\Project;
use App\Models\ProjectProgress;
use App\Models\ProjectWorker;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Edit extends Component
{
    public int $reportId;

    public DailyReport $report;

    public string $reviewNotes = '';

    public function mount(
        DailyReport $report
    ): void {
        $this->authorizeReport(
            $report
        );

        $this->ensureProjectCanBeReviewed(
            $report
        );

        abort_unless(
            $report->status === 'submitted',
            409,
            'Laporan ini sudah diperiksa.'
        );

        $this->reportId = $report->id;
        $this->report = $report;
        $this->reviewNotes = '';
    }

    public function approveReport(): void
    {
        $this->validate([
            'reviewNotes' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $currentReport = $this->findReport();

        $this->ensureProjectCanBeReviewed(
            $currentReport
        );

        if (
            $currentReport->work_status === 'completed'
            && (int) $currentReport->reported_progress < 100
        ) {
            $this->addError(
                'decision',
                'Laporan berstatus pekerjaan selesai harus memiliki progress 100%. Minta Pekerja melakukan revisi.'
            );

            return;
        }

        DB::transaction(
            function (): void {
                $report = DailyReport::query()
                    ->with([
                        'project',
                        'task',
                    ])
                    ->lockForUpdate()
                    ->findOrFail(
                        $this->reportId
                    );

                $this->authorizeReport(
                    $report
                );

                $this->ensureProjectCanBeReviewed(
                    $report
                );

                abort_unless(
                    $report->status === 'submitted',
                    409,
                    'Laporan ini sudah diperiksa.'
                );

                $report->update([
                    'status' => 'approved',
                    'reviewed_by' => Auth::id(),
                    'reviewed_at' => now(),
                    'review_notes' => filled(
                        $this->reviewNotes
                    )
                        ? trim($this->reviewNotes)
                        : null,
                ]);

                if ($report->task) {
                    $this->approveTaskProgress(
                        $report,
                        $report->task
                    );
                }

                if ($report->project) {
                    $this->synchronizeProjectProgress(
                        $report->project,
                        $report
                    );
                }
            }
        );

        session()->flash(
            'success',
            'Laporan berhasil disetujui dan progress Task telah diperbarui.'
        );

        $this->redirect(
            route(
                'mandor.daily-reports.show',
                $this->reportId
            ),
            navigate: true
        );
    }

    public function requestRevision(): void
    {
        $this->validate([
            'reviewNotes' => [
                'required',
                'string',
                'min:10',
                'max:2000',
            ],
        ], [
            'reviewNotes.required' => 'Alasan revisi wajib diisi.',

            'reviewNotes.min' => 'Alasan revisi minimal 10 karakter.',

            'reviewNotes.max' => 'Catatan validasi maksimal 2.000 karakter.',
        ]);

        DB::transaction(
            function (): void {
                $report = DailyReport::query()
                    ->with([
                        'project',
                        'task',
                    ])
                    ->lockForUpdate()
                    ->findOrFail(
                        $this->reportId
                    );

                $this->authorizeReport(
                    $report
                );

                $this->ensureProjectCanBeReviewed(
                    $report
                );

                abort_unless(
                    $report->status === 'submitted',
                    409,
                    'Laporan ini sudah diperiksa.'
                );

                $report->update([
                    'status' => 'revision',
                    'reviewed_by' => Auth::id(),
                    'reviewed_at' => now(),
                    'review_notes' => trim(
                        $this->reviewNotes
                    ),
                ]);

                if (
                    $report->task
                    && ! in_array(
                        $report->task->status,
                        [
                            'completed',
                            'cancelled',
                        ],
                        true
                    )
                ) {
                    $report->task->update([
                        'status' => 'revision',
                    ]);
                }
            }
        );

        session()->flash(
            'success',
            'Laporan dikembalikan kepada Pekerja untuk diperbaiki.'
        );

        $this->redirect(
            route(
                'mandor.daily-reports.show',
                $this->reportId
            ),
            navigate: true
        );
    }

    public function render()
    {
        $report = DailyReport::query()
            ->with([
                'project:id,mandor_id,project_code,project_name,location',

                'task:id,project_id,mandor_id,worker_id,task_code,title,location,status,progress,weight',

                'user:id,name,email,status',

                'documentations' => fn ($query) => $query
                    ->with([
                        'user:id,name',
                    ])
                    ->orderBy('taken_at')
                    ->orderBy('id'),
            ])
            ->findOrFail(
                $this->reportId
            );

        $this->authorizeReport(
            $report
        );

        $this->ensureProjectCanBeReviewed(
            $report
        );

        $report->documentations->transform(
            function (
                Documentation $documentation
            ): Documentation {
                $photoExists = filled(
                    $documentation->photo
                ) && Storage::disk('public')
                    ->exists(
                        $documentation->photo
                    );

                $documentation->setAttribute(
                    'photo_exists',
                    $photoExists
                );

                $documentation->setAttribute(
                    'photo_url',
                    $photoExists
                        ? asset(
                            'storage/'
                                .ltrim(
                                    $documentation->photo,
                                    '/'
                                )
                        )
                        : null
                );

                return $documentation;
            }
        );

        abort_unless(
            $report->status === 'submitted',
            409,
            'Laporan ini sudah diperiksa.'
        );

        $this->report = $report;

        return view(
            'livewire.mandor.daily-reports.edit',
            [
                'report' => $report,
            ]
        );
    }

    private function findReport(): DailyReport
    {
        $report = DailyReport::query()
            ->with([
                'project',
                'task',
            ])
            ->findOrFail(
                $this->reportId
            );

        $this->authorizeReport(
            $report
        );

        $this->ensureProjectCanBeReviewed(
            $report
        );

        abort_unless(
            $report->status === 'submitted',
            409,
            'Laporan ini sudah diperiksa.'
        );

        return $report;
    }

    private function authorizeReport(
        DailyReport $report
    ): void {
        $isOwnedByMandor = DailyReport::query()
            ->whereKey(
                $report->id
            )
            ->whereHas(
                'project',
                fn ($query) => $query->where(
                    'mandor_id',
                    Auth::id()
                )
            )
            ->exists();

        abort_unless(
            $isOwnedByMandor,
            403
        );
    }

    private function approveTaskProgress(
        DailyReport $report,
        Task $task
    ): void {
        abort_unless(
            (int) $task->project_id
                === (int) $report->project_id,
            422,
            'Task tidak sesuai dengan Project laporan.'
        );

        $reportedProgress = max(
            0,
            min(
                100,
                (int) $report->reported_progress
            )
        );

        $newProgress = max(
            (int) $task->progress,
            $reportedProgress
        );

        $taskData = [
            'progress' => $newProgress,
        ];

        if (
            $report->work_status === 'completed'
            && $reportedProgress === 100
        ) {
            $taskData['status'] = 'completed';

            $taskData['completed_at'] =
                $task->completed_at ?? now();
        } elseif (
            ! in_array(
                $task->status,
                [
                    'completed',
                    'cancelled',
                ],
                true
            )
        ) {
            $taskData['status'] = 'in_progress';

            $taskData['started_at'] =
                $task->started_at ?? now();
        }

        $task->update(
            $taskData
        );
    }

    private function ensureProjectCanBeReviewed(
        DailyReport $report
    ): void {
        $project = $report->project;

        abort_if(
            $project
                && in_array(
                    $project->status,
                    [
                        'completed',
                        'cancelled',
                    ],
                    true
                ),
            409,
            'Laporan tidak dapat diproses karena Project telah selesai atau dibatalkan.'
        );
    }

    private function synchronizeProjectProgress(
        Project $project,
        DailyReport $report
    ): void {
        $tasks = $project
            ->tasks()
            ->where(
                'status',
                '!=',
                'cancelled'
            )
            ->get([
                'id',
                'project_id',
                'status',
                'progress',
                'weight',
            ]);

        if ($tasks->isEmpty()) {
            return;
        }

        $totalWeight = (float) $tasks->sum(
            fn (Task $task) => max(
                0.01,
                (float) $task->weight
            )
        );

        if ($totalWeight <= 0) {
            return;
        }

        $weightedProgress = $tasks->sum(
            fn (Task $task) => max(
                0,
                min(
                    100,
                    (int) $task->progress
                )
            )
                * max(
                    0.01,
                    (float) $task->weight
                )
        );

        $projectProgress = max(
            0,
            min(
                100,
                (int) round(
                    $weightedProgress
                    / $totalWeight
                )
            )
        );

        $projectData = [
            'progress' => $projectProgress,
        ];

        $allActiveTasksCompleted = $tasks->every(
            fn (Task $task) => $task->status === 'completed'
                && (int) $task->progress === 100
        );

        if ($allActiveTasksCompleted) {
            $projectData['status'] = 'completed';
            $projectData['progress'] = 100;
        } elseif (
            $projectProgress > 0
            && $project->status === 'planning'
        ) {
            $projectData['status'] = 'on_progress';
        }

        $project->update(
            $projectData
        );

        if ($allActiveTasksCompleted) {
            ProjectWorker::query()
                ->where(
                    'project_id',
                    $project->id
                )
                ->where(
                    'status',
                    'active'
                )
                ->update([
                    'status' => 'inactive',
                    'ended_at' => now(),
                ]);
        }

        ProjectProgress::query()->create([
            'project_id' => $project->id,

            'user_id' => Auth::id(),

            'progress_percentage' => $projectProgress,

            'description' => $this->buildProgressDescription(
                $report,
                $projectProgress
            ),
        ]);
    }

    private function buildProgressDescription(
        DailyReport $report,
        int $projectProgress
    ): string {
        $taskCode =
            $report->task?->task_code;

        $taskTitle =
            $report->task?->title;

        $taskLabel = collect([
            $taskCode,
            $taskTitle,
        ])
            ->filter()
            ->implode(' - ');

        if ($taskLabel === '') {
            $taskLabel = 'Task';
        }

        return sprintf(
            'Laporan %s disetujui. Progress Project diperbarui menjadi %d%%.',
            $taskLabel,
            $projectProgress
        );
    }
}
