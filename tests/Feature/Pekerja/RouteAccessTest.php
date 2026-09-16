<?php

namespace Tests\Feature\Pekerja;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class RouteAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        app(PermissionRegistrar::class)
            ->forgetCachedPermissions();

        foreach (
            [
                'owner',
                'mandor',
                'pekerja',
            ] as $role
        ) {
            Role::findOrCreate(
                $role,
                'web'
            );
        }
    }

    /**
     * @return array<string, array{string}>
     */
    public static function workerRoutes(): array
    {
        return [
            'dashboard' => [
                'pekerja.dashboard',
            ],

            'tasks' => [
                'pekerja.task.index',
            ],

            'documentation index' => [
                'pekerja.documentation.index',
            ],

            'documentation create' => [
                'pekerja.documentation.create',
            ],

            'report index' => [
                'pekerja.report.index',
            ],

            'report create' => [
                'pekerja.report.create',
            ],

            'profile' => [
                'pekerja.profile.index',
            ],
        ];
    }

    private function createUserWithRole(
        string $role,
        string $status = 'active'
    ): User {
        $user = User::factory()->create([
            'status' => $status,
        ]);

        $user->assignRole($role);

        return $user;
    }

    #[DataProvider('workerRoutes')]
    public function test_guest_is_redirected_from_worker_routes(
        string $routeName
    ): void {
        $response = $this->get(
            route($routeName)
        );

        $response->assertRedirect(
            route('login')
        );
    }

    #[DataProvider('workerRoutes')]
    public function test_owner_cannot_access_worker_routes(
        string $routeName
    ): void {
        $owner = $this->createUserWithRole(
            'owner'
        );

        $response = $this
            ->actingAs($owner)
            ->get(
                route($routeName)
            );

        $response->assertForbidden();
    }

    #[DataProvider('workerRoutes')]
    public function test_mandor_cannot_access_worker_routes(
        string $routeName
    ): void {
        $mandor = $this->createUserWithRole(
            'mandor'
        );

        $response = $this
            ->actingAs($mandor)
            ->get(
                route($routeName)
            );

        $response->assertForbidden();
    }

    #[DataProvider('workerRoutes')]
    public function test_inactive_worker_is_logged_out_and_redirected(
        string $routeName
    ): void {
        $worker = $this->createUserWithRole(
            'pekerja',
            'inactive'
        );

        $response = $this
            ->actingAs($worker)
            ->get(
                route($routeName)
            );

        $response->assertRedirect(
            route('login')
        );

        $this->assertGuest();
    }

    #[DataProvider('workerRoutes')]
    public function test_active_worker_can_access_worker_routes(
        string $routeName
    ): void {
        $worker = $this->createUserWithRole(
            'pekerja'
        );

        $response = $this
            ->actingAs($worker)
            ->get(
                route($routeName)
            );

        $response->assertOk();
    }
}