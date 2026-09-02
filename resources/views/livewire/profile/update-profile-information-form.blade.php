<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section class="flex flex-col gap-sm">
    <header>
        <h3 class="font-display text-title-sm text-on-surface">
            {{ __('Informasi Profil') }}
        </h3>

        <p class="font-sans text-body-md text-on-surface-variant mt-1">
            {{ __('Perbarui nama dan alamat email akunmu.') }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="flex flex-col gap-md">
        <div class="flex flex-col gap-xs">
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input wire:model="name" id="name" name="name" type="text" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div class="flex flex-col gap-xs">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" name="email" type="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div class="bg-warning/10 border-2 border-warning p-sm flex flex-col gap-1">
                    <p class="font-sans text-body-md text-on-surface">
                        {{ __('Alamat emailmu belum diverifikasi.') }}

                        <button wire:click.prevent="sendVerification" class="font-bold text-primary hover:underline">
                            {{ __('Klik di sini untuk kirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="font-sans text-body-md font-bold text-secondary">
                            {{ __('Link verifikasi baru sudah dikirim ke emailmu.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-sm">
            <button type="submit" wire:loading.attr="disabled" class="px-6 py-2 bg-primary text-white border-2 border-black font-sans text-label-caps font-bold shadow-[4px_4px_0px_0px_#000000] active:translate-x-[2px] active:translate-y-[2px] active:shadow-[2px_2px_0px_0px_#000000] transition-all uppercase">
                <span wire:loading.remove wire:target="updateProfileInformation">{{ __('Simpan') }}</span>
                <span wire:loading wire:target="updateProfileInformation">{{ __('Menyimpan...') }}</span>
            </button>

            <x-action-message on="profile-updated">
                {{ __('Tersimpan.') }}
            </x-action-message>
        </div>
    </form>
</section>