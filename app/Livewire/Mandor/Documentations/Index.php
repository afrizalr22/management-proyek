<?php

namespace App\Livewire\Mandor\Documentations;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public Project $project;

    public function mount(
        Project $project
    ): void {
        $this->authorizeProject(
            $project
        );

        $this->project = $project;
    }

    private function authorizeProject(
        Project $project
    ): void {
        abort_unless(
            (int) $project->mandor_id
                === (int) Auth::id(),
            403
        );
    }

    public function render()
    {
        return view(
            'livewire.mandor.documentations.index'
        );
    }
}