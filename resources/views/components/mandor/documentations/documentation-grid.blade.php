@props([
    'documentations',
])

<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">
    @foreach ($documentations as $documentation)
        <x-mandor.documentations.documentation-card
            :documentation="$documentation"
            wire:key="mandor-documentation-{{ $documentation->id }}"
        />
    @endforeach
</div>