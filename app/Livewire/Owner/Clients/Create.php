<?php

namespace App\Livewire\Owner\Clients;

use Livewire\Component;

class Create extends Component
{
    public bool $isEdit = false;

    public string $pageTitle = 'New Client';

    public string $pageDescription = '';

    public string $buttonText = '';

    public $name = '';

    public $company = '';

    public $email = '';

    public $phone = '';

    public $city = '';

    public $address = '';

    public $status = 'Active';

    public function render()
    {
        return view('livewire.owner.clients.create');
    }
}
