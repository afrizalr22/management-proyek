<div class="border-b border-gray-200 bg-gray-50">

    {{-- Month Header --}}
    <div class="grid grid-cols-[260px_1fr]">

        {{-- Task Column --}}
        <div></div>


        {{-- Month Columns --}}
        <div class="grid grid-cols-3">

            @foreach (['July', 'August', 'September'] as $month)

                <div
                    class="border-l border-gray-200 px-3 py-3 text-center"
                >

                    <span
                        class="text-xs font-semibold uppercase tracking-wider text-gray-600"
                    >
                        {{ $month }}
                    </span>

                </div>

            @endforeach

        </div>

    </div>


    {{-- Week Header --}}
    <div class="grid grid-cols-[260px_1fr] border-t border-gray-200">

        {{-- Task --}}
        <div class="flex items-center px-5 py-3">

            <span class="text-sm font-semibold text-gray-700">
                Task
            </span>

        </div>


        {{-- Week Columns --}}
        <div class="grid grid-cols-12">

            @for ($i = 1; $i <= 12; $i++)

                <div
                    class="border-l border-gray-100 px-2 py-2 text-center"
                >

                    <span
                        class="text-[11px] font-medium text-gray-400"
                    >
                        W{{ (($i - 1) % 4) + 1 }}
                    </span>

                </div>

            @endfor

        </div>

    </div>

</div>