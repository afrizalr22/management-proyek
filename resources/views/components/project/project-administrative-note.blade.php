@props([
    'mode' => 'create',
])

<div class="space-y-6">

    {{-- Information --}}
    <x-ui.info-card>

        <div class="rounded-2xl border border-blue-100 bg-blue-50 p-6">

            <div class="flex items-start gap-4">

                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-xl">

                    ℹ️

                </div>

                <div>

                    <h3 class="font-semibold text-blue-700">

                        Informasi

                    </h3>

                    @if($mode === 'create')

                        <p class="mt-2 text-sm leading-7 text-blue-600">

                            Pastikan seluruh informasi project telah diisi dengan benar
                            sebelum menyimpan data. Data project masih dapat diubah
                            melalui halaman Edit Project.

                        </p>

                    @else

                        <p class="mt-2 text-sm leading-7 text-blue-600">

                            Perubahan yang dilakukan akan langsung memperbarui data
                            project. Pastikan informasi yang diperbarui sudah sesuai
                            sebelum menyimpan perubahan.

                        </p>

                    @endif

                </div>

            </div>

        </div>

    </x-ui.info-card>

</div>  