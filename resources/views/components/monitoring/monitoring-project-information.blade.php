@props([
    'project',
    'isDelayed' => false,
])

@php
    $formatCurrency = static function (
        mixed $amount
    ): string {
        if ($amount === null) {
            return '-';
        }

        return 'Rp '.number_format(
            (float) $amount,
            0,
            ',',
            '.'
        );
    };

    $duration = null;

    if ($project->start_date && $project->end_date) {
        $duration =
            $project->start_date
                ->diffInDays($project->end_date)
            + 1;
    }
@endphp

<x-ui.info-card>
    <div class="p-6 sm:p-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Informasi Project
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Informasi utama dan periode pelaksanaan Project.
            </p>
        </div>

        <hr class="my-8 border-gray-200">

        <div class="grid grid-cols-1 gap-x-8 gap-y-7 md:grid-cols-2 xl:grid-cols-3">
            <div>
                <p class="text-sm font-medium text-gray-500">
                    Kode Project
                </p>

                <p class="mt-1.5 font-semibold leading-6 text-blue-600">
                    {{ $project->project_code }}
                </p>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-500">
                    Nama Project
                </p>

                <p class="mt-1.5 font-semibold leading-6 text-gray-900">
                    {{ $project->project_name }}
                </p>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-500">
                    Client
                </p>

                <p class="mt-1.5 font-semibold leading-6 text-gray-900">
                    {{ $project->client?->company_name
                        ?? 'Client tidak tersedia' }}
                </p>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-500">
                    Mandor
                </p>

                <p class="mt-1.5 font-semibold leading-6 text-gray-900">
                    {{ $project->mandor?->name
                        ?? 'Belum ditentukan' }}
                </p>

                @if ($project->mandor?->phone)
                    <p class="mt-1 text-sm text-gray-500">
                        {{ $project->mandor->phone }}
                    </p>
                @endif
            </div>

            <div>
                <p class="text-sm font-medium text-gray-500">
                    Lokasi
                </p>

                <p class="mt-1.5 font-semibold leading-6 text-gray-900">
                    {{ $project->location ?: '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-500">
                    Nomor Kontrak
                </p>

                <p class="mt-1.5 font-semibold leading-6 text-gray-900">
                    {{ $project->contract_number ?: '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-500">
                    Nilai Kontrak
                </p>

                <p class="mt-1.5 font-semibold leading-6 text-blue-600">
                    {{ $formatCurrency($project->contract_value) }}
                </p>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-500">
                    Anggaran Project
                </p>

                <p class="mt-1.5 font-semibold leading-6 text-gray-900">
                    {{ $formatCurrency($project->project_budget) }}
                </p>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-500">
                    Tanggal Kontrak
                </p>

                <p class="mt-1.5 font-semibold leading-6 text-gray-900">
                    {{ $project->contract_date
                        ?->translatedFormat('d F Y') ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-500">
                    Tanggal Mulai
                </p>

                <p class="mt-1.5 font-semibold leading-6 text-gray-900">
                    {{ $project->start_date
                        ?->translatedFormat('d F Y') ?? '-' }}
                </p>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-500">
                    Batas Waktu
                </p>

                <p
                    @class([
                        'mt-1.5 font-semibold leading-6',
                        'text-red-600' => $isDelayed,
                        'text-gray-900' => ! $isDelayed,
                    ])
                >
                    {{ $project->end_date
                        ?->translatedFormat('d F Y') ?? '-' }}
                </p>

                @if ($isDelayed)
                    <p class="mt-1 text-xs font-medium text-red-500">
                        Project telah melewati batas waktu.
                    </p>
                @endif
            </div>

            <div>
                <p class="text-sm font-medium text-gray-500">
                    Durasi Pelaksanaan
                </p>

                <p class="mt-1.5 font-semibold leading-6 text-gray-900">
                    {{ $duration !== null
                        ? $duration.' hari'
                        : '-' }}
                </p>
            </div>
        </div>

        @if (filled($project->description))
            <hr class="my-8 border-gray-200">

            <div>
                <p class="text-sm font-medium text-gray-500">
                    Deskripsi Project
                </p>

                <p class="mt-2 whitespace-pre-line text-sm leading-7 text-gray-700">
                    {{ $project->description }}
                </p>
            </div>
        @endif
    </div>
</x-ui.info-card>