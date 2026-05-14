console.log("Archivo inactividad.js cargado");

let temporizador;

function redirigir() {
    window.location.href = "http://localhost/intranet/LDRHSystem/";
}

function reiniciarTemporizador() {
    clearTimeout(temporizador);
    temporizador = setTimeout(redirigir, 1800000); // 30 minutos
}

// Detectar actividad del usuario
['mousemove', 'mousedown', 'keypress', 'scroll', 'touchstart'].forEach(function (evento) {
    document.addEventListener(evento, reiniciarTemporizador, false);
});

// Iniciar temporizador al cargar
reiniciarTemporizador();
