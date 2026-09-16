@props([
    'invoice',
])

<x-ui.info-card>
    <div class="p-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Informasi Penagihan
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Snapshot informasi klien saat invoice dibuat.
            </p>
        </div>

        <hr class="my-6 border-gray-200">

        <dl class="space-y-6">
            <div>
                <dt class="text-sm text-gray-500">
                    Klien
                </dt>

                <dd class="mt-1 text-lg font-semibold text-gray-800">
                    {{ $invoice->client_name }}
                </dd>
            </div>

            <div>
                <dt class="text-sm text-gray-500">
                    Contact Person
                </dt>

                <dd class="mt-1 font-semibold text-gray-800">
                    {{ $invoice->client_contact_person ?: '-' }}
                </dd>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm text-gray-500">
                        Telepon
                    </dt>

                    <dd class="mt-1 font-semibold text-gray-800">
                        {{ $invoice->client_phone ?: '-' }}
                    </dd>
                </div>

                <div>
                    <dt class="text-sm text-gray-500">
                        Email
                    </dt>

                    <dd class="mt-1 break-all font-semibold text-gray-800">
                        {{ $invoice->client_email ?: '-' }}
                    </dd>
                </div>
            </div>

            <div>
                <dt class="text-sm text-gray-500">
                    Alamat
                </dt>

                <dd class="mt-1 whitespace-pre-line font-semibold leading-relaxed text-gray-800">
                    {{ $invoice->client_address ?: '-' }}
                </dd>
            </div>
        </dl>
    </div>
</x-ui.info-card>