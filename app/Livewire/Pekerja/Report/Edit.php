<?php

namespace App\Livewire\Pekerja\Report;

use App\Models\Project;
use App\Models\ProjectWorker;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use App\Models\DailyReport;
use App\Models\Documentation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use RuntimeException;
use Throwable;

class Edit extends Component
{
    use WithFileUploads;

    public int $reportId;

    public string $reportNumber = '';

    public string $reportDate = '';

    public string $taskCode = '';

    public string $taskTitle = '';

    public string $projectName = '';

    public string $taskLocation = '';

    public string $activities = '';

    public string $workStatus = 'in_progress';

    public int|string $reportedProgress = 0;

    public int $currentTaskProgress = 0;

    public string $obstacles = '';

    public string $notes = '';

    public string $reviewNotes = '';

    /**
     * @var array<int, array<string, mixed>>
     */
    public array $existingDocumentations = [];

    /**
     * @var array<int, int>
     */
    public array $removedDocumentationIds = [];

    /**
     * @var array<int, TemporaryUploadedFile>
     */
    public array $photos = [];

    public function mount(
        int $report
    ): void {
        $this->authenticatedWorker();

        $this->reportId = $report;

        $dailyReport = $this->findRevisionReport();

        $this->reportNumber =
            $dailyReport->report_number
            ?? 'Nomor laporan tidak tersedia';

        $this->reportDate =
            $dailyReport->report_date
                ?->toDateString()
            ?? '';

        $this->taskCode =
            $dailyReport->task?->task_code
            ?? '';

        $this->taskTitle =
            $dailyReport->task?->title
            ?? 'Task tidak tersedia';

        $this->projectName =
            $dailyReport->project?->project_name
            ?? 'Proyek tidak tersedia';

        $this->taskLocation =
            filled($dailyReport->task?->location)
                ? $dailyReport->task->location
                : (
                    $dailyReport->project?->location
                    ?? 'Lokasi belum tersedia'
                );

        $this->activities =
            $dailyReport->activities;

        $this->workStatus =
            $dailyReport->work_status;

        $this->reportedProgress =
            (int) $dailyReport->reported_progress;

        $this->currentTaskProgress =
            (int) (
                $dailyReport->task?->progress
                ?? 0
            );

        $this->obstacles =
            $dailyReport->obstacles
            ?? '';

        $this->notes =
            $dailyReport->notes
            ?? '';

        $this->reviewNotes =
            $dailyReport->review_notes
            ?? '';

        $this->existingDocumentations =
            $dailyReport->documentations
                ->map(
                    function (
                        Documentation $documentation
                    ): array {
                        $photoExists =
                            filled($documentation->photo)
                            && Storage::disk('public')
                                ->exists(
                                    $documentation->photo
                                );

                        return [
                            'id' =>
                                $documentation->id,

                            'title' =>
                                $documentation->title,

                            'original_name' =>
                                $documentation->original_name,

                            'file_size' =>
                                $documentation->file_size,

                            'photo_exists' =>
                                $photoExists,

                            'photo_url' =>
                                $photoExists
                                    ? asset(
                                        'storage/'
                                        . ltrim(
                                            $documentation->photo,
                                            '/'
                                        )
                                    )
                                    : null,
                        ];
                    }
                )
                ->values()
                ->all();
    }

    protected function rules(): array
    {
        return [
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

            'removedDocumentationIds' => [
                'array',
            ],

            'removedDocumentationIds.*' => [
                'integer',
                'distinct',
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'activities.required' =>
                'Uraian hasil pekerjaan wajib diisi.',

            'activities.min' =>
                'Uraian hasil pekerjaan minimal 10 karakter.',

            'activities.max' =>
                'Uraian hasil pekerjaan maksimal 2.000 karakter.',

            'workStatus.required' =>
                'Status pekerjaan wajib dipilih.',

            'workStatus.in' =>
                'Status pekerjaan tidak valid.',

            'reportedProgress.required' =>
                'Persentase progres wajib diisi.',

            'reportedProgress.integer' =>
                'Persentase progres harus berupa angka bulat.',

            'reportedProgress.min' =>
                'Persentase progres minimal 0%.',

            'reportedProgress.max' =>
                'Persentase progres maksimal 100%.',

            'obstacles.max' =>
                'Kendala pekerjaan maksimal 1.000 karakter.',

            'notes.max' =>
                'Catatan tambahan maksimal 1.000 karakter.',

            'photos.array' =>
                'Daftar foto baru tidak valid.',

            'photos.max' =>
                'Maksimal lima foto baru dalam satu pengiriman.',

            'photos.*.image' =>
                'Setiap file harus berupa gambar.',

            'photos.*.mimes' =>
                'Foto harus berformat JPG, JPEG, PNG, atau WEBP.',

            'photos.*.max' =>
                'Ukuran setiap foto maksimal 5 MB.',
        ];
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

    public function removePhoto(
        int $index
    ): void {
        if (
            ! array_key_exists(
                $index,
                $this->photos
            )
        ) {
            return;
        }

        unset(
            $this->photos[$index]
        );

        $this->photos = array_values(
            $this->photos
        );

        $this->resetValidation([
            'photos',
            'photos.*',
        ]);
    }

    public function removeExistingDocumentation(
        int $documentationId
    ): void {
        $documentationExists = collect(
            $this->existingDocumentations
        )->contains(
            fn (array $documentation): bool =>
                (int) $documentation['id']
                    === $documentationId
        );

        if (! $documentationExists) {
            return;
        }

        $this->removedDocumentationIds[] =
            $documentationId;

        $this->removedDocumentationIds =
            array_values(
                array_unique(
                    $this->removedDocumentationIds
                )
            );

        $this->existingDocumentations =
            collect(
                $this->existingDocumentations
            )
                ->reject(
                    fn (array $documentation): bool =>
                        (int) $documentation['id']
                            === $documentationId
                )
                ->values()
                ->all();
    }

    public function resubmitReport(): void
    {
        $worker = $this->authenticatedWorker();

        $this->resetValidation('submit');

        $this->activities = trim($this->activities);
        $this->obstacles = trim($this->obstacles);
        $this->notes = trim($this->notes);

        $validated = $this->validate();

        $reportedProgress = (int) $validated['reportedProgress'];

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
        $pathsToDelete = [];

        try {
            DB::transaction(
                function () use (
                    $validated,
                    $worker,
                    $reportedProgress,
                    &$storedPaths,
                    &$pathsToDelete
                ): void {
                    /*
                    * Ambil identitas Task dari database,
                    * bukan dari properti formulir.
                    */
                    $reportReference = DailyReport::query()
                        ->where(function (Builder $query) use ($worker): void {
                            $query
                                ->where('user_id', $worker->id)
                                ->orWhereHas(
                                    'task.workers',
                                    fn (Builder $workerQuery) => $workerQuery
                                        ->where('users.id', $worker->id)
                                );
                        })
                        ->findOrFail($this->reportId);

                    $task = Task::query()
                        ->whereKey($reportReference->task_id)
                        ->whereHas(
                            'workers',
                            fn (Builder $query) => $query
                                ->where('users.id', $worker->id)
                        )
                        ->lockForUpdate()
                        ->first();

                    if (! $task) {
                        throw new RuntimeException(
                            'Task tidak tersedia atau Anda bukan anggota Task ini.'
                        );
                    }

                    $project = Project::query()
                        ->whereKey($task->project_id)
                        ->lockForUpdate()
                        ->first();

                    if (
                        ! $project
                        || ! in_array(
                            $project->status,
                            ['planning', 'on_progress'],
                            true
                        )
                    ) {
                        throw new RuntimeException(
                            'Project sudah selesai atau dibatalkan. Perbaikan laporan tidak dapat dikirim.'
                        );
                    }

                    $assignment = ProjectWorker::query()
                        ->where('project_id', $project->id)
                        ->where('worker_id', $worker->id)
                        ->where('status', 'active')
                        ->lockForUpdate()
                        ->first();

                    if (! $assignment) {
                        throw new RuntimeException(
                            'Penugasan Anda pada Project ini sudah tidak aktif.'
                        );
                    }

                    $report = DailyReport::query()
                        ->whereKey($this->reportId)
                        ->where('task_id', $task->id)
                        ->where('project_id', $project->id)
                        ->lockForUpdate()
                        ->firstOrFail();

                    /*
                    * Pemeriksaan dilakukan kembali setelah penguncian.
                    * Form lama tidak boleh menimpa pengiriman anggota lain.
                    */
                    if ($report->status !== 'revision') {
                        throw new RuntimeException(
                            'Laporan sudah tidak dapat diperbaiki.'
                        );
                    }

                    if ($task->status !== 'revision') {
                        throw new RuntimeException(
                            'Task sudah tidak berstatus revisi.'
                        );
                    }

                    $otherPendingReportExists = DailyReport::query()
                        ->where('task_id', $task->id)
                        ->where('id', '!=', $report->id)
                        ->whereIn('status', [
                            'draft',
                            'submitted',
                            'revision',
                        ])
                        ->exists();

                    if ($otherPendingReportExists) {
                        throw new RuntimeException(
                            'Task masih memiliki laporan lain yang belum selesai diperiksa.'
                        );
                    }

                    if ($reportedProgress < (int) $task->progress) {
                        throw new RuntimeException(
                            'Progres laporan tidak boleh lebih rendah dari progres Task saat ini.'
                        );
                    }

                    /*
                    * Semua foto pada laporan ini dapat dikelola anggota Task.
                    * ID dari formulir harus benar-benar milik laporan ini.
                    */
                    $removedIds = collect(
                        $validated['removedDocumentationIds'] ?? []
                    )
                        ->map(fn ($id): int => (int) $id)
                        ->unique()
                        ->values();

                    $documentations = Documentation::query()
                        ->where('daily_report_id', $report->id)
                        ->lockForUpdate()
                        ->get();

                    if (
                        $removedIds
                            ->diff($documentations->pluck('id'))
                            ->isNotEmpty()
                    ) {
                        throw new RuntimeException(
                            'Pilihan foto yang dihapus tidak valid.'
                        );
                    }

                    $remainingPhotoCount = $documentations->count()
                        - $removedIds->count();

                    if (
                        $remainingPhotoCount
                        + count($validated['photos'] ?? []) > 5
                    ) {
                        throw new RuntimeException(
                            'Maksimal lima foto dalam satu laporan. Hapus foto lama sebelum menambahkan foto pengganti.'
                        );
                    }

                    $submittedAt = now();

                    $report->update([
                        'reported_progress' => $reportedProgress,
                        'work_status' => $validated['workStatus'],
                        'activities' => $validated['activities'],
                        'obstacles' => filled($validated['obstacles'] ?? null)
                            ? $validated['obstacles']
                            : null,
                        'notes' => filled($validated['notes'] ?? null)
                            ? $validated['notes']
                            : null,
                        'status' => 'submitted',
                        'submitted_at' => $submittedAt,
                        'reviewed_by' => null,
                        'reviewed_at' => null,
                        'review_notes' => null,
                    ]);

                    foreach ($documentations as $documentation) {
                        if (! $removedIds->contains((int) $documentation->id)) {
                            continue;
                        }

                        if (filled($documentation->photo)) {
                            $pathsToDelete[] = $documentation->photo;
                        }

                        $documentation->delete();
                    }

                    $storageDirectory = 'documentations/'
                        .$worker->id
                        .'/'
                        .$report->report_date->format('Y/m');

                    foreach ($validated['photos'] ?? [] as $photo) {
                        $storedPath = $photo->store(
                            $storageDirectory,
                            'public'
                        );

                        if (! is_string($storedPath) || $storedPath === '') {
                            throw new RuntimeException(
                                'Foto dokumentasi gagal disimpan.'
                            );
                        }

                        $storedPaths[] = $storedPath;

                        Documentation::query()->create([
                            'project_id' => $project->id,
                            'task_id' => $task->id,
                            'daily_report_id' => $report->id,
                            'user_id' => $worker->id,
                            'title' => $task->title,
                            'category' => 'progress',
                            'photo' => $storedPath,
                            'original_name' => $photo->getClientOriginalName(),
                            'mime_type' => $photo->getMimeType() ?: null,
                            'file_size' => $photo->getSize() ?: null,
                            'description' => $validated['activities'],
                            'documentation_date' => $report->report_date
                                ->toDateString(),
                            'taken_at' => $submittedAt,
                        ]);
                    }

                    $task->update([
                        'status' => 'submitted',
                        'submitted_at' => $submittedAt,
                    ]);
                }
            );
        } catch (Throwable $exception) {
            /*
            * Transaksi gagal: hapus hanya foto baru.
            * Foto lama belum dihapus dari penyimpanan.
            */
            foreach ($storedPaths as $storedPath) {
                try {
                    Storage::disk('public')->delete($storedPath);
                } catch (Throwable $cleanupException) {
                    report($cleanupException);
                }
            }

            report($exception);

            $this->addError(
                'submit',
                $exception instanceof RuntimeException
                    ? $exception->getMessage()
                    : 'Perbaikan laporan gagal dikirim. Silakan coba kembali.'
            );

            return;
        }

        /*
        * Database berhasil disimpan.
        * Kegagalan menghapus file lama tidak boleh menghapus foto baru
        * yang sekarang sudah digunakan laporan.
        */
        foreach (array_unique($pathsToDelete) as $pathToDelete) {
            try {
                $stillUsed = Documentation::query()
                    ->where('photo', $pathToDelete)
                    ->exists();

                if (
                    ! $stillUsed
                    && ! Storage::disk('public')->delete($pathToDelete)
                ) {
                    report(new RuntimeException(
                        'File foto lama gagal dihapus setelah revisi laporan.'
                    ));
                }
            } catch (Throwable $exception) {
                report($exception);
            }
        }

        session()->flash(
            'success',
            'Perbaikan laporan berhasil dikirim kembali kepada Mandor.'
        );

        $this->redirectRoute(
            'pekerja.report.index',
            navigate: true
        );
    }

    private function findRevisionReport(): DailyReport
    {
        $worker = $this->authenticatedWorker();

        $report = DailyReport::query()
            ->where(function (Builder $query) use ($worker): void {
                $query
                    ->where('user_id', $worker->id)
                    ->orWhereHas(
                        'task.workers',
                        fn (Builder $workerQuery) => $workerQuery
                            ->where('users.id', $worker->id)
                    );
            })
            ->with([
                'project:id,project_name,location',
                'task:id,project_id,task_code,title,location,status,progress',
                'documentations' => fn ($query) => $query
                    ->orderBy('id'),
            ])
            ->findOrFail($this->reportId);

        abort_unless(
            $report->status === 'revision',
            409,
            'Laporan ini tidak berstatus revisi.'
        );

        return $report;
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
        $this->authenticatedWorker();

        return view(
            'livewire.pekerja.report.edit'
        );
    }
}