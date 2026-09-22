<?php

namespace App\Livewire\Pekerja\Report;

use App\Models\DailyReport;
use App\Models\Documentation;
use App\Models\ProjectWorker;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use RuntimeException;
use Throwable;

class Create extends Component
{
    use WithFileUploads;

    public string $taskId = '';

    public string $reportDate = '';

    public string $activities = '';

    public string $workStatus = 'in_progress';

    public int|string $reportedProgress = 0;

    public string $obstacles = '';

    public string $notes = '';

    /**
     * @var array<int, TemporaryUploadedFile>
     */
    public array $photos = [];

    public string $projectName = '';

    public string $taskLocation = '';

    public int $currentTaskProgress = 0;

    public function mount(): void
    {
        $this->authenticatedWorker();

        $this->reportDate = now('Asia/Jakarta')
            ->toDateString();
    }

    protected function rules(): array
    {
        return [
            'taskId' => [
                'required',
                'integer',
            ],

            'reportDate' => [
                'required',
                'date',
                'before_or_equal:'
                    .now('Asia/Jakarta')
                        ->toDateString(),
            ],

            'activities' => [
                'required',
                'string',
                'min:10',
                'max:2000',
            ],

            'workStatus' => [
                'required',
                Rule::in([
                    'in_progress',
                    'completed',
                ]),
            ],

            'reportedProgress' => [
                'required',
                'integer',
                'min:0',
                'max:100',
            ],

            'obstacles' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'photos' => [
                'nullable',
                'array',
                'max:5',
            ],

            'photos.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'taskId.required' => 'Task wajib dipilih.',
            'taskId.integer' => 'Task yang dipilih tidak valid.',

            'reportDate.required' => 'Tanggal laporan wajib diisi.',
            'reportDate.date' => 'Tanggal laporan tidak valid.',
            'reportDate.before_or_equal' => 'Tanggal laporan tidak boleh melewati tanggal hari ini.',

            'activities.required' => 'Uraian hasil pekerjaan wajib diisi.',
            'activities.string' => 'Uraian hasil pekerjaan tidak valid.',
            'activities.min' => 'Uraian hasil pekerjaan minimal 10 karakter.',
            'activities.max' => 'Uraian hasil pekerjaan maksimal 2.000 karakter.',

            'workStatus.required' => 'Status pekerjaan wajib dipilih.',
            'workStatus.in' => 'Status pekerjaan tidak valid.',

            'reportedProgress.required' => 'Persentase progres wajib diisi.',
            'reportedProgress.integer' => 'Persentase progres harus berupa angka bulat.',
            'reportedProgress.min' => 'Persentase progres minimal 0%.',
            'reportedProgress.max' => 'Persentase progres maksimal 100%.',

            'obstacles.string' => 'Kendala pekerjaan tidak valid.',
            'obstacles.max' => 'Kendala pekerjaan maksimal 1.000 karakter.',

            'notes.string' => 'Catatan tambahan tidak valid.',
            'notes.max' => 'Catatan tambahan maksimal 1.000 karakter.',

            'photos.array' => 'Daftar foto dokumentasi tidak valid.',
            'photos.max' => 'Maksimal lima foto dalam satu laporan.',
            'photos.*.image' => 'Setiap file harus berupa gambar.',
            'photos.*.mimes' => 'Foto harus berformat JPG, JPEG, PNG, atau WEBP.',
            'photos.*.max' => 'Ukuran setiap foto maksimal 5 MB.',
        ];
    }

    public function updatedTaskId(): void
    {
        $this->resetValidation('taskId');

        $this->resetTaskInformation();

        if ($this->taskId === '') {
            return;
        }

        $task = $this
            ->availableTaskQuery()
            ->with(
                'project:id,project_name,location'
            )
            ->find($this->taskId);

        if (! $task) {
            $this->taskId = '';

            $this->addError(
                'taskId',
                'Task tidak tersedia atau belum dapat dilaporkan.'
            );

            return;
        }

        $this->projectName =
            $task->project?->project_name
            ?? 'Proyek tidak tersedia';

        $this->taskLocation =
            filled($task->location)
                ? $task->location
                : (
                    $task->project?->location
                    ?? 'Lokasi belum tersedia'
                );

        $this->currentTaskProgress =
            (int) $task->progress;

        $this->reportedProgress =
            (int) $task->progress;
    }

    public function updatedWorkStatus(
        string $value
    ): void {
        $this->resetValidation([
            'workStatus',
            'reportedProgress',
        ]);

        if ($value === 'completed') {
            $this->reportedProgress = 100;

            return;
        }

        if (
            (int) $this->reportedProgress >= 100
        ) {
            $this->reportedProgress = max(
                0,
                min(
                    99,
                    $this->currentTaskProgress
                )
            );
        }
    }

    public function removePhoto(int $index): void
    {
        if (! array_key_exists($index, $this->photos)) {
            return;
        }

        unset($this->photos[$index]);

        $this->photos = array_values(
            $this->photos
        );

        $this->resetValidation([
            'photos',
            'photos.*',
        ]);
    }

    public function submitReport(): void
    {
        $validated = $this->validate();

        $worker = $this->authenticatedWorker();

        $reportedProgress =
            (int) $validated['reportedProgress'];

        if (
            $validated['workStatus'] === 'completed'
            && $reportedProgress !== 100
        ) {
            $this->addError(
                'reportedProgress',
                'Pekerjaan selesai harus memiliki progres 100%.'
            );

            return;
        }

        if (
            $validated['workStatus'] === 'in_progress'
            && $reportedProgress >= 100
        ) {
            $this->addError(
                'reportedProgress',
                'Gunakan status Selesai jika progres telah mencapai 100%.'
            );

            return;
        }

        $storedPaths = [];

        try {
            DB::transaction(
                function () use (
                    $validated,
                    $worker,
                    $reportedProgress,
                    &$storedPaths
                ): void {
                    $task = Task::query()
                        ->with('project')
                        ->whereKey(
                            $validated['taskId']
                        )
                        ->where(
                            'worker_id',
                            $worker->id
                        )
                        ->lockForUpdate()
                        ->first();

                    if (! $task) {
                        throw new RuntimeException(
                            'Task tidak tersedia atau sudah tidak dapat dilaporkan.'
                        );
                    }

                    if (
                        ! $task->project
                        || ! in_array(
                            $task->project->status,
                            [
                                'planning',
                                'on_progress',
                            ],
                            true
                        )
                    ) {
                        throw new RuntimeException(
                            'Project sudah selesai atau dibatalkan. Laporan tidak dapat dikirim lagi.'
                        );
                    }

                    if (
                        $task->status !== 'in_progress'
                    ) {
                        throw new RuntimeException(
                            'Task ini sudah tidak dapat dilaporkan.'
                        );
                    }

                    $activeAssignmentExists =
                        ProjectWorker::query()
                            ->where(
                                'project_id',
                                $task->project_id
                            )
                            ->where(
                                'worker_id',
                                $worker->id
                            )
                            ->where(
                                'status',
                                'active'
                            )
                            ->exists();

                    if (! $activeAssignmentExists) {
                        throw new RuntimeException(
                            'Penugasan Anda pada Project ini sudah tidak aktif. Laporan tidak dapat dikirim.'
                        );
                    }

                    $reportDate =
                        $validated['reportDate'];

                    if ($task->started_at) {
                        $taskStartDate = $task
                            ->started_at
                            ->copy()
                            ->timezone('Asia/Jakarta')
                            ->toDateString();

                        if (
                            $reportDate < $taskStartDate
                        ) {
                            throw new RuntimeException(
                                'Tanggal laporan tidak boleh lebih awal dari tanggal Task dimulai.'
                            );
                        }
                    }

                    $duplicateExists =
                        DailyReport::query()
                            ->where(
                                'user_id',
                                $worker->id
                            )
                            ->where(
                                'task_id',
                                $task->id
                            )
                            ->whereDate(
                                'report_date',
                                $reportDate
                            )
                            ->lockForUpdate()
                            ->exists();

                    if ($duplicateExists) {
                        throw new RuntimeException(
                            'Laporan untuk Task dan tanggal tersebut sudah tersedia.'
                        );
                    }

                    if (
                        $reportedProgress
                        < (int) $task->progress
                    ) {
                        throw new RuntimeException(
                            'Progres laporan tidak boleh lebih rendah dari progres Task saat ini.'
                        );
                    }

                    $submittedAt = now();

                    $report = DailyReport::query()
                        ->create([
                            'report_number' => null,

                            'project_id' => $task->project_id,

                            'task_id' => $task->id,

                            'user_id' => $worker->id,

                            'report_date' => $reportDate,

                            'reported_progress' => $reportedProgress,

                            'work_status' => $validated['workStatus'],

                            'activities' => trim(
                                $validated['activities']
                            ),

                            'obstacles' => filled(
                                $validated['obstacles']
                                ?? null
                            )
                                    ? trim(
                                        $validated['obstacles']
                                    )
                                    : null,

                            'notes' => filled(
                                $validated['notes']
                                ?? null
                            )
                                    ? trim(
                                        $validated['notes']
                                    )
                                    : null,

                            'status' => 'submitted',

                            'submitted_at' => $submittedAt,

                            'reviewed_by' => null,

                            'reviewed_at' => null,

                            'review_notes' => null,
                        ]);

                    $report->update([
                        'report_number' => 'RPT-'
                            .str_replace(
                                '-',
                                '',
                                $reportDate
                            )
                            .'-'
                            .str_pad(
                                (string) $report->id,
                                6,
                                '0',
                                STR_PAD_LEFT
                            ),
                    ]);

                    $storageDirectory =
                        'documentations/'
                        .$worker->id
                        .'/'
                        .str_replace(
                            '-',
                            '/',
                            substr(
                                $reportDate,
                                0,
                                7
                            )
                        );

                    foreach (
                        $validated['photos'] ?? [] as $photo
                    ) {
                        $originalName =
                            $photo->getClientOriginalName();

                        $mimeType =
                            $photo->getMimeType()
                            ?: null;

                        $fileSize =
                            $photo->getSize()
                            ?: null;

                        $storedPath = $photo->store(
                            $storageDirectory,
                            'public'
                        );

                        if (! is_string($storedPath)) {
                            throw new RuntimeException(
                                'Foto dokumentasi gagal disimpan.'
                            );
                        }

                        $storedPaths[] =
                            $storedPath;

                        Documentation::query()
                            ->create([
                                'project_id' => $task->project_id,

                                'task_id' => $task->id,

                                'daily_report_id' => $report->id,

                                'user_id' => $worker->id,

                                'title' => $task->title,

                                'category' => 'progress',

                                'photo' => $storedPath,

                                'original_name' => $originalName,

                                'mime_type' => $mimeType,

                                'file_size' => $fileSize,

                                'description' => trim(
                                    $validated['activities']
                                ),

                                'documentation_date' => $reportDate,

                                'taken_at' => $submittedAt,
                            ]);
                    }

                    $task->update([
                        'status' => 'submitted',

                        'submitted_at' => $submittedAt,
                    ]);
                },
                3
            );

            session()->flash(
                'success',
                'Laporan berhasil dikirim dan sedang menunggu pemeriksaan Mandor.'
            );

            $this->redirectRoute(
                'pekerja.report.index',
                navigate: true
            );
        } catch (Throwable $exception) {
            foreach (
                $storedPaths as $storedPath
            ) {
                Storage::disk('public')
                    ->delete(
                        $storedPath
                    );
            }

            report(
                $exception
            );

            $message =
                $exception instanceof RuntimeException
                    ? $exception->getMessage()
                    : 'Laporan gagal dikirim. Silakan coba kembali.';

            $this->addError(
                'submit',
                $message
            );
        }
    }

    private function resetTaskInformation(): void
    {
        $this->projectName = '';

        $this->taskLocation = '';

        $this->currentTaskProgress = 0;

        $this->reportedProgress = 0;
    }

    private function availableTaskQuery(): Builder
    {
        $worker = $this->authenticatedWorker();

        $activeProjectIds = $worker
            ->activeWorkerProjects()
            ->whereIn(
                'projects.status',
                [
                    'planning',
                    'on_progress',
                ]
            )
            ->pluck(
                'projects.id'
            );

        return Task::query()
            ->where(
                'worker_id',
                $worker->id
            )
            ->whereIn(
                'project_id',
                $activeProjectIds
            )
            ->where(
                'status',
                'in_progress'
            );
    }

    private function authenticatedWorker(): User
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User
                && $user->hasRole('pekerja')
                && $user->isActive(),
            403
        );

        return $user;
    }

    public function render()
    {
        $availableTasks = $this
            ->availableTaskQuery()
            ->with(
                'project:id,project_name,location'
            )
            ->orderBy('due_at')
            ->orderBy('title')
            ->get();

        return view(
            'livewire.pekerja.report.create',
            [
                'availableTasks' => $availableTasks,
            ]
        );
    }
}
