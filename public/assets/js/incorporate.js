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


// CARGAR PAISES EN EL SELECT
document.addEventListener("DOMContentLoaded", function(){

    const paises = [
        "Argentina","Bolivia","Brasil","Chile","Colombia","Costa Rica","Cuba",
        "Ecuador","El Salvador","Guatemala","Honduras","México","Nicaragua",
        "Panamá","Paraguay","Perú","República Dominicana","Uruguay","Venezuela","España"
    ];

    const select = document.getElementById("pais");

    // opción inicial
    let opcionInicial = document.createElement("option");
    opcionInicial.value = "";
    opcionInicial.textContent = "Seleccione un país";
    select.appendChild(opcionInicial);

    // cargar lista
    paises.forEach(function(pais){
        let option = document.createElement("option");
        option.value = pais;
        option.textContent = pais;
        select.appendChild(option);
    });

});














function validarFormulario() {

    const nombre = document.querySelector('[name="nombre"]').value.trim();
    const fecha = document.querySelector('[name="fecha_nacimiento"]').value;
    const pais = document.querySelector('[name="pais"]').value;
    const telefono = document.querySelector('[name="telefono"]').value.trim();
    const experiencia = document.querySelector('[name="experiencia"]').value;
    const motivo = document.querySelector('[name="motivo"]').value.trim();
    const normas = document.querySelector('[name="normas"]').checked;
    const datos = document.querySelector('[name="datos"]').checked;

    // 🔴 Validación individual (MEJOR UX)
    if (!nombre) {
        Swal.fire('Error', 'Ingresa tu nombre completo', 'error');
        return false;
    }

    if (!fecha) {
        Swal.fire('Error', 'Selecciona tu fecha de nacimiento', 'error');
        return false;
    }

    if (!pais) {
        Swal.fire('Error', 'Selecciona un país', 'error');
        return false;
    }

    if (!telefono) {
        Swal.fire('Error', 'Ingresa tu teléfono', 'error');
        return false;
    }

    if (!experiencia) {
        Swal.fire('Error', 'Selecciona tu experiencia', 'error');
        return false;
    }

    if (!motivo) {
        Swal.fire('Error', 'Escribe tu motivo de ingreso', 'error');
        return false;
    }

    // 🔴 Checkboxes
    if (!normas || !datos) {
        Swal.fire('Error', 'Debes aceptar las normas y datos', 'error');
        return false;
    }

    return true;
}



// 🔥 CONFIRMACIÓN FINAL
function confirmarEnvio() {

    // 🔴 VALIDAR PRIMERO
    if (!validarFormulario()) {
        return; // ⛔ corta ejecución
    }

    // 🔥 CONFIRMACIÓN
    Swal.fire({
        title: '🎖️ Confirmar solicitud',
        text: 'Un mando de incorporación te contactará por WhatsApp.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, enviar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#c8982e',
        background: '#1a1a1a',
        color: '#fff'
    }).then((result) => {
        if (result.isConfirmed) {

            // 🔥 ENVÍO MANUAL DEL FORM
            document.querySelector("form").submit();
        }
    });
}
