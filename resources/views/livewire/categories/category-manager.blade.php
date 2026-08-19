@php
    $iconFor = function (string $name) {
        $name = strtolower($name);
        return match (true) {
            str_contains($name, 'makan') || str_contains($name, 'minum') => 'restaurant',
            str_contains($name, 'bensin') || str_contains($name, 'transport') || str_contains($name, 'bbm') => 'directions_car',
            str_contains($name, 'gaji') || str_contains($name, 'freelance') || str_contains($name, 'usaha') => 'payments',
            str_contains($name, 'listrik') || str_contains($name, 'tagihan') || str_contains($name, 'internet') => 'receipt_long',
            str_contains($name, 'belanja') => 'shopping_bag',
            str_contains($name, 'hiburan') || str_contains($name, 'nonton') || str_contains($name, 'film') => 'movie',
            str_contains($name, 'jajan') || str_contains($name, 'bonus') || str_contains($name, 'hadiah') => 'redeem',
            default => 'label',
        };
    };
@endphp

<div class="flex flex-col gap-md">
    <div class="flex flex-col gap-4 mb-4">
        <div>
            <h2 class="font-display text-headline-md text-on-surface uppercase">Pengaturan Kategori</h2>
            <p class="font-sans text-base sm:text-lg text-on-surface-variant mt-1">Atur kategori pemasukan dan pengeluaranmu di sini!</p>
        </div>

        <button wire:click="openCreateModal"
            class="w-full bg-primary text-white font-display text-sm md:text-title-sm py-2 md:py-3 px-sm md:px-md border-2 border-outline-variant shadow-[4px_4px_0px_0px_#4f46e5] md:shadow-[6px_6px_0px_0px_#4f46e5] active:shadow-[2px_2px_0px_0px_#4f46e5] active:translate-x-[4px] active:translate-y-[4px] transition-all flex items-center justify-center gap-1.5 md:gap-2">
            <span class="material-symbols-outlined text-lg md:text-2xl">add</span>
            TAMBAH KATEGORI
        </button>
    </div>

    <div class="grid grid-cols-2 gap-sm md:max-w-md">
        <button wire:click="setActiveType('income')"
            class="py-2 md:py-3 border-2 font-display text-sm md:text-title-sm transition-all {{ $activeType === 'income' ? 'bg-secondary text-on-secondary border-outline-variant shadow-[3px_3px_0px_0px_rgb(var(--color-shadow-ink))] md:shadow-[4px_4px_0px_0px_rgb(var(--color-shadow-ink))]' : 'bg-surface-container text-on-surface-variant border-outline-variant hover:bg-surface-container-high' }}">
            PEMASUKAN
        </button>
        <button wire:click="setActiveType('expense')"
            class="py-2 md:py-3 border-2 font-display text-sm md:text-title-sm transition-all {{ $activeType === 'expense' ? 'bg-tertiary text-on-tertiary border-outline-variant shadow-[3px_3px_0px_0px_rgb(var(--color-shadow-ink))] md:shadow-[4px_4px_0px_0px_rgb(var(--color-shadow-ink))]' : 'bg-surface-container text-on-surface-variant border-outline-variant hover:bg-surface-container-high' }}">
            PENGELUARAN
        </button>
    </div>

    @if ($deleteError)
        <div class="bg-tertiary/10 border-2 border-tertiary p-sm flex items-start gap-2">
            <span class="material-symbols-outlined text-tertiary">error</span>
            <p class="font-sans text-body-md text-on-surface">{{ $deleteError }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-sm">
        @forelse ($categories as $category)
            <div wire:key="cat-{{ $category->id }}"
                class="bg-surface-container border-2 border-outline-variant p-2 md:p-sm shadow-[3px_3px_0px_0px_rgb(var(--color-shadow-ink))] md:shadow-[4px_4px_0px_0px_rgb(var(--color-shadow-ink))] flex items-center justify-between gap-sm">
                <div class="flex items-center gap-2 md:gap-sm min-w-0">
                    <div class="w-8 h-8 md:w-11 md:h-11 shrink-0 flex items-center justify-center border-2 border-outline-variant bg-surface">
                        <span class="material-symbols-outlined text-on-surface text-lg md:text-2xl">{{ $iconFor($category->name) }}</span>
                    </div>
                    <span class="font-sans text-sm md:text-body-lg text-on-surface truncate">{{ $category->name }}</span>
                </div>

                <div class="flex items-center gap-1.5 md:gap-2 shrink-0">
                    <button wire:click="openEditModal({{ $category->id }})" aria-label="Edit"
                        class="w-8 h-8 md:w-10 md:h-10 flex items-center justify-center border-2 border-outline-variant bg-surface hover:bg-surface-container-high transition-colors">
                        <span class="material-symbols-outlined text-primary text-base md:text-xl">edit</span>
                    </button>
                    <button wire:click="delete({{ $category->id }})" wire:confirm="Hapus kategori \"{{ $category->name }}\"?" aria-label="Hapus"
                        class="w-8 h-8 md:w-10 md:h-10 flex items-center justify-center border-2 border-outline-variant bg-surface hover:bg-tertiary/10 transition-colors">
                        <span class="material-symbols-outlined text-tertiary text-base md:text-xl">delete</span>
                    </button>
                </div>
            </div>
        @empty
            <div class="bg-surface-container border-2 border-outline-variant p-md md:p-lg text-center">
                <p class="font-sans text-sm md:text-body-md text-on-surface-variant">
                    Belum ada kategori {{ $activeType === 'income' ? 'pemasukan' : 'pengeluaran' }}.
                </p>
            </div>
        @endforelse
    </div>

    @if ($showModal)
        <div class="!fixed !inset-0 z-[9999] w-screen h-screen flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" wire:click="closeModal"></div>

            <div class="relative bg-surface border-2 border-outline neo-shadow w-full max-w-md flex flex-col">
                <div class="flex justify-between items-center p-md border-b-2 border-outline bg-surface-container">
                    <h2 class="font-display text-headline-md text-on-surface">
                        {{ $editingId ? 'EDIT KATEGORI' : 'KATEGORI BARU' }}
                    </h2>
                    <button wire:click="closeModal" type="button" class="p-2 border-2 border-outline bg-surface hover:bg-surface-container-high transition-colors group">
                        <span class="material-symbols-outlined text-on-surface group-hover:text-tertiary transition-colors">close</span>
                    </button>
                </div>

                <form wire:submit="save" class="flex flex-col">
                    <div class="p-md flex flex-col gap-md">
                        <div class="flex flex-col gap-xs">
                            <x-input-label for="name" value="NAMA KATEGORI" />
                            <x-text-input wire:model="name" id="name" type="text" placeholder="Contoh: Makan Siang" autofocus />
                            <x-input-error :messages="$errors->get('name')" />
                        </div>

                        @unless ($editingId)
                            <p class="font-sans text-sm text-on-surface-variant">
                                Tipe: <span class="font-bold {{ $activeType === 'income' ? 'text-secondary' : 'text-tertiary' }}">
                                    {{ $activeType === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                </span>
                            </p>
                        @endunless
                    </div>

                    <div class="p-md border-t-2 border-outline bg-surface-container">
                        <button type="submit"
                            class="w-full bg-primary text-white font-display text-title-sm py-4 border-2 border-outline neo-shadow-primary active:translate-x-[2px] active:translate-y-[2px] active:shadow-[4px_4px_0px_0px_#4f46e5] transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">save</span>
                            SIMPAN
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>