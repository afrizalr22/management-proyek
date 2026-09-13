<?php

namespace App\Livewire\Pekerja\Documentation;

use App\Models\Documentation;
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

    /**
     * Status Task yang sudah dapat didokumentasikan.
     */
    private const DOCUMENTABLE_TASK_STATUSES = [
        'in_progress',
        'revision',
    ];

    /**
     * Kategori dokumentasi yang tersedia.
     */
    private const CATEGORIES = [
        'progress',
        'material',
        'safety',
        'obstacle',
        'other',
    ];

    public string $taskId = '';

    public string $category = 'progress';

    public string $description = '';

    /**
     * @var array<int, TemporaryUploadedFile>
     */
    public array $photos = [];

    public string $projectName = '';

    public string $taskLocation = '';

    public function mount(): void
    {
        $this->authenticatedWorker();
    }

    protected function rules(): array
    {
        return [
            'taskId' => [
                'required',
                'integer',
            ],

            'category' => [
                'required',
                Rule::in(self::CATEGORIES),
            ],

            'description' => [
                'required',
                'string',
                'max:1000',
            ],

            'photos' => [
                'required',
                'array',
                'min:1',
                'max:5',
            ],

            'photos.*' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'taskId.required' =>
                'Tugas wajib dipilih.',

            'taskId.integer' =>
                'Tugas yang dipilih tidak valid.',

            'category.required' =>
                'Kategori dokumentasi wajib dipilih.',

            'category.in' =>
                'Kategori dokumentasi tidak valid.',

            'description.required' =>
                'Keterangan lapangan wajib diisi.',

            'description.string' =>
                'Keterangan lapangan tidak valid.',

            'description.max' =>
                'Keterangan lapangan maksimal 1.000 karakter.',

            'photos.required' =>
                'Pilih minimal satu foto dokumentasi.',

            'photos.array' =>
                'Daftar foto dokumentasi tidak valid.',

            'photos.min' =>
                'Pilih minimal satu foto dokumentasi.',

            'photos.max' =>
                'Maksimal lima foto dalam satu kali penyimpanan.',

            'photos.*.required' =>
                'Foto dokumentasi tidak valid.',

            'photos.*.image' =>
                'Setiap file harus berupa gambar.',

            'photos.*.mimes' =>
                'Foto harus berformat JPG, JPEG, PNG, atau WEBP.',

            'photos.*.max' =>
                'Ukuran setiap foto maksimal 5 MB.',
        ];
    }

    /**
     * Memperbarui informasi proyek ketika Task dipilih.
     */
    public function updatedTaskId(): void
    {
        $this->resetValidation('taskId');

        $this->projectName = '';
        $this->taskLocation = '';

        if ($this->taskId === '') {
            return;
        }

        $task = $this->availableTaskQuery()
            ->with('project:id,project_name,location')
            ->find($this->taskId);

        if (! $task) {
            $this->taskId = '';

            $this->addError(
                'taskId',
                'Tugas tidak tersedia atau belum dapat didokumentasikan.'
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
    }

    /**
     * Memvalidasi foto segera setelah dipilih.
     */
    public function updatedPhotos(): void
    {
        $this->resetValidation('photos');

        $this->validateOnly(
            'photos',
            [
                'photos' => [
                    'required',
                    'array',
                    'min:1',
                    'max:5',
                ],

                'photos.*' => [
                    'required',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:5120',
                ],
            ]
        );
    }

    /**
     * Menghapus satu foto dari daftar sebelum disimpan.
     */
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
            "photos.$index",
        ]);
    }

    /**
     * Menyimpan seluruh foto sebagai record dokumentasi terpisah.
     */
    public function save(): void
    {
        $validated = $this->validate();

        $worker = $this->authenticatedWorker();

        $storedPaths = [];

        try {
            DB::transaction(
                function () use (
                    $validated,
                    $worker,
                    &$storedPaths
                ): void {
                    $task = $this->availableTaskQuery()
                        ->lockForUpdate()
                        ->find($validated['taskId']);

                    if (! $task) {
                        throw new RuntimeException(
                            'Tugas tidak tersedia atau belum dapat didokumentasikan.'
                        );
                    }

                    $documentedAt = now();

                    $documentationDate = $documentedAt
                        ->copy()
                        ->timezone('Asia/Jakarta')
                        ->toDateString();

                    $storageDirectory = 'documentations/'
                        . $worker->id
                        . '/'
                        . $documentedAt
                            ->copy()
                            ->timezone('Asia/Jakarta')
                            ->format('Y/m');

                    foreach ($validated['photos'] as $photo) {
                        $originalName =
                            $photo->getClientOriginalName();

                        $mimeType =
                            $photo->getMimeType();

                        $fileSize =
                            $photo->getSize();

                        $storedPath = $photo->store(
                            $storageDirectory,
                            'public'
                        );

                        if (! is_string($storedPath)) {
                            throw new RuntimeException(
                                'Foto dokumentasi gagal disimpan.'
                            );
                        }

                        $storedPaths[] = $storedPath;

                        Documentation::query()->create([
                            'project_id' =>
                                $task->project_id,

                            'task_id' =>
                                $task->id,

                            'daily_report_id' =>
                                null,

                            'user_id' =>
                                $worker->id,

                            'title' =>
                                $task->title,

                            'category' =>
                                $validated['category'],

                            'photo' =>
                                $storedPath,

                            'original_name' =>
                                $originalName,

                            'mime_type' =>
                                $mimeType,

                            'file_size' =>
                                $fileSize,

                            'description' =>
                                trim(
                                    $validated['description']
                                ),

                            'documentation_date' =>
                                $documentationDate,

                            'taken_at' =>
                                $documentedAt,
                        ]);
                    }
                },
                3
            );

            session()->flash(
                'success',
                count($storedPaths)
                    . ' foto dokumentasi berhasil disimpan.'
            );

            $this->redirectRoute(
                'pekerja.documentation.index',
                navigate: true
            );
        } catch (Throwable $exception) {
            foreach ($storedPaths as $storedPath) {
                Storage::disk('public')
                    ->delete($storedPath);
            }

            report($exception);

            $message =
                $exception instanceof RuntimeException
                    ? $exception->getMessage()
                    : 'Dokumentasi gagal disimpan. Silakan coba kembali.';

            $this->addError(
                'save',
                $message
            );
        }
    }

    /**
     * Query Task yang sah untuk Pekerja aktif.
     */
    private function availableTaskQuery(): Builder
    {
        $worker = $this->authenticatedWorker();

        $activeProjectIds = $worker
            ->activeWorkerProjects()
            ->pluck('projects.id');

        return Task::query()
            ->where(
                'worker_id',
                $worker->id
            )
            ->whereIn(
                'project_id',
                $activeProjectIds
            )
            ->whereIn(
                'status',
                self::DOCUMENTABLE_TASK_STATUSES
            );
    }

    /**
     * Memastikan pengguna adalah Pekerja aktif.
     */
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
        $worker = $this->authenticatedWorker();

        $availableTasks = $this
            ->availableTaskQuery()
            ->with(
                'project:id,project_name,location'
            )
            ->orderByRaw(
                "
                    CASE status
                        WHEN 'revision' THEN 1
                        WHEN 'in_progress' THEN 2
                        ELSE 3
                    END
                "
            )
            ->orderBy('due_at')
            ->orderBy('title')
            ->get();

        $todayInJakarta = now('Asia/Jakarta')
            ->toDateString();

        $recentUploads = Documentation::query()
            ->where(
                'user_id',
                $worker->id
            )
            ->whereDate(
                'documentation_date',
                $todayInJakarta
            )
            ->with([
                'task:id,title',
                'project:id,project_name',
            ])
            ->latest('taken_at')
            ->latest('id')
            ->limit(5)
            ->get();

        return view(
            'livewire.pekerja.documentation.create',
            [
                'availableTasks' =>
                    $availableTasks,

                'recentUploads' =>
                    $recentUploads,
            ]
        );
    }
}