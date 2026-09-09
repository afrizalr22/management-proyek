<?php

namespace App\Livewire\Owner\DeliveryOrders;

use App\Models\DeliveryOrder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $status = '';

    #[Url(except: 'latest')]
    public string $sort = 'latest';

    public function mount(): void
    {
        Gate::authorize(
            'view-any delivery orders'
        );

        $this->normalizeFilters();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->normalizeFilters();
        $this->resetPage();
    }

    public function updatedSort(): void
    {
        $this->normalizeFilters();
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset([
            'search',
            'status',
        ]);

        $this->sort = 'latest';

        $this->resetPage();
    }

    private function normalizeFilters(): void
    {
        if (! in_array(
            $this->status,
            [
                '',
                'draft',
                'sent',
                'received',
                'cancelled',
            ],
            true
        )) {
            $this->status = '';
        }

        if (! in_array(
            $this->sort,
            [
                'latest',
                'oldest',
                'delivery_latest',
                'delivery_oldest',
                'number_ascending',
                'number_descending',
            ],
            true
        )) {
            $this->sort = 'latest';
        }
    }

    private function deliveryOrdersQuery(): Builder
    {
        $search = trim($this->search);

        return DeliveryOrder::query()
            ->with([
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
                        'mandor:id,name',
                    ]),

                'creator:id,name',
            ])
            ->withCount('items')
            ->when(
                $search !== '',
                function (
                    Builder $query
                ) use ($search): void {
                    $query->where(
                        function (
                            Builder $subQuery
                        ) use ($search): void {
                            $subQuery
                                ->where(
                                    'delivery_number',
                                    'like',
                                    '%'.$search.'%'
                                )
                                ->orWhere(
                                    'destination',
                                    'like',
                                    '%'.$search.'%'
                                )
                                ->orWhere(
                                    'receiver_name',
                                    'like',
                                    '%'.$search.'%'
                                )
                                ->orWhere(
                                    'receiver_phone',
                                    'like',
                                    '%'.$search.'%'
                                )
                                ->orWhereHas(
                                    'project',
                                    function (
                                        Builder $projectQuery
                                    ) use ($search): void {
                                        $projectQuery
                                            ->where(
                                                'project_code',
                                                'like',
                                                '%'.$search.'%'
                                            )
                                            ->orWhere(
                                                'project_name',
                                                'like',
                                                '%'.$search.'%'
                                            )
                                            ->orWhereHas(
                                                'client',
                                                fn (
                                                    Builder $clientQuery
                                                ) => $clientQuery
                                                    ->where(
                                                        'company_name',
                                                        'like',
                                                        '%'.$search.'%'
                                                    )
                                            );
                                    }
                                );
                        }
                    );
                }
            )
            ->when(
                $this->status !== '',
                fn (Builder $query) =>
                    $query->where(
                        'status',
                        $this->status
                    )
            )
            ->when(
                $this->sort === 'latest',
                fn (Builder $query) =>
                    $query
                        ->latest('id')
            )
            ->when(
                $this->sort === 'oldest',
                fn (Builder $query) =>
                    $query
                        ->oldest('id')
            )
            ->when(
                $this->sort === 'delivery_latest',
                fn (Builder $query) =>
                    $query
                        ->orderByDesc(
                            'delivery_date'
                        )
                        ->orderByDesc('id')
            )
            ->when(
                $this->sort === 'delivery_oldest',
                fn (Builder $query) =>
                    $query
                        ->orderBy(
                            'delivery_date'
                        )
                        ->orderBy('id')
            )
            ->when(
                $this->sort === 'number_ascending',
                fn (Builder $query) =>
                    $query
                        ->orderBy(
                            'delivery_number'
                        )
            )
            ->when(
                $this->sort === 'number_descending',
                fn (Builder $query) =>
                    $query
                        ->orderByDesc(
                            'delivery_number'
                        )
            );
    }

    private function statistics(): array
    {
        return [
            'total' =>
                DeliveryOrder::query()->count(),

            'draft' =>
                DeliveryOrder::query()
                    ->where('status', 'draft')
                    ->count(),

            'sent' =>
                DeliveryOrder::query()
                    ->where('status', 'sent')
                    ->count(),

            'received' =>
                DeliveryOrder::query()
                    ->where('status', 'received')
                    ->count(),

            'cancelled' =>
                DeliveryOrder::query()
                    ->where('status', 'cancelled')
                    ->count(),
        ];
    }

    public function render()
    {
        return view(
            'livewire.owner.delivery-orders.index',
            [
                'deliveryOrders' =>
                    $this->deliveryOrdersQuery()
                        ->paginate(10),

                'statistics' =>
                    $this->statistics(),
            ]
        );
    }
}