<script>
    (() => {
        const storageKey = 'library-alhasra-theme';
        let theme = null;

        try {
            const savedTheme = localStorage.getItem(storageKey);
            if (savedTheme === 'light' || savedTheme === 'dark') {
                theme = savedTheme;
            }
        } catch (error) {
            // Continue with the device preference if local storage is unavailable.
        }

        if (theme === null) {
            try {
                theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            } catch (error) {
                theme = 'light';
            }
        }

        document.documentElement.classList.toggle('dark', theme === 'dark');
    })();
</script>
