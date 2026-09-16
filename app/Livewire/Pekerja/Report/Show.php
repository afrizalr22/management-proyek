<?php

namespace App\Livewire\Pekerja\Report;

use App\Models\DailyReport;
use App\Models\Documentation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

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
        return DailyReport::query()
            ->where(
                'user_id',
                Auth::id()
            )
            ->with([
                'project:id,mandor_id,project_code,project_name,location',
                'project.mandor:id,name',
                'task:id,project_id,task_code,title,description,location,status,progress',
                'user:id,name,email,status',
                'reviewer:id,name',
                'documentations' => fn ($query) =>
                    $query
                        ->where(
                            'user_id',
                            Auth::id()
                        )
                        ->orderBy('taken_at')
                        ->orderBy('id'),
            ])
            ->findOrFail(
                $this->reportId
            );
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