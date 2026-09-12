<?php

namespace App\Livewire\Mandor\DailyReports;

use App\Models\DailyReport;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;
    public int $reportId;

    /*
    |--------------------------------------------------------------------------
    | Data laporan
    |--------------------------------------------------------------------------
    */
    public array $existingDocumentations = [];
    public array $removedDocumentationIds = [];
    public array $newPhotos = [];
    public string $documentationDescription = '';
    public string $projectName = 'Pembangunan Gedung Perkantoran Sudirman';
    public string $reportDate = '2026-08-25';
    public string $activities = '';
    public string $obstacles = '';
    public string $notes = '';

    public function mount(
        DailyReport $report
    ): void {
        $this->authorizeReport(
            $report
        );

        $this->reportId = $report->id;

        $this->projectName =
            $report->project?->project_name
            ?? 'Project tidak ditemukan';

        $this->reportDate =
            $report->report_date
                ?->format('Y-m-d')
            ?? today()->format('Y-m-d');

        $this->activities =
            $report->activities
            ?? '';

        $this->obstacles =
            $report->obstacles
            ?? '';

        $this->notes =
            $report->notes
            ?? '';

        $this->existingDocumentations =
            $report->documentations()
                ->orderBy('id')
                ->get()
                ->map(
                    fn ($documentation): array => [
                        'id' =>
                            $documentation->id,

                        'photo' =>
                            $documentation->photo,

                        'description' =>
                            $documentation->description
                            ?? $documentation->title
                            ?? 'Dokumentasi pekerjaan',

                        'time' =>
                            (
                                $documentation->taken_at
                                ?? $documentation->created_at
                            )?->format('H:i').' WIB',
                    ]
                )
                ->all();

        $this->removedDocumentationIds = [];
        $this->newPhotos = [];
    }

    private function authorizeReport(
        DailyReport $report
    ): void {
        $isOwnedByMandor = DailyReport::query()
            ->whereKey($report->id)
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

    public function updateReport(): void
    {
        $report = DailyReport::query()
            ->with('project')
            ->findOrFail(
                $this->reportId
            );

        $this->authorizeReport(
            $report
        );

        $this->validate();

        session()->flash(
            'success',
            'Perubahan laporan berhasil divalidasi.'
        );
    }

    public function render()
    {
        return view('livewire.mandor.daily-reports.edit');
    }

    protected function rules(): array
    {
        return [
            'reportDate' => [
                'required',
                'date',
                'before_or_equal:today',
            ],

            'activities' => [
                'required',
                'string',
                'min:10',
                'max:2000',
            ],

            'newPhotos' => [
                'array',
                'max:5',
            ],

            'newPhotos.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'documentationDescription' => [
                'nullable',
                'string',
                'max:500',
            ],
        ];
    }

        protected function messages(): array
    {
        return [
            'reportDate.required' => 'Tanggal laporan wajib diisi.',
            'reportDate.date' => 'Format tanggal laporan tidak valid.',
            'reportDate.before_or_equal' => 'Tanggal laporan tidak boleh melebihi hari ini.',

            'activities.required' => 'Aktivitas pekerjaan wajib diisi.',
            'activities.string' => 'Aktivitas pekerjaan harus berupa teks.',
            'activities.min' => 'Aktivitas pekerjaan minimal 10 karakter.',
            'activities.max' => 'Aktivitas pekerjaan maksimal 2.000 karakter.',

            'newPhotos.max' => 'Dokumentasi maksimal 5 foto.',
            'newPhotos.*.image' => 'File dokumentasi harus berupa gambar.',
            'newPhotos.*.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'newPhotos.*.max' => 'Ukuran setiap foto maksimal 5 MB.',
            'documentationDescription.max' => 'Keterangan dokumentasi maksimal 500 karakter.',
        ];

        
    }

    public function removeExistingDocumentation(int $documentationId): void
    {
        $this->removedDocumentationIds[] = $documentationId;

        $this->existingDocumentations = array_values(
            array_filter(
                $this->existingDocumentations,
                fn (array $documentation) =>
                    $documentation['id'] !== $documentationId
            )
        );
    }

    public function removeNewPhoto(int $index): void
    {
        unset($this->newPhotos[$index]);

        $this->newPhotos = array_values($this->newPhotos);
    }

    public function updatedNewPhotos(): void
    {
        $this->newPhotos ??= [];
        $this->existingDocumentations ??= [];

        $this->validate([
            'newPhotos.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        $totalPhotos = count($this->existingDocumentations)
            + count($this->newPhotos);

        if ($totalPhotos > 5) {
            $allowedNewPhotos = max(
                0,
                5 - count($this->existingDocumentations)
            );

            $this->newPhotos = array_slice(
                $this->newPhotos,
                0,
                $allowedNewPhotos
            );

            $this->addError(
                'newPhotos',
                'Jumlah keseluruhan dokumentasi maksimal 5 foto.'
            );
        }
    }
}