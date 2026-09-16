@props([
    'quotation',
    'statusText',
    'statusColor',
])

<x-ui.info-card>
    <div class="p-5 sm:p-6 lg:p-8">

        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 xl:grid-cols-4">

            {{-- Client --}}
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Client
                </p>

                <h3 class="mt-2 break-words text-lg font-bold text-gray-900">
                    {{ $quotation->client?->company_name
                        ?: $quotation->client_name
                        ?: '-' }}
                </h3>

                <div class="mt-3 space-y-1.5 text-sm text-gray-500">
                    <p class="break-words">
                        {{ $quotation->client?->contact_person
                            ?: $quotation->client_contact_person
                            ?: '-' }}
                    </p>

                    <p class="break-all">
                        {{ $quotation->client?->email
                            ?: $quotation->client_email
                            ?: '-' }}
                    </p>

                    <p>
                        {{ $quotation->client?->phone
                            ?: $quotation->client_phone
                            ?: '-' }}
                    </p>
                </div>

                @if ($quotation->client)
                    <a
                        href="{{ route('owner.clients.show', [
                            'client' => $quotation->client->id,
                        ]) }}"
                        wire:navigate
                        class="mt-3 inline-flex text-sm font-semibold text-blue-600 transition hover:text-blue-700"
                    >
                        Lihat Client
                    </a>
                @endif
            </div>

            {{-- Calon proyek --}}
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Calon Proyek
                </p>

                <h3 class="mt-2 break-words text-lg font-semibold leading-7 text-gray-900">
                    {{ $quotation->project_name ?: '-' }}
                </h3>

                <p class="mt-2 break-words text-sm leading-6 text-gray-500">
                    {{ $quotation->project_location
                        ?: 'Lokasi belum ditentukan' }}
                </p>

                @if ($quotation->project)
                    <div class="mt-3">
                        <x-ui.badge color="green">
                            Proyek telah dibuat
                        </x-ui.badge>
                    </div>

                    <a
                        href="{{ route('owner.projects.show', [
                            'project' => $quotation->project->id,
                        ]) }}"
                        wire:navigate
                        class="mt-3 inline-flex text-sm font-semibold text-blue-600 transition hover:text-blue-700"
                    >
                        Lihat Proyek
                    </a>
                @else
                    <div class="mt-3">
                        <x-ui.badge color="gray">
                            Proyek belum dibuat
                        </x-ui.badge>
                    </div>
                @endif
            </div>

            {{-- Tanggal quotation --}}
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Informasi Quotation
                </p>

                <div class="mt-3 space-y-3">
                    <div>
                        <p class="text-xs text-gray-500">
                            Tanggal
                        </p>

                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $quotation->quotation_date
                                ? $quotation->quotation_date->format('d M Y')
                                : '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500">
                            Berlaku sampai
                        </p>

                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $quotation->valid_until
                                ? $quotation->valid_until->format('d M Y')
                                : '-' }}
                        </p>
                    </div>

                    <div>
                        <x-ui.badge :color="$statusColor">
                            {{ $statusText }}
                        </x-ui.badge>
                    </div>
                </div>
            </div>

            {{-- Grand total --}}
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Grand Total
                </p>

                <h3 class="mt-3 break-words text-2xl font-bold text-blue-600">
                    Rp {{ number_format(
                        (float) $quotation->grand_total,
                        0,
                        ',',
                        '.'
                    ) }}
                </h3>

                <p class="mt-2 text-sm text-gray-500">
                    Total akhir quotation
                </p>

                <div class="mt-5 border-t border-gray-200 pt-4">
                    <p class="text-xs text-gray-500">
                        Dibuat oleh
                    </p>

                    <p class="mt-1 text-sm font-semibold text-gray-800">
                        {{ $quotation->creator?->name ?: '-' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Alamat client --}}
       @if ($quotation->client?->address || $quotation->client_address)
            <div class="mt-8 border-t border-gray-200 pt-6">
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Alamat Client
                </p>

                <p class="mt-2 whitespace-pre-line break-words text-sm leading-6 text-gray-700">
                    {{ $quotation->client?->address
                        ?: $quotation->client_address
                        ?: '-' }}
                </p>
            </div>
        @endif
    </div>
</x-ui.info-card>