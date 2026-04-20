document.addEventListener("DOMContentLoaded", function () {
    const btn = document.getElementById("btnIncorporate");
    const modal = document.getElementById("modalIncorporacion");
    const contenido = document.getElementById("contenidoModal");
    const cerrar = document.getElementById("cerrarModal");

    const form = document.getElementById("formIncorporacion");
    const pais = document.getElementById("pais");
    const bandera = document.getElementById("banderaTelefono");
    const indicativo = document.getElementById("indicativoTelefono");
    const indicativoInput = document.getElementById("indicativo");
    const telefono = document.getElementById("telefono");

    // ==========================================
    // CERRAR MODAL
    // ==========================================
    if (cerrar && modal) {
        cerrar.addEventListener("click", function () {
            modal.classList.add("hidden");
            document.body.style.overflow = "auto";
        });
    }

    // ==========================================
    // CERRAR CON ESC
    // ==========================================
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && modal) {
            modal.classList.add("hidden");
            document.body.style.overflow = "auto";
        }
    });

    // ==========================================
    // CERRAR AL HACER CLICK FUERA
    // ==========================================
    if (modal) {
        modal.addEventListener("click", function (e) {
            if (e.target === modal) {
                modal.classList.add("hidden");
                document.body.style.overflow = "auto";
            }
        });
    }

    // ==========================================
    // ACTUALIZAR BANDERA E INDICATIVO
    // ==========================================
    if (pais && bandera && indicativo && indicativoInput && telefono) {
        const banderaDefault = bandera.getAttribute("src");

        function actualizarPais() {
            const option = pais.options[pais.selectedIndex];

            if (option && option.value !== "") {
                const rutaBandera = option.getAttribute("data-bandera") || banderaDefault;
                const codigo = option.getAttribute("data-indicativo") || "+00";

                bandera.src = rutaBandera;
                indicativo.textContent = codigo;
                indicativoInput.value = codigo;
                telefono.placeholder = codigo + " Ingrese su número";
            } else {
                bandera.src = banderaDefault;
                indicativo.textContent = "+00";
                indicativoInput.value = "";
                telefono.placeholder = "Ingrese su número";
            }
        }

        pais.addEventListener("change", actualizarPais);
        actualizarPais();
    }

    // ==========================================
    // ENLAZAR SUBMIT DEL FORMULARIO
    // ==========================================
    if (form) {
        form.addEventListener("submit", function (e) {
            if (!validarFormulario()) {
                e.preventDefault();
            }
        });
    }
});

// ==========================================
// VALIDAR FORMULARIO
// ==========================================
function validarFormulario() {
    const nombre = document.getElementById("nombre_completo");
    const fecha = document.getElementById("fecha_nacimiento");
    const pais = document.getElementById("pais");
    const telefono = document.getElementById("telefono");
    const normas = document.getElementById("normas");
    const datos = document.getElementById("datos");
    const motivo = document.getElementById("motivo");
    const form = document.getElementById("formIncorporacion");

    if (!form || !nombre || !fecha || !pais || !telefono || !normas || !datos) {
        alert("❌ Error: faltan elementos del formulario.");
        return false;
    }

    if (nombre.value.trim() === "") {
        alert("⚠️ Debe ingresar el nombre completo.");
        nombre.focus();
        return false;
    }

    if (fecha.value.trim() === "") {
        alert("⚠️ Debe seleccionar la fecha de nacimiento.");
        fecha.focus();
        return false;
    }

    if (pais.value.trim() === "") {
        alert("⚠️ Debe seleccionar un país.");
        pais.focus();
        return false;
    }

    if (telefono.value.trim() === "") {
        alert("⚠️ Debe ingresar el teléfono.");
        telefono.focus();
        return false;
    }

    if (motivo && motivo.value.trim() === "") {
        alert("⚠️ Debe escribir el motivo de ingreso.");
        motivo.focus();
        return false;
    }

    if (!normas.checked) {
        alert("⚠️ Debe aceptar las normas del CMI.");
        normas.focus();
        return false;
    }

    if (!datos.checked) {
        alert("⚠️ Debe aceptar el tratamiento de datos.");
        datos.focus();
        return false;
    }

    return true;
}

// ==========================================
// CONFIRMACIÓN FINAL
// ==========================================
function confirmarEnvio() {
    if (!validarFormulario()) {
        return false;
    }

    const form = document.getElementById("formIncorporacion");

    if (!form) {
        alert("❌ No se encontró el formulario.");
        return false;
    }

    if (typeof Swal !== "undefined") {
        Swal.fire({
            title: "🎖️ Confirmar solicitud",
            text: "Un mando de incorporación te contactará por WhatsApp.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, enviar",
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#c8982e",
            background: "#1a1a1a",
            color: "#fff"
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    } else {
        const confirmar = confirm("¿Desea enviar la solicitud de incorporación?");
        if (confirmar) {
            form.submit();
        }
    }

    return false;
}