<?php

namespace App\Livewire\Owner\Projects;

use Livewire\Component;

class Delete extends Component
{
    public string $pageTitle = 'Delete Project';

    public string $pageDescription = 'Hapus project dari sistem secara permanen.';

    public function render()
    {
        return view('livewire.owner.projects.delete');
    }
}