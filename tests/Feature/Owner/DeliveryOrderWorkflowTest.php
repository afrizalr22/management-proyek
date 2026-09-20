<?php

namespace Tests\Feature\Owner;

use App\Livewire\Owner\DeliveryOrders\Create;
use App\Livewire\Owner\DeliveryOrders\Delete;
use App\Livewire\Owner\DeliveryOrders\Edit;
use App\Livewire\Owner\DeliveryOrders\Show;
use App\Models\Client;
use App\Models\DeliveryOrder;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class DeliveryOrderWorkflowTest extends TestCase
{
    use RefreshDatabase;

    private User $owner;

    private User $mandor;

    private Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(
            '2026-09-20 10:00:00'
        );

        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

        $permissions = collect([
            'view-any delivery orders',
            'view delivery orders',
            'create delivery orders',
            'update delivery orders',
            'delete delivery orders',
        ])->map(
            fn (string $permission): Permission => Permission::findOrCreate(
                $permission,
                'web'
            )
        );

        $ownerRole = Role::findOrCreate(
            'owner',
            'web'
        );

        $ownerRole->syncPermissions(
            $permissions
        );

        $this->owner = User::factory()->create([
            'name' => 'Owner Surat Jalan',
            'status' => 'active',
        ]);

        $this->owner->assignRole(
            $ownerRole
        );

        $this->mandor = User::factory()->create([
            'name' => 'Mandor Penerima',
            'phone' => '081234567890',
            'status' => 'active',
        ]);

        $this->client = Client::query()->create([
            'company_name' => 'PT Pengiriman Material',
            'contact_person' => 'Budi Logistik',
            'phone' => '0215551234',
            'email' => 'logistik@example.com',
            'city' => 'Jakarta Selatan',
            'status' => 'active',
            'address' => 'Jl. Pengiriman No. 10',
            'notes' => 'Client pengujian Surat Jalan.',
        ]);
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_owner_can_open_delivery_order_create_page(): void
    {
        $project = $this->createProject(
            'planning',
            1
        );

        $this->actingAs($this->owner)
            ->get(
                route(
                    'owner.delivery-orders.create'
                )
            )
            ->assertOk()
            ->assertSee('Buat Surat Jalan')
            ->assertSee($project->project_code)
            ->assertSee($project->project_name);
    }

    public function test_delivery_order_can_be_created_from_planning_project(): void
    {
        $project = $this->createProject(
            'planning',
            1
        );

        Livewire::actingAs($this->owner)
            ->test(Create::class)
            ->set(
                'projectId',
                $project->id
            )
            ->assertSet(
                'destination',
                $project->location
            )
            ->assertSet(
                'receiverName',
                $this->mandor->name
            )
            ->assertSet(
                'receiverPhone',
                $this->mandor->phone
            )
            ->set(
                'deliveryDate',
                '2026-09-21'
            )
            ->set('items', [
                [
                    'item_name' => 'Semen Portland',
                    'description' => 'Semen untuk pekerjaan struktur.',
                    'qty' => 20,
                    'unit' => 'sak',
                    'condition' => 'good',
                ],
                [
                    'item_name' => 'Keramik Lantai',
                    'description' => null,
                    'qty' => 10.5,
                    'unit' => 'dus',
                    'condition' => 'good',
                ],
            ])
            ->set(
                'notes',
                'Pengiriman tahap pertama.'
            )
            ->call('createDeliveryOrder')
            ->assertHasNoErrors()
            ->assertRedirect(
                route(
                    'owner.delivery-orders.index'
                )
            );

        $deliveryOrder = DeliveryOrder::query()
            ->where(
                'project_id',
                $project->id
            )
            ->sole();

        $this->assertSame(
            'SJ-2026-0001',
            $deliveryOrder->delivery_number
        );

        $this->assertSame(
            'draft',
            $deliveryOrder->status
        );

        $this->assertSame(
            $this->owner->id,
            $deliveryOrder->created_by
        );

        $this->assertSame(
            $project->location,
            $deliveryOrder->destination
        );

        $this->assertSame(
            $this->mandor->name,
            $deliveryOrder->receiver_name
        );

        $this->assertSame(
            2,
            $deliveryOrder->items()->count()
        );

        $this->assertDatabaseHas(
            'delivery_order_items',
            [
                'delivery_order_id' => $deliveryOrder->id,

                'item_name' => 'Semen Portland',

                'qty' => 20,

                'unit' => 'sak',

                'condition' => 'good',

                'sort_order' => 1,
            ]
        );
    }

    public function test_on_progress_project_can_have_multiple_delivery_orders(): void
    {
        $project = $this->createProject(
            'on_progress',
            1
        );

        foreach (
            [
                'Material Tahap Pertama',
                'Material Tahap Kedua',
            ] as $itemName
        ) {
            Livewire::actingAs($this->owner)
                ->test(Create::class)
                ->set(
                    'projectId',
                    $project->id
                )
                ->set(
                    'deliveryDate',
                    '2026-09-21'
                )
                ->set('items', [
                    [
                        'item_name' => $itemName,
                        'description' => null,
                        'qty' => 5,
                        'unit' => 'unit',
                        'condition' => 'good',
                    ],
                ])
                ->call('createDeliveryOrder')
                ->assertHasNoErrors();
        }

        $orders = DeliveryOrder::query()
            ->where(
                'project_id',
                $project->id
            )
            ->orderBy('id')
            ->get();

        $this->assertCount(
            2,
            $orders
        );

        $this->assertSame(
            'SJ-2026-0001',
            $orders[0]->delivery_number
        );

        $this->assertSame(
            'SJ-2026-0002',
            $orders[1]->delivery_number
        );
    }

    public function test_draft_completed_and_cancelled_projects_cannot_create_delivery_order(): void
    {
        foreach (
            [
                'draft',
                'completed',
                'cancelled',
            ] as $index => $status
        ) {
            $project = $this->createProject(
                $status,
                $index + 1
            );

            Livewire::actingAs($this->owner)
                ->test(Create::class)
                ->set(
                    'projectId',
                    $project->id
                )
                ->set(
                    'deliveryDate',
                    '2026-09-21'
                )
                ->set(
                    'destination',
                    'Jakarta Selatan'
                )
                ->set(
                    'receiverName',
                    'Penerima Material'
                )
                ->set('items', [
                    [
                        'item_name' => 'Material Uji',
                        'description' => null,
                        'qty' => 1,
                        'unit' => 'unit',
                        'condition' => 'good',
                    ],
                ])
                ->call('createDeliveryOrder')
                ->assertHasErrors([
                    'projectId',
                ]);
        }

        $this->assertSame(
            0,
            DeliveryOrder::query()->count()
        );
    }

    public function test_create_form_limits_items_to_one_hundred(): void
    {
        $items = array_fill(
            0,
            100,
            [
                'item_name' => 'Material',
                'description' => null,
                'qty' => 1,
                'unit' => 'unit',
                'condition' => 'good',
            ]
        );

        Livewire::actingAs($this->owner)
            ->test(Create::class)
            ->set('items', $items)
            ->call('addItem')
            ->assertCount(
                'items',
                100
            )
            ->assertHasErrors([
                'items',
            ]);
    }

    public function test_draft_delivery_order_and_items_can_be_updated(): void
    {
        $project = $this->createProject(
            'planning',
            1
        );

        $deliveryOrder = $this->createDeliveryOrder(
            $project
        );

        Livewire::actingAs($this->owner)
            ->test(
                Edit::class,
                [
                    'deliveryOrder' => $deliveryOrder,
                ]
            )
            ->set(
                'deliveryDate',
                '2026-09-22'
            )
            ->set(
                'destination',
                'Gudang Project Baru'
            )
            ->set(
                'receiverName',
                'Penerima Baru'
            )
            ->set(
                'receiverPhone',
                '081299999999'
            )
            ->set(
                'notes',
                'Data pengiriman diperbarui.'
            )
            ->set('items', [
                [
                    'item_name' => 'Besi Beton',
                    'description' => 'Besi beton ukuran 10 mm.',
                    'qty' => 15,
                    'unit' => 'batang',
                    'condition' => 'good',
                ],
            ])
            ->call('updateDeliveryOrder')
            ->assertHasNoErrors()
            ->assertRedirect(
                route(
                    'owner.delivery-orders.show',
                    $deliveryOrder
                )
            );

        $deliveryOrder->refresh();

        $this->assertSame(
            '2026-09-22',
            $deliveryOrder->delivery_date
                ->format('Y-m-d')
        );

        $this->assertSame(
            'Gudang Project Baru',
            $deliveryOrder->destination
        );

        $this->assertSame(
            'Penerima Baru',
            $deliveryOrder->receiver_name
        );

        $this->assertSame(
            1,
            $deliveryOrder->items()->count()
        );

        $this->assertDatabaseHas(
            'delivery_order_items',
            [
                'delivery_order_id' => $deliveryOrder->id,

                'item_name' => 'Besi Beton',

                'qty' => 15,

                'unit' => 'batang',
            ]
        );

        $this->assertDatabaseMissing(
            'delivery_order_items',
            [
                'delivery_order_id' => $deliveryOrder->id,

                'item_name' => 'Semen Portland',
            ]
        );
    }

    public function test_non_draft_delivery_order_cannot_open_edit_page(): void
    {
        $project = $this->createProject(
            'on_progress',
            1
        );

        foreach (
            [
                'sent',
                'received',
                'cancelled',
            ] as $index => $status
        ) {
            $deliveryOrder =
                $this->createDeliveryOrder(
                    $project,
                    $status,
                    $index + 1
                );

            $this->actingAs($this->owner)
                ->get(
                    route(
                        'owner.delivery-orders.edit',
                        $deliveryOrder
                    )
                )
                ->assertForbidden();
        }
    }

    public function test_draft_delivery_order_can_be_marked_as_sent(): void
    {
        $project = $this->createProject(
            'planning',
            1
        );

        $deliveryOrder =
            $this->createDeliveryOrder(
                $project
            );

        Livewire::actingAs($this->owner)
            ->test(
                Show::class,
                [
                    'deliveryOrder' => $deliveryOrder,
                ]
            )
            ->call('markAsSent')
            ->assertHasNoErrors()
            ->assertRedirect(
                route(
                    'owner.delivery-orders.show',
                    $deliveryOrder
                )
            );

        $deliveryOrder->refresh();

        $this->assertSame(
            'sent',
            $deliveryOrder->status
        );

        $this->assertNotNull(
            $deliveryOrder->sent_at
        );

        $this->assertNull(
            $deliveryOrder->received_at
        );
    }

    public function test_delivery_order_without_items_cannot_be_sent(): void
    {
        $project = $this->createProject(
            'planning',
            1
        );

        $deliveryOrder =
            $this->createDeliveryOrder(
                $project,
                createItem: false
            );

        Livewire::actingAs($this->owner)
            ->test(
                Show::class,
                [
                    'deliveryOrder' => $deliveryOrder,
                ]
            )
            ->call('markAsSent')
            ->assertHasErrors([
                'statusAction',
            ]);

        $this->assertSame(
            'draft',
            $deliveryOrder
                ->fresh()
                ->status
        );
    }

    public function test_sent_delivery_order_can_be_marked_as_received(): void
    {
        $project = $this->createProject(
            'on_progress',
            1
        );

        $deliveryOrder =
            $this->createDeliveryOrder(
                $project,
                'sent'
            );

        Livewire::actingAs($this->owner)
            ->test(
                Show::class,
                [
                    'deliveryOrder' => $deliveryOrder,
                ]
            )
            ->call('markAsReceived')
            ->assertHasNoErrors();

        $deliveryOrder->refresh();

        $this->assertSame(
            'received',
            $deliveryOrder->status
        );

        $this->assertNotNull(
            $deliveryOrder->sent_at
        );

        $this->assertNotNull(
            $deliveryOrder->received_at
        );
    }

    public function test_draft_and_sent_delivery_orders_can_be_cancelled(): void
    {
        $project = $this->createProject(
            'on_progress',
            1
        );

        foreach (
            [
                'draft',
                'sent',
            ] as $index => $status
        ) {
            $deliveryOrder =
                $this->createDeliveryOrder(
                    $project,
                    $status,
                    $index + 1
                );

            Livewire::actingAs($this->owner)
                ->test(
                    Show::class,
                    [
                        'deliveryOrder' => $deliveryOrder,
                    ]
                )
                ->call('cancelDeliveryOrder')
                ->assertHasNoErrors();

            $this->assertSame(
                'cancelled',
                $deliveryOrder
                    ->fresh()
                    ->status
            );
        }
    }

    public function test_received_delivery_order_cannot_be_cancelled(): void
    {
        $project = $this->createProject(
            'on_progress',
            1
        );

        $deliveryOrder =
            $this->createDeliveryOrder(
                $project,
                'received'
            );

        Livewire::actingAs($this->owner)
            ->test(
                Show::class,
                [
                    'deliveryOrder' => $deliveryOrder,
                ]
            )
            ->call('cancelDeliveryOrder')
            ->assertHasErrors([
                'statusAction',
            ]);

        $this->assertSame(
            'received',
            $deliveryOrder
                ->fresh()
                ->status
        );
    }

    public function test_only_draft_delivery_order_can_be_deleted(): void
    {
        $project = $this->createProject(
            'planning',
            1
        );

        $draft = $this->createDeliveryOrder(
            $project
        );

        Livewire::actingAs($this->owner)
            ->test(Delete::class)
            ->call(
                'openModal',
                $draft->id
            )
            ->call('deleteDeliveryOrder')
            ->assertHasNoErrors()
            ->assertRedirect(
                route(
                    'owner.delivery-orders.index'
                )
            );

        $this->assertModelMissing(
            $draft
        );

        $this->assertDatabaseMissing(
            'delivery_order_items',
            [
                'delivery_order_id' => $draft->id,
            ]
        );

        $sent = $this->createDeliveryOrder(
            $project,
            'sent',
            2
        );

        Livewire::actingAs($this->owner)
            ->test(Delete::class)
            ->call(
                'openModal',
                $sent->id
            )
            ->assertHasErrors([
                'delete',
            ])
            ->call('deleteDeliveryOrder')
            ->assertHasErrors([
                'delete',
            ]);

        $this->assertModelExists(
            $sent
        );
    }

    public function test_user_without_permission_cannot_run_delivery_order_actions(): void
    {
        $project = $this->createProject(
            'planning',
            1
        );

        $deliveryOrder =
            $this->createDeliveryOrder(
                $project
            );

        $user = User::factory()->create([
            'status' => 'active',
        ]);

        Livewire::actingAs($user)
            ->test(
                Show::class,
                [
                    'deliveryOrder' => $deliveryOrder,
                ]
            )
            ->assertForbidden();

        Livewire::actingAs($user)
            ->test(Create::class)
            ->assertForbidden();
    }

    private function createProject(
        string $status,
        int $sequence
    ): Project {
        return Project::query()->create([
            'client_id' => $this->client->id,

            'mandor_id' => $this->mandor->id,

            'project_code' => sprintf(
                'PRJ-SJ-2026-%04d',
                $sequence
            ),

            'project_name' => 'Project Pengiriman '.$sequence,

            'location' => 'Jl. Lokasi Project No. '.$sequence,

            'description' => 'Project pengujian Surat Jalan.',

            'contract_number' => 'SPK-SJ/'.$sequence.'/IX/2026',

            'contract_date' => '2026-09-18',

            'project_budget' => 50000000,

            'contract_value' => 60000000,

            'start_date' => '2026-09-20',

            'end_date' => '2026-12-20',

            'progress' => match ($status) {
                'on_progress' => 50,
                'completed' => 100,
                default => 0,
            },

            'status' => $status,
        ]);
    }

    private function createDeliveryOrder(
        Project $project,
        string $status = 'draft',
        int $sequence = 1,
        bool $createItem = true
    ): DeliveryOrder {
        $deliveryOrder =
            DeliveryOrder::query()->create([
                'project_id' => $project->id,

                'created_by' => $this->owner->id,

                'delivery_number' => sprintf(
                    'SJ-2026-9%03d',
                    $sequence
                ),

                'delivery_date' => '2026-09-20',

                'destination' => $project->location,

                'receiver_name' => $this->mandor->name,

                'receiver_phone' => $this->mandor->phone,

                'status' => $status,

                'sent_at' => in_array(
                    $status,
                    [
                        'sent',
                        'received',
                    ],
                    true
                )
                        ? now()->subHour()
                        : null,

                'received_at' => $status === 'received'
                        ? now()
                        : null,

                'notes' => null,
            ]);

        if ($createItem) {
            $deliveryOrder->items()->create([
                'item_name' => 'Semen Portland',

                'description' => 'Material pengujian Surat Jalan.',

                'qty' => 10,

                'unit' => 'sak',

                'condition' => 'good',

                'sort_order' => 1,
            ]);
        }

        return $deliveryOrder->fresh([
            'items',
        ]);
    }
}
