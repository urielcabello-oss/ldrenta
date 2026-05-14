document.addEventListener("DOMContentLoaded", function () {

    //abrimos la modal para realizar la prorroga de la unidad
    const modalprorrogaunidaddemo = new bootstrap.Modal(document.getElementById("modalprorrogaunidaddemo"));
    const modalprorrogaunidaddemobody = document.getElementById("modalprorrogaunidaddemobody");  
    let id_asignacion_demo = 0;

    document.body.addEventListener("click", function (event) {
        if (event.target.classList.contains("btnsolicitarprorrogademo")) {
            id_asignacion_demo = event.target.getAttribute("data-id_asignacion_demo");
            $.ajax({
                type: "POST",
                data: {id_asignacion : id_asignacion_demo},
                url: "../../Servidor/solicitudes/unidades_demo_autorizadas/formulario_prorrogaunidaddemo.php",
                success: function (response) {
                    modalprorrogaunidaddemobody.innerHTML = response;
                    modalprorrogaunidaddemo.show();
                },
            });
        }
    });

        //declaracion del spinner de carga
  const contenedorspinner = document.getElementById("contenedorspinner");

    //obtenemos la informacion de la prorroga con los documentos necesarios
let valorcomentarios_prorroga_demo;
let valorfecha_prolongacion;
let valorcomprobante_domicilio;
let valorconstancia_fiscal;

    document.body.addEventListener("click", function (event) {
        if (event.target.classList.contains("btnsolicitarprorroga")) {
            console.log("click en el boton");

            //mandamos a llamar los datos del formulario para solicitar la prorroga
            const btnsolicitarprorroga = document.getElementById("btnsolicitarprorroga");

            const comentarios_prorroga_demo = document.getElementById("comentarios_prorroga_demo");
            const fecha_prolongacion = document.getElementById("fecha_prolongacion");
            const comprobante_domicilio = document.getElementById("comprobante_domicilio");
            const constancia_fiscal = document.getElementById("constancia_fiscal");
            contenedorspinner.style.display = "flex";

            obtenervalores();
            validarllenado();
            insertardatos();
        }
    });

        function obtenervalores(){
            valorcomentarios_prorroga_demo = comentarios_prorroga_demo.value;
            valorfecha_prolongacion = fecha_prolongacion.value;
            valorcomprobante_domicilio = comprobante_domicilio.files[0];
            valorconstancia_fiscal = constancia_fiscal.files[0];

            console.log(valorcomentarios_prorroga_demo);
            console.log(valorfecha_prolongacion);
            console.log(valorcomprobante_domicilio);
            console.log(valorconstancia_fiscal);
        }

        function validarllenado(){
            const campos = [
                {
                    campo: valorcomentarios_prorroga_demo,
                    nombre: "Comentarios de la prorroga",
                },
                {
                    campo: valorfecha_prolongacion,
                    nombre: "Fecha de prórroga",
                },
                {
                    campo: valorcomprobante_domicilio,
                    nombre: "Comprobante de domicilio",
                },
                {
                    campo: valorconstancia_fiscal,
                    nombre: "Constancia de situación fiscal",
                },
            ];

            for (let i = 0; i < campos.length; i++) {
                if (!campos[i].campo) {
                    Toastify({
                        text: "No obtuve " + campos[i].nombre,
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        stopOnFocus: true,
                        style: {
                            background:
                                "linear-gradient(to right,rgb(0, 183, 255),rgb(0, 183, 255))",
                        },
                    }).showToast();
                    return false;
                }
            }
            return true;
        }

        function insertardatos(){
            if (validarllenado()) {
                console.log("entro a insertardatos");

                const formdata = new FormData();
                formdata.append("id_asignacion", id_asignacion_demo);
                formdata.append("comentarios_prorroga_demo", valorcomentarios_prorroga_demo);
                formdata.append("fecha_prolongacion", valorfecha_prolongacion);
                formdata.append("comprobante_domicilio", valorcomprobante_domicilio);
                formdata.append("constancia_fiscal", valorconstancia_fiscal);

                $.ajax({
                    type: "POST",
                    url: "../../Servidor/solicitudes/unidades_demo_autorizadas/solicitar_prorroga.php",
                    data: formdata,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        console.log("entro a success");
                        console.log(response);
                        if (response.includes("correctamente")) {
                            contenedorspinner.style.display = "none";
                            window.location.href = "./asignaciones_unidades_demo.php?resultado=prorrogaenviada";
                        }
                    },
                });
            }
        }


    //notificacion de finalizacion de la unidad demo
    document.body.addEventListener("click", function (event) {
        if (event.target.classList.contains("btnfinalizarpruebaunidademo")) {
            id_asignacion_demo = event.target.getAttribute("data-id_asignacion_demo");
            Swal.fire({
                title: "¿Estás seguro de finalizar la prueba demo?",
                html: "<p>Se notificará a telematics la baja de la unidad.</p>"
                    + "<p>Una vez finalizada, no podrás revertir el proceso.</p>",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, finalizar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                   $.ajax({
    type: "POST",
    data: { id_asignacion: id_asignacion_demo },
    url: "../../Servidor/solicitudes/unidades_demo_autorizadas/finalizar_prueba_demo.php",
    beforeSend: function () {
        // mostrar spinner antes de enviar
        contenedorspinner.style.display = "flex";
    },
    success: function (response) {
        console.log("entro a success");
        console.log(response);

        if (response.includes("correctamente")) {
            window.location.href = "./asignaciones_unidades_demo.php?resultado=pruebaterminada";
        } else {
            Swal.fire("Error", "No se pudo finalizar la prueba demo.", "error");
        }
    },
    error: function (xhr, status, error) {
        console.error(error);
        Swal.fire("Error", "Hubo un problema en el servidor.", "error");
    },
    complete: function () {
        // ocultar spinner siempre (success o error)
        contenedorspinner.style.display = "none";
    }
});

                }
            });
        }
    });

})