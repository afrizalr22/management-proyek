@props([
    'projects',
])

<div class="space-y-4">
    @if ($projects->hasPages())
        <div class="rounded-xl border border-gray-200 bg-white px-4 py-4">
            {{ $projects->links() }}
        </div>
    @endif

    <p class="px-2 text-sm text-gray-500">
        @if ($projects->total() > 0)
            Menampilkan

            <span class="font-medium text-gray-700">
                {{ $projects->firstItem() }}
            </span>

            sampai

            <span class="font-medium text-gray-700">
                {{ $projects->lastItem() }}
            </span>

            dari

            <span class="font-medium text-gray-700">
                {{ $projects->total() }}
            </span>

            Project
        @else
            Tidak ada Project yang ditampilkan
        @endif
    </p>
</div>