@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full bg-surface-container border-2 border-outline py-sm px-sm font-sans text-mono-data text-on-background placeholder:text-outline-variant focus:border-inverse-primary focus:outline-none focus:-translate-y-1 focus:-translate-x-1 neo-shadow focus:neo-shadow-focus rounded-none']) }}>