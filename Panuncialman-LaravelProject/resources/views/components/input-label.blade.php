@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-orange-600']) }}>
    {{ $value ?? $slot }}
</label>
