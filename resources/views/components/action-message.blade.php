@props(['on'])

<div x-data="{ shown: false, timeout: null }"
     x-init="@this.on('{{ $on }}', () => { clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 2000); })"
     x-show.transition.out.opacity.duration.1500ms="shown"
     x-transition:leave.opacity.duration.1500ms
     style="display: none;"
    {{ $attributes->merge(['class' => 'inline-flex items-center gap-1 px-sm py-1.5 bg-secondary border-2 border-outline-variant text-on-secondary font-sans text-label-caps font-bold']) }}>
    <span class="material-symbols-outlined text-base">check_circle</span>
    {{ $slot->isEmpty() ? __('Tersimpan.') : $slot }}
</div>