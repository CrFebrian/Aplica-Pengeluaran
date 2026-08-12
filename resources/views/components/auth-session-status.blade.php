@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-sans text-sm font-semibold text-secondary bg-secondary-container/10 border-2 border-secondary-container px-sm py-xs']) }}>
        {{ $status }}
    </div>
@endif
