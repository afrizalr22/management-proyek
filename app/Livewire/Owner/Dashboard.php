<?php

namespace App\Livewire\Owner;

use App\Livewire\Actions\Logout;
use App\Models\Client;
use App\Models\DailyReport;
use App\Models\DeliveryOrder;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\Quotation;
use Livewire\Component;


class Dashboard extends Component
{
    public function logout(Logout $logout)
    {
        $logout();

        return redirect()->route('login');
    }

    public function render()
    {
        $activeClients = Client::query()
            ->where('status', 'active')
            ->count();

        $totalClients = Client::query()
            ->count();

        $activeProjects = Project::query()
            ->whereNotIn(
                'status',
                [
                    'completed',
                    'cancelled',
                ]
            )
            ->count();

        $totalProjects = Project::query()
            ->count();

        $invoiceSummary = Invoice::query()
            ->where('status', '!=', 'cancelled')
            ->selectRaw(
                'COALESCE(SUM(grand_total), 0) as grand_total'
            )
            ->selectRaw(
                'COALESCE(SUM(paid_amount), 0) as paid_amount'
            )
            ->first();

        $invoiceGrandTotal = (float) (
            $invoiceSummary?->grand_total
            ?? 0
        );

        $invoicePaidAmount = (float) (
            $invoiceSummary?->paid_amount
            ?? 0
        );

        $outstandingAmount = max(
            $invoiceGrandTotal - $invoicePaidAmount,
            0
        );

        $totalInvoices = Invoice::query()
            ->where('status', '!=', 'cancelled')
            ->count();

        $unpaidInvoices = Invoice::query()
            ->where('status', '!=', 'cancelled')
            ->whereIn(
                'payment_status',
                [
                    'unpaid',
                    'partial',
                ]
            )
            ->count();

        $statistics = [
            'active_clients' =>
                $activeClients,

            'total_clients' =>
                $totalClients,

            'active_projects' =>
                $activeProjects,

            'total_projects' =>
                $totalProjects,

            'invoice_grand_total' =>
                $invoiceGrandTotal,

            'invoice_paid_amount' =>
                $invoicePaidAmount,

            'outstanding_amount' =>
                $outstandingAmount,

            'total_invoices' =>
                $totalInvoices,

            'unpaid_invoices' =>
                $unpaidInvoices,
        ];

        $summary = [
        'quotations' =>
            Quotation::query()->count(),

        'approved_quotations' =>
            Quotation::query()
                ->where('status', 'approved')
                ->count(),

        'delivery_orders' =>
            DeliveryOrder::query()->count(),

        'draft_delivery_orders' =>
            DeliveryOrder::query()
                ->where('status', 'draft')
                ->count(),

        'delayed_projects' =>
            Project::query()
                ->whereNotNull('end_date')
                ->whereDate('end_date', '<', today())
                ->whereNotIn(
                    'status',
                    [
                        'completed',
                        'cancelled',
                    ]
                )
                ->count(),

        'overdue_invoices' =>
            Invoice::query()
                ->whereNotNull('due_date')
                ->whereDate('due_date', '<', today())
                ->whereIn(
                    'status',
                    [
                        'issued',
                        'sent',
                    ]
                )
                ->where(
                    'payment_status',
                    '!=',
                    'paid'
                )
                ->count(),

        'project_issues' =>
            DailyReport::query()
                ->whereNotNull('obstacles')
                ->where('obstacles', '!=', '')
                ->count(),

        'pending_delivery_orders' =>
            DeliveryOrder::query()
                ->whereIn(
                    'status',
                    [
                        'draft',
                        'sent',
                    ]
                )
                ->count(),
    ];

    $chartProjects = Project::query()
    ->whereNotIn(
        'status',
        [
            'completed',
            'cancelled',
        ]
    )
    ->orderByDesc('updated_at')
    ->limit(8)
    ->get([
        'id',
        'project_code',
        'project_name',
        'progress',
        'status',
    ]);

    $pipelineProjects = Project::query()
    ->with([
        'client:id,company_name,city',
        'mandor:id,name',
    ])
    ->withCount([
        'tasks',

        'tasks as completed_tasks_count' =>
            fn ($query) => $query
                ->where('status', 'completed'),
    ])
    ->orderByRaw(
        "
        CASE status
            WHEN 'in_progress' THEN 1
            WHEN 'ongoing' THEN 1
            WHEN 'planning' THEN 2
            WHEN 'on_hold' THEN 3
            WHEN 'completed' THEN 4
            WHEN 'cancelled' THEN 5
            ELSE 6
        END
        "
    )
    ->orderBy('end_date')
    ->orderByDesc('updated_at')
    ->limit(8)
    ->get();

    $recentActivities = collect();

    Client::query()
        ->latest('updated_at')
        ->limit(4)
        ->get([
            'id',
            'company_name',
            'status',
            'created_at',
            'updated_at',
        ])
        ->each(function (
            Client $client
        ) use ($recentActivities): void {
            $recentActivities->push([
                'key' =>
                    'client-'.$client->id,

                'title' =>
                    'Client '.$client->company_name,

                'description' =>
                    'Data Client ditambahkan atau diperbarui.',

                'type' =>
                    'client',

                'occurred_at' =>
                    $client->updated_at,

                'href' =>
                    route(
                        'owner.clients.show',
                        [
                            'client' => $client->id,
                        ]
                    ),
            ]);
        });

    Project::query()
        ->latest('updated_at')
        ->limit(4)
        ->get([
            'id',
            'project_code',
            'project_name',
            'progress',
            'created_at',
            'updated_at',
        ])
        ->each(function (
            Project $project
        ) use ($recentActivities): void {
            $recentActivities->push([
                'key' =>
                    'project-'.$project->id,

                'title' =>
                    $project->project_name,

                'description' =>
                    sprintf(
                        '%s • Progress %d%%',
                        $project->project_code,
                        (int) $project->progress
                    ),

                'type' =>
                    'project',

                'occurred_at' =>
                    $project->updated_at,

                'href' =>
                    route(
                        'owner.monitoring.show',
                        [
                            'project' => $project->id,
                        ]
                    ),
            ]);
        });

    Invoice::query()
        ->latest('updated_at')
        ->limit(4)
        ->get([
            'id',
            'invoice_number',
            'client_name',
            'status',
            'payment_status',
            'created_at',
            'updated_at',
        ])
        ->each(function (
            Invoice $invoice
        ) use ($recentActivities): void {
            $paymentText = match (
                $invoice->payment_status
            ) {
                'paid' =>
                    'Lunas',

                'partial' =>
                    'Dibayar Sebagian',

                default =>
                    'Belum Dibayar',
            };

            $recentActivities->push([
                'key' =>
                    'invoice-'.$invoice->id,

                'title' =>
                    'Invoice '.$invoice->invoice_number,

                'description' =>
                    sprintf(
                        '%s • %s',
                        $invoice->client_name,
                        $paymentText
                    ),

                'type' =>
                    'invoice',

                'occurred_at' =>
                    $invoice->updated_at,

                'href' =>
                    route(
                        'owner.invoices.show',
                        [
                            'invoice' => $invoice->id,
                        ]
                    ),
            ]);
        });

    DeliveryOrder::query()
        ->latest('updated_at')
        ->limit(4)
        ->get([
            'id',
            'delivery_number',
            'receiver_name',
            'status',
            'created_at',
            'updated_at',
        ])
        ->each(function (
            DeliveryOrder $deliveryOrder
        ) use ($recentActivities): void {
            $statusText = match (
                $deliveryOrder->status
            ) {
                'sent' =>
                    'Dikirim',

                'received' =>
                    'Diterima',

                'cancelled' =>
                    'Dibatalkan',

                default =>
                    'Draft',
            };

            $recentActivities->push([
                'key' =>
                    'delivery-order-'.$deliveryOrder->id,

                'title' =>
                    'Surat Jalan '
                    .$deliveryOrder->delivery_number,

                'description' =>
                    sprintf(
                        '%s • %s',
                        $deliveryOrder->receiver_name,
                        $statusText
                    ),

                'type' =>
                    'delivery_order',

                'occurred_at' =>
                    $deliveryOrder->updated_at,

                'href' =>
                    route(
                        'owner.delivery-orders.show',
                        [
                            'deliveryOrder' =>
                                $deliveryOrder->id,
                        ]
                    ),
            ]);
        });

    $recentActivities = $recentActivities
        ->filter(
            fn (array $activity): bool =>
                $activity['occurred_at'] !== null
        )
        ->sortByDesc(
            fn (array $activity): int =>
                $activity['occurred_at']->timestamp
        )
        ->take(6)
        ->values();

        return view(
            'livewire.owner.dashboard',
            [
                'statistics' =>
                    $statistics,

                'summary' =>
                    $summary,

                'chartProjects' =>
                    $chartProjects,

                'recentActivities' =>
                    $recentActivities,

                'pipelineProjects' =>
                    $pipelineProjects,
            ]
        );
    }
}