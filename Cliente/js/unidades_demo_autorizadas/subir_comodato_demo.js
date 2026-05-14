document.addEventListener("DOMContentLoaded", function () {
    //abrimos la modal para subir el comodato firmado
    const modalsubircomodatodemo= new bootstrap.Modal(document.getElementById("modalsubircomodatodemo"));
    const modalsubircomodatodemobody = document.getElementById("modalsubircomodatodemobody");
    let id_asignacion_demo = 0;


    document.body.addEventListener("click", function (event) {
        if (event.target.classList.contains("btncomodatodemo")) {
            id_asignacion_demo = event.target.getAttribute("data-id_asignacion_demo");
            $.ajax({
                type: "POST",
                data: {id_asignacion : id_asignacion_demo},
                url: "../../Servidor/solicitudes/unidades_demo_autorizadas/formulario_subir_comodato_demo_firmado.php",
                success: function (response) {
                    modalsubircomodatodemobody.innerHTML = response;
                    modalsubircomodatodemo.show();
                }
            });
        }
    });


      //Obtenemos la informacion del comodato que subio el area de juridico
  const btnenviarcomodato = document.getElementById("btnsubircomodatofirmado");

  let comodato_firmado_demo;

  let valor_comodato_firmado_demo;

    btnenviarcomodato.addEventListener("click", function () {
        comodato_firmado_demo = document.getElementById("comodato_firmado_demo");
        console.log(comodato_firmado_demo.value);

        contenedorspinner.style.display = "flex";
        obtenervalores();
        if (validarllenado()) {
            insertardatos();
        } else {
            contenedorspinner.style.display = "none";
        }
    });

    function obtenervalores() {
        valor_comodato_firmado_demo = comodato_firmado_demo.files[0];
    }

    function validarllenado() {
        const campos = [
            {
                campo: valor_comodato_firmado_demo,
                nombre: "Archivo del comodato firmado",
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
                            "linear-gradient(to right,rgb(255, 230, 0),rgb(231, 208, 0))",
                    },
                }).showToast();
                return false;
            }
        }
        return true;
    }

    function insertardatos() {
        let formData = new FormData();
        formData.append("id_asignacion", id_asignacion_demo);
        formData.append("comodato_firmado_demo", valor_comodato_firmado_demo);

        $.ajax({
            type: "POST",
            url: "../../Servidor/solicitudes/unidades_demo_autorizadas/insertar_comodato_demo_firmado.php",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
                if (response.includes("correctamente")) {
                    contenedorspinner.style.display = "none";
                    window.location.href = "./asignaciones_unidades_demo.php?resultado=Comodatodemosubido";
                } else {
                    if (response == "error") {
                    }
                }
            },
        });
    }
});