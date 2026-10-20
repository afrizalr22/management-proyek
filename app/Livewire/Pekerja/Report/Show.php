<?php

namespace App\Livewire\Pekerja\Report;

use App\Models\DailyReport;
use App\Models\Documentation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;

class Show extends Component
{
    public int $reportId;

    public function mount(
        int $report
    ): void {
        $this->authenticatedWorker();

        $this->reportId = $report;

        $this->findReport();
    }

    public function render()
    {
        $report = $this->findReport();

        $report->documentations->transform(
            function (
                Documentation $documentation
            ): Documentation {
                $photoExists =
                    filled($documentation->photo)
                    && Storage::disk('public')
                        ->exists(
                            $documentation->photo
                        );

                $documentation->setAttribute(
                    'photo_exists',
                    $photoExists
                );

                $documentation->setAttribute(
                    'photo_url',
                    $photoExists
                        ? asset(
                            'storage/'
                            . ltrim(
                                $documentation->photo,
                                '/'
                            )
                        )
                        : null
                );

                return $documentation;
            }
        );

        return view(
            'livewire.pekerja.report.show',
            [
                'report' => $report,
            ]
        );
    }

    private function findReport(): DailyReport
    {
        $workerId = $this->authenticatedWorker()->id;

        return DailyReport::query()
            ->where(function (Builder $query) use ($workerId): void {
                $query
                    ->where('user_id', $workerId)
                    ->orWhereHas(
                        'task.workers',
                        fn (Builder $workerQuery) => $workerQuery
                            ->where('users.id', $workerId)
                    );
            })
            ->with([
                'project:id,mandor_id,project_code,project_name,location',
                'project.mandor:id,name',
                'task:id,project_id,task_code,title,description,location,status,progress',
                'user:id,name,email,status',
                'reviewer:id,name',
                'documentations' => fn ($query) => $query
                    ->orderBy('taken_at')
                    ->orderBy('id'),
            ])
            ->findOrFail($this->reportId);
    }

    private function authenticatedWorker(): User
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User
                && $user->hasRole('pekerja')
                && $user->isActive(),
            403
        );

        return $user;
    }
}