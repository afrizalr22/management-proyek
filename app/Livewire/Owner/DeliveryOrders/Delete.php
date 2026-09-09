<?php

namespace App\Livewire\Owner\DeliveryOrders;

use App\Models\DeliveryOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use RuntimeException;
use Throwable;

class Delete extends Component
{
    public ?int $deliveryOrderId = null;

    public string $deliveryNumber = '';

    public string $projectName = '';

    public string $projectCode = '';

    public string $clientName = '';

    public string $destination = '';

    public string $receiverName = '';

    public string $deliveryDate = '';

    public string $status = '';

    public int $itemsCount = 0;

    public function openModal(
        int $deliveryOrderId
    ): void {
        Gate::authorize(
            'delete delivery orders'
        );

        $this->resetModalData();
        $this->resetErrorBag();

        $deliveryOrder =
            DeliveryOrder::query()
                ->with([
                    'project' => fn ($query) => $query
                        ->select([
                            'id',
                            'client_id',
                            'project_code',
                            'project_name',
                        ])
                        ->with([
                            'client:id,company_name',
                        ]),
                ])
                ->withCount('items')
                ->findOrFail(
                    $deliveryOrderId
                );

        $this->deliveryOrderId =
            $deliveryOrder->id;

        $this->deliveryNumber =
            $deliveryOrder->delivery_number;

        $this->projectName =
            $deliveryOrder->project?->project_name
            ?? 'Project tidak tersedia';

        $this->projectCode =
            $deliveryOrder->project?->project_code
            ?? '-';

        $this->clientName =
            $deliveryOrder->project?->client
                ?->company_name
            ?? '-';

        $this->destination =
            $deliveryOrder->destination;

        $this->receiverName =
            $deliveryOrder->receiver_name;

        $this->deliveryDate =
            $deliveryOrder->delivery_date
                ?->translatedFormat('d F Y')
            ?? '-';

        $this->status =
            $deliveryOrder->status;

        $this->itemsCount =
            (int) $deliveryOrder->items_count;

        if (
            !$this->canDeleteDeliveryOrder(
                $deliveryOrder
            )
        ) {
            $this->addError(
                'delete',
                'Hanya Surat Jalan berstatus draft yang dapat dihapus.'
            );
        }
    }

    public function deleteDeliveryOrder(): void
    {
        Gate::authorize(
            'delete delivery orders'
        );

        if ($this->deliveryOrderId === null) {
            $this->addError(
                'delete',
                'Surat Jalan yang akan dihapus tidak ditemukan.'
            );

            return;
        }

        try {
            DB::transaction(function (): void {
                $deliveryOrder =
                    DeliveryOrder::query()
                        ->whereKey(
                            $this->deliveryOrderId
                        )
                        ->lockForUpdate()
                        ->firstOrFail();

                if (
                    !$this->canDeleteDeliveryOrder(
                        $deliveryOrder
                    )
                ) {
                    throw new RuntimeException(
                        'Hanya Surat Jalan berstatus draft yang dapat dihapus.'
                    );
                }

                /*
                 * Item pengiriman akan ikut terhapus
                 * melalui foreign key cascade.
                 */
                $deliveryOrder->delete();
            });

            session()->flash(
                'notification',
                [
                    'type' => 'delete',

                    'message' => sprintf(
                        'Surat Jalan %s berhasil dihapus.',
                        $this->deliveryNumber
                    ),
                ]
            );

            $this->redirectRoute(
                'owner.delivery-orders.index',
                navigate: true
            );
        } catch (Throwable $exception) {
            if (
                !$exception instanceof
                    RuntimeException
            ) {
                report($exception);
            }

            $this->addError(
                'delete',
                $exception instanceof
                    RuntimeException
                    ? $exception->getMessage()
                    : 'Surat Jalan gagal dihapus. Silakan coba kembali.'
            );
        }
    }

    public function closeModal(): void
    {
        $this->resetModalData();
        $this->resetErrorBag();
    }

    private function canDeleteDeliveryOrder(
        DeliveryOrder $deliveryOrder
    ): bool {
        return $deliveryOrder->status
            === 'draft';
    }

    private function resetModalData(): void
    {
        $this->deliveryOrderId = null;
        $this->deliveryNumber = '';
        $this->projectName = '';
        $this->projectCode = '';
        $this->clientName = '';
        $this->destination = '';
        $this->receiverName = '';
        $this->deliveryDate = '';
        $this->status = '';
        $this->itemsCount = 0;
    }

    public function render()
    {
        return view(
            'livewire.owner.delivery-orders.delete'
        );
    }
}