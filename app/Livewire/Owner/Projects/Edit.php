<?php

namespace App\Livewire\Owner\Projects;

use App\Models\Client;
use App\Models\Project;
use App\Models\Quotation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Throwable;

class Edit extends Component
{
    public Project $project;

    public ?Quotation $sourceQuotation = null;

    public string $pageTitle = 'Edit Project';

    public string $pageDescription =
        'Perbarui informasi Project yang telah dibuat.';

    public ?int $clientId = null;

    public ?int $mandorId = null;

    public string $projectCode = '';

    public string $projectName = '';

    public string $location = '';

    public string $description = '';

    public string $contractNumber = '';

    public string $contractDate = '';

    public $projectBudget = 0;

    public $contractValue = 0;

    public string $startDate = '';

    public string $endDate = '';

    public function mount(Project $project): void
    {
        $this->authorizeUpdateProject();

        abort_unless(
            in_array(
                $project->status,
                [
                    'planning',
                    'on_progress',
                ],
                true
            ),
            403,
            'Project yang telah selesai atau dibatalkan tidak dapat diubah.'
        );

        $project->load([
            'client',
            'mandor',
            'quotations' => fn ($query) => $query
                ->with([
                    'items' => fn ($query) => $query
                        ->orderBy('sort_order')
                        ->orderBy('id'),
                ])
                ->latest('id'),
        ]);

        $this->project = $project;

        $this->sourceQuotation =
            $project->quotations->first();

        $this->clientId = $project->client_id;
        $this->mandorId = $project->mandor_id;
        $this->projectCode = $project->project_code;
        $this->projectName = $project->project_name;
        $this->location = $project->location ?? '';
        $this->description = $project->description ?? '';

        $this->contractNumber =
            $project->contract_number ?? '';

        $this->contractDate = $project->contract_date
            ? $project->contract_date->format('Y-m-d')
            : '';

        $this->projectBudget =
            (float) $project->project_budget;

        $this->contractValue =
            (float) $project->contract_value;

        $this->startDate = $project->start_date
            ? $project->start_date->format('Y-m-d')
            : '';

        $this->endDate = $project->end_date
            ? $project->end_date->format('Y-m-d')
            : '';

        $this->pageTitle =
            'Edit '.$project->project_name;

        $this->pageDescription = sprintf(
            'Perbarui informasi Project %s.',
            $project->project_code
        );
    }

    protected function rules(): array
    {
        return [
            'mandorId' => [
                'required',
                'integer',
                'exists:users,id',
            ],

            'projectName' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],

            'location' => [
                'required',
                'string',
                'min:3',
                'max:2000',
            ],

            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'contractNumber' => [
                'nullable',
                'string',
                'max:255',
            ],

            'contractDate' => [
                'nullable',
                'date',
            ],

            'projectBudget' => [
                'required',
                'numeric',
                'min:0',
            ],

            'startDate' => [
                'required',
                'date',
            ],

            'endDate' => [
                'required',
                'date',
                'after_or_equal:startDate',
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'mandorId.required' =>
                'Mandor wajib dipilih.',

            'mandorId.exists' =>
                'Mandor yang dipilih tidak ditemukan.',

            'projectName.required' =>
                'Nama Project wajib diisi.',

            'projectName.min' =>
                'Nama Project minimal 3 karakter.',

            'projectName.max' =>
                'Nama Project maksimal 255 karakter.',

            'location.required' =>
                'Lokasi Project wajib diisi.',

            'location.min' =>
                'Lokasi Project minimal 3 karakter.',

            'location.max' =>
                'Lokasi Project maksimal 2.000 karakter.',

            'description.max' =>
                'Deskripsi Project maksimal 5.000 karakter.',

            'contractNumber.max' =>
                'Nomor kontrak maksimal 255 karakter.',

            'contractDate.date' =>
                'Format tanggal kontrak tidak valid.',

            'projectBudget.required' =>
                'Anggaran Project wajib diisi.',

            'projectBudget.numeric' =>
                'Anggaran Project harus berupa angka.',

            'projectBudget.min' =>
                'Anggaran Project tidak boleh negatif.',

            'startDate.required' =>
                'Tanggal mulai wajib diisi.',

            'startDate.date' =>
                'Format tanggal mulai tidak valid.',

            'endDate.required' =>
                'Tanggal selesai wajib diisi.',

            'endDate.date' =>
                'Format tanggal selesai tidak valid.',

            'endDate.after_or_equal' =>
                'Tanggal selesai tidak boleh sebelum tanggal mulai.',
        ];
    }

    public function updateProject()
    {
        $this->authorizeUpdateProject();

        $validated = $this->validate();

        $mandor = User::query()
            ->role('mandor')
            ->find($validated['mandorId']);

        if (!$mandor) {
            $this->addError(
                'mandorId',
                'User yang dipilih bukan Mandor.'
            );

            return;
        }

        if (
            (float) $validated['projectBudget']
            > (float) $this->contractValue
        ) {
            $this->addError(
                'projectBudget',
                'Anggaran internal tidak boleh melebihi nilai kontrak.'
            );

            return;
        }

        try {
            DB::transaction(function () use (
                $validated,
                $mandor
            ): void {
                $project = Project::query()
                    ->lockForUpdate()
                    ->find($this->project->id);

                if (!$project) {
                    throw new \RuntimeException(
                        'project_not_found'
                    );
                }

                if (
                    !in_array(
                        $project->status,
                        [
                            'planning',
                            'on_progress',
                        ],
                        true
                    )
                ) {
                    throw new \RuntimeException(
                        'project_locked'
                    );
                }

                $project->update([
                    /*
                     * client_id, project_code, contract_value,
                     * progress, dan status tidak diubah.
                     */
                    'mandor_id' => $mandor->id,
                    'project_name' =>
                        trim($validated['projectName']),
                    'location' =>
                        trim($validated['location']),
                    'description' =>
                        filled($validated['description'])
                            ? trim($validated['description'])
                            : null,
                    'contract_number' =>
                        filled($validated['contractNumber'])
                            ? trim($validated['contractNumber'])
                            : null,
                    'contract_date' =>
                        filled($validated['contractDate'])
                            ? $validated['contractDate']
                            : null,
                    'project_budget' =>
                        (float) $validated['projectBudget'],
                    'start_date' =>
                        $validated['startDate'],
                    'end_date' =>
                        $validated['endDate'],
                ]);

                $this->project = $project->fresh();
            });

            session()->flash('notification', [
    'type' => 'update',
    'message' => sprintf(
        'Project %s berhasil diperbarui.',
        $this->project->project_code
    ),
]);

return $this->redirectRoute(
    'owner.projects.show',
    [
        'project' => $this->project->id,
    ]
);
        } catch (\RuntimeException $exception) {
            $message = match ($exception->getMessage()) {
                'project_not_found' =>
                    'Project tidak ditemukan.',

                'project_locked' =>
                    'Project tidak dapat diubah karena telah selesai atau dibatalkan.',

                default =>
                    'Project gagal diperbarui.',
            };

            $this->addError('save', $message);
        } catch (Throwable $exception) {
            report($exception);

            $this->addError(
                'save',
                'Project gagal diperbarui. Silakan periksa data dan coba kembali.'
            );
        }
    }

    public function render()
    {
        $clients = Client::query()
            ->whereKey($this->project->client_id)
            ->get([
                'id',
                'company_name',
                'contact_person',
                'status',
            ]);

        $mandors = User::query()
            ->role('mandor')
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'email',
            ]);

        $selectedClient = $clients->first();

        return view('livewire.owner.projects.edit', [
            'clients' => $clients,
            'mandors' => $mandors,
            'selectedClient' => $selectedClient,
        ]);
    }

    private function authorizeUpdateProject(): void
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User
                && $user->can('update projects'),
            403
        );
    }
}