<?php

namespace App\Livewire\Owner\Invoices;

use App\Models\Invoice;
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

    #[Url(except: '')]
    public string $paymentStatus = '';

    #[Url(except: 'latest')]
    public string $sort = 'latest';

    public int $perPage = 10;

    public function mount(): void
    {
        Gate::authorize('view-any invoices');
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function updatedPaymentStatus(): void
    {
        $this->resetPage();
    }

    public function updatedSort(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset([
            'search',
            'status',
            'paymentStatus',
            'sort',
        ]);

        $this->sort = 'latest';

        $this->resetPage();
    }

    private function invoiceQuery(): Builder
    {
        return Invoice::query()
            ->with([
                'project:id,project_code,project_name',
                'quotation:id,quotation_number,project_name',
                'creator:id,name,email',
            ])
            ->when(
                trim($this->search) !== '',
                function (Builder $query): void {
                    $search = '%'
                        .trim($this->search)
                        .'%';

                    $query->where(
                        function (Builder $query) use ($search): void {
                            $query
                                ->where(
                                    'invoice_number',
                                    'like',
                                    $search
                                )
                                ->orWhere(
                                    'client_name',
                                    'like',
                                    $search
                                )
                                ->orWhere(
                                    'client_contact_person',
                                    'like',
                                    $search
                                )
                                ->orWhereHas(
                                    'project',
                                    function (Builder $query) use ($search): void {
                                        $query
                                            ->where(
                                                'project_code',
                                                'like',
                                                $search
                                            )
                                            ->orWhere(
                                                'project_name',
                                                'like',
                                                $search
                                            );
                                    }
                                )
                                ->orWhereHas(
                                    'quotation',
                                    function (Builder $query) use ($search): void {
                                        $query->where(
                                            'quotation_number',
                                            'like',
                                            $search
                                        );
                                    }
                                );
                        }
                    );
                }
            )
            ->when(
                $this->status !== '',
                fn (Builder $query): Builder =>
                    $query->where(
                        'status',
                        $this->status
                    )
            )
            ->when(
                $this->paymentStatus !== '',
                fn (Builder $query): Builder =>
                    $query->where(
                        'payment_status',
                        $this->paymentStatus
                    )
            )
            ->when(
                $this->sort === 'oldest',
                fn (Builder $query): Builder =>
                    $query
                        ->orderBy('invoice_date')
                        ->orderBy('id')
            )
            ->when(
                $this->sort === 'total_highest',
                fn (Builder $query): Builder =>
                    $query
                        ->orderByDesc('grand_total')
                        ->orderByDesc('id')
            )
            ->when(
                $this->sort === 'total_lowest',
                fn (Builder $query): Builder =>
                    $query
                        ->orderBy('grand_total')
                        ->orderByDesc('id')
            )
            ->when(
                $this->sort === 'due_soon',
                fn (Builder $query): Builder =>
                    $query
                        ->orderByRaw(
                            'due_date IS NULL'
                        )
                        ->orderBy('due_date')
                        ->orderByDesc('id')
            )
            ->when(
                $this->sort === 'latest',
                fn (Builder $query): Builder =>
                    $query
                        ->orderByDesc('invoice_date')
                        ->orderByDesc('id')
            );
    }

    private function statistics(): array
    {
        $activeInvoices = Invoice::query()
            ->where('status', '!=', 'cancelled');

        $totalAmount = (float) (clone $activeInvoices)
            ->sum('grand_total');

        $paidAmount = (float) (clone $activeInvoices)
            ->sum('paid_amount');

        $outstandingAmount = max(
            $totalAmount - $paidAmount,
            0
        );

        $unpaidCount = (clone $activeInvoices)
            ->whereIn('payment_status', [
                'unpaid',
                'partial',
            ])
            ->count();

        $paidCount = (clone $activeInvoices)
            ->where('payment_status', 'paid')
            ->count();

        return [
            'total_count' => Invoice::count(),
            'total_amount' => $totalAmount,
            'outstanding_amount' => $outstandingAmount,
            'unpaid_count' => $unpaidCount,
            'paid_amount' => $paidAmount,
            'paid_count' => $paidCount,
        ];
    }

    public function render()
    {
        return view('livewire.owner.invoices.index', [
            'invoices' => $this
                ->invoiceQuery()
                ->paginate($this->perPage),

            'statistics' => $this->statistics(),
        ]);
    }
}