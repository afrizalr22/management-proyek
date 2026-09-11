@props([
    'label',
])

<section {{ $attributes->class(['space-y-1']) }}>
    <h2 class="px-3 pb-1 pt-3 text-[11px] font-bold uppercase tracking-[0.16em] text-gray-400">
        {{ $label }}
    </h2>

    <div class="space-y-1">
        {{ $slot }}
    </div>
</section>