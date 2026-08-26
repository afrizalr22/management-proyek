@props([
    'image',
    'project',
    'description',
    'date',
    'uploader',
])

<article
    class="group overflow-hidden rounded-2xl
           border border-gray-200 bg-white shadow-sm
           transition duration-300
           hover:-translate-y-1 hover:shadow-lg"
>

    {{-- Documentation Image --}}
    <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">

        <img
            src="{{ $image }}"
            alt="{{ $description }}"
            class="h-full w-full object-cover
                   transition duration-500
                   group-hover:scale-105"
        >

        {{-- Image Overlay --}}
        <div
            class="absolute inset-0 bg-gradient-to-t
                   from-black/70 via-transparent to-transparent"
        ></div>

        {{-- Project Label --}}
        <div class="absolute left-4 top-4">

            <span
                class="rounded-md bg-blue-600 px-2.5 py-1.5
                       text-[10px] font-bold uppercase
                       tracking-wide text-white shadow-sm"
            >
                {{ $project }}
            </span>

        </div>

{{-- Preview Button --}}
<button
    type="button"
    title="Lihat foto"
    data-image="{{ $image }}"
    data-project="{{ $project }}"
    data-description="{{ $description }}"
    data-date="{{ $date }}"
    data-uploader="{{ $uploader }}"
    x-on:click="
        $dispatch('open-documentation-preview', {
            image: $el.dataset.image,
            project: $el.dataset.project,
            description: $el.dataset.description,
            date: $el.dataset.date,
            uploader: $el.dataset.uploader
        })
    "
    class="absolute bottom-4 right-4 flex h-10 w-10
           items-center justify-center rounded-lg
           bg-black/40 text-white opacity-0
           backdrop-blur-sm transition
           hover:bg-black/60
           group-hover:opacity-100"
>
    <svg
        class="h-5 w-5"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2"
    >
        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M2 12s3.5-7 10-7 10 7 10 7-3.5
               7-10 7S2 12 2 12z"
        />

        <circle cx="12" cy="12" r="3" />
    </svg>
</button>

    </div>

    {{-- Documentation Information --}}
    <div class="p-5">

        {{-- Description --}}
        <h3
            class="line-clamp-2 min-h-[48px]
                   font-semibold leading-6 text-gray-900"
        >
            {{ $description }}
        </h3>

        {{-- Meta Information --}}
        <div class="mt-4 space-y-2">

            {{-- Date --}}
            <div class="flex items-center gap-2 text-sm text-gray-500">

                <svg
                    class="h-4 w-4 shrink-0 text-gray-400"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <rect
                        x="3"
                        y="5"
                        width="18"
                        height="16"
                        rx="2"
                    />

                    <path d="M16 3v4M8 3v4M3 11h18" />
                </svg>

                <span>
                    {{ $date }}
                </span>

            </div>

            {{-- Uploader --}}
            <div class="flex items-center gap-2 text-sm text-gray-500">

                <svg
                    class="h-4 w-4 shrink-0 text-gray-400"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <circle cx="12" cy="8" r="4" />

                    <path
                        stroke-linecap="round"
                        d="M4 21a8 8 0 0116 0"
                    />
                </svg>

                <span class="truncate">
                    Diunggah oleh {{ $uploader }}
                </span>

            </div>

        </div>

    </div>

</article>