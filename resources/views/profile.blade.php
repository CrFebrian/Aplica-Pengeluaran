<x-app-layout>

    <h2 class="font-display text-headline-md text-on-surface uppercase">Profil</h2>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-md items-start">
        <div class="bg-surface-container border-2 border-outline-variant neo-shadow p-md">
            <livewire:profile.update-profile-information-form />
        </div>
        <div class="bg-surface-container border-2 border-outline-variant neo-shadow p-md">
            <livewire:profile.update-password-form />
        </div>
        <div class="lg:col-span-2 bg-surface-container border-2 border-tertiary neo-shadow-danger p-md">
            <livewire:profile.delete-user-form />
        </div>
    </div>
    
</x-app-layout>
