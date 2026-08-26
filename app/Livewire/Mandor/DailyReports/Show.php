<?php

namespace App\Livewire\Mandor\DailyReports;

use Livewire\Component;

class Show extends Component
{
    public int $reportId;

    public function mount(int $report): void
    {
        $this->reportId = $report;
    }

    public function render()
    {
        return view('livewire.mandor.daily-reports.show');
    }
}