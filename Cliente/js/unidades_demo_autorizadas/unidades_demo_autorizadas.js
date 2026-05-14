document.addEventListener("DOMContentLoaded", function () {
  //AQUI USAMOS ESTE CODIGO PARA FILTRAR POR TIPO DE SOLICITANTE
  document.querySelectorAll(".opcion-filtro-solicitante").forEach(opcion => {
    opcion.addEventListener("click", function (e) {
      e.preventDefault();
      const filtro = this.getAttribute("data-filtro");

      // Actualiza el texto del botón dropdown
      document.getElementById("dropdownFiltroSolicitante").innerText = "Filtrar: " + this.innerText;

      // Filtra las cards
      document.querySelectorAll(".card-solicitante").forEach(card => {
        if (filtro === "todos" || card.classList.contains("tipo-" + filtro)) {
          card.style.display = "block";
        } else {
          card.style.display = "none";
        }
      });

      // Filtra las filas de la tabla
      document.querySelectorAll(".fila-solicitante").forEach(row => {
        if (filtro === "todos" || row.classList.contains("tipo-" + filtro)) {
          row.style.display = "table-row";
        } else {
          row.style.display = "none";
        }
      });
    });
  });
});

//aqui usams este codigo para realizar el cambio de interfaz cards a tabla 
function toggleVista() {
    const button = document.getElementById("botonCambiarVista");
    const cards = document.getElementById("vistaCards");
    const tabla = document.getElementById("vistaTabla");

    if (tabla.style.display === "none") {
        tabla.style.display = "block";
        cards.style.display = "none";
        button.innerHTML = '<i class="fa-solid fa-table-cells me-2"></i> Cambiar a vista de cards';
    } else {
        tabla.style.display = "none";
        cards.style.display = "flex";
        button.innerHTML = '<i class="fa-solid fa-table me-2"></i> Cambiar a vista de tabla';
    }
}


    document.addEventListener("click", function (e) {

    const boton = e.target.closest(".btn-devolver-unidad");
    if (!boton) return;

    const idAsignacion = boton.getAttribute("data-id_asignacion");
    const idUnidad     = boton.getAttribute("data-id_unidad");

    Swal.fire({
        title: '¿Devolver unidad?',
        text: "La unidad pasará a estado disponible.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f59e0b',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, devolver',
        cancelButtonText: 'Cancelar'
    }).then((result) => {

        if (!result.isConfirmed) return;

        boton.disabled = true;

        fetch("../../Servidor/solicitudes/unidades/asignacion_unidades_demo/devolver_unidad_demo.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "id_asignacion=" + idAsignacion + "&id_unidad=" + idUnidad
        })
        .then(response => response.json())
        .then(data => {

            if (data.status) {

                Swal.fire({
                    icon: 'success',
                    title: 'Unidad devuelta',
                    text: data.msg,
                    timer: 1800,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });

            } else {

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.msg
                });

                boton.disabled = false;
            }

        })
        .catch(error => {

            console.error(error);

            Swal.fire({
                icon: 'error',
                title: 'Error inesperado',
                text: 'Ocurrió un problema al procesar la solicitud.'
            });

            boton.disabled = false;
        });

    });

});

document.getElementById("btnPendientes").addEventListener("click", function(){

    let panel = new bootstrap.Offcanvas(document.getElementById('panelPendientes'));
    panel.show();

    fetch("../../Servidor/solicitudes/unidades/asignacion_unidades_demo/obtener_pendientes_demo.php")
    .then(res => res.text())
    .then(data => {

        document.getElementById("listaPendientes").innerHTML = data;

    });

});

document.addEventListener("change", function(e){

    if(!e.target.classList.contains("cambiar-impacto")) return;

    let select = e.target;
    let impacto = select.value;
    let id = select.dataset.id;

    fetch("../../Servidor/solicitudes/unidades/asignacion_unidades_demo/actualizar_impacto_demo.php",{
        method:"POST",
        headers:{
            "Content-Type":"application/x-www-form-urlencoded"
        },
        body:`impacto=${impacto}&id=${id}`
    })
    .then(res=>res.json())
    .then(data=>{

        if(data.status){

            // buscar la fila actual
            let fila = select.closest("tr");

            // buscar la columna impacto
            let celdaImpacto = fila.querySelector(".col-impacto");

            if(impacto == 1){
                celdaImpacto.innerHTML = '<span class="badge bg-success">Bajo</span>';
            }

            if(impacto == 2){
                celdaImpacto.innerHTML = '<span class="badge bg-warning text-dark">Medio</span>';
            }

            if(impacto == 3){
                celdaImpacto.innerHTML = '<span class="badge bg-danger">Alto</span>';
            }

            Swal.fire({
                icon:"success",
                title:"Impacto actualizado",
                timer:1000,
                showConfirmButton:false
            });

        }

    });

});