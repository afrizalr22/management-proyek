@props([
    'name' => null,
])

<div class="relative min-w-[180px]">

    <select
        name="{{ $name }}"
        {{
            $attributes->merge([
                'class' =>
                    'peer w-full appearance-none rounded-xl border border-gray-300 bg-white py-3 pl-4 pr-11 text-sm font-medium text-gray-700 shadow-sm transition-all duration-200 hover:border-gray-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none'
            ])
        }}
    >

        {{ $slot }}

    </select>

    {{-- Arrow --}}
    <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center">

        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4 text-gray-400 transition duration-200 peer-focus:text-blue-600"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2.5"
        >

            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M19 9l-7 7-7-7"
            />

        </svg>

    </div>

</div>