<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-start gap-3">

            {{-- Back --}}
            <a
                href="{{ route('owner.invoices.index') }}"
                class="mt-1 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-gray-500 transition hover:bg-gray-100 hover:text-gray-700"
                title="Kembali"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 19l-7-7 7-7"
                    />
                </svg>

            </a>

            <div>

                <h1 class="text-2xl font-bold text-gray-800 sm:text-3xl">
                    Buat Invoice Baru
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Lengkapi detail di bawah untuk membuat invoice proyek.
                </p>

            </div>

        </div>


        {{-- Actions --}}
        <div class="flex items-center gap-3">

            <a href="{{ route('owner.invoices.index') }}">
                <x-ui.button variant="outline">
                    Batal
                </x-ui.button>
            </a>

            <x-ui.button variant="success">
                Simpan Invoice
            </x-ui.button>

        </div>

    </div>


    {{-- Main Content --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- Left Content --}}
        <div class="space-y-6 xl:col-span-2">

            {{-- Primary Information --}}
            <x-invoice.invoice-create-primary />

            {{-- Invoice Items --}}
            <x-invoice.invoice-create-items />

        </div>


        {{-- Right Content --}}
        <div class="space-y-6">

            {{-- Financial Summary --}}
            <x-invoice.invoice-create-summary />

        </div>

    </div>

</div>