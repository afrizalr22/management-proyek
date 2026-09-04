<div class="min-h-full bg-slate-50">
    <div class="mx-auto w-full max-w-3xl px-4 py-6 sm:px-6 lg:px-8">

        {{-- Breadcrumb --}}
        <nav class="mb-4 flex flex-wrap items-center gap-2 text-sm text-slate-500">
            <a
                href="{{ route('owner.clients.index') }}"
                wire:navigate
                class="transition hover:text-blue-600"
            >
                Client
            </a>

            <span>/</span>

            <a
                href="{{ route('owner.clients.show', ['client' => $client->id]) }}"
                wire:navigate
                class="transition hover:text-blue-600"
            >
                {{ $client->company_name }}
            </a>

            <span>/</span>

            <span class="font-medium text-slate-700">
                Hapus
            </span>
        </nav>

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">
                Hapus Client
            </h1>

            <p class="mt-2 text-sm text-slate-500 sm:text-base">
                Periksa keterkaitan data sebelum menghapus client.
            </p>
        </div>

        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-5 py-5 sm:px-6">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-600">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="h-6 w-6"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 9v3.75m9.303 3.376c.866 1.5-.217 3.374-1.948 3.374H4.645c-1.73 0-2.813-1.874-1.948-3.374L10.052 3.38c.865-1.5 3.03-1.5 3.896 0l7.355 12.746ZM12 15.75h.008v.008H12v-.008Z"
                            />
                        </svg>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">
                            Konfirmasi Penghapusan
                        </h2>

                        <p class="mt-1 text-sm leading-6 text-slate-500">
                            Data yang telah dihapus tidak dapat dikembalikan.
                        </p>
                    </div>
                </div>
            </div>

            <div class="space-y-6 px-5 py-6 sm:px-6">
                {{-- Data client --}}
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <dl class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                Perusahaan
                            </dt>

                            <dd class="mt-1 text-sm font-semibold text-slate-900">
                                {{ $client->company_name }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                Kontak
                            </dt>

                            <dd class="mt-1 text-sm font-semibold text-slate-900">
                                {{ $client->contact_person }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                Email
                            </dt>

                            <dd class="mt-1 break-all text-sm text-slate-700">
                                {{ $client->email }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                Status
                            </dt>

                            <dd class="mt-1 text-sm text-slate-700">
                                {{ $client->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                            </dd>
                        </div>
                    </dl>
                </div>

                {{-- Pemeriksaan relasi --}}
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-xl border border-slate-200 p-4">
                        <p class="text-sm text-slate-500">
                            Jumlah Quotation
                        </p>

                        <p class="mt-1 text-2xl font-bold text-slate-900">
                            {{ $quotationsCount }}
                        </p>
                    </div>

                    <div class="rounded-xl border border-slate-200 p-4">
                        <p class="text-sm text-slate-500">
                            Jumlah Proyek
                        </p>

                        <p class="mt-1 text-2xl font-bold text-slate-900">
                            {{ $projectsCount }}
                        </p>
                    </div>
                </div>

                @if ($this->hasRelatedData())
                    <div
                        class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm leading-6 text-amber-800"
                        role="alert"
                    >
                        Client ini tidak dapat dihapus karena sudah memiliki
                        quotation atau proyek. Data client perlu dipertahankan
                        untuk menjaga riwayat transaksi.
                    </div>
                @else
                    <div
                        class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm leading-6 text-red-700"
                        role="alert"
                    >
                        Client ini belum memiliki quotation maupun proyek.
                        Apakah Anda yakin ingin menghapusnya?
                    </div>
                @endif
            </div>

            {{-- Action --}}
            <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                <a
                    href="{{ route('owner.clients.show', ['client' => $client->id]) }}"
                    wire:navigate
                    class="inline-flex min-h-11 items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 focus:outline-none focus:ring-4 focus:ring-slate-200"
                >
                    Batal
                </a>

                <button
                    type="button"
                    wire:click="delete"
                    wire:confirm="Yakin ingin menghapus client ini?"
                    wire:loading.attr="disabled"
                    wire:target="delete"
                    @disabled($this->hasRelatedData())
                    class="inline-flex min-h-11 items-center justify-center rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-200 disabled:cursor-not-allowed disabled:bg-slate-300 disabled:text-slate-500"
                >
                    <span wire:loading.remove wire:target="delete">
                        Hapus Client
                    </span>

                    <span wire:loading wire:target="delete">
                        Menghapus...
                    </span>
                </button>
            </div>
        </section>

    </div>
</div>