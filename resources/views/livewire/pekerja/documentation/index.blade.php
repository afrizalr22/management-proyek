<div class="space-y-6">
    <x-pekerja.documentation.page-header />

    @if (session('success'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 5000)"
            x-show="show"
            x-transition.opacity
            class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700"
            role="status"
        >
            {{ session('success') }}
        </div>
    @endif

    <x-pekerja.documentation.documentation-toolbar
        :task-options="$taskOptions"
        :search="$search"
        :task="$task"
        :category="$category"
        :sort="$sort"
    />

    <x-pekerja.documentation.documentation-gallery
        :documentations="$documentations"
        :total-documentations="$totalDocumentations"
    />

    <x-pekerja.documentation.documentation-pagination
        :documentations="$documentations"
    />
</div>