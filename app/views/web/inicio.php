<br><br>
<section class="relative z-10 w-full h-[100vh] overflow-hidden pt-28 bg-black"> ">

    <div id="carousel"
         class="flex w-[300%] h-full transition-transform duration-700 ease-in-out">

        <!-- SLIDE 1 -->
        <div class="relative w-screen h-full flex-shrink-0 bg-cover bg-center scale-110 animate-[zoom_20s_linear_infinite]"

             style="background-image:url('assets/img/hero/hero1.jpg')">
            <div class="absolute inset-0 bg-black/60 flex flex-col items-center justify-center text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-widest text-white
                           animate-pulse
                           drop-shadow-[0_0_12px_rgba(200,152,46,1)]">
                    SIMULACIÓN MILITAR
                </h1>
                <p class="mt-4 text-gray-200 tracking-widest
                          drop-shadow-[0_0_8px_rgba(200,152,46,0.8)]">
                    Realismo táctico total
                </p>
            </div>
        </div>

        <!-- SLIDE 2 -->
        <div class="relative w-screen h-full flex-shrink-0 bg-cover bg-center scale-110 animate-[zoom_20s_linear_infinite]"

             style="background-image:url('assets/img/hero/hero2.jpg')">
            <div class="absolute inset-0 bg-black/60 flex flex-col items-center justify-center text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-widest text-white
                           animate-pulse
                           drop-shadow-[0_0_12px_rgba(200,152,46,1)]">
                    OPERACIONES ESPECIALES
                </h1>
                <p class="mt-4 text-gray-200 tracking-widest
                          drop-shadow-[0_0_8px_rgba(200,152,46,0.8)]">
                    Disciplina · Estrategia · Equipo
                </p>
            </div>
        </div>

        <!-- SLIDE 3 -->
        <div class="relative w-screen h-full flex-shrink-0 bg-cover bg-center scale-110 animate-[zoom_20s_linear_infinite]"

             style="background-image:url('assets/img/hero/hero3.jpg')">
            <div class="absolute inset-0 bg-black/60 flex flex-col items-center justify-center text-center">
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-widest text-white
                           animate-pulse
                           drop-shadow-[0_0_12px_rgba(200,152,46,1)]">
                    COMUNIDAD TÁCTICA
                </h1>
                <p class="mt-4 text-gray-200 tracking-widest
                          drop-shadow-[0_0_8px_rgba(200,152,46,0.8)]">
                    ARMA 3 · TeamSpeak · Hermandad
                </p>
            </div>
        </div>
    </div>

        <!-- BOTONES -->
    <button onclick="prevSlide()"
            class="absolute left-5 top-1/2 -translate-y-1/2
                   text-[#c8982e] text-4xl font-bold
                   hover:scale-110 transition">
        ←
    </button>

    <button onclick="nextSlide()"
            class="absolute right-5 top-1/2 -translate-y-1/2
                   text-[#c8982e] text-4xl font-bold
                   hover:scale-110 transition">
        →
    </button>

    <!-- DOTS -->
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-4">
        <span onclick="goSlide(0)" class="dot"></span>
        <span onclick="goSlide(1)" class="dot"></span>
        <span onclick="goSlide(2)" class="dot"></span>
    </div>

</section>
<script>
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

</script>