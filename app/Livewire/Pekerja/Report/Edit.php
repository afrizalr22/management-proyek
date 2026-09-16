<?php

namespace App\Livewire\Pekerja\Report;

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
        $validated = $this->validate();

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
        $pathsToDelete = [];

        try {
            DB::transaction(
                function () use (
                    $validated,
                    $reportedProgress,
                    &$storedPaths,
                    &$pathsToDelete
                ): void {
                    $report = DailyReport::query()
                        ->where(
                            'user_id',
                            Auth::id()
                        )
                        ->with([
                            'task',
                            'project',
                        ])
                        ->lockForUpdate()
                        ->findOrFail(
                            $this->reportId
                        );

                    if (
                        $report->status
                        !== 'revision'
                    ) {
                        throw new RuntimeException(
                            'Laporan sudah tidak dapat diperbaiki.'
                        );
                    }

                    if (! $report->task) {
                        throw new RuntimeException(
                            'Task laporan tidak tersedia.'
                        );
                    }

                    if (
                        $report->task->status
                        !== 'revision'
                    ) {
                        throw new RuntimeException(
                            'Task sudah tidak berstatus revisi.'
                        );
                    }

                    if (
                        $reportedProgress
                        < (int) $report->task->progress
                    ) {
                        throw new RuntimeException(
                            'Progres laporan tidak boleh lebih rendah dari progres Task saat ini.'
                        );
                    }

                    $submittedAt = now();

                    $report->update([
                        'reported_progress' =>
                            $reportedProgress,

                        'work_status' =>
                            $validated['workStatus'],

                        'activities' =>
                            trim(
                                $validated['activities']
                            ),

                        'obstacles' =>
                            filled(
                                $validated['obstacles']
                                ?? null
                            )
                                ? trim(
                                    $validated['obstacles']
                                )
                                : null,

                        'notes' =>
                            filled(
                                $validated['notes']
                                ?? null
                            )
                                ? trim(
                                    $validated['notes']
                                )
                                : null,

                        'status' =>
                            'submitted',

                        'submitted_at' =>
                            $submittedAt,

                        'reviewed_by' =>
                            null,

                        'reviewed_at' =>
                            null,

                        'review_notes' =>
                            null,
                    ]);

                    $documentationsToRemove =
                        Documentation::query()
                            ->where(
                                'daily_report_id',
                                $report->id
                            )
                            ->where(
                                'user_id',
                                Auth::id()
                            )
                            ->whereIn(
                                'id',
                                $this->removedDocumentationIds
                            )
                            ->lockForUpdate()
                            ->get();

                    foreach (
                        $documentationsToRemove
                        as $documentation
                    ) {
                        if (
                            filled(
                                $documentation->photo
                            )
                        ) {
                            $pathsToDelete[] =
                                $documentation->photo;
                        }

                        $documentation->delete();
                    }

                    $storageDirectory =
                        'documentations/'
                        . Auth::id()
                        . '/'
                        . str_replace(
                            '-',
                            '/',
                            substr(
                                $this->reportDate,
                                0,
                                7
                            )
                        );

                    foreach (
                        $validated['photos'] ?? []
                        as $photo
                    ) {
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
                                'project_id' =>
                                    $report->project_id,

                                'task_id' =>
                                    $report->task_id,

                                'daily_report_id' =>
                                    $report->id,

                                'user_id' =>
                                    Auth::id(),

                                'title' =>
                                    $report->task->title,

                                'category' =>
                                    'progress',

                                'photo' =>
                                    $storedPath,

                                'original_name' =>
                                    $photo
                                        ->getClientOriginalName(),

                                'mime_type' =>
                                    $photo->getMimeType()
                                    ?: null,

                                'file_size' =>
                                    $photo->getSize()
                                    ?: null,

                                'description' =>
                                    trim(
                                        $validated['activities']
                                    ),

                                'documentation_date' =>
                                    $report
                                        ->report_date
                                        ->toDateString(),

                                'taken_at' =>
                                    $submittedAt,
                            ]);
                    }

                    $report->task->update([
                        'status' =>
                            'submitted',

                        'submitted_at' =>
                            $submittedAt,
                    ]);
                }
            );

            foreach (
                array_unique(
                    $pathsToDelete
                )
                as $pathToDelete
            ) {
                Storage::disk('public')
                    ->delete(
                        $pathToDelete
                    );
            }

            session()->flash(
                'success',
                'Perbaikan laporan berhasil dikirim kembali kepada Mandor.'
            );

            $this->redirectRoute(
                'pekerja.report.index',
                navigate: true
            );
        } catch (Throwable $exception) {
            foreach (
                $storedPaths
                as $storedPath
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
                    : 'Perbaikan laporan gagal dikirim. Silakan coba kembali.';

            $this->addError(
                'submit',
                $message
            );
        }
    }

    private function findRevisionReport(): DailyReport
    {
        $report = DailyReport::query()
            ->where(
                'user_id',
                Auth::id()
            )
            ->with([
                'project:id,project_name,location',
                'task:id,project_id,task_code,title,location,status,progress',
                'documentations' => fn ($query) =>
                    $query
                        ->where(
                            'user_id',
                            Auth::id()
                        )
                        ->orderBy('id'),
            ])
            ->findOrFail(
                $this->reportId
            );

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