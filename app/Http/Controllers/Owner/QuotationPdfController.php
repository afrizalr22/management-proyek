<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class QuotationPdfController extends Controller
{
    public function preview(
        Quotation $quotation
    ): Response {
        $this->authorizeViewQuotation();

        $quotation = $this->loadQuotation(
            $quotation
        );

        $response = $this->makePdf(
            $quotation
        )->stream(
            $this->fileName($quotation)
        );

        /*
         * Preview tidak disimpan oleh browser sebagai
         * salinan cache publik.
         */
        $response->headers->set(
            'Cache-Control',
            'private, no-store, no-cache, must-revalidate'
        );

        $response->headers->set(
            'Pragma',
            'no-cache'
        );

        return $response;
    }

    public function download(
        Quotation $quotation
    ): Response {
        $this->authorizeViewQuotation();

        $quotation = $this->loadQuotation(
            $quotation
        );

        $response = $this->makePdf(
            $quotation
        )->download(
            $this->fileName($quotation)
        );

        $response->headers->set(
            'Cache-Control',
            'private, no-store, no-cache, must-revalidate'
        );

        $response->headers->set(
            'Pragma',
            'no-cache'
        );

        return $response;
    }

    private function makePdf(
        Quotation $quotation
    ) {
        return Pdf::loadView(
            'pdf.quotations.document',
            [
                'quotation' => $quotation,
            ]
        )
            ->setPaper('a4', 'portrait')
            ->setOptions([
                /*
                 * Mencegah PDF mengambil gambar,
                 * stylesheet, atau file dari URL luar.
                 */
                'isRemoteEnabled' => false,

                /*
                 * Mencegah eksekusi kode PHP
                 * di dalam dokumen PDF.
                 */
                'isPhpEnabled' => false,

                /*
                 * Menggunakan font yang mendukung
                 * karakter Bahasa Indonesia.
                 */
                'defaultFont' => 'DejaVu Sans',

                /*
                 * Resolusi dokumen.
                 */
                'dpi' => 96,

                /*
                 * Hanya mengizinkan akses file lokal
                 * dari folder public.
                 */
                'chroot' => public_path(),
            ]);
    }

    private function loadQuotation(
        Quotation $quotation
    ): Quotation {
        $quotation->load([
            'client',
            'project',
            'creator',

            'items' => fn ($query) => $query
                ->orderBy('sort_order')
                ->orderBy('id'),
        ]);

        return $quotation;
    }

    private function fileName(
        Quotation $quotation
    ): string {
        $quotationNumber = Str::of(
            $quotation->quotation_number
                ?: 'quotation-'.$quotation->id
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

        if ($quotationNumber === '') {
            $quotationNumber =
                'Quotation-'.$quotation->id;
        }

        return sprintf(
            'Quotation-%s.pdf',
            $quotationNumber
        );
    }

    private function authorizeViewQuotation(): void
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User
                && $user->can(
                    'view quotations'
                ),
            403
        );
    }
}