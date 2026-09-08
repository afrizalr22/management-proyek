@props([
    'user',
    'projects' => collect(),
])

@php
    $projectStatus = fn (?string $status): array => match ($status) {
        'planning' => ['Perencanaan', 'yellow'],
        'on_progress' => ['Sedang Berjalan', 'blue'],
        'completed' => ['Selesai', 'green'],
        'cancelled' => ['Dibatalkan', 'red'],
        default => ['Tidak Diketahui', 'gray'],
    };
@endphp

<x-ui.info-card>
    <div class="p-6 sm:p-8">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800">
                Riwayat Project
            </h2>

            <p class="mt-2 text-gray-500">
                Daftar Project yang pernah maupun sedang ditangani pengguna.
            </p>
        </div>

        @if ($projects->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Project
                            </th>

                            <th class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Client
                            </th>

                            <th class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Peran
                            </th>

                            <th class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Status
                            </th>

                            <th class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Mulai
                            </th>

                            <th class="px-3 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                Selesai
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @foreach ($projects as $project)
                            @php
                                [$statusText, $statusColor] =
                                    $projectStatus($project['status']);

                                $startDate = $project['joined_at']
                                    ?? $project['start_date'];

                                $endDate = $project['ended_at']
                                    ?? $project['end_date'];
                            @endphp

                            <tr class="transition hover:bg-gray-50">
                                <td class="px-3 py-4">
                                    @if ($project['id'])
                                        <a
                                            href="{{ route('owner.projects.show', [
                                                'project' => $project['id'],
                                            ]) }}"
                                            wire:navigate
                                            class="font-semibold text-gray-900 transition hover:text-blue-600"
                                        >
                                            {{ $project['name'] }}
                                        </a>
                                    @else
                                        <span class="font-semibold text-gray-900">
                                            {{ $project['name'] }}
                                        </span>
                                    @endif

                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $project['code'] ?: '-' }}
                                    </p>
                                </td>

                                <td class="px-3 py-4 text-sm text-gray-600">
                                    {{ $project['client'] }}
                                </td>

                                <td class="px-3 py-4 text-sm text-gray-600">
                                    {{ $project['role'] }}
                                </td>

                                <td class="px-3 py-4">
                                    <x-ui.badge :color="$statusColor">
                                        {{ $statusText }}
                                    </x-ui.badge>

                                    @if ($project['assignment_status'])
                                        <p class="mt-2 text-xs text-gray-500">
                                            Penugasan:
                                            {{ $project['assignment_status'] === 'active'
                                                ? 'Aktif'
                                                : 'Tidak Aktif' }}
                                        </p>
                                    @endif
                                </td>

                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">
                                    {{ $startDate
                                        ? \Illuminate\Support\Carbon::parse($startDate)
                                            ->translatedFormat('d M Y')
                                        : '-' }}
                                </td>

                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600">
                                    {{ $endDate
                                        ? \Illuminate\Support\Carbon::parse($endDate)
                                            ->translatedFormat('d M Y')
                                        : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-6 py-10 text-center">
                <p class="font-semibold text-gray-700">
                    Belum memiliki riwayat Project
                </p>

                <p class="mt-1 text-sm text-gray-500">
                    Pengguna ini belum pernah ditugaskan pada Project.
                </p>
            </div>
        @endif
    </div>
</x-ui.info-card>