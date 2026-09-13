<?php

namespace App\Livewire\Mandor\DailyReports;

use App\Models\DailyReport;
use App\Models\Documentation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Show extends Component
{
    public int $reportId;

    public DailyReport $report;

    public function mount(
        DailyReport $report
    ): void {
        $this->authorizeReport(
            $report
        );

        $this->reportId = $report->id;

        $this->report = $report;
    }

    public function render()
    {
        $report = DailyReport::query()
            ->with([
                'project:id,mandor_id,project_code,project_name,location',

                'task:id,project_id,task_code,title,location,status,progress',

                'user:id,name,email,status',

                'reviewer:id,name',

                'documentations' => fn ($query) =>
                    $query
                        ->with([
                            'user:id,name',
                        ])
                        ->orderBy('taken_at')
                        ->orderBy('id'),
            ])
            ->findOrFail(
                $this->reportId
            );

        $this->authorizeReport(
            $report
        );

        $report->documentations->transform(
            function (
                Documentation $documentation
            ): Documentation {
                $photoExists = filled(
                    $documentation->photo
                ) && Storage::disk('public')
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

        $this->report = $report;

        return view(
            'livewire.mandor.daily-reports.show',
            [
                'report' => $report,
            ]
        );
    }

    private function authorizeReport(
        DailyReport $report
    ): void {
        $isOwnedByMandor = DailyReport::query()
            ->whereKey(
                $report->id
            )
            ->whereIn(
                'status',
                [
                    'submitted',
                    'revision',
                    'approved',
                ]
            )
            ->whereHas(
                'project',
                fn ($query) => $query->where(
                    'mandor_id',
                    Auth::id()
                )
            )
            ->exists();

        abort_unless(
            $isOwnedByMandor,
            403
        );
    }
}