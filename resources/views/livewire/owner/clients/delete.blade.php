<div class="space-y-6">

    {{-- Breadcrumb --}}
    <div class="text-sm text-gray-500">

        <a href="{{ route('owner.dashboard') }}" class="hover:text-blue-600">
            Dashboard
        </a>

        <span class="mx-2">></span>

        <a href="{{ route('owner.clients.index') }}" class="hover:text-blue-600">
            Clients
        </a>

        <span class="mx-2">></span>

        <span class="font-medium text-red-600">

            Hapus Client

        </span>

    </div>

    {{-- Header --}}
    <x-ui.page-header
        title="Hapus Client"
        description="Pastikan Anda memahami konsekuensi sebelum menghapus data client."
    >

        <x-slot:actions>

            <div class="flex gap-3">

                <a href="{{ route('owner.clients.index') }}">

                    <x-ui.button color="gray">

                        Batal

                    </x-ui.button>

                </a>

                <x-ui.button color="danger">

                    Ya, Hapus Client

                </x-ui.button>

            </div>

        </x-slot:actions>

    </x-ui.page-header>

    {{-- Warning --}}
    <div class="rounded-2xl border border-red-200 bg-red-50 p-6">

        <div class="flex gap-4">

            <div class="text-4xl">

                ⚠️

            </div>

            <div>

                <h3 class="font-bold text-red-700">

                    Peringatan

                </h3>

                <p class="mt-2 leading-7 text-red-600">

                    Tindakan ini akan menghapus client beserta hubungan data
                    yang dimiliki. Pada implementasi sebenarnya kami akan
                    menggunakan <strong>Soft Delete</strong> agar data tetap
                    dapat dipulihkan apabila diperlukan.

                </p>

            </div>

        </div>

    </div>

    {{-- Client --}}
    <x-ui.info-card>

        <div class="p-8">

            <h3 class="text-lg font-bold">

                Data Client

            </h3>

            <div class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-2">

                <div>

                    <p class="text-sm text-gray-500">

                        Nama Client

                    </p>

                    <p class="mt-2 font-semibold">

                        Budi Santoso

                    </p>

                </div>

                <div>

                    <p class="text-sm text-gray-500">

                        Perusahaan

                    </p>

                    <p class="mt-2 font-semibold">

                        PT Tekno Konstruksi Utama

                    </p>

                </div>

                <div>

                    <p class="text-sm text-gray-500">

                        Email

                    </p>

                    <p class="mt-2">

                        budi@tekno.co.id

                    </p>

                </div>

                <div>

                    <p class="text-sm text-gray-500">

                        Status

                    </p>

                    <div class="mt-2">

                        <x-ui.badge color="green">

                            Active

                        </x-ui.badge>

                    </div>

                </div>

            </div>

        </div>

    </x-ui.info-card>

</div>