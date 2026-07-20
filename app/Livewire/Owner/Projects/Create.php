<?php

namespace App\Livewire\Owner\Projects;

use Livewire\Component;

class Create extends Component
{
    public string $pageTitle = 'Create New Project';
    public string $pageDescription = 'Buat proyek baru dan lengkapi informasi yang diperlukan.';
    public string $buttonText = 'Simpan Project';
    
    public function render()
    {
        return view('livewire.owner.projects.create');
    }
}
