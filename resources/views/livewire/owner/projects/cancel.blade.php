<div class="mx-auto max-w-3xl space-y-6">
    <nav class="flex flex-wrap items-center gap-2 text-sm text-gray-500">
        <a
            href="{{ route('owner.projects.index') }}"
            wire:navigate
            class="transition hover:text-blue-600"
        >
            Project
        </a>

        <span>/</span>

        <a
            href="{{ route('owner.projects.show', [
                'project' => $project->id,
            ]) }}"
            wire:navigate
            class="transition hover:text-blue-600"
        >
            {{ $project->project_code }}
        </a>

        <span>/</span>

        <span class="font-medium text-gray-700">
            Batalkan
        </span>
    </nav>

    <section
        class="rounded-2xl border border-red-200 bg-white p-6 shadow-sm"
    >
        <div class="space-y-2">
            <h1 class="text-xl font-bold text-gray-900">
                Batalkan Project
            </h1>

            <p class="text-sm leading-6 text-gray-600">
                Project
                <span class="font-semibold text-gray-900">
                    {{ $project->project_code }}
                </span>
                akan dibatalkan dan tidak dapat digunakan untuk aktivitas operasional baru.
                Data historis Project tetap disimpan.
            </p>
        </div>

        <form
            wire:submit="cancelProject"
            class="mt-6 space-y-6"
        >
            <div>
                <label
                    for="cancellationReason"
                    class="mb-2 block text-sm font-semibold text-gray-700"
                >
                    Alasan Pembatalan
                </label>

                <textarea
                    id="cancellationReason"
                    wire:model="cancellationReason"
                    rows="5"
                    class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none focus:ring-4 focus:ring-red-100"
                    placeholder="Jelaskan alasan Project dibatalkan..."
                ></textarea>

                @error('cancellationReason')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            @error('cancel')
                <div
                    class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                >
                    {{ $message }}
                </div>
            @enderror

            <div
                class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end"
            >
                <a
                    href="{{ route('owner.projects.show', [
                        'project' => $project->id,
                    ]) }}"
                    wire:navigate
                    class="inline-flex min-h-11 items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100"
                >
                    Kembali
                </a>

                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="cancelProject"
                    class="inline-flex min-h-11 items-center justify-center rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <span
                        wire:loading.remove
                        wire:target="cancelProject"
                    >
                        Batalkan Project
                    </span>

                    <span
                        wire:loading
                        wire:target="cancelProject"
                    >
                        Memproses...
                    </span>
                </button>
            </div>
        </form>
    </section>
</div>