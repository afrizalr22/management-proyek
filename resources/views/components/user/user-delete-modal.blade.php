<div
    x-data="{ open:false }"

    x-on:open-delete-user-modal.window="
        open=true
    "

    x-on:keydown.escape.window="
        open=false
    "

    x-show="open"

    x-transition

    class="fixed inset-0 z-50 flex items-center justify-center"

    style="display:none;"
>

    {{-- Overlay --}}
    <div
        class="absolute inset-0 bg-black/50"
        x-on:click="open=false"
    ></div>

    {{-- Modal --}}
    <div
        class="relative z-10 w-full max-w-lg rounded-3xl bg-white shadow-xl"
    >

        <div class="border-b border-gray-200 px-8 py-6">

            <h2 class="text-2xl font-bold text-gray-900">

                Delete User

            </h2>

            <p class="mt-2 text-gray-500">

                Tindakan ini tidak dapat dibatalkan.

            </p>

        </div>

        <div class="space-y-6 p-8">

            <div class="rounded-2xl border border-red-200 bg-red-50 p-5">

                <h3 class="font-semibold text-red-700">

                    Apakah Anda yakin?

                </h3>

                <p class="mt-2 text-sm text-red-600">

                    User akan dihapus dari sistem.

                    Seluruh data proyek tetap tersimpan.

                </p>

            </div>

            <div class="rounded-xl bg-gray-50 p-5">

                <dl class="space-y-3">

                    <div class="flex justify-between">

                        <dt class="text-gray-500">

                            Nama

                        </dt>

                        <dd class="font-medium">

                            Ahmad Subarjo

                        </dd>

                    </div>

                    <div class="flex justify-between">

                        <dt class="text-gray-500">

                            Role

                        </dt>

                        <dd class="font-medium">

                            Mandor

                        </dd>

                    </div>

                    <div class="flex justify-between">

                        <dt class="text-gray-500">

                            Status

                        </dt>

                        <dd>

                            <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">

                                Active

                            </span>

                        </dd>

                    </div>

                </dl>

            </div>

        </div>

        <div class="flex justify-end gap-3 border-t border-gray-200 px-8 py-6">

            <x-ui.button
                variant="outline"
                x-on:click="open=false"
            >
                Cancel
            </x-ui.button>

            <x-ui.button
                variant="danger"
            >
                Delete User
            </x-ui.button>

        </div>

    </div>

</div>