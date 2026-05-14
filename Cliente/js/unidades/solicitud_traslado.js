document.addEventListener("click", function (e) {
  const btn = e.target.closest(".btnsolicitartraslado");
  if (!btn) return;

  const id_unidad = btn.dataset.id_unidad;
  const modelo = btn.dataset.modelo;
  const placa = btn.dataset.placa;

  document.getElementById("traslado_modelo").value = modelo;
  document.getElementById("traslado_placa").value = placa;

  const btnEnviar = document.getElementById("btnEnviarTraslado");
  btnEnviar.dataset.id_unidad = id_unidad;

  const modal = new bootstrap.Modal(
    document.getElementById("modalTrasladoUnidad"),
  );

  modal.show();
});

document
  .getElementById("btnEnviarTraslado")
  .addEventListener("click", function () {
    const id_unidad = this.dataset.id_unidad;
    const origen = document.getElementById("traslado_origen").value.trim();
    const destino = document.getElementById("traslado_destino").value.trim();
    const motivo = document.getElementById("traslado_motivo").value.trim();

    if (!origen || !destino || !motivo) {
      Swal.fire({
        icon: "warning",
        title: "Campos incompletos",
        text: "Debes llenar todos los campos",
      });

      return;
    }

    Swal.fire({
      title: "Enviando solicitud...",
      allowOutsideClick: false,
      didOpen: () => Swal.showLoading(),
    });

    fetch("../../Servidor/solicitudes/unidades/solicitar_traslado.php", {
      method: "POST",

      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },

      body: new URLSearchParams({
        id_unidad: id_unidad,
        origen: origen,
        destino: destino,
        motivo: motivo,
      }),
    })
      .then(res => res.text())
.then(data => {

  console.log("Respuesta servidor:", data);

  try {

    const json = JSON.parse(data);

if (json.status) {

  Swal.fire({
    icon: "success",
    title: "Solicitud enviada",
    text: json.msg,
    timer: 1500,
    showConfirmButton: false
  });

  // cerrar modal si sigue abierto
  const modal = bootstrap.Modal.getInstance(
    document.getElementById("modalTrasladoUnidad")
  );

  if (modal) {
    modal.hide();
  }

  // recargar interfaz completa
  setTimeout(() => {
    window.location.reload(true);
  }, 1500);

} else {

  Swal.fire({
    icon: "error",
    title: "Error",
    text: json.msg
  });

}

  } catch(e){

    console.error("Respuesta no JSON:", data);

  }

})

      .catch((err) => {
        console.error(err);

        Swal.fire({
          icon: "error",
          title: "Error",
          text: "No se pudo enviar la solicitud",
        });
      });
  });
