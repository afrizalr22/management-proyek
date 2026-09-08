<?php

namespace App\Livewire\Owner\Invoices;

use App\Models\Invoice;
use App\Models\Quotation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use RuntimeException;
use Throwable;

class Create extends Component
{
    public ?int $quotationId = null;

    public string $invoiceDate = '';

    public string $dueDate = '';

    public string $notes = '';

    /*
     * Data preview Quotation.
     */
    public string $quotationNumber = '';

    public string $clientName = '';

    public string $clientContactPerson = '';

    public string $clientPhone = '';

    public string $clientEmail = '';

    public string $clientAddress = '';

    public string $projectName = '';

    public array $items = [];

    public float $subtotal = 0;

    public float $grandTotal = 0;

    public function mount(): void
    {
        Gate::authorize('create invoices');

        $this->invoiceDate = now()->toDateString();

        $this->dueDate = now()
            ->addDays(14)
            ->toDateString();
    }

    protected function rules(): array
    {
        return [
            'quotationId' => [
                'required',
                'integer',
                'exists:quotations,id',
            ],

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
            'quotationId.required' =>
                'Pilih Quotation yang akan dibuatkan Invoice.',

            'quotationId.integer' =>
                'Quotation yang dipilih tidak valid.',

            'quotationId.exists' =>
                'Quotation tidak ditemukan.',

            'invoiceDate.required' =>
                'Tanggal Invoice wajib diisi.',

            'invoiceDate.date' =>
                'Tanggal Invoice tidak valid.',

            'dueDate.required' =>
                'Tanggal jatuh tempo wajib diisi.',

            'dueDate.date' =>
                'Tanggal jatuh tempo tidak valid.',

            'dueDate.after_or_equal' =>
                'Jatuh tempo tidak boleh sebelum tanggal Invoice.',

            'notes.max' =>
                'Catatan maksimal 2.000 karakter.',
        ];
    }

    public function updatedQuotationId(): void
    {
        $this->resetValidation([
            'quotationId',
            'save',
        ]);

        $this->loadQuotationPreview();
    }

    private function loadQuotationPreview(): void
    {
        $this->resetQuotationPreview();

        if (!$this->quotationId) {
            return;
        }

        $quotation = Quotation::query()
            ->with([
                'project:id,project_name',
                'items' => fn ($query) => $query
                    ->orderBy('sort_order')
                    ->orderBy('id'),
            ])
            ->whereKey($this->quotationId)
            ->where('status', 'approved')
            ->whereDoesntHave('invoice')
            ->first();

        if (!$quotation) {
            $this->quotationId = null;

            $this->addError(
                'quotationId',
                'Quotation tidak tersedia atau sudah mempunyai Invoice.'
            );

            return;
        }

        $this->quotationNumber =
            $quotation->quotation_number;

        $this->clientName =
            $quotation->client_name;

        $this->clientContactPerson =
            $quotation->client_contact_person ?? '';

        $this->clientPhone =
            $quotation->client_phone ?? '';

        $this->clientEmail =
            $quotation->client_email ?? '';

        $this->clientAddress =
            $quotation->client_address ?? '';

        $this->projectName =
            $quotation->project?->project_name
            ?? $quotation->project_name
            ?? 'Belum dibuat';

        $this->items = $quotation->items
            ->map(fn ($item): array => [
                'item_name' => $item->item_name,
                'description' => $item->description,
                'qty' => (float) $item->qty,
                'unit' => $item->unit,
                'price' => (float) $item->price,
                'total' => (float) $item->total,
            ])
            ->all();

        $this->subtotal = (float) $quotation
            ->items
            ->sum('total');

        $this->grandTotal = $this->subtotal;
    }

    private function resetQuotationPreview(): void
    {
        $this->quotationNumber = '';
        $this->clientName = '';
        $this->clientContactPerson = '';
        $this->clientPhone = '';
        $this->clientEmail = '';
        $this->clientAddress = '';
        $this->projectName = '';
        $this->items = [];
        $this->subtotal = 0;
        $this->grandTotal = 0;
    }

    public function createInvoice(): void
    {
        Gate::authorize('create invoices');

        $validated = $this->validate();

        try {
            $invoice = DB::transaction(
                function () use ($validated): Invoice {
                    $quotation = Quotation::query()
                        ->with([
                            'items' => fn ($query) => $query
                                ->orderBy('sort_order')
                                ->orderBy('id'),
                        ])
                        ->lockForUpdate()
                        ->find($validated['quotationId']);

                    if (!$quotation) {
                        throw new RuntimeException(
                            'quotation_not_found'
                        );
                    }

                    if ($quotation->status !== 'approved') {
                        throw new RuntimeException(
                            'quotation_not_approved'
                        );
                    }

                    $invoiceExists = Invoice::query()
                        ->where(
                            'quotation_id',
                            $quotation->id
                        )
                        ->lockForUpdate()
                        ->exists();

                    if ($invoiceExists) {
                        throw new RuntimeException(
                            'invoice_already_exists'
                        );
                    }

                    if ($quotation->items->isEmpty()) {
                        throw new RuntimeException(
                            'quotation_has_no_items'
                        );
                    }

                    $subtotal = (float) $quotation
                        ->items
                        ->sum(
                            fn ($item): float =>
                                round(
                                    (float) $item->qty
                                    * (float) $item->price,
                                    2
                                )
                        );

                    $invoice = Invoice::create([
                        'project_id' =>
                            $quotation->project_id,

                        'quotation_id' =>
                            $quotation->id,

                        'created_by' =>
                            Auth::id(),

                        'invoice_number' =>
                            $this->generateInvoiceNumber(),

                        'invoice_date' =>
                            $validated['invoiceDate'],

                        'due_date' =>
                            $validated['dueDate'],

                        'status' => 'draft',

                        'client_name' =>
                            $quotation->client_name,

                        'client_contact_person' =>
                            $quotation->client_contact_person,

                        'client_phone' =>
                            $quotation->client_phone,

                        'client_email' =>
                            $quotation->client_email,

                        'client_address' =>
                            $quotation->client_address,

                        'subtotal' => $subtotal,

                        /*
                         * Pajak dan diskon belum digunakan.
                         */
                        'tax_amount' => 0,
                        'discount_amount' => 0,

                        'grand_total' => $subtotal,

                        'paid_amount' => 0,
                        'payment_status' => 'unpaid',

                        'issued_at' => null,
                        'sent_at' => null,
                        'paid_at' => null,

                        'notes' => filled(
                            $validated['notes'] ?? null
                        )
                            ? trim($validated['notes'])
                            : null,
                    ]);

                    foreach (
                        $quotation->items as $index => $item
                    ) {
                        $qty = (float) $item->qty;
                        $price = (float) $item->price;

                        $invoice->items()->create([
                            'item_name' =>
                                $item->item_name,

                            'description' =>
                                $item->description,

                            'qty' => $qty,

                            'unit' =>
                                $item->unit,

                            'price' => $price,

                            'total' =>
                                round($qty * $price, 2),

                            'sort_order' =>
                                $index + 1,
                        ]);
                    }

                    return $invoice;
                }
            );

            session()->flash('notification', [
                'type' => 'success',
                'message' => sprintf(
                    'Invoice %s berhasil dibuat.',
                    $invoice->invoice_number
                ),
            ]);

            /*
             * Untuk saat ini kembali ke Index.
             * Detail dinamis dibuat pada Sprint berikutnya.
             */
            $this->redirectRoute(
                'owner.invoices.index',
                navigate: true
            );
        } catch (RuntimeException $exception) {
            $message = match ($exception->getMessage()) {
                'quotation_not_found' =>
                    'Quotation tidak ditemukan.',

                'quotation_not_approved' =>
                    'Hanya Quotation yang sudah disetujui yang dapat dibuatkan Invoice.',

                'invoice_already_exists' =>
                    'Quotation ini sudah mempunyai Invoice.',

                'quotation_has_no_items' =>
                    'Quotation tidak mempunyai item pekerjaan.',

                default =>
                    'Invoice gagal dibuat.',
            };

            $this->addError('save', $message);
        } catch (Throwable $exception) {
            report($exception);

            $this->addError(
                'save',
                'Invoice gagal dibuat. Silakan coba kembali.'
            );
        }
    }

    private function generateInvoiceNumber(): string
    {
        $year = now()->format('Y');

        $prefix = sprintf(
            'INV-%s-',
            $year
        );

        $lastNumber = Invoice::query()
            ->where(
                'invoice_number',
                'like',
                $prefix.'%'
            )
            ->lockForUpdate()
            ->orderByDesc('invoice_number')
            ->value('invoice_number');

        $sequence = 1;

        if (
            is_string($lastNumber)
            && preg_match(
                '/(\d+)$/',
                $lastNumber,
                $matches
            )
        ) {
            $sequence = (int) $matches[1] + 1;
        }

        return sprintf(
            '%s%04d',
            $prefix,
            $sequence
        );
    }

    public function render()
    {
        $quotations = Quotation::query()
            ->where('status', 'approved')
            ->whereDoesntHave('invoice')
            ->whereHas('items')
            ->withCount('items')
            ->orderByDesc('approved_at')
            ->orderByDesc('id')
            ->get([
                'id',
                'quotation_number',
                'client_name',
                'project_name',
                'grand_total',
                'approved_at',
            ]);

        return view(
            'livewire.owner.invoices.create',
            [
                'quotations' => $quotations,
            ]
        );
    }
}