@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-sans text-label-caps font-bold text-on-surface-variant uppercase']) }}>
    {{ $value ?? $slot }}
</label>
