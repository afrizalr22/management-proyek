@props([
    'documentations',
])

@if ($documentations->total() > 0)
    <nav
        class="rounded-2xl border border-slate-200 bg-white px-5 py-4 shadow-sm sm:px-6"
        aria-label="Navigasi halaman dokumentasi"
    >
        <div
            class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <p class="text-sm text-slate-500">
                Menampilkan
                <span class="font-semibold text-slate-700">
                    {{ $documentations->firstItem() }}
                </span>
                sampai
                <span class="font-semibold text-slate-700">
                    {{ $documentations->lastItem() }}
                </span>
                dari
                <span class="font-semibold text-slate-700">
                    {{ $documentations->total() }}
                </span>
                dokumentasi
            </p>

            @if ($documentations->hasPages())
                <div class="shrink-0">
                    {{ $documentations->onEachSide(1)->links() }}
                </div>
            @endif
        </div>
    </nav>
@endif