<?php

namespace App\Livewire\Owner\Clients;

use App\Models\Client;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{
    public string $pageTitle = 'Tambah Client Baru';

    public string $pageDescription =
        'Lengkapi informasi di bawah untuk mendaftarkan Client baru.';

    public string $name = '';

    public string $company = '';

    public string $email = '';

    public string $phone = '';

    public string $city = '';

    public string $address = '';

    public string $status = 'active';

    public function mount(): void
    {
        abort_unless(
            auth()->user()?->can('create clients'),
            403
        );
    }

    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],

            'company' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('clients', 'email'),
            ],

            'phone' => [
                'nullable',
                'regex:/^[0-9]{8,15}$/',
            ],

            'city' => [
                'required',
                'string',
                'max:100',
            ],

            'status' => [
                'required',
                Rule::in([
                    'active',
                    'lead',
                    'inactive',
                ]),
            ],

            'address' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Nama lengkap Client wajib diisi.',
            'name.min' => 'Nama lengkap Client minimal 3 karakter.',
            'name.max' => 'Nama lengkap Client maksimal 255 karakter.',

            'company.required' => 'Nama perusahaan wajib diisi.',
            'company.min' => 'Nama perusahaan minimal 3 karakter.',
            'company.max' => 'Nama perusahaan maksimal 255 karakter.',

            'email.required' => 'Email bisnis wajib diisi.',
            'email.email' => 'Format email bisnis tidak valid.',
            'email.unique' => 'Email tersebut sudah digunakan Client lain.',
            'email.max' => 'Email maksimal 255 karakter.',

            'phone.regex' =>
                'Nomor telepon harus terdiri dari 8 sampai 15 angka.',

            'city.required' => 'Kota wajib dipilih.',
            'city.max' => 'Nama kota maksimal 100 karakter.',

            'status.required' => 'Status Client wajib dipilih.',
            'status.in' => 'Status Client tidak valid.',

            'address.max' => 'Alamat maksimal 2.000 karakter.',
        ];
    }

    public function save(): void
    {
        abort_unless(
            auth()->user()?->can('create clients'),
            403
        );

        $this->normalizePhone();

        $data = $this->validate();

        Client::create([
            'company_name' => trim($data['company']),
            'contact_person' => trim($data['name']),
            'email' => strtolower(trim($data['email'])),
            'phone' => $data['phone'] !== ''
                ? '+62'.$data['phone']
                : null,
            'city' => $data['city'],
            'status' => $data['status'],
            'address' => filled($data['address'])
                ? trim($data['address'])
                : null,
            'notes' => null,
        ]);

        session()->flash(
            'success',
            'Client baru berhasil ditambahkan.'
        );

        $this->redirectRoute(
            'owner.clients.index',
            navigate: true
        );
    }

    private function normalizePhone(): void
    {
        $phone = preg_replace('/[^0-9]/', '', $this->phone);

        if (str_starts_with($phone, '62')) {
            $phone = substr($phone, 2);
        }

        if (str_starts_with($phone, '0')) {
            $phone = substr($phone, 1);
        }

        $this->phone = $phone;
    }

    public function render()
    {
        return view('livewire.owner.clients.create');
    }
}