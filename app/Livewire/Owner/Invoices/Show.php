<?php

namespace App\Livewire\Owner\Invoices;

use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Throwable;

class Show extends Component
{
    public Invoice $invoice;

    public string $paymentAmount = '';

    public function mount(Invoice $invoice): void
    {
        Gate::authorize('view invoices');

        $this->invoice = $invoice;

        $this->loadInvoiceData();
    }

    private function loadInvoiceData(): void
    {
        $this->invoice->refresh();

        $this->invoice->load([
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
                    'mandor:id,name,email',
                ]),

            'quotation' => fn ($query) => $query
                ->select([
                    'id',
                    'quotation_number',
                    'status',
                    'project_name',
                    'project_location',
                ]),

            'creator:id,name,email',

            'items' => fn ($query) => $query
                ->orderBy('sort_order')
                ->orderBy('id'),
        ]);

        $this->invoice->loadCount('items');
    }

    public function issueInvoice(): void
    {
        Gate::authorize('update invoices');

        try {
            DB::transaction(function (): void {
                $invoice = Invoice::query()
                    ->whereKey($this->invoice->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($invoice->status !== 'draft') {
                    throw new \RuntimeException(
                        'Hanya invoice draft yang dapat diterbitkan.'
                    );
                }

                if (! $invoice->items()->exists()) {
                    throw new \RuntimeException(
                        'Invoice tidak dapat diterbitkan karena belum memiliki item.'
                    );
                }

                if ((float) $invoice->grand_total <= 0) {
                    throw new \RuntimeException(
                        'Invoice tidak dapat diterbitkan karena total invoice belum valid.'
                    );
                }

                $invoice->update([
                    'status' => 'issued',
                    'issued_at' => now(),
                ]);
            });

            $this->redirectWithNotification(
                'success',
                'Invoice berhasil diterbitkan.'
            );
        } catch (Throwable $exception) {
            $this->handleActionException(
                $exception,
                'Invoice gagal diterbitkan.'
            );
        }
    }

    public function markAsSent(): void
    {
        Gate::authorize('update invoices');

        try {
            DB::transaction(function (): void {
                $invoice = Invoice::query()
                    ->whereKey($this->invoice->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($invoice->status !== 'issued') {
                    throw new \RuntimeException(
                        'Hanya invoice yang sudah diterbitkan yang dapat ditandai sebagai dikirim.'
                    );
                }

                $invoice->update([
                    'status' => 'sent',
                    'sent_at' => now(),
                ]);
            });

            $this->redirectWithNotification(
                'success',
                'Invoice berhasil ditandai sebagai sudah dikirim.'
            );
        } catch (Throwable $exception) {
            $this->handleActionException(
                $exception,
                'Status pengiriman invoice gagal diperbarui.'
            );
        }
    }

    public function cancelInvoice(): void
    {
        Gate::authorize('update invoices');

        try {
            DB::transaction(function (): void {
                $invoice = Invoice::query()
                    ->whereKey($this->invoice->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if (! in_array(
                    $invoice->status,
                    ['draft', 'issued', 'sent'],
                    true
                )) {
                    throw new \RuntimeException(
                        'Invoice ini tidak dapat dibatalkan.'
                    );
                }

                if (
                    (float) $invoice->paid_amount > 0
                    || $invoice->payment_status !== 'unpaid'
                ) {
                    throw new \RuntimeException(
                        'Invoice yang sudah memiliki pembayaran tidak dapat dibatalkan.'
                    );
                }

                $invoice->update([
                    'status' => 'cancelled',
                ]);
            });

            $this->redirectWithNotification(
                'warning',
                'Invoice berhasil dibatalkan.'
            );
        } catch (Throwable $exception) {
            $this->handleActionException(
                $exception,
                'Invoice gagal dibatalkan.'
            );
        }
    }

    public function recordPayment(): void
    {
        Gate::authorize('update invoices');

        $validated = $this->validate(
            [
                'paymentAmount' => [
                    'required',
                    'numeric',
                    'gt:0',
                    'max:9999999999999.99',
                ],
            ],
            [
                'paymentAmount.required' =>
                    'Jumlah pembayaran wajib diisi.',

                'paymentAmount.numeric' =>
                    'Jumlah pembayaran harus berupa angka.',

                'paymentAmount.gt' =>
                    'Jumlah pembayaran harus lebih dari 0.',

                'paymentAmount.max' =>
                    'Jumlah pembayaran terlalu besar.',
            ]
        );

        try {
            DB::transaction(function () use ($validated): void {
                $invoice = Invoice::query()
                    ->whereKey($this->invoice->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if (! in_array(
                    $invoice->status,
                    ['issued', 'sent'],
                    true
                )) {
                    throw new \RuntimeException(
                        'Pembayaran hanya dapat dicatat pada invoice yang sudah diterbitkan atau dikirim.'
                    );
                }

                if ($invoice->payment_status === 'paid') {
                    throw new \RuntimeException(
                        'Invoice ini sudah lunas.'
                    );
                }

                $grandTotal = round(
                    (float) $invoice->grand_total,
                    2
                );

                $currentPaidAmount = round(
                    (float) $invoice->paid_amount,
                    2
                );

                $paymentAmount = round(
                    (float) $validated['paymentAmount'],
                    2
                );

                $remainingAmount = round(
                    max($grandTotal - $currentPaidAmount, 0),
                    2
                );

                if ($remainingAmount <= 0) {
                    throw new \RuntimeException(
                        'Invoice ini tidak memiliki sisa tagihan.'
                    );
                }

                if ($paymentAmount > $remainingAmount) {
                    throw new \RuntimeException(
                        'Jumlah pembayaran melebihi sisa tagihan sebesar Rp '
                        .number_format(
                            $remainingAmount,
                            0,
                            ',',
                            '.'
                        ).'.'
                    );
                }

                $newPaidAmount = round(
                    $currentPaidAmount + $paymentAmount,
                    2
                );

                $isPaid = $newPaidAmount >= $grandTotal;

                $invoice->update([
                    'paid_amount' => $isPaid
                        ? $grandTotal
                        : $newPaidAmount,

                    'payment_status' => $isPaid
                        ? 'paid'
                        : 'partial',

                    'paid_at' => $isPaid
                        ? now()
                        : null,
                ]);
            });

            $this->paymentAmount = '';

            $this->redirectWithNotification(
                'success',
                'Pembayaran invoice berhasil dicatat.'
            );
        } catch (Throwable $exception) {
            $this->handleActionException(
                $exception,
                'Pembayaran invoice gagal dicatat.',
                'paymentAmount'
            );
        }
    }

    private function redirectWithNotification(
        string $type,
        string $message
    ): void {
        session()->flash('notification', [
            'type' => $type,
            'message' => $message,
        ]);

        $this->redirectRoute(
            'owner.invoices.show',
            [
                'invoice' => $this->invoice->id,
            ],
            navigate: true
        );
    }

    private function handleActionException(
        Throwable $exception,
        string $fallbackMessage,
        string $errorField = 'action'
    ): void {
        if (! $exception instanceof \RuntimeException) {
            report($exception);
        }

        $this->addError(
            $errorField,
            $exception instanceof \RuntimeException
                ? $exception->getMessage()
                : $fallbackMessage
        );

        $this->loadInvoiceData();
    }

    public function render()
    {
        return view('livewire.owner.invoices.show');
    }
}