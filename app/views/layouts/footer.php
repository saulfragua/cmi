<footer class="w-full bg-gradient-to-t from-[#0f0f0f] to-[#1a1a1a] border-t border-black mt-20">
        <div class="max-w-[1400px] mx-auto px-6 py-10 grid grid-cols-1 md:grid-cols-4 gap-8">

        <!-- Marca / Derechos -->
        <div>
            <h3 class="text-[#c8982e] font-bold tracking-widest mb-3">
                UNIDAD MILITAR
            </h3>
            <p class="text-gray-400 text-sm leading-relaxed">
                © 2026 Unidad Militar Virtual.<br>
                Todos los derechos reservados.
            </p>
            <p class="text-gray-500 text-xs mt-2">
                Proyecto inspirado en simulación táctica.
            </p>
        </div>

        <!-- Menú de interés -->
        <div>
            <h3 class="text-[#c8982e] font-bold tracking-widest mb-3">
                MENÚ DE INTERÉS
            </h3>
            <ul class="space-y-2 text-sm">
                <li>
                    <a href="https://store.steampowered.com/app/107410/Arma_3" class="footer-link text-white">ARMA 3</a>
                </li>
                <li>
                    <a href="#" class="footer-link text-white">Mods Oficiales</a>
                </li>
                <li>
                    <a href="#" class="footer-link text-white">Guías Tácticas</a>
                </li>
                <li>
                    <a href="#" class="footer-link text-white"  onclick="abrirModalReglamento(); return false; ">Reglamento</a>
                </li>
            </ul>
        </div>

        <!-- Comunidad / TeamSpeak -->
        <div>
            <h3 class="text-[#c8982e] font-bold tracking-widest mb-3">
                COMUNIDAD
            </h3>
            <ul class="space-y-2 text-sm">
                <li>
                    <a href="#" class="footer-link text-white">TeamSpeak 3</a>
                </li>
                <li>
                    <a href="#" class="footer-link text-white">Canales Oficiales</a>
                </li>
                <li>
                    <a href="#" class="footer-link text-white">Reclutamiento</a>
                </li>
                <li>
                    <a href="#" class="footer-link text-white">Contacto</a>
                </li>
            </ul>
        </div>


<!-- REDES SOCIALES -->
<div>
    <h3 class="text-[#c8982e] font-bold tracking-widest mb-3">
        REDES SOCIALES
    </h3>

    <div class="flex flex-col gap-3 text-sm">

        <!-- YOUTUBE -->
        <a href="#" target="_blank"
           class="flex items-center gap-3 text-white hover:text-red-500 transition group">
            <i class="fab fa-youtube text-xl group-hover:scale-110 transition"></i>
            YouTube
        </a>

        <!-- FACEBOOK -->
        <a href="#" target="_blank"
           class="flex items-center gap-3 text-white hover:text-blue-500 transition group">
            <i class="fab fa-facebook text-xl group-hover:scale-110 transition"></i>
            Facebook
        </a>

        <!-- TIKTOK -->
        <a href="#" target="_blank"
           class="flex items-center gap-3 text-white hover:text-pink-400 transition group">
            <i class="fab fa-tiktok text-xl group-hover:scale-110 transition"></i>
            TikTok
        </a>

        <!-- INSTAGRAM -->
        <a href="#" target="_blank"
           class="flex items-center gap-3 text-white hover:text-pink-500 transition group">
            <i class="fab fa-instagram text-xl group-hover:scale-110 transition"></i>
            Instagram
        </a>

    </div>
</div>
</div>

    </div>

    <!-- Línea inferior -->
    <div class="border-t border-[#222] py-4 text-center">
        <p class="text-gray-500 text-xs tracking-widest">
            ARMA 3 · TeamSpeak · Simulación Militar · Comunidad Táctica
        </p>
    </div>

    <div id="modalIncorporacion"
     class="fixed inset-0 bg-black/90 hidden items-center justify-center z-50 overflow-y-auto">

    <div class="relative w-full max-w-5xl mx-auto">

        <button id="cerrarModal"
                class="fixed top-5 right-5 text-white text-2xl z-50 hover:text-red-500">
            ✕
        </button>

        <div id="contenidoModal"></div>

    </div>
</div>
</footer>

<!-- MODAL DE REGLAMENTO -->
<div id="modalReglamento" class="fixed inset-0 bg-black bg-opacity-90 z-[9999] flex items-center justify-center p-4" style="display: none;">
    <div class="bg-gradient-to-b from-[#1a1a1a] to-[#000] border-2 border-[#c8982e] rounded-xl shadow-2xl max-w-5xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6 md:p-8">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-[#c8982e]">
                <h2 class="text-2xl md:text-3xl font-bold text-[#c8982e] tracking-widest">
                    REGLAMENTO - NORMAS DE CONVIVENCIA
                </h2>
                <button onclick="cerrarModalReglamento()" 
                        class="text-gray-400 hover:text-[#c8982e] text-3xl font-bold transition-colors duration-300">
                    ×
                </button>
            </div>
            
            <!-- Imagen del reglamento -->
            <div class="flex justify-center">
                <img src="/cmi/public/assets/img/normas/normas de convivencia.jpeg" 
                     alt="Normas de Convivencia" 
                     class="max-w-full h-auto rounded-lg shadow-2xl"
                     onerror="this.style.display='none'; alert('Error al cargar la imagen del reglamento');">
            </div>
            
            <!-- Botón de cerrar -->
            <div class="mt-6 flex justify-center">
                <button onclick="cerrarModalReglamento()" 
                        class="px-8 py-3 bg-[#c8982e] text-[#0b0e14] font-bold rounded-lg hover:bg-[#e0b84a] transition-all duration-300 text-base md:text-lg shadow-lg hover:shadow-xl hover:scale-105">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL INCORPORACIÓN -->
<div id="modalIncorporacion"
     class="fixed inset-0 bg-black/95 hidden z-[9999]">

    <button id="cerrarModal"
            class="fixed top-5 right-5 text-white text-2xl z-50">
        ✕
    </button>

    <div id="modalScroll"
         class="w-full h-full overflow-y-auto">

        <div id="contenidoModal"
             class="w-full max-w-[900px] mx-auto px-4 py-10">
        </div>

    </div>
</div>
<!-- FIN DE MODAL LOGIN -->
<div id="modalLogin"
     class="fixed inset-0 bg-black/90 backdrop-blur-sm hidden z-50 flex items-center justify-center px-4">

    <div id="contenidoLogin"
         class="w-full max-w-md relative">
    </div>

</div>


<!-- SCRIPTS -->

<script src="/cmi/public/assets/js/carousel.js"></script>
<script src="/cmi/public/assets/js/incorporate.js"></script>
<script src="/cmi/public/assets/js/login.js"></script>
<script src="/cmi/public/assets/js/navbar.js"></script>

<script>
// Función para abrir el modal del reglamento
function abrirModalReglamento() {
    const modal = document.getElementById('modalReglamento');
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden'; // Prevenir scroll del body
    }
}

// Función para cerrar el modal del reglamento
function cerrarModalReglamento() {
    const modal = document.getElementById('modalReglamento');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto'; // Restaurar scroll del body
    }
}

// Cerrar modal al hacer clic fuera de él
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modalReglamento');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                cerrarModalReglamento();
            }
        });
        
        // Cerrar con tecla ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.style.display === 'flex') {
                cerrarModalReglamento();
            }
        });
    }
});





</script>







<style>
/* Animación de entrada para el modal */
#modalReglamento {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

#modalReglamento > div {
    animation: slideUp 0.3s ease-out;
}

@keyframes slideUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

</style>
