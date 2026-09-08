<?php

namespace App\Livewire\Owner\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\Component;
use RuntimeException;
use Throwable;

class Delete extends Component
{
    public bool $showModal = false;

    public ?int $userId = null;

    public array $blockers = [];

    #[On('open-delete-user-modal')]
    public function openModal(int $id): void
    {
        Gate::authorize('delete users');

        $user = User::query()
            ->with('roles:id,name')
            ->find($id);

        if (!$user) {
            $this->addError(
                'delete',
                'Pengguna tidak ditemukan.'
            );

            return;
        }

        $this->resetValidation();

        $this->userId = $user->id;
        $this->blockers = $this->deletionBlockers($user);
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->userId = null;
        $this->blockers = [];

        $this->resetValidation();
    }

    public function deleteUser(): void
    {
        Gate::authorize('delete users');

        if (!$this->userId) {
            $this->addError(
                'delete',
                'Pengguna tidak ditemukan.'
            );

            return;
        }

        try {
            DB::transaction(function (): void {
                $user = User::query()
                    ->with('roles:id,name')
                    ->lockForUpdate()
                    ->find($this->userId);

                if (!$user) {
                    throw new RuntimeException(
                        'user_not_found'
                    );
                }

                $blockers = $this->deletionBlockers($user);

                if ($blockers !== []) {
                    $this->blockers = $blockers;

                    throw new RuntimeException(
                        'user_has_relations'
                    );
                }

                /*
                 * Bersihkan role dan permission langsung
                 * sebelum menghapus akun.
                 */
                $user->syncRoles([]);
                $user->syncPermissions([]);

                $user->delete();
            });

            $this->showModal = false;
            $this->userId = null;
            $this->blockers = [];

            session()->flash('notification', [
                'type' => 'delete',
                'message' => 'Pengguna berhasil dihapus.',
            ]);

            $this->redirectRoute(
                'owner.users.index',
                navigate: true
            );
        } catch (RuntimeException $exception) {
            $message = match ($exception->getMessage()) {
                'user_not_found' =>
                    'Pengguna tidak ditemukan.',

                'user_has_relations' =>
                    'Pengguna tidak dapat dihapus karena masih memiliki data yang terhubung.',

                default =>
                    'Pengguna gagal dihapus.',
            };

            $this->addError('delete', $message);
        } catch (Throwable $exception) {
            report($exception);

            $this->addError(
                'delete',
                'Pengguna gagal dihapus. Silakan coba kembali.'
            );
        }
    }

    private function deletionBlockers(User $user): array
    {
        $blockers = [];

        if (Auth::id() === $user->id) {
            $blockers[] = [
                'label' => 'Akun sedang digunakan',
                'count' => 1,
                'description' =>
                    'Anda tidak dapat menghapus akun sendiri.',
            ];
        }

        if (
            $user->hasRole('owner')
            && !$this->hasAnotherActiveOwner($user)
        ) {
            $blockers[] = [
                'label' => 'Owner aktif terakhir',
                'count' => 1,
                'description' =>
                    'Sistem harus memiliki minimal satu Owner aktif.',
            ];
        }

        $relations = [
            [
                'label' => 'Project yang dikelola',
                'table' => 'projects',
                'column' => 'mandor_id',
            ],
            [
                'label' => 'Riwayat penugasan pekerja',
                'table' => 'project_workers',
                'column' => 'worker_id',
            ],
            [
                'label' => 'Penugasan yang dibuat',
                'table' => 'project_workers',
                'column' => 'assigned_by',
            ],
            [
                'label' => 'Task sebagai Mandor',
                'table' => 'tasks',
                'column' => 'mandor_id',
            ],
            [
                'label' => 'Task sebagai Pekerja',
                'table' => 'tasks',
                'column' => 'worker_id',
            ],
            [
                'label' => 'Riwayat progres Project',
                'table' => 'project_progress',
                'column' => 'user_id',
            ],
            [
                'label' => 'Laporan harian',
                'table' => 'daily_reports',
                'column' => 'user_id',
            ],
            [
                'label' => 'Laporan yang diperiksa',
                'table' => 'daily_reports',
                'column' => 'reviewed_by',
            ],
            [
                'label' => 'Dokumentasi',
                'table' => 'documentations',
                'column' => 'user_id',
            ],
            [
                'label' => 'Quotation yang dibuat',
                'table' => 'quotations',
                'column' => 'created_by',
            ],
            [
                'label' => 'Invoice yang dibuat',
                'table' => 'invoices',
                'column' => 'created_by',
            ],
            [
                'label' => 'Surat jalan yang dibuat',
                'table' => 'delivery_orders',
                'column' => 'created_by',
            ],
        ];

        foreach ($relations as $relation) {
            $count = DB::table($relation['table'])
                ->where(
                    $relation['column'],
                    $user->id
                )
                ->count();

            if ($count > 0) {
                $blockers[] = [
                    'label' => $relation['label'],
                    'count' => $count,
                    'description' =>
                        'Data ini harus tetap tersimpan sebagai histori.',
                ];
            }
        }

        return $blockers;
    }

    private function hasAnotherActiveOwner(User $user): bool
    {
        return User::query()
            ->role('owner')
            ->where('status', 'active')
            ->whereKeyNot($user->id)
            ->exists();
    }

    public function render()
    {
        $user = null;

        if ($this->userId) {
            $user = User::query()
                ->with('roles:id,name')
                ->find($this->userId);
        }

        return view('livewire.owner.users.delete', [
            'user' => $user,
        ]);
    }
}