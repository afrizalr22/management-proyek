<div class="space-y-6">
    <x-pekerja.documentation.create.page-header />

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        {{-- Form dokumentasi --}}
        <div class="xl:col-span-2">
            <x-pekerja.documentation.create.documentation-form />
        </div>

        {{-- Dokumentasi hari ini --}}
        <div>
            <x-pekerja.documentation.create.recent-uploads />
        </div>
    </div>
</div>