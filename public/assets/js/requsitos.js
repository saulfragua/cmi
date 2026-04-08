// ===============================
// CONFIGURACIÓN BASE (Colombia)
// ===============================
const baseStart = 19.5; // 19:30
const baseEnd = 23;    // 23:00
const baseUTC = -5;

// ===============================
// MAPA DE PAÍSES (UTC + BANDERA)
// ===============================
const countries = {
    "-6": { flag: "🇲🇽", name: "México" },
    "-5": { flag: "🇨🇴", name: "Colombia / Perú" },
    "-3": { flag: "🇦🇷", name: "Argentina / Chile" },
    "1":  { flag: "🇪🇸", name: "Europa" }
};

// ===============================
// ELEMENTOS DOM
// ===============================
const select = document.getElementById('countrySelect');
const result = document.getElementById('resultTime');
const hudTimeEl = document.getElementById('hudTime');
const flagEl = document.getElementById('flag');

// ===============================
// UTILIDADES
// ===============================
function formatTime(t) {
    const h = Math.floor(t);
    const m = t % 1 !== 0 ? '30' : '00';
    return `${String(h).padStart(2,'0')}:${m}`;
}

// ===============================
// HORARIO DE SIMULACIÓN
// ===============================
function updateSimulationTime(utc) {
    const diff = utc - baseUTC;

    let start = baseStart + diff;
    let end = baseEnd + diff;

    if (start >= 24) start -= 24;
    if (end >= 24) end -= 24;

    result.textContent = `${formatTime(start)} – ${formatTime(end)}`;
}

// ===============================
// RELOJ MILITAR (HORA REAL)
// ===============================
function updateHUDClock(utc) {
    const now = new Date();

    // Hora UTC real
    let hours = now.getUTCHours() + utc;
    let minutes = now.getUTCMinutes();

    if (hours >= 24) hours -= 24;
    if (hours < 0) hours += 24;

    hudTimeEl.textContent =
        `${String(hours).padStart(2,'0')}:${String(minutes).padStart(2,'0')}`;
}

// ===============================
// ACTUALIZAR BANDERA
// ===============================
function updateFlag(utc) {
    flagEl.textContent = countries[utc]?.flag || "🌍";
}

// ===============================
// DETECTAR PAÍS AUTOMÁTICAMENTE
// ===============================
function detectCountry() {
    const tz = Intl.DateTimeFormat().resolvedOptions().timeZone;

    if (tz.includes("Mexico")) return -6;
    if (tz.includes("Bogota") || tz.includes("Lima")) return -5;
    if (tz.includes("Buenos_Aires") || tz.includes("Santiago")) return -3;
    if (tz.includes("Madrid") || tz.includes("Paris") || tz.includes("Berlin")) return 1;

    return -5; // Default Colombia
}

// ===============================
// INICIALIZACIÓN
// ===============================
function init() {
    let savedUTC = localStorage.getItem('cmi_utc');

    if (!savedUTC) {
        savedUTC = detectCountry();
        localStorage.setItem('cmi_utc', savedUTC);
    }

    savedUTC = parseInt(savedUTC);

    // Sincronizar todo
    select.value = savedUTC;
    updateSimulationTime(savedUTC);
    updateHUDClock(savedUTC);
    updateFlag(savedUTC);

    // Reloj en tiempo real
    setInterval(() => updateHUDClock(savedUTC), 1000);
}

// ===============================
// EVENTO CAMBIO DE PAÍS
// ===============================
select.addEventListener('change', () => {
    const utc = parseInt(select.value);

    localStorage.setItem('cmi_utc', utc);
    updateSimulationTime(utc);
    updateHUDClock(utc);
    updateFlag(utc);
});

// START
init();
