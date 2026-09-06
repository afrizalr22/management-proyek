<?php

namespace App\Livewire\Owner\Projects;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Throwable;

class Delete extends Component
{
    public ?Project $project = null;

    public bool $showModal = false;

    #[On('open-delete-project-modal')]
    public function openDeleteModal(int $projectId): void
    {
        $this->authorizeDeleteProject();

        $project = Project::query()
            ->with([
                'client:id,company_name',
                'mandor:id,name',
            ])
            ->withCount([
                'workers',
                'tasks',
                'progresses',
                'dailyReports',
                'documentations',
                'invoices',
                'deliveryOrders',
            ])
            ->find($projectId);

        if (!$project) {
            $this->dispatch(
                'project-delete-failed',
                message: 'Project tidak ditemukan.'
            );

            return;
        }

        $this->project = $project;
        $this->showModal = true;

        $this->resetValidation();
    }

    public function closeModal(): void
    {
        if ($this->isDeleting()) {
            return;
        }

        $this->resetModal();
    }

    public function deleteProject()
    {
        $this->authorizeDeleteProject();

        if (!$this->project) {
            $this->addError(
                'delete',
                'Project tidak ditemukan.'
            );

            return;
        }

        try {
            $projectCode = $this->project->project_code;

            DB::transaction(function (): void {
                $project = Project::query()
                    ->lockForUpdate()
                    ->find($this->project->id);

                if (!$project) {
                    throw new \RuntimeException(
                        'project_not_found'
                    );
                }

                if ($project->status !== 'planning') {
                    throw new \RuntimeException(
                        'project_not_planning'
                    );
                }

                $relations = [
                    'workers' => 'pekerja',
                    'tasks' => 'tugas',
                    'progresses' => 'riwayat progres',
                    'dailyReports' => 'laporan harian',
                    'documentations' => 'dokumentasi',
                    'invoices' => 'invoice',
                    'deliveryOrders' => 'surat jalan',
                ];

                foreach ($relations as $relation => $label) {
                    if ($project->{$relation}()->exists()) {
                        throw new \RuntimeException(
                            'project_has_'.$relation.':'.$label
                        );
                    }
                }

                /*
                 * Quotation tidak dihapus. Hubungannya dilepas agar
                 * quotation dapat digunakan kembali untuk membuat Project.
                 */
                $project->quotations()->update([
                    'project_id' => null,
                ]);

                $project->delete();
            });

            $this->resetModal();

            session()->flash('notification', [
                'type' => 'delete',
                'message' => sprintf(
                    'Project %s berhasil dihapus.',
                    $projectCode
                ),
            ]);

            return $this->redirectRoute(
                'owner.projects.index'
            );
        } catch (\RuntimeException $exception) {
            $message = match (true) {
                $exception->getMessage()
                    === 'project_not_found' =>
                    'Project tidak ditemukan.',

                $exception->getMessage()
                    === 'project_not_planning' =>
                    'Hanya Project berstatus Perencanaan yang dapat dihapus.',

                str_starts_with(
                    $exception->getMessage(),
                    'project_has_'
                ) =>
                    'Project tidak dapat dihapus karena sudah mempunyai '.
                    (
                        explode(
                            ':',
                            $exception->getMessage(),
                            2
                        )[1] ?? 'data operasional'
                    ).'.',

                default =>
                    'Project gagal dihapus.',
            };

            $this->addError('delete', $message);
        } catch (Throwable $exception) {
            report($exception);

            $this->addError(
                'delete',
                'Project gagal dihapus. Silakan coba kembali.'
            );
        }
    }

    private function resetModal(): void
    {
        $this->project = null;
        $this->showModal = false;

        $this->resetValidation();
    }

    private function authorizeDeleteProject(): void
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User
                && $user->can('delete projects'),
            403
        );
    }

    private function isDeleting(): bool
    {
        return false;
    }

    public function render()
    {
        return view('livewire.owner.projects.delete');
    }
}