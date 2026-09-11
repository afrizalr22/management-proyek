<?php

namespace App\Livewire\Owner\Clients;

use App\Models\Client;
use Illuminate\Validation\Rule;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        $this->authorizeCreateClient();
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
                'required',
                'string',
                'min:9',
                'max:20',
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

            'city.required' => 'Kota wajib diisi.',
            'city.max' => 'Nama kota maksimal 100 karakter.',

            'status.required' => 'Status Client wajib dipilih.',
            'status.in' => 'Status Client tidak valid.',

            'address.max' => 'Alamat maksimal 2.000 karakter.',
        ];
    }

   public function save(): void
{
    $user = Auth::user();

    abort_unless(
        $user instanceof User && $user->can('create clients'),
        403
    );

    $validated = $this->validate();

    Client::create([
        'company_name' => trim($validated['company']),
        'contact_person' => trim($validated['name']),
        'phone' => $this->normalizePhone($validated['phone']),
        'email' => strtolower(trim($validated['email'])),
        'city' => trim($validated['city']),
        'status' => $validated['status'],
        'address' => trim($validated['address']),
    ]);

    session()->flash('notification', [
        'type' => 'create',
        'message' => 'Client berhasil ditambahkan.',
    ]);

    $this->redirectRoute(
        'owner.clients.index',
        navigate: true
    );
}

private function normalizePhone(string $phone): string
{
    $phone = preg_replace('/[^0-9]/', '', trim($phone)) ?? '';

    if (str_starts_with($phone, '62')) {
        $phone = substr($phone, 2);
    }

    if (str_starts_with($phone, '0')) {
        $phone = substr($phone, 1);
    }

    return '+62' . $phone;
}

    public function render()
    {
        return view('livewire.owner.clients.create');
    }

    private function authorizeCreateClient(): void
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User
                && $user->can('create clients'),
            403
        );
    }
}