<div {{ $attributes->merge([
    'class' => 'rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden'
]) }}>

    {{ $slot }}

</div>