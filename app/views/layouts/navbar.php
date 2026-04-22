<header
  class="fixed top-[70px] left-0 z-50 w-full h-20 md:h-20 
         bg-gradient-to-b from-[#2b2b2b] to-[#1a1a1a]
         border-b border-black
         bg-opacity-70
         transition-all duration-300
         hover:bg-opacity-100">

       <div class="max-w-[1400px] h-full mx-auto flex items-center justify-between px-4 md:px-6">

        <!-- Menú hamburguesa para móviles -->
        <button id="menu-toggle" class="md:hidden text-[#c8982e] text-2xl focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                <path id="close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <!-- Menú izquierdo - Desktop -->
        <nav class="hidden md:flex gap-6 lg:gap-10">
            <a href="<?= BASE_URL ?>/"
            data-link
            class="nav-link relative text-sm text-[#c8982e] lg:text-base
                    tracking-widest
                    transition-all duration-300
                    hover:text-[#c8982e]
                    hover:font-bold
                    hover:drop-shadow-[0_0_6px_rgba(200,152,46,0.6)]">
                INICIO
                <span class="underline"></span>
            </a>

            <a href="#multimedia"
            data-link
            class="nav-link relative text-sm lg:text-base
                    text-gray-400
                    tracking-widest
                    transition-all duration-300
                    hover:text-[#c8982e]
                    hover:font-bold
                    hover:drop-shadow-[0_0_6px_rgba(200,152,46,0.6)]">
                MULTIMEDIA
                <span class="underline"></span>
            </a>

            <a href="#nosotros"
            data-link
            class="nav-link relative text-sm lg:text-base
                    text-gray-400
                    tracking-widest
                    transition-all duration-300
                    hover:text-[#c8982e]
                    hover:font-bold
                    hover:drop-shadow-[0_0_6px_rgba(200,152,46,0.6)]">
                NOSOTROS
                <span class="underline"></span>
            </a>
        </nav>

        <!-- Logo central -->
        <div class="flex items-center justify-center flex-1 md:flex-none">
            <img 
                src="<?= BASE_URL ?>/assets/img/logos/escudo-Photoroom.png" 
                alt="Escudo Militar"
                class="relative z-50 w-1 h-12 md:w-auto md:h-auto
                       transition-all duration-300
                       hover:scale-110
                       hover:drop-shadow-[0_10px_18px_rgba(200,152,46,1)]"
                onerror="this.style.display='none'; console.error('Error al cargar el escudo militar');">
        </div>

        <!-- Menú derecho - Desktop -->
        <nav class="hidden md:flex gap-6 lg:gap-9 items-center">
            <a href="#requisitos"
            data-link
            class="nav-link relative text-sm lg:text-base
                    text-gray-400
                    tracking-widest
                    transition-all duration-300
                    hover:text-[#c8982e]
                    hover:font-bold
                    hover:drop-shadow-[0_0_6px_rgba(200,152,46,0.6)]">
                REQUISITOS
                <span class="underline"></span>
            </a>

<a href="<?= BASE_URL ?>/incorporate/formulario" 
   class="nav-link relative text-sm lg:text-base
          text-gray-400
          tracking-widest
          transition-all duration-300
          hover:text-[#c8982e]
          hover:font-bold
          hover:drop-shadow-[0_0_6px_rgba(200,152,46,0.6)]">
    INCORPORATE
</a>

<a href="#"
   onclick="abrirLogin(); return false;"
   class="nav-link text-gray-400 hover:text-[#c8982e] tracking-widest"
          text-gray-400
          tracking-widest
          transition-all duration-300
          hover:text-[#c8982e]
          hover:font-bold
          hover:drop-shadow-[0_0_6px_rgba(200,152,46,0.6)]">
    ENTRAR
    <span class="underline active"></span>
</a>
        </nav>



    <!-- Menú móvil desplegable -->
<div id="mobileMenu"
     class="fixed top-0 left-0 w-full h-screen
            bg-black/95 backdrop-blur-sm
            z-50
            hidden
            flex flex-col items-center justify-center
            space-y-6 text-center">

    <!-- CERRAR -->
    <button onclick="toggleMenu()"
            class="absolute top-6 right-6 text-white text-3xl">
        ✕
    </button>

    <!-- LINKS -->
    <a href="<?= BASE_URL ?>/"
       class="text-white text-xl tracking-widest hover:text-[#c8982e]">
        INICIO
    </a>

    <a href="#nosotros"
       class="text-white text-xl tracking-widest hover:text-[#c8982e]">
        NOSOTROS
    </a>

    <a href="#requisitos"
       class="text-white text-xl tracking-widest hover:text-[#c8982e]">
        REQUISITOS
    </a>

    <a href="#"
        id="btnIncorporate"
       class="text-white text-xl tracking-widest hover:text-[#c8982e]">
        INCORPORACIÓN
    </a>

    <a href="#"
       onclick="abrirLogin(); toggleMenu(); return false;"
       class="text-[#c8982e] text-xl font-bold tracking-widest">
        ENTRAR
    </a>

</div>
</header>

