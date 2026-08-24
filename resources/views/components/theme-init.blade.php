<!-- Theme Init Script -->
<script>
    (function () {
        const stored = localStorage.getItem('theme');
        const isDark = stored ? stored === 'dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (isDark) document.documentElement.classList.add('dark');
    })();
</script>