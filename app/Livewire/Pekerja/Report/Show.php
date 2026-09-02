<?php

namespace App\Livewire\Pekerja\Report;

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
        return view('livewire.pekerja.report.show');
    }
}