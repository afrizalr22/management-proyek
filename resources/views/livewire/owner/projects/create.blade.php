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

            {{ $pageTitle }}

        </span>

    </div>

    {{-- Header --}}
    <x-ui.page-header
        :title="$pageTitle"
        :description="$pageDescription"
    >

        <x-slot:actions>

            <div class="flex gap-3">

                <a href="{{ route('owner.projects.index') }}">

                    <x-ui.button
                        variant="secondary"
                    >

                        Batal

                    </x-ui.button>

                </a>

                <x-ui.button>

                    {{ $buttonText }}

                </x-ui.button>

            </div>

        </x-slot:actions>

    </x-ui.page-header>

    {{-- Content --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- Left Side --}}
        <div class="space-y-6 xl:col-span-2">

            {{-- General Information --}}
            <x-project.project-general-information mode="create" />

            {{-- Timeline & Budget --}}
            <x-project.project-timeline-budget />

        </div>

        {{-- Right Side --}}
        <div class="space-y-6">

            {{-- Sidebar --}}
            <x-project.project-form-sidebar />

            {{-- Administrative Note --}}
            <x-project.project-administrative-note />

        </div>

    </div>

</div>