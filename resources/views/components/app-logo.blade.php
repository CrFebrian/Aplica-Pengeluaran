<img
    src="{{ asset('images/logo.png') }}"
    alt="{{ config('app.name', 'KapanRich') }}"
    {{ $attributes->merge(['class' => "$size object-contain shrink-0"]) }}
    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
>
<div class="hidden {{ $size }} shrink-0 items-center justify-center border-2 border-outline-variant bg-primary font-display font-black text-white {{ $fallbackClass }}">
    K
</div>
