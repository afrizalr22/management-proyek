@props([
    'mode' => 'create',
])

<x-ui.info-card>

    <div class="p-6">

        {{-- Header --}}
        <div>

            <h2 class="text-xl font-bold text-gray-900">

                Quotation Preview

            </h2>

            <p class="mt-2 text-sm leading-6 text-gray-500">

                Preview dokumen quotation akan tersedia setelah data berhasil disimpan.

            </p>

        </div>

        <hr class="my-6 border-gray-200">

        {{-- Preview Placeholder --}}
        <div
            class="flex min-h-[24rem] flex-col items-center justify-center rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 px-6 py-10"
        >

            {{-- Icon --}}
            <div
                class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-100"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-10 w-10 text-gray-400"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.5"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 12h6m-6 4h6M7 4h7l5 5v11a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"
                    />

                </svg>

            </div>

            {{-- Message --}}
            <h3 class="mt-5 text-lg font-semibold text-gray-800">

                Preview Belum Tersedia

            </h3>

            <p class="mt-2 max-w-sm text-center text-sm leading-6 text-gray-500">

                Setelah quotation disimpan, preview dokumen akan tersedia
                di bagian ini untuk ditinjau sebelum dicetak atau dikirim
                kepada client.

            </p>

        </div>

    </div>

</x-ui.info-card>