const storageKey = 'library-alhasra-theme';
const root = document.documentElement;
const systemPreference = typeof window.matchMedia === 'function'
    ? window.matchMedia('(prefers-color-scheme: dark)')
    : null;

function readStoredTheme() {
    try {
        const theme = window.localStorage.getItem(storageKey);
        return theme === 'light' || theme === 'dark' ? theme : null;
    } catch (error) {
        return null;
    }
}

function applyTheme(theme) {
    const isDark = theme === 'dark';
    root.classList.toggle('dark', isDark);

    document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
        const actionLabel = isDark ? 'Aktifkan mode terang' : 'Aktifkan mode gelap';
        button.setAttribute('aria-label', actionLabel);
        button.setAttribute('aria-pressed', String(isDark));
        button.setAttribute('title', actionLabel);

        button.querySelectorAll('[data-theme-icon]').forEach((icon) => {
            const shouldHide = (icon.dataset.themeIcon === 'sun') !== isDark;
            icon.hidden = shouldHide;
            icon.classList.toggle('hidden', shouldHide);
        });

        const label = button.querySelector('[data-theme-toggle-label]');
        if (label) {
            label.textContent = actionLabel;
        }
    });
}

let hasManualPreference = readStoredTheme() !== null;
applyTheme(readStoredTheme() ?? (systemPreference?.matches ? 'dark' : 'light'));

document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
    button.addEventListener('click', () => {
        const nextTheme = root.classList.contains('dark') ? 'light' : 'dark';
        hasManualPreference = true;

        try {
            window.localStorage.setItem(storageKey, nextTheme);
        } catch (error) {
            // The current page still changes theme when storage is unavailable.
        }

        applyTheme(nextTheme);
    });
});

systemPreference?.addEventListener('change', (event) => {
    if (!hasManualPreference) {
        applyTheme(event.matches ? 'dark' : 'light');
    }
});

window.addEventListener('storage', (event) => {
    if (event.key === storageKey || event.key === null) {
        const storedTheme = readStoredTheme();
        hasManualPreference = storedTheme !== null;
        applyTheme(storedTheme ?? (systemPreference?.matches ? 'dark' : 'light'));
    }
});
