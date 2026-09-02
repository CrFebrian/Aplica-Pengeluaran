@if ($paginator->hasPages())
    <div class="flex flex-wrap items-center justify-between gap-sm mt-2 pt-sm border-t-2 border-outline-variant">
        <span class="font-sans text-label-caps text-on-surface-variant">
            Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}
            <span class="hidden sm:inline">&middot; {{ $paginator->total() }} transaksi</span>
        </span>

        <div class="flex items-center gap-xs">
            {{-- Prev --}}
            <button type="button"
                wire:click="gotoPage({{ $paginator->currentPage() - 1 }}, '{{ $pageName }}')"
                @if ($paginator->onFirstPage()) disabled @endif
                class="w-9 h-9 flex items-center justify-center border-2 border-outline-variant bg-surface-container font-sans font-bold transition-all
                    {{ $paginator->onFirstPage()
                        ? 'opacity-40 cursor-not-allowed'
                        : 'hover:bg-surface-container-high shadow-[3px_3px_0px_0px_rgb(var(--color-shadow-ink))] active:translate-x-[1px] active:translate-y-[1px] active:shadow-[1px_1px_0px_0px_rgb(var(--color-shadow-ink))]' }}"
                aria-label="Halaman sebelumnya">
                <span class="material-symbols-outlined text-lg">chevron_left</span>
            </button>

            {{-- NEW: dropdown lompat langsung ke nomor halaman tertentu --}}
            <select
                wire:change="gotoPage($event.target.value, '{{ $pageName }}')"
                class="h-9 px-2 border-2 border-outline-variant bg-surface-container font-sans text-body-md font-bold text-on-surface focus:border-primary focus:ring-0 focus:outline-none rounded-none cursor-pointer"
                aria-label="Lompat ke halaman">
                @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                    <option value="{{ $i }}" @selected($i === $paginator->currentPage())>Hal {{ $i }}</option>
                @endfor
            </select>

            {{-- Next --}}
            <button type="button"
                wire:click="gotoPage({{ $paginator->currentPage() + 1 }}, '{{ $pageName }}')"
                @if (! $paginator->hasMorePages()) disabled @endif
                class="w-9 h-9 flex items-center justify-center border-2 border-outline-variant bg-surface-container font-sans font-bold transition-all
                    {{ ! $paginator->hasMorePages()
                        ? 'opacity-40 cursor-not-allowed'
                        : 'hover:bg-surface-container-high shadow-[3px_3px_0px_0px_rgb(var(--color-shadow-ink))] active:translate-x-[1px] active:translate-y-[1px] active:shadow-[1px_1px_0px_0px_rgb(var(--color-shadow-ink))]' }}"
                aria-label="Halaman berikutnya">
                <span class="material-symbols-outlined text-lg">chevron_right</span>
            </button>
        </div>
    </div>
@endif