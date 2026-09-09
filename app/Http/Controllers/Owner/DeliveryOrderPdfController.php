<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\DeliveryOrder;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DeliveryOrderPdfController extends Controller
{
    public function preview(
        DeliveryOrder $deliveryOrder
    ): Response {
        $this->authorizeViewDeliveryOrder();

        $deliveryOrder =
            $this->loadDeliveryOrder(
                $deliveryOrder
            );

        $response = $this
            ->makePdf($deliveryOrder)
            ->stream(
                $this->fileName(
                    $deliveryOrder
                )
            );

        $this->preventPublicCache(
            $response
        );

        return $response;
    }

    public function download(
        DeliveryOrder $deliveryOrder
    ): Response {
        $this->authorizeViewDeliveryOrder();

        $deliveryOrder =
            $this->loadDeliveryOrder(
                $deliveryOrder
            );

        $response = $this
            ->makePdf($deliveryOrder)
            ->download(
                $this->fileName(
                    $deliveryOrder
                )
            );

        $this->preventPublicCache(
            $response
        );

        return $response;
    }

    private function makePdf(
        DeliveryOrder $deliveryOrder
    ) {
        return Pdf::loadView(
            'pdf.delivery-orders.document',
            [
                'deliveryOrder' =>
                    $deliveryOrder,
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
                 * Font mendukung karakter Bahasa
                 * Indonesia dan simbol satuan.
                 */
                'defaultFont' => 'DejaVu Sans',

                'dpi' => 96,

                /*
                 * Akses file lokal hanya dari
                 * direktori public.
                 */
                'chroot' => public_path(),
            ]);
    }

    private function loadDeliveryOrder(
        DeliveryOrder $deliveryOrder
    ): DeliveryOrder {
        $deliveryOrder->load([
            'project' => fn ($query) => $query
                ->with([
                    'client',
                    'mandor',
                ]),

            'creator:id,name,email',

            'items' => fn ($query) => $query
                ->orderBy('sort_order')
                ->orderBy('id'),
        ]);

        return $deliveryOrder;
    }

    private function fileName(
        DeliveryOrder $deliveryOrder
    ): string {
        $deliveryNumber = Str::of(
            $deliveryOrder->delivery_number
                ?: 'surat-jalan-'
                    .$deliveryOrder->id
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

        if ($deliveryNumber === '') {
            $deliveryNumber =
                'Surat-Jalan-'
                .$deliveryOrder->id;
        }

        return sprintf(
            'Surat-Jalan-%s.pdf',
            $deliveryNumber
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

    private function authorizeViewDeliveryOrder(): void
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User
                && $user->can(
                    'view delivery orders'
                ),
            403
        );
    }
}