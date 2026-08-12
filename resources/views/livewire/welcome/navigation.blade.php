<nav class="flex items-center gap-3">
    @auth
        <a
            href="{{ url('/dashboard') }}"
            class="rounded-base border-2 border-border bg-white px-5 py-2 font-bold text-black shadow-brutal-sm transition hover:-translate-y-0.5 hover:shadow-brutal"
        >
            Dashboard
        </a>
    @else
        <a
            href="{{ route('login') }}"
            class="rounded-base border-2 border-border bg-white px-5 py-2 font-bold text-black shadow-brutal-sm transition hover:-translate-y-0.5 hover:shadow-brutal"
        >
            Masuk
        </a>

        @if (Route::has('register'))
            <a
                href="{{ route('register') }}"
                class="rounded-base border-2 border-border bg-main px-5 py-2 font-bold text-black shadow-brutal-sm transition hover:-translate-y-0.5 hover:shadow-brutal"
            >
                Daftar
            </a>
        @endif
    @endauth
</nav>