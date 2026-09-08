<?php

namespace App\Livewire\Owner\Invoices;

use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Throwable;

class Delete extends Component
{
    public ?int $invoiceId = null;

    public string $invoiceNumber = '';

    public string $clientName = '';

    public string $projectName = '';

    public string $quotationNumber = '';

    public string $paymentStatus = '';

    public float $grandTotal = 0;

    public int $itemsCount = 0;

    public function openModal(int $invoiceId): void
    {
        Gate::authorize('delete invoices');

        $this->resetModalData();
        $this->resetErrorBag();

        $invoice = Invoice::query()
            ->with([
                'project:id,project_name',
                'quotation:id,quotation_number,project_name',
            ])
            ->withCount('items')
            ->findOrFail($invoiceId);

        $this->invoiceId = $invoice->id;
        $this->invoiceNumber = $invoice->invoice_number;
        $this->clientName = $invoice->client_name;

        $this->projectName =
            $invoice->project?->project_name
            ?? $invoice->quotation?->project_name
            ?? 'Belum terhubung dengan proyek';

        $this->quotationNumber =
            $invoice->quotation?->quotation_number
            ?? '-';

        $this->paymentStatus =
            $invoice->payment_status;

        $this->grandTotal =
            (float) $invoice->grand_total;

        $this->itemsCount =
            (int) $invoice->items_count;

        if (! $this->canDeleteInvoice($invoice)) {
            $this->addError(
                'delete',
                'Hanya invoice draft yang belum menerima pembayaran yang dapat dihapus.'
            );
        }
    }

    public function deleteInvoice(): void
    {
        Gate::authorize('delete invoices');

        if ($this->invoiceId === null) {
            $this->addError(
                'delete',
                'Invoice yang akan dihapus tidak ditemukan.'
            );

            return;
        }

        try {
            DB::transaction(function (): void {
                $invoice = Invoice::query()
                    ->whereKey($this->invoiceId)
                    ->lockForUpdate()
                    ->firstOrFail();

                if (! $this->canDeleteInvoice($invoice)) {
                    throw new \RuntimeException(
                        'Hanya invoice draft yang belum menerima pembayaran yang dapat dihapus.'
                    );
                }

                $invoice->delete();
            });

            session()->flash('notification', [
                'type' => 'delete',
                'message' =>
                    'Invoice berhasil dihapus.',
            ]);

            $this->redirectRoute(
                'owner.invoices.index',
                navigate: true
            );
        } catch (Throwable $exception) {
            if (! $exception instanceof \RuntimeException) {
                report($exception);
            }

            $this->addError(
                'delete',
                $exception instanceof \RuntimeException
                    ? $exception->getMessage()
                    : 'Invoice gagal dihapus. Silakan coba kembali.'
            );
        }
    }

    public function closeModal(): void
    {
        $this->resetModalData();
        $this->resetErrorBag();
    }

    private function canDeleteInvoice(
        Invoice $invoice
    ): bool {
        return $invoice->status === 'draft'
            && $invoice->payment_status === 'unpaid'
            && (float) $invoice->paid_amount <= 0;
    }

    private function resetModalData(): void
    {
        $this->invoiceId = null;
        $this->invoiceNumber = '';
        $this->clientName = '';
        $this->projectName = '';
        $this->quotationNumber = '';
        $this->paymentStatus = '';
        $this->grandTotal = 0;
        $this->itemsCount = 0;
    }

    public function render()
    {
        return view(
            'livewire.owner.invoices.delete'
        );
    }
}