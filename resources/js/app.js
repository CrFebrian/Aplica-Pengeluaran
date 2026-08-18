// Alpine.js sendiri disuntik otomatis oleh Livewire 3 (tidak perlu install/import manual).
document.addEventListener('alpine:init', () => {
    Alpine.store('theme', {
        // Prioritas: localStorage (pilihan manual user) > preferensi sistem browser.
        dark: localStorage.getItem('theme')
            ? localStorage.getItem('theme') === 'dark'
            : window.matchMedia('(prefers-color-scheme: dark)').matches,

        toggle() {
            this.dark = !this.dark;
            localStorage.setItem('theme', this.dark ? 'dark' : 'light');
            document.documentElement.classList.toggle('dark', this.dark);
        },
    });
});

function applyStoredTheme() {
    const stored = localStorage.getItem('theme');
    const isDark = stored ? stored === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
    document.documentElement.classList.toggle('dark', isDark);

    if (window.Alpine && Alpine.store('theme')) {
        Alpine.store('theme').dark = isDark;
    }
}

document.addEventListener('livewire:navigated', applyStoredTheme);