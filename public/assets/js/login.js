function abrirLogin() {

    const modal = document.getElementById("modalLogin");
    const contenido = document.getElementById("contenidoLogin");

    // 🔥 CARGAR VISTA DESDE PHP
    fetch("/cmi/public/index.php?url=login")
        .then(res => res.text())
        .then(html => {
            contenido.innerHTML = html;
        });

    modal.classList.remove("hidden");
    document.body.style.overflow = "hidden";
}

function cerrarLogin() {
    document.getElementById("modalLogin").classList.add("hidden");
    document.body.style.overflow = "auto";
}
