<div class="space-y-6">

    {{-- Breadcrumb --}}
    <div class="text-sm text-gray-500">

        <a
            href="{{ route('owner.projects.index') }}"
            class="hover:text-blue-600"
        >
            Project Management
        </a>

        <span class="mx-2">></span>

        <span class="font-medium text-gray-700">

            Renovasi Kantor Cabang Medan

        </span>

    </div>

    {{-- Header --}}
    <x-ui.page-header
        title="Detail Project"
        description="Informasi lengkap proyek."
    >

        <x-slot:actions>

            <div class="flex gap-3">

                <a href="{{ route('owner.projects.edit', 1) }}">
                    <x-ui.button variant="secondary">
                        Edit Project
                    </x-ui.button>
                </a>

                <x-ui.button>
                    Tambah Progress
                </x-ui.button>

            </div>

        </x-slot:actions>

    </x-ui.page-header>

    {{-- Top Section --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        <div class="xl:col-span-2">

            <x-project.project-information />

        </div>

        <div>

            <x-project.project-summary />

        </div>

    </div>

    {{-- Progress --}}
    <x-project.project-progress />

    {{-- Description --}}
    <x-project.project-description />

    {{-- Recent Activity --}}
    <x-project.project-activity />

    {{-- Quick Navigation --}}
    <x-project.project-navigation />

</div>