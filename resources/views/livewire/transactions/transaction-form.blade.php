<div>
    @if ($showModal)
        {{-- Overlay --}}
        <div class="fixed inset-0 z-[60] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" wire:click="closeModal"></div>

            {{-- Modal Panel --}}
            <div class="relative bg-surface border-2 border-outline neo-shadow w-full max-w-md flex flex-col max-h-[90vh]">

                {{-- Modal Header --}}
                <div class="flex justify-between items-center p-md border-b-2 border-outline bg-surface-container shrink-0">
                    <h2 class="font-display text-headline-md text-on-surface">TAMBAH TRANSAKSI BARU</h2>
                    <button wire:click="closeModal" type="button" class="p-2 border-2 border-outline bg-surface hover:bg-surface-container-high transition-colors group">
                        <span class="material-symbols-outlined text-on-surface group-hover:text-tertiary transition-colors">close</span>
                    </button>
                </div>

                {{-- Modal Content --}}
                <form wire:submit="save" class="flex flex-col overflow-y-auto">
                    <div class="p-md flex flex-col gap-md">

                        {{-- Type Tabs --}}
                        <div class="flex gap-2">
                            <button type="button" wire:click="$set('type', 'income')"
                                class="flex-1 border-2 border-outline py-2 text-center font-display text-title-sm transition-colors {{ $type === 'income' ? 'bg-secondary text-on-secondary neo-shadow-success' : 'bg-surface text-on-surface-variant hover:bg-surface-container-high' }}">
                                Pemasukan
                            </button>
                            <button type="button" wire:click="$set('type', 'expense')"
                                class="flex-1 border-2 border-outline py-2 text-center font-display text-title-sm transition-colors {{ $type === 'expense' ? 'bg-tertiary text-on-tertiary neo-shadow-danger' : 'bg-surface text-on-surface-variant hover:bg-surface-container-high' }}">
                                Pengeluaran
                            </button>
                        </div>

                        {{-- Title --}}
                        <div class="flex flex-col gap-xs">
                            <x-input-label for="title" value="JUDUL TRANSAKSI" />
                            <x-text-input wire:model="title" id="title" type="text" placeholder="Contoh: Makan Siang" />
                            <x-input-error :messages="$errors->get('title')" />
                        </div>

                        {{-- Amount --}}
                        <div class="flex flex-col gap-xs">
                            <x-input-label for="amount" value="NOMINAL" />
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 font-display text-headline-md text-secondary pointer-events-none">Rp</span>
                                <input wire:model="amount" id="amount" type="number" min="0" step="1" placeholder="0"
                                    class="w-full bg-surface-container border-2 border-outline h-16 pl-14 pr-4 font-display text-headline-md text-on-surface text-right focus:border-primary focus:ring-0 focus:outline-none transition-colors rounded-none" />
                            </div>
                            <x-input-error :messages="$errors->get('amount')" />
                        </div>

                        {{-- Category + Date --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-xs">
                                <x-input-label for="category_id" value="KATEGORI" />
                                <div class="relative">
                                    <select wire:model="category_id" id="category_id"
                                        class="w-full bg-surface-container border-2 border-outline h-12 px-4 font-sans text-on-surface appearance-none focus:border-primary focus:ring-0 focus:outline-none cursor-pointer rounded-none">
                                        <option value="">Pilih kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">expand_more</span>
                                </div>
                                <x-input-error :messages="$errors->get('category_id')" />

                                @if ($categories->isEmpty())
                                    <p class="font-sans text-sm text-warning">
                                        Belum ada kategori {{ $type === 'income' ? 'pemasukan' : 'pengeluaran' }}.
                                        <a href="{{ Route::has('categories.index') ? route('categories.index') : '#' }}" class="underline">Buat dulu di sini.</a>
                                    </p>
                                @endif
                            </div>

                            <div class="flex flex-col gap-xs">
                                <x-input-label for="transaction_date" value="TANGGAL" />
                                <input wire:model="transaction_date" id="transaction_date" type="date"
                                    class="w-full bg-surface-container border-2 border-outline h-12 px-4 font-sans text-on-surface focus:border-primary focus:ring-0 focus:outline-none cursor-pointer rounded-none" />
                                <x-input-error :messages="$errors->get('transaction_date')" />
                            </div>
                        </div>

                        {{-- Note --}}
                        <div class="flex flex-col gap-xs">
                            <x-input-label for="note" value="KETERANGAN" />
                            <textarea wire:model="note" id="note" rows="3" placeholder="Tambahkan catatan..."
                                class="w-full bg-surface-container border-2 border-outline p-4 font-sans text-on-surface resize-none focus:border-primary focus:ring-0 focus:outline-none transition-colors rounded-none"></textarea>
                            <x-input-error :messages="$errors->get('note')" />
                        </div>
                    </div>

                    {{-- Modal Footer --}}
                    <div class="p-md border-t-2 border-outline bg-surface-container mt-auto shrink-0">
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