<nav class="flex items-center gap-3">
    @auth
        <a
            href="{{ url('/dashboard') }}"
            class="border-2 border-black dark:border-outline-variant bg-white dark:bg-surface-container px-3 py-1.5 font-display text-xs font-bold text-black dark:text-on-surface shadow-[3px_3px_0px_0px_#000] dark:shadow-[3px_3px_0px_0px_#3f3f46] transition-all hover:-translate-y-0.5 hover:shadow-[6px_6px_0px_0px_#000] dark:hover:shadow-[6px_6px_0px_0px_#3f3f46] active:translate-y-0 active:shadow-[2px_2px_0px_0px_#000] sm:px-5 sm:py-2 sm:text-sm sm:shadow-[4px_4px_0px_0px_#000] dark:sm:shadow-[4px_4px_0px_0px_#3f3f46]"
        >
            Dashboard
        </a>
    @else
        <a
            href="{{ route('login') }}"
            class="border-2 border-black dark:border-outline-variant bg-white dark:bg-surface-container px-3 py-1.5 font-display text-xs font-bold text-black dark:text-on-surface shadow-[3px_3px_0px_0px_#000] dark:shadow-[3px_3px_0px_0px_#3f3f46] transition-all hover:-translate-y-0.5 hover:shadow-[6px_6px_0px_0px_#000] dark:hover:shadow-[6px_6px_0px_0px_#3f3f46] active:translate-y-0 active:shadow-[2px_2px_0px_0px_#000] sm:px-5 sm:py-2 sm:text-sm sm:shadow-[4px_4px_0px_0px_#000] dark:sm:shadow-[4px_4px_0px_0px_#3f3f46]"
        >
            Masuk
        </a>

        @if (Route::has('register'))
            <a
                href="{{ route('register') }}"
                class="border-2 border-black dark:border-outline-variant bg-indigo-500 px-3 py-1.5 font-display text-xs font-bold text-white shadow-[3px_3px_0px_0px_#000] dark:shadow-[3px_3px_0px_0px_#3f3f46] transition-all hover:-translate-y-0.5 hover:shadow-[6px_6px_0px_0px_#000] dark:hover:shadow-[6px_6px_0px_0px_#3f3f46] active:translate-y-0 active:shadow-[2px_2px_0px_0px_#000] sm:px-5 sm:py-2 sm:text-sm sm:shadow-[4px_4px_0px_0px_#000] dark:sm:shadow-[4px_4px_0px_0px_#3f3f46]"
            >
                Daftar
            </a>
        @endif
    @endauth
</nav>