<div class="space-y-6">
    {{-- Header --}}
    <x-mandor.projects.page-header />

    {{-- Ringkasan --}}
    <x-mandor.projects.project-summary
        :statistics="$statistics"
    />

    {{-- Toolbar --}}
    <x-mandor.projects.project-toolbar
        :search="$search"
        :status="$status"
        :sort="$sort"
    />

    {{-- Daftar Project --}}
    <x-mandor.projects.project-grid
        :projects="$projects"
        :search="$search"
        :status="$status"
        :sort="$sort"
    />
</div>