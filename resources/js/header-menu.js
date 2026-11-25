const menuButton = document.getElementById('header__menu');
const iconsContainer = document.getElementById('header__icons');
const menuIcon = document.getElementById('menu__icon');
const closeMenuIcon = document.getElementById('close__menu__icon');
const mobileNav = document.getElementById('mobile__nav');

menuButton.style.display = 'none';

function toggleMenu() {
    let isMenuOpen = false;
    menuIcon.style.display = 'block';
    closeMenuIcon.style.display = 'none';
    menuButton.style.display = 'block';

    menuButton.addEventListener('click', () => {
        if (!isMenuOpen) {
            menuIcon.style.display = 'none';
            closeMenuIcon.style.display = 'block';
            iconsContainer.style.zIndex = '1000';
            isMenuOpen = true;
            mobileNav.style.transform = 'translateY(0)';
            document.body.style.overflow = 'hidden';
        } else {
            menuIcon.style.display = 'block';
            closeMenuIcon.style.display = 'none';
            isMenuOpen = false;
            mobileNav.style.transform = 'translateY(-100%)';
            iconsContainer.style.zIndex = '100';
            document.body.style.overflow = 'auto';
        }
    });
}

if (window.innerWidth <= 768) {
    toggleMenu();
}

addEventListener('resize', () => {
    if (window.innerWidth <= 768) {
        toggleMenu();
    } else {
        menuButton.style.display = 'none';
        mobileNav.style.transform = 'translateY(-100%)';
        iconsContainer.style.zIndex = '100';
        document.body.style.overflow = 'auto';
    }
});