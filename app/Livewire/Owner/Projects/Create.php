<?php

namespace App\Livewire\Owner\Projects;

use App\Models\Client;
use App\Models\Project;
use App\Models\Quotation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Throwable;

class Create extends Component
{
    public string $pageTitle = 'Buat Project Baru';

    public string $pageDescription =
        'Lengkapi informasi Project berdasarkan quotation yang telah disetujui.';

    public string $buttonText = 'Simpan Project';

    public ?int $quotationId = null;

    public ?Quotation $sourceQuotation = null;

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

    public string $status = 'planning';

    public int $progress = 0;

    public function mount(?Quotation $quotation = null): void
    {
        $this->authorizeCreateProject();

        /*
         * Project pada alur sistem hanya dibuat dari quotation
         * yang sudah disetujui.
         */
        if (!$quotation) {
            session()->flash('notification', [
                'type' => 'error',
                'message' =>
                    'Pilih quotation berstatus Disetujui untuk membuat Project.',
            ]);

            $this->redirectRoute(
                'owner.quotations.index',
                navigate: true
            );

            return;
        }

        abort_unless(
            $quotation->status === 'approved',
            403,
            'Hanya quotation berstatus Disetujui yang dapat dibuat menjadi Project.'
        );

        abort_if(
            $quotation->project_id !== null,
            409,
            'Quotation ini sudah terhubung dengan Project.'
        );

        $quotation->load([
            'client',
            'items' => fn ($query) => $query
                ->orderBy('sort_order')
                ->orderBy('id'),
        ]);

        $this->quotationId = $quotation->id;
        $this->sourceQuotation = $quotation;
        $this->clientId = $quotation->client_id;

        $this->projectCode = $this->generateProjectCode();

        $this->projectName =
            $quotation->project_name ?? '';

        $this->location =
            $quotation->project_location ?? '';

        $this->description =
            $quotation->notes ?? '';

        $this->contractValue =
            (float) $quotation->grand_total;

        $this->pageTitle =
            'Buat Project dari Quotation';

        $this->pageDescription = sprintf(
            'Lengkapi data Project berdasarkan quotation %s.',
            $quotation->quotation_number
        );
    }

    protected function rules(): array
    {
        return [
            'quotationId' => [
                'required',
                'integer',
                'exists:quotations,id',
            ],

            'clientId' => [
                'required',
                'integer',
                'exists:clients,id',
            ],

            'mandorId' => [
                'required',
                'integer',
                'exists:users,id',
            ],

            'projectCode' => [
                'required',
                'string',
                'max:100',
                Rule::unique('projects', 'project_code'),
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

            'contractValue' => [
                'required',
                'numeric',
                'gt:0',
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
            'quotationId.required' =>
                'Quotation sumber wajib tersedia.',

            'quotationId.exists' =>
                'Quotation sumber tidak ditemukan.',

            'clientId.required' =>
                'Client wajib tersedia.',

            'clientId.exists' =>
                'Client tidak ditemukan.',

            'mandorId.required' =>
                'Mandor wajib dipilih.',

            'mandorId.exists' =>
                'Mandor yang dipilih tidak ditemukan.',

            'projectCode.required' =>
                'Kode Project wajib tersedia.',

            'projectCode.unique' =>
                'Kode Project sudah digunakan.',

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

            'contractValue.required' =>
                'Nilai kontrak wajib tersedia.',

            'contractValue.numeric' =>
                'Nilai kontrak harus berupa angka.',

            'contractValue.gt' =>
                'Nilai kontrak harus lebih dari nol.',

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

    public function save(): void
    {
        $this->authorizeCreateProject();

        $validated = $this->validate();

        /*
         * Pastikan User yang dipilih benar-benar memiliki role Mandor.
         */
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

        try {
            $project = DB::transaction(function () use (
                $validated,
                $mandor
            ): Project {
                /*
                 * Mengunci quotation untuk mencegah satu quotation
                 * membuat lebih dari satu Project.
                 */
                $quotation = Quotation::query()
                    ->lockForUpdate()
                    ->find($validated['quotationId']);

                if (!$quotation) {
                    throw new \RuntimeException(
                        'quotation_not_found'
                    );
                }

                if ($quotation->status !== 'approved') {
                    throw new \RuntimeException(
                        'quotation_not_approved'
                    );
                }

                if ($quotation->project_id !== null) {
                    throw new \RuntimeException(
                        'quotation_already_used'
                    );
                }

                /*
                 * Data penting diambil kembali dari database
                 * agar tidak dapat dimanipulasi melalui browser.
                 */
                $projectCode = $this->generateProjectCode();

                $project = Project::create([
                    'client_id' => $quotation->client_id,
                    'mandor_id' => $mandor->id,
                    'project_code' => $projectCode,
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
                    'contract_value' =>
                        (float) $quotation->grand_total,
                    'start_date' =>
                        $validated['startDate'],
                    'end_date' =>
                        $validated['endDate'],
                    'progress' => 0,
                    'status' => 'planning',
                ]);

                $quotation->update([
                    'project_id' => $project->id,
                ]);

                return $project;
            });

            session()->flash('notification', [
                'type' => 'create',
                'message' => sprintf(
                    'Project %s berhasil dibuat dan terhubung dengan quotation.',
                    $project->project_code
                ),
            ]);

            $this->redirectRoute(
                'owner.projects.show',
                [
                    'project' => $project->id,
                ],
                navigate: true
            );
        } catch (\RuntimeException $exception) {
            $message = match ($exception->getMessage()) {
                'quotation_not_found' =>
                    'Quotation sumber tidak ditemukan.',

                'quotation_not_approved' =>
                    'Quotation belum disetujui sehingga Project tidak dapat dibuat.',

                'quotation_already_used' =>
                    'Quotation sudah terhubung dengan Project lain.',

                default =>
                    'Project gagal disimpan. Silakan periksa data dan coba kembali.',
            };

            $this->addError('save', $message);
        } catch (Throwable $exception) {
            report($exception);

            $this->addError(
                'save',
                'Project gagal disimpan. Silakan periksa data dan coba kembali.'
            );
        }
    }

    private function generateProjectCode(): string
    {
        $year = now()->format('Y');

        $lastCode = Project::query()
            ->where(
                'project_code',
                'like',
                'PRJ-'.$year.'-%'
            )
            ->latest('id')
            ->value('project_code');

        $sequence = 1;

        if (
            is_string($lastCode)
            && preg_match(
                '/(\d+)$/',
                $lastCode,
                $matches
            )
        ) {
            $sequence = ((int) $matches[1]) + 1;
        }

        return sprintf(
            'PRJ-%s-%04d',
            $year,
            $sequence
        );
    }

    private function authorizeCreateProject(): void
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User
                && $user->can('create projects'),
            403
        );
    }

    public function render()
    {
        $clients = Client::query()
            ->where(function ($query) {
                $query
                    ->where('status', 'active')
                    ->when(
                        $this->clientId,
                        fn ($query) => $query
                            ->orWhere(
                                'id',
                                $this->clientId
                            )
                    );
            })
            ->orderBy('company_name')
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

        $selectedClient = $this->clientId
            ? $clients->firstWhere(
                'id',
                $this->clientId
            )
            : null;

        return view('livewire.owner.projects.create', [
            'clients' => $clients,
            'mandors' => $mandors,
            'selectedClient' => $selectedClient,
        ]);
    }
}