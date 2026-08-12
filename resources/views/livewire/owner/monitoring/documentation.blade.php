<div class="space-y-6">

    {{-- Breadcrumb --}}
    <div class="flex flex-wrap items-center gap-2 text-sm">

        <a
            href="{{ route('owner.monitoring.index') }}"
            class="font-medium text-gray-500 transition hover:text-blue-600"
        >
            Project Monitoring
        </a>

        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4 text-gray-400"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="m9 5 7 7-7 7"
            />
        </svg>

        <a
            href="{{ route('owner.monitoring.show', 1) }}"
            class="font-medium text-gray-500 transition hover:text-blue-600"
        >
            Monitoring Detail
        </a>

        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4 text-gray-400"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="m9 5 7 7-7 7"
            />
        </svg>

        <span class="font-semibold text-gray-700">
            Documentation
        </span>

    </div>


    {{-- Header --}}
    <x-monitoring.documentation-header />


    {{-- Filter --}}
    <x-monitoring.documentation-filter />


    {{-- Gallery --}}
    <x-monitoring.documentation-gallery />


    {{-- Pagination --}}
    <x-monitoring.documentation-pagination />

</div>