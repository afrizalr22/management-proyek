<?php

namespace App\Livewire\Owner\Invoices;

use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Locked;
use Livewire\Component;
use RuntimeException;
use Throwable;

class Edit extends Component
{
    public Invoice $invoice;

    public string $invoiceDate = '';

    public string $dueDate = '';

    public string $notes = '';

    #[Locked]
    public array $items = [];

    public function mount(Invoice $invoice): void
    {
        Gate::authorize('update invoices');

        abort_unless(
            $invoice->status === 'draft',
            403,
            'Hanya Invoice berstatus Draft yang dapat diedit.'
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

        /*
         * Item merupakan snapshot Quotation dan hanya
         * digunakan untuk ditampilkan pada form Edit.
         */
        $this->items = $invoice->items
            ->map(fn ($item): array => [
                'item_name' => $item->item_name,
                'description' => $item->description,
                'qty' => (float) $item->qty,
                'unit' => $item->unit,
                'price' => (float) $item->price,
                'total' => (float) $item->total,
            ])
            ->values()
            ->all();
    }

    protected function rules(): array
    {
        return [
            'invoiceDate' => [
                'required',
                'date',
            ],

            'dueDate' => [
                'required',
                'date',
                'after_or_equal:invoiceDate',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'invoiceDate.required' =>
                'Tanggal Invoice wajib diisi.',

            'invoiceDate.date' =>
                'Tanggal Invoice tidak valid.',

            'dueDate.required' =>
                'Tanggal jatuh tempo wajib diisi.',

            'dueDate.date' =>
                'Tanggal jatuh tempo tidak valid.',

            'dueDate.after_or_equal' =>
                'Tanggal jatuh tempo tidak boleh sebelum tanggal Invoice.',

            'notes.max' =>
                'Catatan maksimal 2.000 karakter.',
        ];
    }

    public function updateInvoice(): void
    {
        Gate::authorize('update invoices');

        $validated = $this->validate();

        try {
            DB::transaction(function () use (
                $validated
            ): void {
                $invoice = Invoice::query()
                    ->whereKey($this->invoice->id)
                    ->lockForUpdate()
                    ->first();

                if (! $invoice) {
                    throw new RuntimeException(
                        'invoice_not_found'
                    );
                }

                if ($invoice->status !== 'draft') {
                    throw new RuntimeException(
                        'invoice_not_draft'
                    );
                }

                /*
                 * Project, Quotation, data Client,
                 * item, dan nilai Invoice tidak diubah.
                 */
                $invoice->update([
                    'invoice_date' =>
                        $validated['invoiceDate'],

                    'due_date' =>
                        $validated['dueDate'],

                    'notes' => filled(
                        $validated['notes'] ?? null
                    )
                        ? trim($validated['notes'])
                        : null,
                ]);

                $this->invoice = $invoice->fresh();
            });

            session()->flash('notification', [
                'type' => 'update',
                'message' => sprintf(
                    'Invoice %s berhasil diperbarui.',
                    $this->invoice->invoice_number
                ),
            ]);

            $this->redirectRoute(
                'owner.invoices.show',
                [
                    'invoice' => $this->invoice->id,
                ],
                navigate: true
            );
        } catch (RuntimeException $exception) {
            $message = match ($exception->getMessage()) {
                'invoice_not_found' =>
                    'Invoice tidak ditemukan.',

                'invoice_not_draft' =>
                    'Invoice tidak dapat diubah karena sudah tidak berstatus Draft.',

                default =>
                    'Invoice gagal diperbarui.',
            };

            $this->addError('save', $message);
        } catch (Throwable $exception) {
            report($exception);

            $this->addError(
                'save',
                'Invoice gagal diperbarui. Silakan coba kembali.'
            );
        }
    }

    public function render()
    {
        $subtotal = (float) $this->invoice
            ->items
            ->sum('total');

        $totalQuantity = (float) $this->invoice
            ->items
            ->sum('qty');

        return view(
            'livewire.owner.invoices.edit',
            [
                'subtotal' => $subtotal,
                'totalQuantity' => $totalQuantity,
            ]
        );
    }
}