<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InvoicePdfController extends Controller
{
    public function preview(
        Invoice $invoice
    ): Response {
        $this->authorizeViewInvoice();

        $invoice = $this->loadInvoice($invoice);

        $response = $this
            ->makePdf($invoice)
            ->stream($this->fileName($invoice));

        $this->preventPublicCache($response);

        return $response;
    }

    public function download(
        Invoice $invoice
    ): Response {
        $this->authorizeViewInvoice();

        $invoice = $this->loadInvoice($invoice);

        $response = $this
            ->makePdf($invoice)
            ->download($this->fileName($invoice));

        $this->preventPublicCache($response);

        return $response;
    }

    private function makePdf(
        Invoice $invoice
    ) {
        return Pdf::loadView(
            'pdf.invoices.document',
            [
                'invoice' => $invoice,
            ]
        )
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isRemoteEnabled' => false,
                'isPhpEnabled' => false,
                'defaultFont' => 'DejaVu Sans',
                'dpi' => 96,
                'chroot' => public_path(),
            ]);
    }

    private function loadInvoice(
        Invoice $invoice
    ): Invoice {
        $invoice->load([
            'project' => fn ($query) => $query
                ->with([
                    'client',
                    'mandor',
                ]),

            'quotation',

            'creator:id,name,email',

            'items' => fn ($query) => $query
                ->orderBy('sort_order')
                ->orderBy('id'),
        ]);

        return $invoice;
    }

    private function fileName(
        Invoice $invoice
    ): string {
        $invoiceNumber = Str::of(
            $invoice->invoice_number
                ?: 'invoice-'.$invoice->id
        )
            ->ascii()
            ->replaceMatches(
                '/[^A-Za-z0-9\-_]/',
                '-'
            )
            ->replaceMatches(
                '/-+/',
                '-'
            )
            ->trim('-')
            ->toString();

        if ($invoiceNumber === '') {
            $invoiceNumber =
                'Invoice-'.$invoice->id;
        }

        return sprintf(
            'Invoice-%s.pdf',
            $invoiceNumber
        );
    }

    private function preventPublicCache(
        Response $response
    ): void {
        $response->headers->set(
            'Cache-Control',
            'private, no-store, no-cache, must-revalidate'
        );

        $response->headers->set(
            'Pragma',
            'no-cache'
        );
    }

    private function authorizeViewInvoice(): void
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User
                && $user->can('view invoices'),
            403
        );
    }
}