<?php

namespace App\Livewire\Mandor\DailyReports;

use App\Models\DailyReport;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public int $reportId;

    public function mount(
        DailyReport $report
    ): void {
        $this->authorizeReport(
            $report
        );

        $this->reportId = $report->id;
    }

    private function authorizeReport(
        DailyReport $report
    ): void {
        $isOwnedByMandor = DailyReport::query()
            ->whereKey($report->id)
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

    public function render()
    {
        return view(
            'livewire.mandor.daily-reports.show'
        );
    }
}