<?php

namespace App\Livewire\Owner\Projects;

use App\Models\Project;
use App\Models\ProjectWorker;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use RuntimeException;
use Throwable;

class ManageWorkers extends Component
{
    public int $projectId;

    public bool $showModal = false;

    public string $search = '';

    /**
     * Daftar pekerja yang dipilih saat ini.
     */
    public array $selectedWorkerIds = [];

    /**
     * Daftar pekerja aktif ketika modal pertama kali dibuka.
     */
    public array $originalWorkerIds = [];

    public function mount(Project $project): void
    {
        $this->projectId = $project->id;
    }

    #[On('open-manage-project-workers')]
    public function openModal(int $projectId): void
    {
        if ($projectId !== $this->projectId) {
            return;
        }

        $this->authorizeManageWorkers();

        $project = Project::query()
            ->find($this->projectId);

        if (!$project) {
            return;
        }

        if (!$this->projectCanManageWorkers($project)) {
            $this->addError(
                'workers',
                'Pekerja tidak dapat dikelola pada Project yang selesai atau dibatalkan.'
            );

            return;
        }

        $activeWorkerIds = ProjectWorker::query()
            ->where('project_id', $this->projectId)
            ->where('status', 'active')
            ->pluck('worker_id')
            ->map(
                fn ($workerId): int => (int) $workerId
            )
            ->values()
            ->all();

        $this->search = '';
        $this->originalWorkerIds = $activeWorkerIds;
        $this->selectedWorkerIds = $activeWorkerIds;

        $this->resetValidation();

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;

        $this->reset([
            'search',
            'selectedWorkerIds',
            'originalWorkerIds',
        ]);

        $this->resetValidation();
    }

    public function saveWorkers(): void
    {
        $this->authorizeManageWorkers();
        $this->resetValidation();

        $this->validate([
            'selectedWorkerIds' => [
                'array',
            ],

            'selectedWorkerIds.*' => [
                'integer',
                'distinct',
                'exists:users,id',
            ],
        ], [
            'selectedWorkerIds.array' =>
                'Pilihan pekerja tidak valid.',

            'selectedWorkerIds.*.integer' =>
                'Pilihan pekerja tidak valid.',

            'selectedWorkerIds.*.distinct' =>
                'Terdapat pekerja yang dipilih lebih dari satu kali.',

            'selectedWorkerIds.*.exists' =>
                'Salah satu pekerja tidak ditemukan.',
        ]);

        $selectedWorkerIds = collect(
            $this->selectedWorkerIds
        )
            ->map(
                fn ($workerId): int => (int) $workerId
            )
            ->unique()
            ->sort()
            ->values();

        $validWorkerIds = User::query()
            ->role('pekerja')
            ->whereIn('id', $selectedWorkerIds)
            ->pluck('id')
            ->map(
                fn ($workerId): int => (int) $workerId
            )
            ->sort()
            ->values();

        if (
            $validWorkerIds->count()
            !== $selectedWorkerIds->count()
        ) {
            $this->addError(
                'workers',
                'Pilihan mengandung pengguna yang bukan Pekerja.'
            );

            return;
        }

        try {
            $result = DB::transaction(
                function () use (
                    $selectedWorkerIds
                ): array {
                    $project = Project::query()
                        ->lockForUpdate()
                        ->find($this->projectId);

                    if (!$project) {
                        throw new RuntimeException(
                            'project_not_found'
                        );
                    }

                    if (!$this->projectCanManageWorkers($project)) {
                        throw new RuntimeException(
                            'project_locked'
                        );
                    }

                    $currentActiveWorkerIds =
                        ProjectWorker::query()
                            ->where(
                                'project_id',
                                $project->id
                            )
                            ->where(
                                'status',
                                'active'
                            )
                            ->lockForUpdate()
                            ->pluck('worker_id')
                            ->map(
                                fn ($workerId): int =>
                                    (int) $workerId
                            );

                    $workerIdsToActivate =
                        $selectedWorkerIds
                            ->diff(
                                $currentActiveWorkerIds
                            )
                            ->values();

                    $workerIdsToDeactivate =
                        $currentActiveWorkerIds
                            ->diff(
                                $selectedWorkerIds
                            )
                            ->values();

                    /*
                     * Pekerja yang baru dipilih tidak boleh
                     * sedang aktif pada Project lain.
                     */
                    $workerOnOtherProject =
                        ProjectWorker::query()
                            ->with(
                                'project:id,project_code,project_name'
                            )
                            ->whereIn(
                                'worker_id',
                                $workerIdsToActivate
                            )
                            ->where(
                                'project_id',
                                '!=',
                                $project->id
                            )
                            ->where(
                                'status',
                                'active'
                            )
                            ->lockForUpdate()
                            ->first();

                    if ($workerOnOtherProject) {
                        $projectName =
                            $workerOnOtherProject
                                ->project?->project_name
                            ?? 'Project lain';

                        throw new RuntimeException(
                            'worker_on_other_project:'
                            .$projectName
                        );
                    }

                    /*
                     * Pekerja tidak boleh dinonaktifkan jika
                     * masih memiliki tugas aktif.
                     */
                    $workerWithActiveTask = Task::query()
                        ->with('worker:id,name')
                        ->where(
                            'project_id',
                            $project->id
                        )
                        ->whereIn(
                            'worker_id',
                            $workerIdsToDeactivate
                        )
                        ->whereNotIn(
                            'status',
                            [
                                'completed',
                                'cancelled',
                            ]
                        )
                        ->lockForUpdate()
                        ->first();

                    if ($workerWithActiveTask) {
                        $workerName =
                            $workerWithActiveTask
                                ->worker?->name
                            ?? 'Pekerja';

                        throw new RuntimeException(
                            'worker_has_active_tasks:'
                            .$workerName
                        );
                    }

                    $activatedCount = 0;
                    $deactivatedCount = 0;

                    foreach (
                        $workerIdsToActivate
                        as $workerId
                    ) {
                        $assignment =
                            ProjectWorker::query()
                                ->where(
                                    'project_id',
                                    $project->id
                                )
                                ->where(
                                    'worker_id',
                                    $workerId
                                )
                                ->lockForUpdate()
                                ->first();

                        if ($assignment) {
                            $assignment->update([
                                'assigned_by' =>
                                    Auth::id(),

                                'status' =>
                                    'active',

                                'joined_at' =>
                                    now(),

                                'ended_at' =>
                                    null,
                            ]);
                        } else {
                            ProjectWorker::create([
                                'project_id' =>
                                    $project->id,

                                'worker_id' =>
                                    $workerId,

                                'assigned_by' =>
                                    Auth::id(),

                                'status' =>
                                    'active',

                                'joined_at' =>
                                    now(),

                                'ended_at' =>
                                    null,
                            ]);
                        }

                        $activatedCount++;
                    }

                    if (
                        $workerIdsToDeactivate
                            ->isNotEmpty()
                    ) {
                        $deactivatedCount =
                            ProjectWorker::query()
                                ->where(
                                    'project_id',
                                    $project->id
                                )
                                ->whereIn(
                                    'worker_id',
                                    $workerIdsToDeactivate
                                )
                                ->where(
                                    'status',
                                    'active'
                                )
                                ->update([
                                    'status' =>
                                        'inactive',

                                    'ended_at' =>
                                        now(),
                                ]);
                    }

                    return [
                        'activated' =>
                            $activatedCount,

                        'deactivated' =>
                            $deactivatedCount,
                    ];
                }
            );

            $this->originalWorkerIds =
                $selectedWorkerIds->all();

            $messageParts = [];

            if ($result['activated'] > 0) {
                $messageParts[] = sprintf(
                    '%d pekerja ditambahkan',
                    $result['activated']
                );
            }

            if ($result['deactivated'] > 0) {
                $messageParts[] = sprintf(
                    '%d pekerja dinonaktifkan',
                    $result['deactivated']
                );
            }

            if ($messageParts === []) {
                $this->addError(
                    'workers',
                    'Tidak ada perubahan pekerja yang perlu disimpan.'
                );

                return;
            }

            session()->flash('notification', [
                'type' => 'success',
                'message' =>
                    ucfirst(
                        implode(
                            ' dan ',
                            $messageParts
                        )
                    ).' dari Project.',
            ]);

            $this->showModal = false;

            $this->reset([
                'search',
                'selectedWorkerIds',
                'originalWorkerIds',
            ]);

            $this->dispatch(
                'project-workers-updated',
                projectId: $this->projectId
            );
        } catch (RuntimeException $exception) {
            $this->handleRuntimeException(
                $exception
            );
        } catch (Throwable $exception) {
            report($exception);

            $this->addError(
                'workers',
                'Perubahan pekerja gagal disimpan. Silakan coba kembali.'
            );
        }
    }

    private function projectCanManageWorkers(
        Project $project
    ): bool {
        return in_array(
            $project->status,
            [
                'planning',
                'on_progress',
            ],
            true
        );
    }

    private function handleRuntimeException(
        RuntimeException $exception
    ): void {
        $exceptionMessage =
            $exception->getMessage();

        $message = match (true) {
            $exceptionMessage ===
                'project_not_found' =>
                'Project tidak ditemukan.',

            $exceptionMessage ===
                'project_locked' =>
                'Pekerja tidak dapat dikelola pada Project yang selesai atau dibatalkan.',

            str_starts_with(
                $exceptionMessage,
                'worker_on_other_project:'
            ) =>
                'Pekerja yang dipilih masih aktif pada '
                .str_replace(
                    'worker_on_other_project:',
                    '',
                    $exceptionMessage
                ).'.',

            str_starts_with(
                $exceptionMessage,
                'worker_has_active_tasks:'
            ) =>
                str_replace(
                    'worker_has_active_tasks:',
                    '',
                    $exceptionMessage
                )
                .' tidak dapat dinonaktifkan karena masih memiliki tugas aktif.',

            default =>
                'Perubahan pekerja gagal disimpan.',
        };

        $this->addError(
            'workers',
            $message
        );
    }

    private function authorizeManageWorkers(): void
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User
                && $user->can(
                    'update projects'
                ),
            403
        );
    }

    public function render()
    {
        $assignments = ProjectWorker::query()
            ->where(
                'project_id',
                $this->projectId
            )
            ->get()
            ->keyBy('worker_id');

        /*
         * Mengambil tugas aktif pada Project ini.
         */
        $activeTaskCounts = Task::query()
            ->where(
                'project_id',
                $this->projectId
            )
            ->whereNotNull('worker_id')
            ->whereNotIn(
                'status',
                [
                    'completed',
                    'cancelled',
                ]
            )
            ->selectRaw(
                'worker_id, COUNT(*) as total'
            )
            ->groupBy('worker_id')
            ->pluck(
                'total',
                'worker_id'
            );

        /*
         * Mengambil penempatan aktif pekerja
         * pada Project lain.
         */
        $otherProjectAssignments =
            ProjectWorker::query()
                ->with(
                    'project:id,project_code,project_name'
                )
                ->where(
                    'project_id',
                    '!=',
                    $this->projectId
                )
                ->where(
                    'status',
                    'active'
                )
                ->get()
                ->keyBy('worker_id');

        $workers = User::query()
            ->role('pekerja')
            ->when(
                trim($this->search) !== '',
                function ($query): void {
                    $search =
                        '%'.trim(
                            $this->search
                        ).'%';

                    $query->where(
                        function (
                            $query
                        ) use ($search): void {
                            $query
                                ->where(
                                    'name',
                                    'like',
                                    $search
                                )
                                ->orWhere(
                                    'email',
                                    'like',
                                    $search
                                );
                        }
                    );
                }
            )
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'email',
            ]);

        $selectedWorkerIds = collect(
            $this->selectedWorkerIds
        )
            ->map(
                fn ($workerId): int =>
                    (int) $workerId
            )
            ->sort()
            ->values()
            ->all();

        $originalWorkerIds = collect(
            $this->originalWorkerIds
        )
            ->map(
                fn ($workerId): int =>
                    (int) $workerId
            )
            ->sort()
            ->values()
            ->all();

        $hasChanges =
            $selectedWorkerIds
            !== $originalWorkerIds;

        return view(
            'livewire.owner.projects.manage-workers',
            [
                'workers' =>
                    $workers,

                'assignments' =>
                    $assignments,

                'activeTaskCounts' =>
                    $activeTaskCounts,

                'otherProjectAssignments' =>
                    $otherProjectAssignments,

                'hasChanges' =>
                    $hasChanges,
            ]
        );
    }
}