let index = 0;
const carousel = document.getElementById('carousel');
const dots = document.querySelectorAll('.dot');
const sound = new Audio('audio/transition-ui-militar.mp3');

function updateCarousel() {
    carousel.style.transform = `translateX(-${index * 100}vw)`;
    dots.forEach(d => d.classList.remove('active'));
    dots[index].classList.add('active');
    sound.currentTime = 0;
    sound.play();
}

function nextSlide() {
    index = (index + 1) % 3;
    updateCarousel();
}

function prevSlide() {
    index = (index - 1 + 3) % 3;
    updateCarousel();
}

function goSlide(i) {
    index = i;
    updateCarousel();
}

setInterval(nextSlide, 6000);
updateCarousel();
