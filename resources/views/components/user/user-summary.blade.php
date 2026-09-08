@props([
    'user',
    'role' => '-',
    'projectHistory' => collect(),
])

@php
    $roleText = match ($role) {
        'owner' => 'Owner',
        'mandor' => 'Mandor',
        'pekerja' => 'Pekerja',
        default => '-',
    };

    $totalProjects = $projectHistory->count();

    $activeProjects = $projectHistory
        ->filter(function ($project) {
            if (($project['role'] ?? null) === 'Pekerja') {
                return ($project['assignment_status'] ?? null) === 'active';
            }

            return in_array(
                $project['status'] ?? null,
                ['planning', 'on_progress'],
                true
            );
        })
        ->count();

    $availabilityText = match (true) {
        $user->status !== 'active' => 'Akun tidak aktif',
        $role === 'pekerja' && $activeProjects > 0 => 'Sedang bertugas',
        $role === 'pekerja' => 'Tersedia',
        $role === 'mandor' && $activeProjects > 0 => 'Mengelola Project',
        $role === 'mandor' => 'Tersedia',
        default => 'Akses sistem',
    };

    $availabilityClasses = match (true) {
        $user->status !== 'active' =>
            'border-red-200 bg-red-50 text-red-700',

        $activeProjects > 0 =>
            'border-yellow-200 bg-yellow-50 text-yellow-700',

        default =>
            'border-green-200 bg-green-50 text-green-700',
    };
@endphp

<x-ui.info-card>
    <div class="p-6 sm:p-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                Ringkasan User
            </h2>

            <p class="mt-2 text-gray-500">
                Ringkasan akun dan penugasan pengguna.
            </p>
        </div>

        <div class="space-y-5">
            <div class="flex items-center justify-between gap-4 border-b border-gray-100 pb-3">
                <span class="text-gray-500">Role</span>
                <span class="font-semibold text-gray-800">
                    {{ $roleText }}
                </span>
            </div>

            <div class="flex items-center justify-between gap-4 border-b border-gray-100 pb-3">
                <span class="text-gray-500">Total Project</span>
                <span class="font-semibold text-gray-800">
                    {{ $totalProjects }}
                </span>
            </div>

            <div class="flex items-center justify-between gap-4 border-b border-gray-100 pb-3">
                <span class="text-gray-500">Project Aktif</span>
                <span class="font-semibold text-gray-800">
                    {{ $activeProjects }}
                </span>
            </div>

            <div>
                <span class="mb-2 block text-gray-500">
                    Ketersediaan
                </span>

                <div class="rounded-xl border px-4 py-3 text-sm font-semibold {{ $availabilityClasses }}">
                    {{ $availabilityText }}
                </div>
            </div>
        </div>
    </div>
</x-ui.info-card>