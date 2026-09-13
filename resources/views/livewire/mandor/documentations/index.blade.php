<div class="space-y-6">

    <x-mandor.documentations.page-header
        :project="$project"
        :total-documentations="$totalDocumentations"
    />

    <x-mandor.documentations.documentation-filter
        :categories="$categories"
        :tasks="$tasks"
        :category="$category"
        :task-filter="$taskFilter"
        :sort="$sort"
        :filtered-documentations="$filteredDocumentations"
        :total-documentations="$totalDocumentations"
        :has-active-filters="$hasActiveFilters"
    />

    <div wire:loading.class="opacity-60">
        @if ($documentations->isNotEmpty())
            <x-mandor.documentations.documentation-grid
                :documentations="$documentations"
            />

            <x-mandor.documentations.documentation-footer
                :documentations="$documentations"
            />
        @else
            <x-mandor.documentations.documentation-empty
                :has-active-filters="$hasActiveFilters"
            />
        @endif
    </div>

    <x-mandor.documentations.documentation-preview />

</div>