function toggleMenu() {

    const mobileMenu = document.getElementById('mobileMenu');
    const menuIcon   = document.getElementById('menu-icon');
    const closeIcon  = document.getElementById('close-icon');

    if (!mobileMenu) return;

    const isHidden = mobileMenu.classList.contains('hidden');

    mobileMenu.classList.toggle('hidden');

    menuIcon?.classList.toggle('hidden');
    closeIcon?.classList.toggle('hidden');

    document.body.style.overflow = isHidden ? 'hidden' : 'auto';
}


// DOM READY
document.addEventListener('DOMContentLoaded', function() {

    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobileMenu'); // ✅ CORREGIDO

    if (!menuToggle || !mobileMenu) return;

    // CLICK BOTÓN
    menuToggle.addEventListener('click', toggleMenu);

    // LINKS
    const mobileLinks = mobileMenu.querySelectorAll('a');
    mobileLinks.forEach(link => {
        link.addEventListener('click', function() {
            mobileMenu.classList.add('hidden');

            document.getElementById('menu-icon')?.classList.remove('hidden');
            document.getElementById('close-icon')?.classList.add('hidden');

            document.body.style.overflow = 'auto';
        });
    });

    // ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
            toggleMenu();
        }
    });

    // CLICK FUERA
    mobileMenu.addEventListener('click', function(e) {
        if (e.target === mobileMenu) {
            toggleMenu();
        }
    });

});