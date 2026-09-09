<?php

namespace App\Livewire\Owner\DeliveryOrders;

use App\Models\DeliveryOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Livewire\Component;
use RuntimeException;
use Throwable;

class Edit extends Component
{
    public DeliveryOrder $deliveryOrder;

    public string $deliveryDate = '';

    public string $destination = '';

    public string $receiverName = '';

    public string $receiverPhone = '';

    public string $notes = '';

    public array $items = [];

    public function mount(
        DeliveryOrder $deliveryOrder
    ): void {
        Gate::authorize(
            'update delivery orders'
        );

        abort_unless(
            $deliveryOrder->status === 'draft',
            403,
            'Hanya Surat Jalan berstatus draft yang dapat diedit.'
        );

        $deliveryOrder->load([
            'project' => fn ($query) => $query
                ->select([
                    'id',
                    'client_id',
                    'mandor_id',
                    'project_code',
                    'project_name',
                    'location',
                    'status',
                ])
                ->with([
                    'client:id,company_name',

                    'mandor:id,name,email,phone',
                ]),

            'items' => fn ($query) => $query
                ->orderBy('sort_order')
                ->orderBy('id'),
        ]);

        $this->deliveryOrder =
            $deliveryOrder;

        $this->deliveryDate =
            $deliveryOrder->delivery_date
                ?->format('Y-m-d')
            ?? '';

        $this->destination =
            $deliveryOrder->destination
            ?? '';

        $this->receiverName =
            $deliveryOrder->receiver_name
            ?? '';

        $this->receiverPhone =
            $deliveryOrder->receiver_phone
            ?? '';

        $this->notes =
            $deliveryOrder->notes
            ?? '';

        $this->items = $deliveryOrder->items
            ->map(fn ($item): array => [
                'item_name' =>
                    $item->item_name,

                'description' =>
                    $item->description ?? '',

                'qty' =>
                    (string) $item->qty,

                'unit' =>
                    $item->unit,

                'condition' =>
                    $item->condition,
            ])
            ->values()
            ->all();

        if ($this->items === []) {
            $this->addItem();
        }
    }

    protected function rules(): array
    {
        return [
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
                'max:100',
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
                'Surat Jalan harus memiliki item.',

            'items.array' =>
                'Data item pengiriman tidak valid.',

            'items.min' =>
                'Surat Jalan minimal memiliki satu item.',

            'items.max' =>
                'Surat Jalan maksimal memiliki 100 item.',

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

    public function addItem(): void
    {
        if (count($this->items) >= 100) {
            $this->addError(
                'items',
                'Surat Jalan maksimal memiliki 100 item.'
            );

            return;
        }

        $this->items[] = [
            'item_name' => '',
            'description' => '',
            'qty' => '1',
            'unit' => '',
            'condition' => 'good',
        ];

        $this->resetValidation([
            'items',
            'save',
        ]);
    }

    public function removeItem(
        int $index
    ): void {
        if (
            !array_key_exists(
                $index,
                $this->items
            )
        ) {
            return;
        }

        if (count($this->items) <= 1) {
            $this->addError(
                'items',
                'Surat Jalan minimal memiliki satu item.'
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

    public function getTotalQuantityProperty(): float
    {
        return collect($this->items)
            ->sum(
                fn (array $item): float =>
                    is_numeric(
                        $item['qty'] ?? null
                    )
                        ? (float) $item['qty']
                        : 0
            );
    }

    public function updateDeliveryOrder(): void
    {
        Gate::authorize(
            'update delivery orders'
        );

        $validated = $this->validate();

        try {
            DB::transaction(
                function () use ($validated): void {
                    $deliveryOrder =
                        DeliveryOrder::query()
                            ->whereKey(
                                $this->deliveryOrder->id
                            )
                            ->lockForUpdate()
                            ->firstOrFail();

                    if (
                        $deliveryOrder->status
                        !== 'draft'
                    ) {
                        throw new RuntimeException(
                            'Surat Jalan sudah tidak berstatus draft.'
                        );
                    }

                    $normalizedItems = collect(
                        $validated['items']
                    )
                        ->values()
                        ->map(
                            function (
                                array $item,
                                int $index
                            ): array {
                                return [
                                    'item_name' =>
                                        trim(
                                            $item['item_name']
                                        ),

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
                                        trim(
                                            $item['unit']
                                        ),

                                    'condition' =>
                                        $item['condition'],

                                    'sort_order' =>
                                        $index + 1,
                                ];
                            }
                        );

                    $deliveryOrder->update([
                        'delivery_date' =>
                            $validated['deliveryDate'],

                        'destination' =>
                            trim(
                                $validated['destination']
                            ),

                        'receiver_name' =>
                            trim(
                                $validated['receiverName']
                            ),

                        'receiver_phone' =>
                            filled(
                                $validated['receiverPhone']
                                ?? null
                            )
                                ? trim(
                                    $validated['receiverPhone']
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
                    ]);

                    /*
                     * Item lama diganti dengan data
                     * terbaru dalam transaksi yang sama.
                     */
                    $deliveryOrder
                        ->items()
                        ->delete();

                    $deliveryOrder
                        ->items()
                        ->createMany(
                            $normalizedItems->all()
                        );
                }
            );

            session()->flash(
                'notification',
                [
                    'type' => 'update',

                    'message' => sprintf(
                        'Surat Jalan %s berhasil diperbarui.',
                        $this->deliveryOrder
                            ->delivery_number
                    ),
                ]
            );

            $this->redirectRoute(
                'owner.delivery-orders.show',
                [
                    'deliveryOrder' =>
                        $this->deliveryOrder->id,
                ],
                navigate: true
            );
        } catch (Throwable $exception) {
            report($exception);

            $this->addError(
                'save',
                $exception instanceof RuntimeException
                    ? $exception->getMessage()
                    : 'Surat Jalan gagal diperbarui. Silakan coba kembali.'
            );
        }
    }

    public function render()
    {
        return view(
            'livewire.owner.delivery-orders.edit',
            [
                'totalQuantity' =>
                    $this->totalQuantity,
            ]
        );
    }
}