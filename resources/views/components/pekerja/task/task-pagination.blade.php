@props([
    'tasks',
])

@if ($tasks->hasPages())
    <div class="border-t border-slate-200 px-5 py-4 sm:px-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-slate-500">
                Menampilkan

                <span class="font-semibold text-slate-700">
                    {{ $tasks->firstItem() }}
                    sampai
                    {{ $tasks->lastItem() }}
                </span>

                dari

                <span class="font-semibold text-slate-700">
                    {{ $tasks->total() }}
                </span>

                task
            </p>

            <div>
                {{ $tasks->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
@endif