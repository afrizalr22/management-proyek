<?php

namespace App\Livewire\Owner\Quotations;

use App\Models\Client;
use App\Models\Quotation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Throwable;

class Create extends Component
{
    public string $pageTitle = 'Buat Quotation';

    public string $pageDescription =
        'Buat penawaran pekerjaan baru untuk client.';

    public string $buttonText = 'Simpan Quotation';

    public ?int $clientId = null;

    public string $quotationNumber = '';

    public string $quotationDate = '';

    public string $validUntil = '';

    public string $projectName = '';

    public string $projectLocation = '';

    public string $notes = '';

    public array $items = [
        [
            'item_name' => '',
            'description' => '',
            'qty' => 1,
            'unit' => '',
            'price' => 0,
        ],
    ];

    public function mount(): void
    {
        $this->authorizeCreateQuotation();

        $this->quotationNumber =
            $this->generateQuotationNumber();

        $this->quotationDate = now()->format('Y-m-d');

        $this->validUntil = now()
            ->addDays(7)
            ->format('Y-m-d');
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
                'Client yang dipilih tidak valid.',

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
                'Nama calon proyek wajib diisi.',

            'projectName.min' =>
                'Nama calon proyek minimal 3 karakter.',

            'projectName.max' =>
                'Nama calon proyek maksimal 255 karakter.',

            'projectLocation.max' =>
                'Lokasi proyek maksimal 255 karakter.',

            'notes.max' =>
                'Catatan maksimal 5.000 karakter.',

            'items.required' =>
                'Minimal satu item quotation wajib tersedia.',

            'items.array' =>
                'Format item quotation tidak valid.',

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

    public function addItem(): void
    {
        $this->resetValidation('items');

        $this->items[] = [
            'item_name' => '',
            'description' => '',
            'qty' => 1,
            'unit' => '',
            'price' => 0,
        ];
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

        $this->resetValidation();
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
                $quantity =
                    (float) ($item['qty'] ?? 0);

                $price =
                    (float) ($item['price'] ?? 0);

                return $quantity * $price;
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

    public function save(): void
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User
                && $user->can('create quotations'),
            403
        );

        $validated = $this->validate();

        $client = Client::query()
            ->whereIn('status', [
                'lead',
                'active',
            ])
            ->find($validated['clientId']);

        if (!$client) {
            $this->addError(
                'clientId',
                'Client tidak ditemukan atau sudah berstatus Nonaktif.'
            );

            return;
        }


        try {
            $quotation = DB::transaction(
                function () use (
                    $validated,
                    $client,
                    $user
                ): Quotation {
                    $quotationNumber =
                        $this->generateQuotationNumber();

                    $notes = $validated['notes'] ?? null;
                    $projectLocation =
                        $validated['projectLocation'] ?? null;

                    $quotation = Quotation::create([
                        'client_id' => $client->id,
                        'project_id' => null,
                        'created_by' => $user->id,

                        'quotation_number' =>
                            $quotationNumber,

                        'quotation_date' =>
                            $validated['quotationDate'],

                        'valid_until' =>
                            $validated['validUntil'],

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

                        'project_name' =>
                            trim($validated['projectName']),

                        'project_location' =>
                            filled($projectLocation)
                                ? trim($projectLocation)
                                : null,

                        'subtotal' =>
                            $this->subtotal,

                        'grand_total' =>
                            $this->subtotal,

                        'status' => 'draft',

                        'notes' => filled($notes)
                            ? trim($notes)
                            : null,
                    ]);

                    foreach (
                        $validated['items'] as $index => $item
                    ) {
                        $quantity =
                            (float) $item['qty'];

                        $price =
                            (float) $item['price'];

                        $description =
                            $item['description'] ?? null;

                        $quotation->items()->create([
                            'item_name' =>
                                trim($item['item_name']),

                            'description' =>
                                filled($description)
                                    ? trim($description)
                                    : null,

                            'qty' =>
                                $quantity,

                            'unit' =>
                                trim($item['unit']),

                            'price' =>
                                $price,

                            'total' =>
                                $quantity * $price,

                            'sort_order' =>
                                $index + 1,
                        ]);
                    }

                    return $quotation;
                }
            );

            session()->flash('notification', [
                'type' => 'create',
                'message' =>
                    "Quotation {$quotation->quotation_number} berhasil dibuat.",
            ]);

            $this->redirectRoute(
                'owner.quotations.index',
                navigate: true
            );
        } catch (Throwable $exception) {
            report($exception);

            $this->addError(
                'save',
                'Quotation gagal disimpan. Silakan periksa data dan coba kembali.'
            );
        }
    }

    private function generateQuotationNumber(): string
    {
        $year = now()->format('Y');

        $lastNumber = Quotation::query()
            ->whereYear('quotation_date', $year)
            ->latest('id')
            ->value('quotation_number');

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
                ((int) $matches[1]) + 1;
        }

        return sprintf(
            'QT-%s-%04d',
            $year,
            $sequence
        );
    }

    private function authorizeCreateQuotation(): void
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User
                && $user->can('create quotations'),
            403
        );
    }

    public function render()
    {
        $clients = Client::query()
            ->whereIn('status', [
                'lead',
                'active',
            ])
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

        return view(
            'livewire.owner.quotations.create',
            [
                'clients' =>
                    $clients,

                'selectedClient' =>
                    $selectedClient,

                'subtotal' =>
                    $this->subtotal,

                'totalQuantity' =>
                    $this->totalQuantity,

                'grandTotal' =>
                    $this->grandTotal,
            ]
        );
    }
}