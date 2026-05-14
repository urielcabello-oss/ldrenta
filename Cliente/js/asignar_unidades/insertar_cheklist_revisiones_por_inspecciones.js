document.addEventListener("DOMContentLoaded", function () {
    document.body.addEventListener("click", function(event) {
        if (event.target.classList.contains("resgitrarchecklist")) {
            let id_revision = event.target.getAttribute("data-id");
            let id_inspeccion = event.target.getAttribute("data-idinspeccion");
            $.ajax({
                type: "POST",
                url: "../../Servidor/solicitudes/unidades/asignacion_unidades/insertar_cheklist_revisiones_por_inspecciones.php",
                data: {
                    id_revision: id_revision,
                    id_inspeccion: id_inspeccion
                },
                success: function(response) {
                    console.log(response);
                }
            });
        }
    });
    
});
