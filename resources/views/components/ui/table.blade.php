<div class="overflow-hidden bg-white rounded-2xl border border-gray-100 shadow-sm">

    <div class="overflow-x-auto">

        <table {{ $attributes->merge(['class' => 'min-w-full divide-y divide-gray-200']) }}>

            @isset($head)
                <thead class="bg-gray-50">
                    {{ $head }}
                </thead>
            @endisset

            @isset($body)
                <tbody class="divide-y divide-gray-100 bg-white">
                    {{ $body }}
                </tbody>
            @endisset

        </table>

    </div>

</div>