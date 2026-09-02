<div>
    @if ($showModal)
        <div class="fixed inset-0 z-[60] flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" wire:click="closeModal"></div>

            <div class="relative bg-surface border-2 border-outline neo-shadow w-full max-w-md flex flex-col max-h-[90vh]">

                <div class="flex justify-between items-center p-md border-b-2 border-outline bg-surface-container shrink-0">
                    <h2 class="font-display text-headline-md text-on-surface">CATAT HUTANG BARU</h2>
                    <button wire:click="closeModal" type="button" class="p-2 border-2 border-outline bg-surface hover:bg-surface-container-high transition-colors group">
                        <span class="material-symbols-outlined text-on-surface group-hover:text-tertiary transition-colors">close</span>
                    </button>
                </div>

                <form wire:submit="save" class="flex flex-col overflow-y-auto">
                    <div class="p-md flex flex-col gap-md">

                        <div class="flex flex-col gap-xs">
                            <x-input-label for="creditor_name" value="NAMA PEMBERI HUTANG" />
                            <x-text-input wire:model="creditor_name" id="creditor_name" type="text" placeholder="Contoh: Budi Santoso" />
                            <x-input-error :messages="$errors->get('creditor_name')" />
                        </div>

                        <div class="flex flex-col gap-xs">
                            <x-input-label for="amount" value="NOMINAL" />
                            {{-- NEW: format titik ribuan otomatis saat mengetik, tanpa perlu migrasi/kolom baru --}}
                            <div class="relative"
                                x-data="{
                                    amount: @entangle('amount'),
                                    display: '',
                                    formatFrom(raw) {
                                        raw = String(raw ?? '').replace(/\D/g, '');
                                        return raw ? new Intl.NumberFormat('id-ID').format(raw) : '';
                                    },
                                    onInput(e) {
                                        let raw = e.target.value.replace(/\D/g, '');
                                        this.amount = raw ? parseInt(raw, 10) : '';
                                        this.display = this.formatFrom(raw);
                                    }
                                }"
                                x-init="display = formatFrom(amount)"
                            >
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 font-display text-headline-md text-warning pointer-events-none">Rp</span>
                                <input type="text" inputmode="numeric" autocomplete="off" placeholder="0"
                                    x-model="display" @input="onInput($event)"
                                    class="w-full bg-surface-container border-2 border-outline h-16 pl-14 pr-4 font-display text-headline-md text-on-surface text-right focus:border-primary focus:ring-0 focus:outline-none transition-colors rounded-none" />
                            </div>
                            <x-input-error :messages="$errors->get('amount')" />
                        </div>

                        <div class="flex flex-col gap-xs">
                            <x-input-label for="due_date" value="JATUH TEMPO (OPSIONAL)" />
                            <input wire:model="due_date" id="due_date" type="date"
                                class="w-full bg-surface-container border-2 border-outline h-12 px-4 font-sans text-on-surface focus:border-primary focus:ring-0 focus:outline-none cursor-pointer rounded-none" />
                            <x-input-error :messages="$errors->get('due_date')" />
                        </div>

                        <div class="flex flex-col gap-xs">
                            <x-input-label for="note" value="KETERANGAN" />
                            <textarea wire:model="note" id="note" rows="3" placeholder="Contoh: Pinjaman modal"
                                class="w-full bg-surface-container border-2 border-outline p-4 font-sans text-on-surface resize-none focus:border-primary focus:ring-0 focus:outline-none transition-colors rounded-none"></textarea>
                            <x-input-error :messages="$errors->get('note')" />
                        </div>
                    </div>

                    <div class="p-md border-t-2 border-outline bg-surface-container mt-auto shrink-0">
                        <button type="submit" wire:loading.attr="disabled"
                            class="w-full bg-warning text-on-warning font-display text-title-sm py-4 border-2 border-outline neo-shadow-warning active:translate-x-[2px] active:translate-y-[2px] active:shadow-[4px_4px_0px_0px_#fbbf24] transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined" wire:loading.remove wire:target="save">save</span>
                            <span class="material-symbols-outlined animate-spin" wire:loading wire:target="save">progress_activity</span>
                            <span wire:loading.remove wire:target="save">SIMPAN</span>
                            <span wire:loading wire:target="save">MENYIMPAN...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>