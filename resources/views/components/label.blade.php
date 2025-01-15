@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-[11px] text-gray-700 ']) }}>
    {{ $value ?? $slot }}
</label>
