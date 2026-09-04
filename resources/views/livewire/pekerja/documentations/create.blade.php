<div class="space-y-6">
    <x-pekerja.documentations.create.page-header />

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        {{-- Form dokumentasi --}}
        <div class="xl:col-span-2">
            <x-pekerja.documentations.create.documentation-form />
        </div>

        {{-- Dokumentasi hari ini --}}
        <div>
            <x-pekerja.documentations.create.recent-uploads />
        </div>
    </div>
</div>