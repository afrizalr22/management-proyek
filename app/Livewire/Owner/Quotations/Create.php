<?php

namespace App\Livewire\Owner\Quotations;

use Livewire\Component;

class Create extends Component
{
    public string $pageTitle = 'Create Quotation';
    public string $pageDescription = 'Buat quotation baru untuk project yang dipilih.';
    public string $buttonText = 'Simpan Quotation';
    public function render()
    {
        return view('livewire.owner.quotations.create');
    }
}
