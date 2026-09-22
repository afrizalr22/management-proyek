<?php

namespace App\Livewire\Owner\Projects;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use RuntimeException;
use Throwable;

class Cancel extends Component
{
    public Project $project;

    public string $cancellationReason = '';

    public function mount(
        Project $project
    ): void {
        $this->authorizeCancelProject();

        abort_unless(
            in_array(
                $project->status,
                [
                    'planning',
                    'on_progress',
                ],
                true
            ),
            409,
            'Project yang telah selesai atau dibatalkan tidak dapat dibatalkan.'
        );

        $this->project = $project;
    }

    public function cancelProject()
    {
        $this->authorizeCancelProject();

        $this->validate(
            [
                'cancellationReason' => [
                    'required',
                    'string',
                    'min:10',
                    'max:2000',
                ],
            ],
            [
                'cancellationReason.required' => 'Alasan pembatalan wajib diisi.',

                'cancellationReason.min' => 'Alasan pembatalan minimal 10 karakter.',

                'cancellationReason.max' => 'Alasan pembatalan maksimal 2.000 karakter.',
            ]
        );

        try {
            DB::transaction(
                function (): void {
                    $project = Project::query()
                        ->lockForUpdate()
                        ->findOrFail(
                            $this->project->id
                        );

                    if (
                        ! in_array(
                            $project->status,
                            [
                                'planning',
                                'on_progress',
                            ],
                            true
                        )
                    ) {
                        throw new RuntimeException(
                            'project_cannot_be_cancelled'
                        );
                    }

                    /*
                     * Semua Task yang belum berada pada status
                     * terminal dibatalkan.
                     */
                    $project
                        ->tasks()
                        ->whereNotIn(
                            'status',
                            [
                                'completed',
                                'cancelled',
                            ]
                        )
                        ->update([
                            'status' => 'cancelled',
                        ]);

                    /*
                     * Assignment Pekerja yang masih aktif
                     * diakhiri ketika Project dibatalkan.
                     */
                    $project
                        ->workerAssignments()
                        ->where(
                            'status',
                            'active'
                        )
                        ->update([
                            'status' => 'inactive',
                            'ended_at' => now()
                                ->toDateString(),
                        ]);

                    /*
                     * Progress terakhir tetap dipertahankan.
                     * Data historis Project juga tidak dihapus.
                     */
                    $project->update([
                        'status' => 'cancelled',
                        'cancelled_at' => now(),
                        'cancelled_by' => Auth::id(),
                        'cancellation_reason' => trim(
                            $this->cancellationReason
                        ),
                    ]);
                }
            );

            session()->flash(
                'notification',
                [
                    'type' => 'delete',
                    'message' => sprintf(
                        'Project %s berhasil dibatalkan.',
                        $this->project->project_code
                    ),
                ]
            );

            return $this->redirectRoute(
                'owner.projects.show',
                [
                    'project' => $this->project->id,
                ],
                navigate: true
            );
        } catch (RuntimeException $exception) {
            if (
                $exception->getMessage()
                === 'project_cannot_be_cancelled'
            ) {
                $this->addError(
                    'cancel',
                    'Project yang telah selesai atau dibatalkan tidak dapat dibatalkan.'
                );

                return;
            }

            throw $exception;
        } catch (Throwable $exception) {
            report($exception);

            $this->addError(
                'cancel',
                'Project gagal dibatalkan. Silakan coba kembali.'
            );
        }
    }

    private function authorizeCancelProject(): void
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User
                && $user->can(
                    'cancel projects'
                ),
            403
        );
    }

    public function render()
    {
        return view(
            'livewire.owner.projects.cancel'
        );
    }
}
