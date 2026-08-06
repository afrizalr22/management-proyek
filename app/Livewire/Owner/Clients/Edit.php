<?php

namespace App\Livewire\Owner\Clients;

use Livewire\Component;

class Edit extends Component
{
    public string $pageTitle = '';

    public string $pageDescription = '';

    public string $buttonText = '';

    public string $name = '';

    public string $company = '';

    public string $email = '';

    public string $phone = '';

    public string $city = '';

    public string $address = '';

    public string $status = 'Active';

    public function mount($client = null)
    {
        if ($client) {

            $this->pageTitle = 'Edit Client';

            $this->pageDescription = 'Perbarui informasi client yang telah terdaftar di dalam sistem.';

            $this->buttonText = 'Simpan Perubahan';

            // Dummy Data UI
            $this->name = 'Budi Santoso';

            $this->company = 'PT Tekno Konstruksi Utama';

            $this->email = 'budi@tekno.co.id';

            $this->phone = '81234567890';

            $this->city = 'Jakarta';

            $this->address = 'Jl. Jenderal Sudirman No.45, Jakarta Selatan';

            $this->status = 'Active';

        } else {

            $this->pageTitle = 'Tambah Client Baru';

            $this->pageDescription = 'Lengkapi informasi di bawah untuk mendaftarkan client baru.';

            $this->buttonText = 'Tambah Client';

        }
    }

    public function render()
    {
        return view('livewire.owner.clients.edit');
    }
}