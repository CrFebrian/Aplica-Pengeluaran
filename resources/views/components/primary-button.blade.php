<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-xs bg-inverse-primary border-2 border-inverse-primary text-white font-display text-title-sm py-sm px-md uppercase tracking-wider neo-shadow-primary hover:bg-primary-container transition-colors active:translate-x-[4px] active:translate-y-[4px]']) }}>
    {{ $slot }}
</button>