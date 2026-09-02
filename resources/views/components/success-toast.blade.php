<div
    x-data="{
        show: false,
        message: '',
        timer: null,
        openToast(text) {
            clearTimeout(this.timer);
            this.message = text;
            this.show = true;
            this.timer = setTimeout(() => { this.show = false }, 2600);
        }
    }"
    x-on:notify-success.window="openToast($event.detail.message ?? $event.detail[0]?.message ?? 'Data berhasil disimpan')"
    x-cloak
    class="fixed inset-0 z-[10000] flex items-start justify-center pointer-events-none px-4"
>
    <div
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 -translate-y-4 scale-95"
        class="mt-20 md:mt-8 pointer-events-auto flex items-center gap-xs sm:gap-sm bg-surface border-2 border-outline-variant neo-shadow-success px-sm py-xs sm:px-md sm:py-sm max-w-xs sm:max-w-sm w-full"
        role="status"
        aria-live="polite"
    >
        {{-- Animasi centang: lingkaran + check di-gambar (stroke draw-in), murni SVG+CSS, ikut tema --}}
        <svg
            x-show="show"
            x-init="$watch('show', value => { if (value) { $el.classList.remove('success-tick-play'); void $el.offsetWidth; $el.classList.add('success-tick-play'); } })"
            class="success-tick shrink-0"
            width="28" height="28" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg"
        >
            <circle class="success-tick-circle" cx="26" cy="26" r="23" fill="none" stroke="#22c55e" stroke-width="4"/>
            <path class="success-tick-check" fill="none" stroke="#22c55e" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" d="M14 27l7 7 17-17"/>
        </svg>

        <p class="font-sans text-sm sm:text-body-md font-bold text-on-surface leading-snug" x-text="message"></p>

        <button
            type="button"
            @click="show = false"
            aria-label="Tutup notifikasi"
            class="ml-auto shrink-0 text-on-surface-variant hover:text-on-surface transition-colors"
        >
            <span class="material-symbols-outlined" style="font-size: 20px;">close</span>
        </button>
    </div>
</div>
