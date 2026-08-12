<div
    x-data="{ open: false }"

    x-on:open-delete-user-modal.window="
        open = true
    "

    x-on:keydown.escape.window="
        open = false
    "

    x-show="open"

    x-transition.opacity

    class="fixed inset-0 z-50 flex items-center justify-center"

    style="display: none;"
>

    {{-- Overlay --}}
    <div
        class="absolute inset-0 bg-black/50"
        x-on:click="open = false"
    ></div>


    {{-- Modal --}}
    <div
        class="relative z-10 w-full max-w-lg rounded-3xl bg-white shadow-2xl"
    >

        {{-- Header --}}
        <div class="border-b border-gray-200 px-8 py-6">

            <h2 class="text-2xl font-bold text-gray-900">
                Delete User
            </h2>

            <p class="mt-2 text-gray-500">
                Tindakan ini tidak dapat dibatalkan.
            </p>

        </div>


        {{-- Body --}}
        <div class="space-y-6 p-8">

            {{-- Warning --}}
            <div
                class="rounded-2xl border border-red-200 bg-red-50 p-5"
            >

                <div class="flex items-start gap-4">

                    {{-- Icon --}}
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-500 text-white"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 9v4m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"
                            />

                        </svg>

                    </div>


                    {{-- Message --}}
                    <div>

                        <h3 class="font-semibold text-red-700">
                            Apakah Anda yakin?
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-red-600">
                            User akan dihapus dari sistem.
                            Seluruh data proyek yang berkaitan
                            tetap tersimpan.
                        </p>

                    </div>

                </div>

            </div>


            {{-- User Preview --}}
            <div
                class="rounded-2xl bg-gray-50 p-6"
            >

                <dl class="space-y-4">

                    {{-- Name --}}
                    <div class="flex items-center justify-between gap-4">

                        <dt class="text-gray-500">
                            Nama
                        </dt>

                        <dd class="font-semibold text-gray-900">
                            Ahmad Subarjo
                        </dd>

                    </div>


                    {{-- Email --}}
                    <div class="flex items-center justify-between gap-4">

                        <dt class="text-gray-500">
                            Email
                        </dt>

                        <dd class="text-right font-medium text-gray-800">
                            ahmad@example.com
                        </dd>

                    </div>


                    {{-- Role --}}
                    <div class="flex items-center justify-between gap-4">

                        <dt class="text-gray-500">
                            Role
                        </dt>

                        <dd>

                            <x-ui.badge color="blue">
                                Mandor
                            </x-ui.badge>

                        </dd>

                    </div>


                    {{-- Status --}}
                    <div class="flex items-center justify-between gap-4">

                        <dt class="text-gray-500">
                            Status
                        </dt>

                        <dd>

                            <x-ui.badge color="green">
                                Active
                            </x-ui.badge>

                        </dd>

                    </div>

                </dl>

            </div>

        </div>


        {{-- Footer --}}
        <div
            class="flex justify-end gap-3 border-t border-gray-200 px-8 py-6"
        >

            {{-- Cancel --}}
            <x-ui.button
                variant="outline"
                x-on:click="open = false"
            >
                Cancel
            </x-ui.button>


            {{-- Delete --}}
            <x-ui.button
                variant="danger"
            >
                Delete User
            </x-ui.button>

        </div>

    </div>

</div>