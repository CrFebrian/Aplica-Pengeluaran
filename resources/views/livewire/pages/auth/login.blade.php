<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <p class="font-sans text-body-md text-on-surface-variant mb-md">
        Masukkan Email untuk mengakses akunmu.
    </p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-md block" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-md bg-surface p-md border-2 border-outline-variant neo-shadow relative">

        <!-- Decorative badge -->
        <div class="absolute -top-3 -right-3 bg-secondary-container text-on-secondary-container border-2 border-on-secondary-container px-xs py-base font-sans text-label-caps font-bold rotate-3 shadow-[2px_2px_0px_0px_#002114]">
            AMAN
        </div>

        <!-- Email Address -->
        <div class="flex flex-col gap-xs">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="form.email" id="email" type="email" name="email" required autofocus autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('form.email')" />
        </div>

        <!-- Password -->
        <div class="flex flex-col gap-xs">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input wire:model="form.password" id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('form.password')" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember" class="inline-flex items-center gap-xs cursor-pointer">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded-none border-2 border-outline bg-surface-container text-inverse-primary focus:ring-inverse-primary focus:ring-offset-0" name="remember">
                <span class="font-sans text-body-md text-on-surface-variant">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="font-sans text-body-md text-primary hover:text-primary-fixed transition-colors underline decoration-2 underline-offset-4" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <div class="pt-sm">
            <x-primary-button class="w-full">
                {{ __('Masuk') }}
                <span class="material-symbols-outlined text-[20px]">login</span>
            </x-primary-button>
        </div>
    </form>

    <div class="mt-md text-center md:text-left">
        <a class="font-sans text-body-md text-on-surface hover:text-primary transition-colors" href="{{ route('register') }}" wire:navigate>
            Belum punya akun?
        </a>
    </div>
</div>