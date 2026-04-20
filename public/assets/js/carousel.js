document.addEventListener('DOMContentLoaded', () => {

    let index = 0;

    const carousel = document.getElementById('carousel');
    const dots = document.querySelectorAll('.dot');
    const totalSlides = dots.length || 3;

    const sound = new Audio('audio/transition-ui-militar.mp3');

    function updateCarousel() {
        if (!carousel) return;

        carousel.style.transform = `translateX(-${index * 100}vw)`;

        dots.forEach(d => d.classList.remove('active'));

        if (dots[index]) {
            dots[index].classList.add('active');
        }

        sound.currentTime = 0;
        sound.play().catch(() => {});
    }

    function nextSlide() {
        index = (index + 1) % totalSlides;
        updateCarousel();
    }

    function prevSlide() {
        index = (index - 1 + totalSlides) % totalSlides;
        updateCarousel();
    }

    // 👉 Hacer funciones accesibles al HTML
    window.goSlide = function(i) {
        if (i >= 0 && i < totalSlides) {
            index = i;
            updateCarousel();
        }
    };

    window.nextSlide = nextSlide;
    window.prevSlide = prevSlide;

    if (carousel) {
        setInterval(nextSlide, 6000);
        updateCarousel();
    }

});