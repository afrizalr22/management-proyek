<?php

namespace App\Livewire\Owner\Clients;

use Livewire\Component;

class Edit extends Component
{
    public bool $isEdit = false;

    public string $pageTitle = '';

    public string $pageDescription = '';

    public string $buttonText = '';

    public $name = '';

    public $company = '';

    public $email = '';

    public $phone = '';

    public $city = '';

    public $address = '';

    public $status = 'Active';

    public function mount($client = null)
    {
        if ($client) {

            $this->isEdit = true;

            $this->pageTitle = 'Edit Client';

            $this->pageDescription = 'Perbarui informasi client yang telah terdaftar.';

            $this->buttonText = 'Update Client';

            // Dummy Data
            $this->name = 'Budi Santoso';

            $this->company = 'PT Tekno Konstruksi Utama';

            $this->email = 'budi@tekno.co.id';

            $this->phone = '81234567890';

            $this->city = 'Jakarta';

            $this->address = 'Jl. Jenderal Sudirman No.45, Jakarta Selatan';

            $this->status = 'Active';

        } else {

            $this->pageTitle = 'Tambah Client Baru';

            $this->pageDescription = 'Lengkapi informasi di bawah untuk mendaftarkan mitra bisnis baru.';

            $this->buttonText = 'Simpan Data';

        }
    }

    public function render()
    {
        return view('livewire.owner.clients.edit');
    }
}