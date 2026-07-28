<?php

namespace App\Livewire\Owner\Monitoring;

use Livewire\Component;

class Show extends Component
{
    public int $project;

    public function mount(int $project)
    {
        $this->project = $project;
    }

    public function render()
    {
        return view('livewire.owner.monitoring.show');
    }
}