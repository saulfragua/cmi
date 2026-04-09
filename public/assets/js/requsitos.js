function actualizarHora() {
    const opciones = {
        timeZone: "America/Bogota",
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit"
    };

    const ahora = new Date().toLocaleString("es-CO", opciones);

    document.getElementById("fechaHora").innerHTML = "📅 " + ahora;
}

// actualizar cada segundo
setInterval(actualizarHora, 1000);

// ejecutar al cargar
actualizarHora();