<?php

namespace App\Livewire\Mandor\WorkProgress;

use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Index extends Component
{
    public Project $project;

    public bool $showTaskForm = false;

    public ?int $workerId = null;

    public string $title = '';

    public string $description = '';

    public string $location = '';

    public string $priority = 'medium';

    public string $startAt = '';

    public string $dueAt = '';

    public string $weight = '1.00';

    public string $mandorNotes = '';

    public function mount(
        Project $project
    ): void {
        $this->authorizeProject($project);

        $this->project = $project;

        $this->setDefaultTaskDates();
    }

    public function openTaskForm(): void
    {
        $this->resetValidation();

        $this->resetTaskForm();

        $this->showTaskForm = true;
    }

    public function closeTaskForm(): void
    {
        $this->showTaskForm = false;

        $this->resetValidation();

        $this->resetTaskForm();
    }

    public function createTask(): void
    {
        $validated = $this->validate();

        $workerIsAvailable = $this->project
            ->workerAssignments()
            ->where('worker_id', $validated['workerId'])
            ->where('status', 'active')
            ->whereHas(
                'worker',
                fn ($query) => $query
                    ->where('status', 'active')
            )
            ->exists();

        if (! $workerIsAvailable) {
            $this->addError(
                'workerId',
                'Pekerja tidak aktif atau tidak terdaftar pada proyek ini.'
            );

            return;
        }
        $totalExistingWeight = (float) $this->project
    ->tasks()
    ->where(
        'status',
        '!=',
        'cancelled'
    )
    ->sum('weight');

    $newTotalWeight = $totalExistingWeight
        + (float) $validated['weight'];

    if ($newTotalWeight > 100) {
        $remainingWeight = max(
            0,
            100 - $totalExistingWeight
        );

        $this->addError(
            'weight',
            'Total bobot Task aktif tidak boleh melebihi 100. '
                . 'Sisa bobot proyek saat ini '
                . number_format(
                    $remainingWeight,
                    2,
                    ',',
                    '.'
                )
                . '.'
        );

        return;
    }

        DB::transaction(function () use ($validated): void {
            Task::query()->create([
                'project_id' => $this->project->id,
                'mandor_id' => Auth::id(),
                'worker_id' => $validated['workerId'],
                'task_code' => $this->generateTaskCode(),
                'title' => trim($validated['title']),
                'description' => filled($validated['description'])
                    ? trim($validated['description'])
                    : null,
                'location' => filled($validated['location'])
                    ? trim($validated['location'])
                    : null,
                'priority' => $validated['priority'],
                'status' => 'assigned',
                'start_at' => $validated['startAt'],
                'due_at' => $validated['dueAt'],
                'progress' => 0,
                'weight' => $validated['weight'],
                'mandor_notes' => filled($validated['mandorNotes'])
                    ? trim($validated['mandorNotes'])
                    : null,
            ]);
        });

        $this->showTaskForm = false;

        $this->resetTaskForm();

        session()->flash(
            'success',
            'Task berhasil dibuat dan diberikan kepada pekerja.'
        );
    }

    public function render()
    {
        $this->authorizeProject($this->project);

        $this->project->load([
            'tasks' => fn ($query) => $query
                ->with([
                    'worker:id,name,email,status',
                ])
                ->orderBy('start_at')
                ->orderBy('due_at')
                ->orderBy('id'),

            'workerAssignments' => fn ($query) => $query
                ->where('status', 'active')
                ->with([
                    'worker:id,name,email,status',
                ])
                ->orderBy('joined_at')
                ->orderBy('id'),
        ]);

        $tasks = $this->project->tasks;

        $actualProgress = $this->calculateActualProgress(
            $tasks
        );

        $plannedProgress = $this->calculatePlannedProgress();

        return view(
            'livewire.mandor.work-progress.index',
            [
                'tasks' => $tasks,

                'assignedTasks' => $tasks
                    ->where('status', 'assigned')
                    ->values(),

                'activeTasks' => $tasks
                    ->whereIn(
                        'status',
                        [
                            'in_progress',
                            'submitted',
                            'revision',
                        ]
                    )
                    ->values(),

                'completedTasks' => $tasks
                    ->where('status', 'completed')
                    ->values(),

                'cancelledTasks' => $tasks
                    ->where('status', 'cancelled')
                    ->values(),

                'activeWorkers' => $this->activeWorkers(),

                'actualProgress' => $actualProgress,

                'plannedProgress' => $plannedProgress,

                'progressVariance' => $actualProgress
                    - $plannedProgress,

                'taskStatistics' => [
                    'total' => $tasks->count(),

                    'assigned' => $tasks
                        ->where('status', 'assigned')
                        ->count(),

                    'active' => $tasks
                        ->whereIn(
                            'status',
                            [
                                'in_progress',
                                'submitted',
                                'revision',
                            ]
                        )
                        ->count(),

                    'completed' => $tasks
                        ->where('status', 'completed')
                        ->count(),

                    'cancelled' => $tasks
                        ->where('status', 'cancelled')
                        ->count(),
                ],
            ]
        );
    }

    protected function rules(): array
    {
        return [
            'workerId' => [
                'required',
                'integer',

                Rule::exists(
                    'project_workers',
                    'worker_id'
                )->where(
                    fn ($query) => $query
                        ->where(
                            'project_id',
                            $this->project->id
                        )
                        ->where(
                            'status',
                            'active'
                        )
                ),
            ],

            'title' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'location' => [
                'nullable',
                'string',
                'max:255',
            ],

            'priority' => [
                'required',

                Rule::in([
                    'low',
                    'medium',
                    'high',
                    'urgent',
                ]),
            ],

            'startAt' => [
                'required',
                'date',
            ],

            'dueAt' => [
                'required',
                'date',
                'after_or_equal:startAt',
            ],

            'weight' => [
                'required',
                'numeric',
                'min:0.01',
                'max:100',
            ],

            'mandorNotes' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'workerId.required' =>
                'Pekerja wajib dipilih.',

            'workerId.exists' =>
                'Pekerja tidak aktif atau tidak terdaftar pada proyek ini.',

            'title.required' =>
                'Judul Task wajib diisi.',

            'title.min' =>
                'Judul Task minimal 3 karakter.',

            'title.max' =>
                'Judul Task maksimal 255 karakter.',

            'description.max' =>
                'Deskripsi maksimal 5.000 karakter.',

            'location.max' =>
                'Lokasi maksimal 255 karakter.',

            'priority.required' =>
                'Prioritas wajib dipilih.',

            'priority.in' =>
                'Prioritas Task tidak valid.',

            'startAt.required' =>
                'Waktu mulai wajib diisi.',

            'startAt.date' =>
                'Waktu mulai tidak valid.',

            'dueAt.required' =>
                'Tenggat waktu wajib diisi.',

            'dueAt.date' =>
                'Tenggat waktu tidak valid.',

            'dueAt.after_or_equal' =>
                'Tenggat waktu tidak boleh sebelum waktu mulai.',

            'weight.required' =>
                'Bobot Task wajib diisi.',

            'weight.numeric' =>
                'Bobot Task harus berupa angka.',

            'weight.min' =>
                'Bobot Task minimal 0,01.',

            'weight.max' =>
                'Bobot Task maksimal 100.',

            'mandorNotes.max' =>
                'Catatan Mandor maksimal 2.000 karakter.',
        ];
    }

    private function authorizeProject(
        Project $project
    ): void {
        abort_unless(
            (int) $project->mandor_id
                === (int) Auth::id(),
            403
        );
    }

    private function activeWorkers(): Collection
    {
        return $this->project
            ->workerAssignments
            ->filter(
                fn ($assignment) =>
                    $assignment->worker !== null
                    && $assignment->worker->status === 'active'
            )
            ->pluck('worker')
            ->unique('id')
            ->sortBy('name')
            ->values();
    }

    private function calculateActualProgress(
        Collection $tasks
    ): int {
        if ($tasks->isEmpty()) {
            return max(
                0,
                min(
                    100,
                    (int) $this->project->progress
                )
            );
        }

        $totalWeight = (float) $tasks->sum(
            fn (Task $task) => max(
                0.01,
                (float) $task->weight
            )
        );

        if ($totalWeight <= 0) {
            return 0;
        }

        $weightedProgress = $tasks->sum(
            fn (Task $task) =>
                max(
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

        return max(
            0,
            min(
                100,
                (int) round(
                    $weightedProgress / $totalWeight
                )
            )
        );
    }

    private function calculatePlannedProgress(): int
    {
        if (
            ! $this->project->start_date
            || ! $this->project->end_date
        ) {
            return 0;
        }

        $startDate = Carbon::parse(
            $this->project->start_date
        )->startOfDay();

        $endDate = Carbon::parse(
            $this->project->end_date
        )->endOfDay();

        $today = now();

        if ($today->lessThanOrEqualTo($startDate)) {
            return 0;
        }

        if ($today->greaterThanOrEqualTo($endDate)) {
            return 100;
        }

        $totalDuration = max(
            1,
            $startDate->diffInSeconds(
                $endDate
            )
        );

        $elapsedDuration = $startDate
            ->diffInSeconds($today);

        return max(
            0,
            min(
                100,
                (int) round(
                    ($elapsedDuration / $totalDuration)
                    * 100
                )
            )
        );
    }

    private function generateTaskCode(): string
    {
        do {
            $taskCode = sprintf(
                'TSK-%s-%s',
                str_pad(
                    (string) $this->project->id,
                    4,
                    '0',
                    STR_PAD_LEFT
                ),
                Str::upper(
                    Str::random(8)
                )
            );
        } while (
            Task::query()
                ->where(
                    'task_code',
                    $taskCode
                )
                ->exists()
        );

        return $taskCode;
    }

    private function resetTaskForm(): void
    {
        $this->workerId = null;
        $this->title = '';
        $this->description = '';
        $this->location = '';
        $this->priority = 'medium';
        $this->weight = '1.00';
        $this->mandorNotes = '';

        $this->setDefaultTaskDates();
    }

    private function setDefaultTaskDates(): void
    {
        $defaultStart = now()
            ->addHour()
            ->startOfHour();

        $defaultDue = $defaultStart
            ->copy()
            ->addDay();

        if ($this->project->start_date) {
            $projectStart = Carbon::parse(
                $this->project->start_date
            )->startOfDay();

            if ($defaultStart->lessThan($projectStart)) {
                $defaultStart = $projectStart;
            }
        }

        if ($this->project->end_date) {
            $projectEnd = Carbon::parse(
                $this->project->end_date
            )->endOfDay();

            if ($defaultDue->greaterThan($projectEnd)) {
                $defaultDue = $projectEnd;
            }

            if ($defaultStart->greaterThan($projectEnd)) {
                $defaultStart = $projectEnd
                    ->copy()
                    ->subHour();
            }
        }

        if ($defaultDue->lessThan($defaultStart)) {
            $defaultDue = $defaultStart
                ->copy()
                ->addHour();
        }

        $this->startAt = $defaultStart->format(
            'Y-m-d\TH:i'
        );

        $this->dueAt = $defaultDue->format(
            'Y-m-d\TH:i'
        );
    }
}