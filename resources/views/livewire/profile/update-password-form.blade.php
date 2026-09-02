<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section class="flex flex-col gap-sm">
    <header>
        <h3 class="font-display text-title-sm text-on-surface">
            {{ __('Ubah Password') }}
        </h3>

        <p class="font-sans text-body-md text-on-surface-variant mt-1">
            {{ __('Gunakan password yang panjang dan acak supaya akunmu tetap aman.') }}
        </p>
    </header>

    <form wire:submit="updatePassword" class="flex flex-col gap-md">
        <div class="flex flex-col gap-xs">
            <x-input-label for="update_password_current_password" :value="__('Password Saat Ini')" />
            <x-text-input wire:model="current_password" id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" />
            <x-input-error :messages="$errors->get('current_password')" />
        </div>

        <div class="flex flex-col gap-xs">
            <x-input-label for="update_password_password" :value="__('Password Baru')" />
            <x-text-input wire:model="password" id="update_password_password" name="password" type="password" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="flex flex-col gap-xs">
            <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input wire:model="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <div class="flex items-center gap-sm">
            <button type="submit" wire:loading.attr="disabled" class="px-6 py-2 bg-primary text-white border-2 border-black font-sans text-label-caps font-bold shadow-[4px_4px_0px_0px_#000000] active:translate-x-[2px] active:translate-y-[2px] active:shadow-[2px_2px_0px_0px_#000000] transition-all uppercase">
                <span wire:loading.remove wire:target="updatePassword">{{ __('Simpan') }}</span>
                <span wire:loading wire:target="updatePassword">{{ __('Menyimpan...') }}</span>
            </button>

            <x-action-message on="password-updated">
                {{ __('Tersimpan.') }}
            </x-action-message>
        </div>
    </form>
</section>