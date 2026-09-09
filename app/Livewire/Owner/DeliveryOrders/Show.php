<?php

namespace App\Livewire\Owner\DeliveryOrders;

use App\Models\DeliveryOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use RuntimeException;
use Throwable;

class Show extends Component
{
    public DeliveryOrder $deliveryOrder;

    public function mount(
        DeliveryOrder $deliveryOrder
    ): void {
        Gate::authorize(
            'view delivery orders'
        );

        $this->deliveryOrder =
            $deliveryOrder;

        $this->loadDeliveryOrderData();
    }

    private function loadDeliveryOrderData(): void
    {
        $this->deliveryOrder->load([
            'project' => fn ($query) => $query
                ->select([
                    'id',
                    'client_id',
                    'mandor_id',
                    'project_code',
                    'project_name',
                    'location',
                    'contract_number',
                    'start_date',
                    'end_date',
                    'progress',
                    'status',
                ])
                ->with([
                    'client' => fn ($query) => $query
                        ->select([
                            'id',
                            'company_name',
                            'contact_person',
                            'phone',
                            'email',
                            'city',
                            'address',
                        ]),

                    'mandor' => fn ($query) => $query
                        ->select([
                            'id',
                            'name',
                            'email',
                            'phone',
                            'status',
                        ]),
                ]),

            'creator' => fn ($query) => $query
                ->select([
                    'id',
                    'name',
                    'email',
                ]),

            'items' => fn ($query) => $query
                ->orderBy('sort_order')
                ->orderBy('id'),
        ]);

        $this->deliveryOrder->loadCount(
            'items'
        );
    }

    public function markAsSent(): void
    {
        Gate::authorize(
            'update delivery orders'
        );

        try {
            DB::transaction(function (): void {
                $deliveryOrder =
                    DeliveryOrder::query()
                        ->whereKey(
                            $this->deliveryOrder->id
                        )
                        ->lockForUpdate()
                        ->firstOrFail();

                if (
                    $deliveryOrder->status
                    !== 'draft'
                ) {
                    throw new RuntimeException(
                        'Hanya Surat Jalan berstatus draft yang dapat dikirim.'
                    );
                }

                if (
                    !$deliveryOrder
                        ->items()
                        ->exists()
                ) {
                    throw new RuntimeException(
                        'Surat Jalan tidak dapat dikirim karena belum mempunyai item.'
                    );
                }

                $deliveryOrder->update([
                    'status' => 'sent',
                    'sent_at' => now(),
                    'received_at' => null,
                ]);
            });

            $this->redirectWithNotification(
                'success',
                sprintf(
                    'Surat Jalan %s berhasil ditandai sebagai dikirim.',
                    $this->deliveryOrder
                        ->delivery_number
                )
            );
        } catch (Throwable $exception) {
            $this->handleStatusException(
                $exception,
                'Surat Jalan gagal ditandai sebagai dikirim.'
            );
        }
    }

    public function markAsReceived(): void
    {
        Gate::authorize(
            'update delivery orders'
        );

        try {
            DB::transaction(function (): void {
                $deliveryOrder =
                    DeliveryOrder::query()
                        ->whereKey(
                            $this->deliveryOrder->id
                        )
                        ->lockForUpdate()
                        ->firstOrFail();

                if (
                    $deliveryOrder->status
                    !== 'sent'
                ) {
                    throw new RuntimeException(
                        'Hanya Surat Jalan berstatus dikirim yang dapat ditandai sebagai diterima.'
                    );
                }

                $deliveryOrder->update([
                    'status' => 'received',

                    /*
                     * Menjaga data lama apabila sent_at
                     * sebelumnya belum tercatat.
                     */
                    'sent_at' =>
                        $deliveryOrder->sent_at
                        ?? now(),

                    'received_at' => now(),
                ]);
            });

            $this->redirectWithNotification(
                'success',
                sprintf(
                    'Surat Jalan %s berhasil ditandai sebagai diterima.',
                    $this->deliveryOrder
                        ->delivery_number
                )
            );
        } catch (Throwable $exception) {
            $this->handleStatusException(
                $exception,
                'Surat Jalan gagal ditandai sebagai diterima.'
            );
        }
    }

    public function cancelDeliveryOrder(): void
    {
        Gate::authorize(
            'update delivery orders'
        );

        try {
            DB::transaction(function (): void {
                $deliveryOrder =
                    DeliveryOrder::query()
                        ->whereKey(
                            $this->deliveryOrder->id
                        )
                        ->lockForUpdate()
                        ->firstOrFail();

                if (
                    !in_array(
                        $deliveryOrder->status,
                        [
                            'draft',
                            'sent',
                        ],
                        true
                    )
                ) {
                    throw new RuntimeException(
                        'Hanya Surat Jalan draft atau dikirim yang dapat dibatalkan.'
                    );
                }

                $deliveryOrder->update([
                    'status' => 'cancelled',
                    'received_at' => null,
                ]);
            });

            $this->redirectWithNotification(
                'warning',
                sprintf(
                    'Surat Jalan %s berhasil dibatalkan.',
                    $this->deliveryOrder
                        ->delivery_number
                )
            );
        } catch (Throwable $exception) {
            $this->handleStatusException(
                $exception,
                'Surat Jalan gagal dibatalkan.'
            );
        }
    }

    private function redirectWithNotification(
        string $type,
        string $message
    ): void {
        session()->flash(
            'notification',
            [
                'type' => $type,
                'message' => $message,
            ]
        );

        $this->redirectRoute(
            'owner.delivery-orders.show',
            [
                'deliveryOrder' =>
                    $this->deliveryOrder->id,
            ],
            navigate: true
        );
    }

    private function handleStatusException(
        Throwable $exception,
        string $defaultMessage
    ): void {
        if (!$exception instanceof RuntimeException) {
            report($exception);
        }

        $this->addError(
            'statusAction',
            $exception instanceof RuntimeException
                ? $exception->getMessage()
                : $defaultMessage
        );

        /*
         * Memuat kembali data agar tombol selalu
         * mengikuti status terbaru dari database.
         */
        $this->deliveryOrder->refresh();

        $this->loadDeliveryOrderData();
    }

    public function render()
    {
        return view(
            'livewire.owner.delivery-orders.show'
        );
    }
}