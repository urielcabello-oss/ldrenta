document.addEventListener("DOMContentLoaded", function () {

    //abrimos la modal para vizualisar la informacion de la prueba demo
    const modalresultadopruebademo = new bootstrap.Modal(document.getElementById("modalresultadopruebademo"));
    const modalresultadopruebademobody = document.getElementById("modalresultadopruebademobody");

    let id_asignacion_unidad_demo = 0;
    document.body.addEventListener("click", function (event) {
        if (event.target.classList.contains("btnreportefinalunidademo")) {
            id_asignacion_unidad_demo = event.target.getAttribute("data-id_asignacion_demo");
            $.ajax({
                type: "POST",
                data: { id_asignacion_unidad_demo: id_asignacion_unidad_demo },
                url: "../../Servidor/solicitudes/pruebas_unidades_demo/formulario_resultados_pruebas.php",
                success: function (response) {
                    modalresultadopruebademobody.innerHTML = response;
                    modalresultadopruebademo.show();
                }
            });
        }
    })
});

//aqui usams este codigo para realizar el cambio de interfaz cards a tabla 
function toggleVista() {
    const button = document.getElementById("botonCambiarVista");
    const cards = document.getElementById("vistaCards");
    const tabla = document.getElementById("vistaTabla");
    const boton = event.target;

    if (cards.style.display === "none") {
        cards.style.display = "flex";
        tabla.style.display = "none";
        boton.textContent = "Cambiar a vista de tabla";
    } else {
        cards.style.display = "none";
        tabla.style.display = "block";
        boton.textContent = "Cambiar a vista de cards";
    }
}