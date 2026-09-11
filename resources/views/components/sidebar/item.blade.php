@props([
    'href',
    'active' => false,
])

<a
    href="{{ $href }}"
    wire:navigate
    x-on:click="sidebarOpen = false"
    @if ($active)
        aria-current="page"
    @endif
    {{ $attributes->except('class') }}
    @class([
        'group flex min-h-11 items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition duration-200',

        'bg-blue-600 text-white shadow-sm shadow-blue-200' =>
            $active,

        'text-gray-600 hover:bg-gray-100 hover:text-gray-900' =>
            !$active,
    ])
>
    @isset($icon)
        <span
            @class([
                'flex h-5 w-5 shrink-0 items-center justify-center transition',

                'text-white' =>
                    $active,

                'text-gray-400 group-hover:text-blue-600' =>
                    !$active,
            ])
        >
            {{ $icon }}
        </span>
    @endisset

    <span class="min-w-0 flex-1 truncate">
        {{ $slot }}
    </span>

    @if ($active)
        <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-white"></span>
    @endif
</a>