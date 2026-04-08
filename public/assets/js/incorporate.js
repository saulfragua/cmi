document.addEventListener("DOMContentLoaded", function(){

    const btn = document.getElementById("btnIncorporate");
    const modal = document.getElementById("modalIncorporacion");
    const contenido = document.getElementById("contenidoModal");
    const cerrar = document.getElementById("cerrarModal");

    if (!btn || !modal || !contenido) return;

    // 🔥 ABRIR MODAL
 document.addEventListener("click", function(e){

    if(e.target && e.target.id === "btnIncorporate"){

        e.preventDefault();

        const modal = document.getElementById("modalIncorporacion");
        const contenido = document.getElementById("contenidoModal");

        if (!modal || !contenido) return;

        modal.classList.remove("hidden");
        document.body.style.overflow = "hidden";

        fetch("index.php?url=incorporate/formulario")
            .then(res => res.text())
            .then(html => {
                contenido.innerHTML = html;

                const scrollContainer = document.getElementById("modalScroll");
                if (scrollContainer) {
                    scrollContainer.scrollTop = 0;
                }
            })
            .catch(() => {
                contenido.innerHTML = "<p class='text-white text-center'>Error al cargar formulario</p>";
            });
    }

});

    // 🔥 CERRAR MODAL
    if(cerrar){
        cerrar.addEventListener("click", function(){
            modal.classList.add("hidden");
            document.body.style.overflow = "auto";
        });
    }

    // 🔥 CERRAR CON ESC
    document.addEventListener("keydown", function(e){
        if(e.key === "Escape"){
            modal.classList.add("hidden");
            document.body.style.overflow = "auto";
        }
    });

    // 🔥 CERRAR AL HACER CLICK FUERA
    modal.addEventListener("click", function(e){
        if(e.target === modal){
            modal.classList.add("hidden");
            document.body.style.overflow = "auto";
        }
    });

});