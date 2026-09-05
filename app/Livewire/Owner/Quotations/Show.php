<?php

namespace App\Livewire\Owner\Quotations;

use App\Models\Quotation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Throwable;

class Show extends Component
{
    public Quotation $quotation;

    public ?string $pendingStatusAction = null;

    public bool $showDeleteModal = false;

    public function mount(Quotation $quotation): void
    {
        $this->authorizeViewQuotation();

        $this->quotation = $quotation;

        $this->refreshQuotation();
    }

    public function openStatusConfirmation(string $action): void
    {
        $allowedActions = [
            'send',
            'approve',
            'reject',
        ];

        if (!in_array($action, $allowedActions, true)) {
            $this->addError(
                'statusAction',
                'Aksi quotation tidak valid.'
            );

            return;
        }

        $this->quotation->refresh();

        $allowed = match ($action) {
            'send' =>
                $this->quotation->status === 'draft',

            'approve', 'reject' =>
                $this->quotation->status === 'sent',

            default => false,
        };

        if (!$allowed) {
            $this->addError(
                'statusAction',
                'Aksi tersebut tidak tersedia untuk status quotation saat ini.'
            );

            return;
        }

        $this->resetValidation('statusAction');

        $this->pendingStatusAction = $action;
    }

    public function closeStatusConfirmation(): void
    {
        $this->pendingStatusAction = null;
    }

    public function confirmStatusAction(): void
    {
        $action = $this->pendingStatusAction;

        if (!$action) {
            $this->addError(
                'statusAction',
                'Tidak ada aksi quotation yang dipilih.'
            );

            return;
        }

        $this->pendingStatusAction = null;

        match ($action) {
            'send' => $this->sendQuotation(),
            'approve' => $this->approveQuotation(),
            'reject' => $this->rejectQuotation(),
            default => $this->addError(
                'statusAction',
                'Aksi quotation tidak valid.'
            ),
        };
    }

    public function sendQuotation(): void
    {
        $this->authorizeUpdateQuotation();

        $quotation = $this->findCurrentQuotation();

        if (!$quotation) {
            return;
        }

        if ($quotation->status !== 'draft') {
            $this->addError(
                'statusAction',
                'Hanya quotation berstatus Draft yang dapat dikirim.'
            );

            return;
        }

        if (
            $quotation->valid_until
            && $quotation->valid_until->isBefore(today())
        ) {
            $this->addError(
                'statusAction',
                'Quotation tidak dapat dikirim karena masa berlakunya telah berakhir.'
            );

            return;
        }

        $quotationNumber = $quotation->quotation_number;

        $updated = Quotation::query()
            ->whereKey($quotation->id)
            ->where('status', 'draft')
            ->update([
                'status' => 'sent',
                'sent_at' => now(),
                'approved_at' => null,
                'rejected_at' => null,
            ]);

        if ($updated === 0) {
            $this->addError(
                'statusAction',
                'Status quotation telah berubah. Silakan muat ulang halaman.'
            );

            return;
        }

        $this->refreshQuotation();

        $this->resetValidation('statusAction');

        session()->flash('notification', [
            'type' => 'update',
            'message' => sprintf(
                'Quotation %s ditandai sudah dikirim kepada Client.',
                $quotationNumber
            ),
        ]);
    }

    public function approveQuotation(): void
    {
        $this->authorizeUpdateQuotation();

        $quotation = $this->findCurrentQuotation();

        if (!$quotation) {
            return;
        }

        if ($quotation->status !== 'sent') {
            $this->addError(
                'statusAction',
                'Hanya quotation berstatus Dikirim yang dapat disetujui.'
            );

            return;
        }

        $quotationNumber = $quotation->quotation_number;

        $updated = Quotation::query()
            ->whereKey($quotation->id)
            ->where('status', 'sent')
            ->update([
                'status' => 'approved',
                'approved_at' => now(),
                'rejected_at' => null,
            ]);

        if ($updated === 0) {
            $this->addError(
                'statusAction',
                'Status quotation telah berubah. Silakan muat ulang halaman.'
            );

            return;
        }

        $this->refreshQuotation();

        $this->resetValidation('statusAction');

        session()->flash('notification', [
            'type' => 'success',
            'message' => sprintf(
                'Quotation %s telah disetujui.',
                $quotationNumber
            ),
        ]);
    }

    public function rejectQuotation(): void
    {
        $this->authorizeUpdateQuotation();

        $quotation = $this->findCurrentQuotation();

        if (!$quotation) {
            return;
        }

        if ($quotation->status !== 'sent') {
            $this->addError(
                'statusAction',
                'Hanya quotation berstatus Dikirim yang dapat ditolak.'
            );

            return;
        }

        $quotationNumber = $quotation->quotation_number;

        $updated = Quotation::query()
            ->whereKey($quotation->id)
            ->where('status', 'sent')
            ->update([
                'status' => 'rejected',
                'rejected_at' => now(),
                'approved_at' => null,
            ]);

        if ($updated === 0) {
            $this->addError(
                'statusAction',
                'Status quotation telah berubah. Silakan muat ulang halaman.'
            );

            return;
        }

        $this->refreshQuotation();

        $this->resetValidation('statusAction');

        session()->flash('notification', [
            'type' => 'delete',
            'message' => sprintf(
                'Quotation %s telah ditolak.',
                $quotationNumber
            ),
        ]);
    }

    private function findCurrentQuotation(): ?Quotation
    {
        $quotation = Quotation::query()
            ->find($this->quotation->id);

        if (!$quotation) {
            $this->addError(
                'statusAction',
                'Quotation tidak ditemukan.'
            );

            return null;
        }

        return $quotation;
    }

    private function refreshQuotation(): void
    {
        $this->quotation->refresh();

        $this->quotation->load([
            'client',
            'project',
            'creator',
            'items' => fn ($query) => $query
                ->orderBy('sort_order')
                ->orderBy('id'),
        ]);
    }

    private function authorizeViewQuotation(): void
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User
                && $user->can('view quotations'),
            403
        );
    }

    private function authorizeUpdateQuotation(): void
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User
                && $user->can('update quotations'),
            403
        );
    }

    private function authorizeDeleteQuotation(): void
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User
                && $user->can('delete quotations'),
            403
        );
    }

    public function render()
    {
        $statusText = match ($this->quotation->status) {
            'draft' => 'Draft',
            'sent' => 'Dikirim',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'expired' => 'Kedaluwarsa',
            default => 'Tidak diketahui',
        };

        $statusColor = match ($this->quotation->status) {
            'draft' => 'yellow',
            'sent' => 'blue',
            'approved' => 'green',
            'rejected' => 'red',
            'expired' => 'gray',
            default => 'gray',
        };

        return view('livewire.owner.quotations.show', [
            'statusText' => $statusText,
            'statusColor' => $statusColor,
        ]);
    }

    public function openDeleteModal(): void
{
    $this->authorizeDeleteQuotation();

    $this->quotation->refresh();

    if ($this->quotation->status !== 'draft') {
        $this->addError(
            'statusAction',
            'Hanya quotation berstatus Draft yang dapat dihapus.'
        );

        return;
    }

    if ($this->quotation->project_id !== null) {
        $this->addError(
            'statusAction',
            'Quotation yang sudah terhubung dengan Project tidak dapat dihapus.'
        );

        return;
    }

    $this->resetValidation('deleteQuotation');

    $this->showDeleteModal = true;
    }

    public function closeDeleteModal(): void
    {
        $this->showDeleteModal = false;
    }

    public function deleteQuotation(): void
    {
        $this->authorizeDeleteQuotation();

        $quotationId = $this->quotation->id;
        $quotationNumber = $this->quotation->quotation_number;

        try {
            DB::transaction(function () use (
                $quotationId
            ): void {
                $quotation = Quotation::query()
                    ->lockForUpdate()
                    ->find($quotationId);

                if (!$quotation) {
                    throw new \RuntimeException(
                        'QUOTATION_NOT_FOUND'
                    );
                }

                if ($quotation->status !== 'draft') {
                    throw new \RuntimeException(
                        'QUOTATION_NOT_DRAFT'
                    );
                }

                if ($quotation->project_id !== null) {
                    throw new \RuntimeException(
                        'QUOTATION_HAS_PROJECT'
                    );
                }

                $quotation->items()->delete();

                $quotation->delete();
            });

            $this->showDeleteModal = false;

            session()->flash('notification', [
                'type' => 'delete',
                'message' => sprintf(
                    'Quotation %s berhasil dihapus.',
                    $quotationNumber
                ),
            ]);

            $this->redirectRoute(
                'owner.quotations.index',
                navigate: true
            );
        } catch (Throwable $exception) {
            $this->showDeleteModal = false;

            if (
                $exception->getMessage()
                === 'QUOTATION_NOT_FOUND'
            ) {
                $this->addError(
                    'deleteQuotation',
                    'Quotation tidak ditemukan.'
                );

                return;
            }

            if (
                $exception->getMessage()
                === 'QUOTATION_NOT_DRAFT'
            ) {
                $this->addError(
                    'deleteQuotation',
                    'Quotation tidak dapat dihapus karena statusnya bukan Draft.'
                );

                $this->refreshQuotation();

                return;
            }

            if (
                $exception->getMessage()
                === 'QUOTATION_HAS_PROJECT'
            ) {
                $this->addError(
                    'deleteQuotation',
                    'Quotation sudah terhubung dengan Project dan tidak dapat dihapus.'
                );

                return;
            }

            report($exception);

            $this->addError(
                'deleteQuotation',
                'Quotation gagal dihapus. Silakan coba kembali.'
            );
        }
    }
}