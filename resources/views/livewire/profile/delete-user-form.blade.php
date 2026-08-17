<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="flex flex-col gap-sm">
    <header class="flex items-center gap-xs">
        <span class="material-symbols-outlined text-tertiary">warning</span>
        <h3 class="font-display text-title-sm text-tertiary">
            {{ __('Hapus Akun') }}
        </h3>
    </header>

    <p class="font-sans text-body-md text-on-surface-variant">
        {{ __('Setelah akunmu dihapus, semua data — transaksi, kategori, catatan hutang — akan dihapus permanen. Unduh atau catat data yang ingin kamu simpan sebelum melanjutkan.') }}
    </p>

    <div>
        <x-danger-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        >{{ __('Hapus Akun') }}</x-danger-button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="flex flex-col">

            <div class="p-md border-b-2 border-outline-variant bg-surface-container flex items-center gap-xs">
                <span class="material-symbols-outlined text-tertiary">warning</span>
                <h2 class="font-display text-title-sm text-on-surface">
                    {{ __('Yakin Ingin Menghapus Akun?') }}
                </h2>
            </div>

            <div class="p-md flex flex-col gap-md">
                <p class="font-sans text-body-md text-on-surface-variant">
                    {{ __('Tindakan ini tidak bisa dibatalkan. Semua data akan dihapus permanen. Masukkan password untuk konfirmasi.') }}
                </p>

                <div class="flex flex-col gap-xs">
                    <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                    <x-text-input
                        wire:model="password"
                        id="password"
                        name="password"
                        type="password"
                        placeholder="{{ __('Password') }}"
                    />

                    <x-input-error :messages="$errors->get('password')" />
                </div>
            </div>

            <div class="p-md border-t-2 border-outline-variant bg-surface-container flex justify-end gap-sm">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button>
                    {{ __('Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>