<?php

namespace App\Livewire\Owner\DeliveryOrders;

use App\Models\DeliveryOrder;
use App\Models\Project;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Livewire\Component;
use RuntimeException;
use Throwable;

class Create extends Component
{
    public ?int $projectId = null;

    public string $deliveryDate = '';

    public string $destination = '';

    public string $receiverName = '';

    public string $receiverPhone = '';

    public string $notes = '';

    /*
     * Informasi Project yang dipilih.
     */
    public string $projectCode = '';

    public string $projectName = '';

    public string $clientName = '';

    public string $mandorName = '';

    public array $items = [];

    public function mount(): void
    {
        Gate::authorize('create delivery orders');

        $this->deliveryDate = now()->toDateString();

        $this->addItem();
    }

    protected function rules(): array
    {
        return [
            'projectId' => [
                'required',
                'integer',
                Rule::exists('projects', 'id')
                    ->whereNotIn(
                        'status',
                        [
                            'completed',
                            'cancelled',
                        ]
                    ),
            ],

            'deliveryDate' => [
                'required',
                'date',
            ],

            'destination' => [
                'required',
                'string',
                'max:2000',
            ],

            'receiverName' => [
                'required',
                'string',
                'max:255',
            ],

            'receiverPhone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.item_name' => [
                'required',
                'string',
                'max:255',
            ],

            'items.*.description' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'items.*.qty' => [
                'required',
                'numeric',
                'gt:0',
                'max:99999999.99',
            ],

            'items.*.unit' => [
                'required',
                'string',
                'max:50',
            ],

            'items.*.condition' => [
                'required',
                'string',
                Rule::in([
                    'good',
                    'damaged',
                ]),
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'projectId.required' =>
                'Project wajib dipilih.',

            'projectId.integer' =>
                'Project yang dipilih tidak valid.',

            'projectId.exists' =>
                'Project tidak ditemukan atau sudah tidak tersedia.',

            'deliveryDate.required' =>
                'Tanggal pengiriman wajib diisi.',

            'deliveryDate.date' =>
                'Tanggal pengiriman tidak valid.',

            'destination.required' =>
                'Tujuan pengiriman wajib diisi.',

            'destination.max' =>
                'Tujuan pengiriman maksimal 2.000 karakter.',

            'receiverName.required' =>
                'Nama penerima wajib diisi.',

            'receiverName.max' =>
                'Nama penerima maksimal 255 karakter.',

            'receiverPhone.max' =>
                'Nomor telepon penerima maksimal 20 karakter.',

            'notes.max' =>
                'Catatan maksimal 2.000 karakter.',

            'items.required' =>
                'Tambahkan minimal satu item pengiriman.',

            'items.array' =>
                'Data item pengiriman tidak valid.',

            'items.min' =>
                'Tambahkan minimal satu item pengiriman.',

            'items.*.item_name.required' =>
                'Nama item wajib diisi.',

            'items.*.item_name.max' =>
                'Nama item maksimal 255 karakter.',

            'items.*.description.max' =>
                'Deskripsi item maksimal 2.000 karakter.',

            'items.*.qty.required' =>
                'Jumlah item wajib diisi.',

            'items.*.qty.numeric' =>
                'Jumlah item harus berupa angka.',

            'items.*.qty.gt' =>
                'Jumlah item harus lebih dari 0.',

            'items.*.qty.max' =>
                'Jumlah item terlalu besar.',

            'items.*.unit.required' =>
                'Satuan item wajib dipilih.',

            'items.*.unit.max' =>
                'Satuan item maksimal 50 karakter.',

            'items.*.condition.required' =>
                'Kondisi item wajib dipilih.',

            'items.*.condition.in' =>
                'Kondisi item tidak valid.',
        ];
    }

    protected function validationAttributes(): array
    {
        $attributes = [];

        foreach ($this->items as $index => $item) {
            $number = $index + 1;

            $attributes[
                "items.{$index}.item_name"
            ] = "nama item ke-{$number}";

            $attributes[
                "items.{$index}.description"
            ] = "deskripsi item ke-{$number}";

            $attributes[
                "items.{$index}.qty"
            ] = "jumlah item ke-{$number}";

            $attributes[
                "items.{$index}.unit"
            ] = "satuan item ke-{$number}";

            $attributes[
                "items.{$index}.condition"
            ] = "kondisi item ke-{$number}";
        }

        return $attributes;
    }

    public function updatedProjectId(): void
    {
        $this->resetValidation([
            'projectId',
            'destination',
            'receiverName',
            'receiverPhone',
            'save',
        ]);

        $this->loadProjectInformation();
    }

    private function loadProjectInformation(): void
    {
        $this->resetProjectInformation();

        if (!$this->projectId) {
            return;
        }

        $project = Project::query()
            ->with([
                'client:id,company_name',
                'mandor:id,name,phone',
            ])
            ->whereKey($this->projectId)
            ->whereNotIn(
                'status',
                [
                    'completed',
                    'cancelled',
                ]
            )
            ->first([
                'id',
                'client_id',
                'mandor_id',
                'project_code',
                'project_name',
                'location',
                'status',
            ]);

        if (!$project) {
            $this->projectId = null;

            $this->addError(
                'projectId',
                'Project tidak ditemukan atau sudah tidak tersedia.'
            );

            return;
        }

        $this->projectCode =
            $project->project_code;

        $this->projectName =
            $project->project_name;

        $this->clientName =
            $project->client?->company_name
            ?? '-';

        $this->mandorName =
            $project->mandor?->name
            ?? 'Belum ditentukan';

        $this->destination =
            $project->location ?? '';

        $this->receiverName =
            $project->mandor?->name ?? '';

        $this->receiverPhone =
            $project->mandor?->phone ?? '';
    }

    private function resetProjectInformation(): void
    {
        $this->projectCode = '';
        $this->projectName = '';
        $this->clientName = '';
        $this->mandorName = '';
        $this->destination = '';
        $this->receiverName = '';
        $this->receiverPhone = '';
    }

    public function addItem(): void
    {
        $this->items[] = [
            'item_name' => '',
            'description' => '',
            'qty' => 1,
            'unit' => '',
            'condition' => 'good',
        ];

        $this->resetValidation([
            'items',
            'save',
        ]);
    }

    public function removeItem(int $index): void
    {
        if (!array_key_exists($index, $this->items)) {
            return;
        }

        if (count($this->items) <= 1) {
            $this->addError(
                'items',
                'Surat Jalan harus memiliki minimal satu item.'
            );

            return;
        }

        unset($this->items[$index]);

        $this->items = array_values(
            $this->items
        );

        $this->resetValidation([
            'items',
            'save',
        ]);
    }

    public function createDeliveryOrder(): void
    {
        Gate::authorize('create delivery orders');

        $validated = $this->validate();

        try {
            $deliveryOrder = DB::transaction(
                function () use ($validated): DeliveryOrder {
                    $project = Project::query()
                        ->whereKey($validated['projectId'])
                        ->whereNotIn(
                            'status',
                            [
                                'completed',
                                'cancelled',
                            ]
                        )
                        ->lockForUpdate()
                        ->first();

                    if (!$project) {
                        throw new RuntimeException(
                            'project_not_available'
                        );
                    }

                    $deliveryOrder = DeliveryOrder::create([
                        'project_id' =>
                            $project->id,

                        'created_by' =>
                            Auth::id(),

                        'delivery_number' =>
                            $this->generateDeliveryNumber(),

                        'delivery_date' =>
                            $validated['deliveryDate'],

                        'destination' =>
                            trim($validated['destination']),

                        'receiver_name' =>
                            trim($validated['receiverName']),

                        'receiver_phone' =>
                            filled(
                                $validated['receiverPhone']
                                ?? null
                            )
                                ? trim(
                                    $validated['receiverPhone']
                                )
                                : null,

                        'status' => 'draft',

                        'sent_at' => null,

                        'received_at' => null,

                        'notes' =>
                            filled(
                                $validated['notes']
                                ?? null
                            )
                                ? trim($validated['notes'])
                                : null,
                    ]);

                    foreach (
                        $validated['items']
                        as $index => $item
                    ) {
                        $deliveryOrder->items()->create([
                            'item_name' =>
                                trim($item['item_name']),

                            'description' =>
                                filled(
                                    $item['description']
                                    ?? null
                                )
                                    ? trim(
                                        $item['description']
                                    )
                                    : null,

                            'qty' =>
                                round(
                                    (float) $item['qty'],
                                    2
                                ),

                            'unit' =>
                                trim($item['unit']),

                            'condition' =>
                                $item['condition'],

                            'sort_order' =>
                                $index + 1,
                        ]);
                    }

                    return $deliveryOrder;
                }
            );

            session()->flash('notification', [
                'type' => 'success',
                'message' => sprintf(
                    'Surat Jalan %s berhasil dibuat.',
                    $deliveryOrder->delivery_number
                ),
            ]);

            $this->redirectRoute(
                'owner.delivery-orders.index',
                navigate: true
            );
        } catch (RuntimeException $exception) {
            $message = match (
                $exception->getMessage()
            ) {
                'project_not_available' =>
                    'Project tidak ditemukan atau sudah tidak tersedia.',

                default =>
                    'Surat Jalan gagal dibuat.',
            };

            $this->addError(
                'save',
                $message
            );
        } catch (QueryException $exception) {
            report($exception);

            $this->addError(
                'save',
                'Nomor Surat Jalan sudah digunakan. Silakan coba simpan kembali.'
            );
        } catch (Throwable $exception) {
            report($exception);

            $this->addError(
                'save',
                'Surat Jalan gagal dibuat. Silakan coba kembali.'
            );
        }
    }

    private function generateDeliveryNumber(): string
    {
        $year = now()->format('Y');

        $prefix = sprintf(
            'SJ-%s-',
            $year
        );

        $lastNumber = DeliveryOrder::query()
            ->where(
                'delivery_number',
                'like',
                $prefix.'%'
            )
            ->lockForUpdate()
            ->orderByDesc('delivery_number')
            ->value('delivery_number');

        $sequence = 1;

        if (
            is_string($lastNumber)
            && preg_match(
                '/(\d+)$/',
                $lastNumber,
                $matches
            )
        ) {
            $sequence =
                (int) $matches[1] + 1;
        }

        return sprintf(
            '%s%04d',
            $prefix,
            $sequence
        );
    }

    public function render()
    {
        $projects = Project::query()
            ->whereNotIn(
                'status',
                [
                    'completed',
                    'cancelled',
                ]
            )
            ->with([
                'client:id,company_name',
                'mandor:id,name',
            ])
            ->withCount('deliveryOrders')
            ->orderBy('project_name')
            ->get([
                'id',
                'client_id',
                'mandor_id',
                'project_code',
                'project_name',
                'location',
                'status',
            ]);

        return view(
            'livewire.owner.delivery-orders.create',
            [
                'projects' => $projects,
            ]
        );
    }
}