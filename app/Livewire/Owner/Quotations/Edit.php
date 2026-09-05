<?php

namespace App\Livewire\Owner\Quotations;

use App\Models\Client;
use App\Models\Quotation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Throwable;

class Edit extends Component
{
    public Quotation $quotation;

    public string $pageTitle = 'Edit Quotation';

    public string $pageDescription =
        'Perbarui informasi quotation sebelum diserahkan kepada Client.';

    public string $buttonText = 'Simpan Perubahan';

    public ?int $clientId = null;

    public string $quotationNumber = '';

    public string $quotationDate = '';

    public string $validUntil = '';

    public string $projectName = '';

    public string $projectLocation = '';

    public string $notes = '';

    public array $items = [];

    public function mount(Quotation $quotation): void
    {
        $this->authorizeUpdateQuotation();

        abort_unless(
            $quotation->status === 'draft',
            403,
            'Hanya quotation berstatus Draft yang dapat diubah.'
        );

        $quotation->load([
            'client',
            'items' => fn ($query) => $query
                ->orderBy('sort_order')
                ->orderBy('id'),
        ]);

        $this->quotation = $quotation;

        $this->clientId = $quotation->client_id;

        $this->quotationNumber =
            $quotation->quotation_number;

        $this->quotationDate =
            $quotation->quotation_date
                ? $quotation->quotation_date->format('Y-m-d')
                : '';

        $this->validUntil =
            $quotation->valid_until
                ? $quotation->valid_until->format('Y-m-d')
                : '';

        $this->projectName =
            $quotation->project_name ?? '';

        $this->projectLocation =
            $quotation->project_location ?? '';

        $this->notes =
            $quotation->notes ?? '';

        $this->items = $quotation->items
            ->map(function ($item): array {
                return [
                    'item_name' => $item->item_name,
                    'description' =>
                        $item->description ?? '',
                    'qty' => (float) $item->qty,
                    'unit' => $item->unit,
                    'price' => (float) $item->price,
                ];
            })
            ->values()
            ->all();

        if ($this->items === []) {
            $this->items = [
                $this->emptyItem(),
            ];
        }
    }

    public function addItem(): void
    {
        $this->items[] = $this->emptyItem();

        $this->resetValidation('items');
    }

    public function removeItem(int $index): void
    {
        if (count($this->items) <= 1) {
            $this->addError(
                'items',
                'Minimal satu item quotation wajib tersedia.'
            );

            return;
        }

        if (!array_key_exists($index, $this->items)) {
            return;
        }

        unset($this->items[$index]);

        $this->items = array_values($this->items);

        $this->resetValidation('items');
    }

    public function getItemTotal(int $index): float
    {
        $item = $this->items[$index] ?? [];

        $quantity = (float) ($item['qty'] ?? 0);
        $price = (float) ($item['price'] ?? 0);

        return $quantity * $price;
    }

    public function getSubtotalProperty(): float
    {
        return collect($this->items)
            ->sum(function (array $item): float {
                return (float) ($item['qty'] ?? 0)
                    * (float) ($item['price'] ?? 0);
            });
    }

    public function getTotalQuantityProperty(): float
    {
        return collect($this->items)
            ->sum(
                fn (array $item): float =>
                    (float) ($item['qty'] ?? 0)
            );
    }

    public function getGrandTotalProperty(): float
    {
        return $this->subtotal;
    }

    private function emptyItem(): array
    {
        return [
            'item_name' => '',
            'description' => '',
            'qty' => 1,
            'unit' => '',
            'price' => 0,
        ];
    }

    private function authorizeUpdateQuotation(): void
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User
                && $user->can('update quotations'),
            403
        );
    }

    public function render()
    {
        $clients = Client::query()
            ->where(function ($query) {
                $query
                    ->whereIn('status', [
                        'lead',
                        'active',
                    ])
                    ->orWhere(
                        'id',
                        $this->clientId
                    );
            })
            ->orderBy('company_name')
            ->get([
                'id',
                'company_name',
                'contact_person',
                'phone',
                'email',
                'address',
                'city',
                'status',
            ]);

        $selectedClient = $this->clientId
            ? $clients->firstWhere(
                'id',
                $this->clientId
            )
            : null;

        return view('livewire.owner.quotations.edit', [
            'clients' => $clients,
            'selectedClient' => $selectedClient,
            'subtotal' => $this->subtotal,
            'totalQuantity' => $this->totalQuantity,
            'grandTotal' => $this->grandTotal,
        ]);
    }

    protected function rules(): array
    {
        return [
            'clientId' => [
                'required',
                'integer',
                'exists:clients,id',
            ],

            'quotationDate' => [
                'required',
                'date',
            ],

            'validUntil' => [
                'required',
                'date',
                'after_or_equal:quotationDate',
            ],

            'projectName' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],

            'projectLocation' => [
                'nullable',
                'string',
                'max:255',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:5000',
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
            ],

            'items.*.unit' => [
                'required',
                'string',
                'max:50',
            ],

            'items.*.price' => [
                'required',
                'numeric',
                'min:0',
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'clientId.required' =>
                'Client wajib dipilih.',

            'clientId.integer' =>
                'Data Client tidak valid.',

            'clientId.exists' =>
                'Client yang dipilih tidak ditemukan.',

            'quotationDate.required' =>
                'Tanggal quotation wajib diisi.',

            'quotationDate.date' =>
                'Format tanggal quotation tidak valid.',

            'validUntil.required' =>
                'Batas berlaku quotation wajib diisi.',

            'validUntil.date' =>
                'Format batas berlaku tidak valid.',

            'validUntil.after_or_equal' =>
                'Batas berlaku tidak boleh sebelum tanggal quotation.',

            'projectName.required' =>
                'Nama calon Project wajib diisi.',

            'projectName.min' =>
                'Nama calon Project minimal 3 karakter.',

            'projectName.max' =>
                'Nama calon Project maksimal 255 karakter.',

            'projectLocation.max' =>
                'Lokasi calon Project maksimal 255 karakter.',

            'notes.max' =>
                'Catatan maksimal 5.000 karakter.',

            'items.required' =>
                'Minimal satu item quotation wajib tersedia.',

            'items.array' =>
                'Data item quotation tidak valid.',

            'items.min' =>
                'Minimal satu item quotation wajib tersedia.',

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
                'Jumlah item harus lebih dari nol.',

            'items.*.unit.required' =>
                'Satuan item wajib dipilih.',

            'items.*.unit.max' =>
                'Satuan item maksimal 50 karakter.',

            'items.*.price.required' =>
                'Harga item wajib diisi.',

            'items.*.price.numeric' =>
                'Harga item harus berupa angka.',

            'items.*.price.min' =>
                'Harga item tidak boleh bernilai negatif.',
        ];
    }

    public function updateQuotation(): void
    {
        $this->authorizeUpdateQuotation();

        $this->resetValidation('save');

        $validated = $this->validate();

        $client = Client::query()
            ->where(function ($query) {
                $query
                    ->whereIn('status', [
                        'lead',
                        'active',
                    ])
                    ->orWhere(
                        'id',
                        $this->quotation->client_id
                    );
            })
            ->find($validated['clientId']);

        if (!$client) {
            $this->addError(
                'clientId',
                'Client tidak ditemukan atau tidak dapat digunakan.'
            );

            return;
        }

        try {
            DB::transaction(function () use (
                $validated,
                $client
            ): void {
                $quotation = Quotation::query()
                    ->lockForUpdate()
                    ->find($this->quotation->id);

                if (!$quotation) {
                    throw new \RuntimeException(
                        'QUOTATION_NOT_FOUND'
                    );
                }

                if ($quotation->status !== 'draft') {
                    throw new \RuntimeException(
                        'QUOTATION_NOT_DRAFT'
                    );
                }

                $quotation->update([
                    'client_id' => $client->id,

                    /*
                    * Snapshot Client diperbarui mengikuti
                    * Client yang dipilih pada quotation.
                    */
                    'client_name' =>
                        $client->company_name,

                    'client_contact_person' =>
                        $client->contact_person,

                    'client_phone' =>
                        $client->phone,

                    'client_email' =>
                        $client->email,

                    'client_address' =>
                        $client->address,

                    /*
                    * Data calon Project.
                    */
                    'project_name' =>
                        trim($validated['projectName']),

                    'project_location' =>
                        filled($validated['projectLocation'])
                            ? trim($validated['projectLocation'])
                            : null,

                    'quotation_date' =>
                        $validated['quotationDate'],

                    'valid_until' =>
                        $validated['validUntil'],

                    'subtotal' =>
                        $this->subtotal,

                    'grand_total' =>
                        $this->grandTotal,

                    'notes' =>
                        filled($validated['notes'])
                            ? trim($validated['notes'])
                            : null,
                ]);

                /*
                * Item lama dihapus lalu dibuat ulang.
                * Seluruh proses berada dalam transaksi.
                */
                $quotation->items()->delete();

                foreach (
                    $validated['items']
                    as $index => $item
                ) {
                    $quantity =
                        (float) $item['qty'];

                    $price =
                        (float) $item['price'];

                    $quotation->items()->create([
                        'item_name' =>
                            trim($item['item_name']),

                        'description' =>
                            filled($item['description'])
                                ? trim($item['description'])
                                : null,

                        'qty' => $quantity,

                        'unit' =>
                            trim($item['unit']),

                        'price' => $price,

                        'total' =>
                            $quantity * $price,

                        'sort_order' =>
                            $index + 1,
                    ]);
                }
            });

            session()->flash('notification', [
                'type' => 'update',
                'message' => sprintf(
                    'Quotation %s berhasil diperbarui.',
                    $this->quotation->quotation_number
                ),
            ]);

            $this->redirectRoute(
                'owner.quotations.show',
                [
                    'quotation' =>
                        $this->quotation->id,
                ],
                navigate: true
            );
        } catch (Throwable $exception) {
            if (
                $exception->getMessage()
                === 'QUOTATION_NOT_DRAFT'
            ) {
                $this->addError(
                    'save',
                    'Quotation tidak dapat diperbarui karena statusnya bukan Draft.'
                );

                return;
            }

            if (
                $exception->getMessage()
                === 'QUOTATION_NOT_FOUND'
            ) {
                $this->addError(
                    'save',
                    'Quotation tidak ditemukan.'
                );

                return;
            }

            report($exception);

            $this->addError(
                'save',
                'Perubahan quotation gagal disimpan. Silakan coba kembali.'
            );
        }
    }
}