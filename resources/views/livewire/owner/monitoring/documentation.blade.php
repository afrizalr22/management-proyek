<div class="space-y-6">

    {{-- Breadcrumb --}}
    <div class="text-sm text-gray-500">

        <a
            href="{{ route('owner.monitoring.index') }}"
            class="hover:text-blue-600"
        >
            Project Monitoring
        </a>

        <span class="mx-2">/</span>

        <a
            href="{{ route('owner.monitoring.show', 1) }}"
            class="hover:text-blue-600"
        >
            Monitoring Detail
        </a>

        <span class="mx-2">/</span>

        <span class="font-medium text-gray-700">
            Documentation
        </span>

    </div>

    <x-monitoring.documentation-header />

    <x-monitoring.documentation-filter />

    <x-monitoring.documentation-gallery />

    <x-monitoring.documentation-pagination />

</div>