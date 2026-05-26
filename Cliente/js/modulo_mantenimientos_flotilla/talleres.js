document.addEventListener("DOMContentLoaded", () => {
  let tablaTalleres = null;

  const btnNuevoTaller = document.getElementById("btnNuevoTaller");

  const modalTalleres = new bootstrap.Modal(
    document.getElementById("modalTalleres"),
  );

  const formTaller = document.getElementById("formTaller");

  //=====================================================
  // ABRIR MODAL
  //=====================================================

  btnNuevoTaller.addEventListener("click", () => {
    limpiarFormularioTaller();

    obtenerTalleres();

    modalTalleres.show();
  });

  //=====================================================
  // GUARDAR
  //=====================================================

  formTaller.addEventListener("submit", (e) => {
    e.preventDefault();

    const formData = new FormData();

    formData.append("id_taller", document.getElementById("idTaller").value);

    formData.append(
      "nombre_taller",
      document.getElementById("nombreTaller").value,
    );

    formData.append(
      "direccion",
      document.getElementById("direccionTaller").value,
    );

    formData.append(
      "telefono",
      document.getElementById("telefonoTaller").value,
    );

    formData.append(
      "contacto",
      document.getElementById("contactoTaller").value,
    );

    fetch(
      "../../Servidor/solicitudes/unidades/mantenimientos_unidades_flotilla/guardar_taller.php",
      {
        method: "POST",
        body: formData,
      },
    )
      .then((res) => res.json())
      .then((resp) => {
        if (resp.success) {
          Swal.fire({
            icon: "success",
            title: "Taller guardado",
          });

          limpiarFormularioTaller();

          obtenerTalleres();

          // RECARGAR SELECTS
          if (window.cargarTalleres) {
            window.cargarTalleres();
          }
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: resp.message,
          });
        }
      });
  });

  //=====================================================
  // OBTENER TALLERES
  //=====================================================

  function obtenerTalleres() {
    fetch(
      "../../Servidor/solicitudes/unidades/mantenimientos_unidades_flotilla/obtener_talleres_admin.php",
    )
      .then((res) => res.json())
      .then((data) => {
        const tbody = document.getElementById("tbodyTalleres");

        // destruir datatable anterior
        if (tablaTalleres) {
          tablaTalleres.destroy();
        }

        tbody.innerHTML = "";

        data.forEach((taller) => {
          tbody.innerHTML += `
            
                <tr>

                    <td>${taller.id_taller}</td>

                    <td>${taller.nombre_taller}</td>

                    <td>${taller.contacto || "-"}</td>

                    <td>${taller.telefono || "-"}</td>

                    <td>${taller.direccion || "-"}</td>

                    <td>
                        ${
                          taller.estatus == 1
                            ? `<span class="badge bg-success">Activo</span>`
                            : `<span class="badge bg-danger">Inactivo</span>`
                        }
                    </td>

                    <td class="text-center">

                        <button
                            class="btn btn-sm btn-outline-primary me-2"
                            onclick='editarTaller(${JSON.stringify(taller)})'>

                            <i class="bi bi-pencil"></i>

                        </button>

                        <button
                            class="btn btn-sm btn-outline-warning"
                            onclick='cambiarEstatusTaller(${taller.id_taller})'>

                            <i class="bi bi-arrow-repeat"></i>

                        </button>

                    </td>

                </tr>
            `;
        });

        tablaTalleres = $("#tablaTalleres").DataTable({
          pageLength: 5,

          lengthMenu: [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "Todos"],
          ],

          order: [[0, "desc"]],

          responsive: true,

          language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
          },
        });
        $.fn.dataTable.ext.errMode = 'none';

        setTimeout(() => {

    $.fn.dataTable
        .tables({ visible: true, api: true })
        .columns.adjust();

}, 300);
      });
  }

  //=====================================================
  // LIMPIAR
  //=====================================================

  function limpiarFormularioTaller() {
    formTaller.reset();

    document.getElementById("idTaller").value = "";
  }

  //=====================================================
  // EDITAR
  //=====================================================

  window.editarTaller = (taller) => {
    document.getElementById("idTaller").value = taller.id_taller;

    document.getElementById("nombreTaller").value = taller.nombre_taller;

    document.getElementById("direccionTaller").value = taller.direccion || "";

    document.getElementById("telefonoTaller").value = taller.telefono || "";

    document.getElementById("contactoTaller").value = taller.contacto || "";
  };

  //=====================================================
  // CAMBIAR ESTATUS
  //=====================================================

  window.cambiarEstatusTaller = (id) => {
    fetch(
      "../../Servidor/solicitudes/unidades/mantenimientos_unidades_flotilla/cambiar_estatus_taller.php",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `id_taller=${id}`,
      },
    )
      .then((res) => res.json())
      .then((resp) => {
        if (resp.success) {
          obtenerTalleres();

          if (window.cargarTalleres) {
            window.cargarTalleres();
          }
        }
      });
  };
});
