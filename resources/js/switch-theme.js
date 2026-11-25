const changeColorButton = document.getElementById('theme-toggle');
const moonIcon = document.getElementById('theme-icon-moon');
const sunIcon = document.getElementById('theme-icon-sun');

if (changeColorButton && moonIcon && sunIcon) {
    const systemTheme = window.matchMedia('(prefers-color-scheme: dark)');
    const savedTheme = localStorage.getItem('theme');
    const hasSavedTheme = savedTheme === 'dark' || savedTheme === 'light';

    function applyTheme(theme) {
        const isDark = theme === 'dark';

        document.documentElement.classList.toggle('dark', isDark);
        document.documentElement.classList.toggle('light', !isDark);
        moonIcon.style.display = isDark ? 'none' : 'block';
        sunIcon.style.display = isDark ? 'block' : 'none';
        changeColorButton.setAttribute('aria-pressed', String(isDark));
        changeColorButton.setAttribute(
            'aria-label',
            isDark ? changeColorButton.dataset.darkLabel : changeColorButton.dataset.lightLabel
        );
    }

    applyTheme(hasSavedTheme ? savedTheme : systemTheme.matches ? 'dark' : 'light');

    if (!hasSavedTheme) {
        systemTheme.addEventListener('change', (event) => {
            const currentTheme = localStorage.getItem('theme');

            if (currentTheme !== 'dark' && currentTheme !== 'light') {
                applyTheme(event.matches ? 'dark' : 'light');
            }
        });
    }

    changeColorButton.addEventListener('click', () => {
        const theme = document.documentElement.classList.contains('dark') ? 'light' : 'dark';

        localStorage.setItem('theme', theme);
        applyTheme(theme);
    });
}
