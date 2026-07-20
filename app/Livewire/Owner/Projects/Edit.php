<?php

namespace App\Livewire\Owner\Projects;

use Livewire\Component;

class Edit extends Component
{
    public string $pageTitle = 'Edit Project';

    public string $pageDescription = 'Perbarui informasi proyek yang telah dibuat.';

    public string $buttonText = 'Simpan Perubahan';

    public function render()
    {
        return view('livewire.owner.projects.edit');
    }
}