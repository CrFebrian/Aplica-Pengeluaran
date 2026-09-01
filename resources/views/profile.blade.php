<x-app-layout>

    <div class="flex items-center gap-3 mb-md page-enter" style="--page-delay: 0ms">
        @if (auth()->user()->avatarUrl())
            <img src="{{ auth()->user()->avatarUrl() }}" alt="Avatar" class="w-12 h-12 sm:w-14 sm:h-14 rounded-full border-2 border-outline-variant bg-surface object-cover shadow-[4px_4px_0px_0px_rgb(var(--color-shadow-ink))]">
        @else
            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full border-2 border-outline-variant bg-secondary flex items-center justify-center shadow-[4px_4px_0px_0px_rgb(var(--color-shadow-ink))]">
                <span class="material-symbols-outlined text-on-secondary text-2xl">person</span>
            </div>
        @endif
        <div class="flex flex-col">
            <h2 class="font-display text-headline-md text-on-surface uppercase leading-tight">{{ auth()->user()->name }}</h2>
            <p class="font-sans text-on-surface-variant text-body-md">{{ auth()->user()->email }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-md items-start">
        <div class="page-enter bg-surface-container border-2 border-outline-variant neo-shadow p-md" style="--page-delay: 100ms">
            <livewire:profile.update-profile-information-form />
        </div>
        <div class="page-enter bg-surface-container border-2 border-outline-variant neo-shadow p-md" style="--page-delay: 180ms">
            <livewire:profile.update-password-form />
        </div>
        <div class="page-enter lg:col-span-2 bg-surface-container border-2 border-tertiary neo-shadow-danger p-md" style="--page-delay: 260ms">
            <livewire:profile.delete-user-form />
        </div>
    </div>

</x-app-layout>
