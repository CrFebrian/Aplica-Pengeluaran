@props(['size' => 'h-10 w-10', 'flat' => false])

@php
    $base = "$size flex items-center justify-center transition-all";
    $style = $flat
        ? 'text-primary active:translate-y-0.5'
        : 'border-2 border-on-surface bg-surface text-on-surface shadow-[3px_3px_0px_0px_rgb(var(--color-shadow-ink))] hover:-translate-y-0.5 active:translate-y-0 active:shadow-[1px_1px_0px_0px_rgb(var(--color-shadow-ink))]';
@endphp

<button
    @click="$store.theme.toggle()"
    aria-label="Ganti tema terang/gelap"
    {{ $attributes->merge(['class' => "$base $style"]) }}
>
    <span class="material-symbols-outlined text-lg" x-text="$store.theme.dark ? 'light_mode' : 'dark_mode'"></span>
</button>