const menuButton = document.getElementById('header__menu');
const iconsContainer = document.getElementById('header__icons');
const menuIcon = document.getElementById('menu__icon');
const closeMenuIcon = document.getElementById('close__menu__icon');
const mobileNav = document.getElementById('mobile__nav');

if (menuButton && iconsContainer && menuIcon && closeMenuIcon && mobileNav) {
    const mobileViewport = window.matchMedia('(max-width: 767px)');
    let isMenuOpen = false;

    function setMenuOpen(isOpen) {
        isMenuOpen = isOpen && mobileViewport.matches;
        menuIcon.style.display = isMenuOpen ? 'none' : 'block';
        closeMenuIcon.style.display = isMenuOpen ? 'block' : 'none';
        iconsContainer.style.zIndex = isMenuOpen ? '1000' : '100';
        mobileNav.style.transform = isMenuOpen ? 'translateY(0)' : 'translateY(-100%)';
        mobileNav.setAttribute('aria-hidden', String(!isMenuOpen));
        mobileNav.inert = !isMenuOpen;
        menuButton.setAttribute('aria-expanded', String(isMenuOpen));
        document.body.style.overflow = isMenuOpen ? 'hidden' : 'auto';
    }

    function updateMenuForViewport() {
        menuButton.hidden = !mobileViewport.matches;
        setMenuOpen(false);
    }

    menuButton.addEventListener('click', () => setMenuOpen(!isMenuOpen));
    window.addEventListener('resize', updateMenuForViewport);
    updateMenuForViewport();
}
