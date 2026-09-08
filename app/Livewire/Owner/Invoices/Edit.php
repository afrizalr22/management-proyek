<?php

namespace App\Livewire\Owner\Invoices;

use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Throwable;

class Edit extends Component
{
    public Invoice $invoice;

    public string $invoiceDate = '';

    public string $dueDate = '';

    public string $notes = '';

    public array $items = [];

    public function mount(Invoice $invoice): void
    {
        Gate::authorize('update invoices');

        abort_unless(
            $invoice->status === 'draft',
            403,
            'Hanya invoice berstatus draft yang dapat diedit.'
        );

        $invoice->load([
            'project:id,project_code,project_name',
            'quotation:id,quotation_number,project_name',
            'items' => fn ($query) => $query
                ->orderBy('sort_order')
                ->orderBy('id'),
        ]);

        $this->invoice = $invoice;
        $this->invoiceDate = $invoice->invoice_date
            ?->format('Y-m-d') ?? '';

        $this->dueDate = $invoice->due_date
            ?->format('Y-m-d') ?? '';

        $this->notes = $invoice->notes ?? '';

        $this->items = $invoice->items
            ->map(fn ($item) => [
                'item_name' => $item->item_name,
                'description' => $item->description ?? '',
                'qty' => (string) $item->qty,
                'unit' => $item->unit,
                'price' => (string) $item->price,
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
            'invoiceDate' => [
                'required',
                'date',
            ],

            'dueDate' => [
                'nullable',
                'date',
                'after_or_equal:invoiceDate',
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

            'items.*.price' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999999999.99',
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'invoiceDate.required' =>
                'Tanggal invoice wajib diisi.',

            'invoiceDate.date' =>
                'Tanggal invoice tidak valid.',

            'dueDate.date' =>
                'Tanggal jatuh tempo tidak valid.',

            'dueDate.after_or_equal' =>
                'Tanggal jatuh tempo tidak boleh sebelum tanggal invoice.',

            'notes.max' =>
                'Catatan maksimal 5000 karakter.',

            'items.required' =>
                'Invoice harus memiliki item.',

            'items.min' =>
                'Invoice minimal memiliki satu item.',

            'items.max' =>
                'Invoice maksimal memiliki 100 item.',

            'items.*.item_name.required' =>
                'Nama item wajib diisi.',

            'items.*.item_name.max' =>
                'Nama item maksimal 255 karakter.',

            'items.*.description.max' =>
                'Deskripsi item maksimal 2000 karakter.',

            'items.*.qty.required' =>
                'Kuantitas wajib diisi.',

            'items.*.qty.numeric' =>
                'Kuantitas harus berupa angka.',

            'items.*.qty.gt' =>
                'Kuantitas harus lebih dari 0.',

            'items.*.unit.required' =>
                'Satuan wajib diisi.',

            'items.*.unit.max' =>
                'Satuan maksimal 50 karakter.',

            'items.*.price.required' =>
                'Harga satuan wajib diisi.',

            'items.*.price.numeric' =>
                'Harga satuan harus berupa angka.',

            'items.*.price.min' =>
                'Harga satuan tidak boleh kurang dari 0.',
        ];
    }

    public function addItem(): void
    {
        $this->items[] = [
            'item_name' => '',
            'description' => '',
            'qty' => '1',
            'unit' => '',
            'price' => '0',
        ];
    }

    public function removeItem(int $index): void
    {
        if (! array_key_exists($index, $this->items)) {
            return;
        }

        if (count($this->items) <= 1) {
            $this->addError(
                'items',
                'Invoice minimal memiliki satu item.'
            );

            return;
        }

        unset($this->items[$index]);

        $this->items = array_values($this->items);

        $this->resetValidation('items');
    }

    public function getSubtotalProperty(): float
    {
        return collect($this->items)
            ->sum(function (array $item): float {
                $qty = is_numeric($item['qty'] ?? null)
                    ? (float) $item['qty']
                    : 0;

                $price = is_numeric($item['price'] ?? null)
                    ? (float) $item['price']
                    : 0;

                return round($qty * $price, 2);
            });
    }

    public function getTotalQuantityProperty(): float
    {
        return collect($this->items)
            ->sum(
                fn (array $item): float =>
                    is_numeric($item['qty'] ?? null)
                        ? (float) $item['qty']
                        : 0
            );
    }

    public function updateInvoice(): void
    {
        Gate::authorize('update invoices');

        $validated = $this->validate();

        try {
            DB::transaction(function () use ($validated): void {
                $invoice = Invoice::query()
                    ->whereKey($this->invoice->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($invoice->status !== 'draft') {
                    throw new \RuntimeException(
                        'Invoice sudah tidak berstatus draft.'
                    );
                }

                $normalizedItems = collect($validated['items'])
                    ->values()
                    ->map(function (
                        array $item,
                        int $index
                    ): array {
                        $qty = round((float) $item['qty'], 2);
                        $price = round((float) $item['price'], 2);

                        return [
                            'item_name' => trim(
                                $item['item_name']
                            ),
                            'description' => filled(
                                $item['description'] ?? null
                            )
                                ? trim($item['description'])
                                : null,
                            'qty' => $qty,
                            'unit' => trim($item['unit']),
                            'price' => $price,
                            'total' => round(
                                $qty * $price,
                                2
                            ),
                            'sort_order' => $index + 1,
                        ];
                    });

                $subtotal = round(
                    (float) $normalizedItems->sum('total'),
                    2
                );

                $invoice->update([
                    'invoice_date' =>
                        $validated['invoiceDate'],

                    'due_date' => filled(
                        $validated['dueDate'] ?? null
                    )
                        ? $validated['dueDate']
                        : null,

                    'subtotal' => $subtotal,
                    'tax_amount' => 0,
                    'discount_amount' => 0,
                    'grand_total' => $subtotal,
                    'notes' => filled(
                        $validated['notes'] ?? null
                    )
                        ? trim($validated['notes'])
                        : null,
                ]);

                $invoice->items()->delete();

                $invoice->items()->createMany(
                    $normalizedItems->all()
                );
            });

            session()->flash('notification', [
                'type' => 'success',
                'message' =>
                    'Invoice berhasil diperbarui.',
            ]);

            $this->redirectRoute(
                'owner.invoices.show',
                [
                    'invoice' => $this->invoice->id,
                ],
                navigate: true
            );
        } catch (Throwable $exception) {
            report($exception);

            $this->addError(
                'save',
                $exception instanceof \RuntimeException
                    ? $exception->getMessage()
                    : 'Invoice gagal diperbarui. Silakan coba kembali.'
            );
        }
    }

    public function render()
    {
        return view('livewire.owner.invoices.edit', [
            'subtotal' => $this->subtotal,
            'totalQuantity' => $this->totalQuantity,
        ]);
    }
}