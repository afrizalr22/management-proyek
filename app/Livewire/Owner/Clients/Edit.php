<?php

namespace App\Livewire\Owner\Clients;

use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    public Client $client;

    public string $name = '';

    public string $company = '';

    public string $email = '';

    public string $phone = '';

    public string $city = '';

    public string $address = '';

    public string $status = 'active';

    public function mount(Client $client): void
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User && $user->can('update clients'),
            403
        );

        $this->client = $client;

        $this->name = $client->contact_person ?? '';
        $this->company = $client->company_name ?? '';
        $this->email = $client->email ?? '';
        $this->phone = $this->formatPhoneForForm($client->phone);
        $this->city = $client->city ?? '';
        $this->address = $client->address ?? '';
        $this->status = $client->status ?? 'active';
    }

    protected function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
            'company' => [
                'required',
                'string',
                'min:3',
                'max:150',
            ],
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('clients', 'email')
                    ->ignore($this->client->id),
            ],
            'phone' => [
                'required',
                'string',
                'min:9',
                'max:20',
                'regex:/^[0-9+\-\s()]+$/',
            ],
            'city' => [
                'required',
                'string',
                'max:100',
            ],
            'address' => [
                'required',
                'string',
                'min:10',
                'max:500',
            ],
            'status' => [
                'required',
                Rule::in(['active', 'inactive']),
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Nama kontak wajib diisi.',
            'name.min' => 'Nama kontak minimal 3 karakter.',
            'name.max' => 'Nama kontak maksimal 100 karakter.',

            'company.required' => 'Nama perusahaan wajib diisi.',
            'company.min' => 'Nama perusahaan minimal 3 karakter.',
            'company.max' => 'Nama perusahaan maksimal 150 karakter.',

            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email telah digunakan client lain.',

            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.min' => 'Nomor telepon minimal 9 karakter.',
            'phone.regex' => 'Format nomor telepon tidak valid.',

            'city.required' => 'Kota wajib diisi.',
            'city.max' => 'Nama kota maksimal 100 karakter.',

            'address.required' => 'Alamat lengkap wajib diisi.',
            'address.min' => 'Alamat lengkap minimal 10 karakter.',
            'address.max' => 'Alamat lengkap maksimal 500 karakter.',

            'status.required' => 'Status client wajib dipilih.',
            'status.in' => 'Status client yang dipilih tidak valid.',
        ];
    }

    public function update(): void
    {
        $user = Auth::user();

        abort_unless(
            $user instanceof User
                && $user->can('update clients'),
            403
        );

        $validated = $this->validate();

        /*
        * Masukkan data ke model terlebih dahulu
        * tanpa langsung menyimpannya.
        */
        $this->client->fill([
            'contact_person' =>
                trim($validated['name']),

            'company_name' =>
                trim($validated['company']),

            'email' =>
                strtolower(
                    trim($validated['email'])
                ),

            'phone' =>
                $this->normalizePhone(
                    $validated['phone']
                ),

            'city' =>
                trim($validated['city']),

            'address' =>
                trim($validated['address']),

            'status' =>
                $validated['status'],
        ]);

        /*
        * Jangan menjalankan query UPDATE apabila
        * tidak ada nilai yang berubah.
        */
        if (!$this->client->isDirty()) {
            session()->flash('notification', [
                'type' => 'warning',
                'message' =>
                    'Tidak ada perubahan data Client yang perlu disimpan.',
            ]);

            $this->redirectRoute(
                'owner.clients.index',
                navigate: true
            );

            return;
        }

        $this->client->save();

        session()->flash('notification', [
            'type' => 'update',
            'message' =>
                'Data Client berhasil diperbarui.',
        ]);

        $this->redirectRoute(
            'owner.clients.index',
            navigate: true
        );
    }

    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/[^0-9+]/', '', trim($phone)) ?? '';

        if (str_starts_with($phone, '+62')) {
            return $phone;
        }

        if (str_starts_with($phone, '62')) {
            return '+' . $phone;
        }

        if (str_starts_with($phone, '0')) {
            return '+62' . substr($phone, 1);
        }

        return '+62' . $phone;
    }

    private function formatPhoneForForm(?string $phone): string
    {
        if (blank($phone)) {
            return '';
        }

        return preg_replace('/^\+62/', '', $phone) ?? $phone;
    }

    public function render()
    {
        return view('livewire.owner.clients.edit');
    }
}