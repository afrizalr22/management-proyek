@props([
    'users',
])

@if ($users->hasPages())
    <div>
        {{ $users->links() }}
    </div>
@elseif ($users->total() > 0)
    <div class="flex flex-col gap-2 text-sm text-gray-500 sm:flex-row sm:items-center sm:justify-between">
        <p>
            Menampilkan
            <span class="font-semibold text-gray-700">
                {{ $users->firstItem() }}
            </span>
            sampai
            <span class="font-semibold text-gray-700">
                {{ $users->lastItem() }}
            </span>
            dari
            <span class="font-semibold text-gray-700">
                {{ $users->total() }}
            </span>
            pengguna
        </p>
    </div>
@endif