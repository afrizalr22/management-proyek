@props([
    'user',
    'isSelf' => false,
])

<x-ui.info-card>
    <div class="rounded-2xl bg-slate-900 p-6 sm:p-8">
        <h2 class="text-2xl font-bold text-slate-100">
            Keamanan Akun
        </h2>

        <p class="mt-2 text-sm leading-6 text-slate-300">
            Perubahan akun akan diterapkan setelah formulir disimpan.
        </p>

        <div class="mt-6 space-y-3">
            <div class="rounded-xl border border-slate-700 px-4 py-3">
                <p class="text-sm font-semibold text-slate-200">
                    Password
                </p>

                <p class="mt-1 text-xs leading-5 text-slate-400">
                    Isi bagian password hanya jika ingin menggantinya.
                </p>
            </div>

            @if ($isSelf)
                <div class="rounded-xl border border-amber-700 bg-amber-900/20 px-4 py-3">
                    <p class="text-sm font-semibold text-amber-300">
                        Akun sedang digunakan
                    </p>

                    <p class="mt-1 text-xs leading-5 text-amber-200/80">
                        Role dan status akun sendiri tidak dapat diubah.
                    </p>
                </div>
            @else
                <div class="rounded-xl border border-slate-700 px-4 py-3">
                    <p class="text-sm font-semibold text-slate-200">
                        Status akun
                    </p>

                    <p class="mt-1 text-xs leading-5 text-slate-400">
                        Akun dapat diaktifkan atau dinonaktifkan melalui formulir role.
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-ui.info-card>