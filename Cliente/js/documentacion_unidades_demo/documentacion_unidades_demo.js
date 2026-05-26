document.addEventListener("DOMContentLoaded", () => {
  obtenerUnidades();
  manejarTipoDocumento();
  obtenerDocumentos();

  document
    .getElementById("tipo_documento")
    .addEventListener("change", manejarTipoDocumento);

  //=====================================================
  // FORM AGREGAR
  //=====================================================

  const form = document.getElementById("formAgregarDocumento");

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = new FormData(form);

    try {
      const response = await fetch(
        "../../Servidor/solicitudes/documentacion_unidades_demo/registrar_documento.php",
        {
          method: "POST",
          body: formData,
        },
      );

      const data = await response.json();

      if (data.success) {
        Swal.fire({
          icon: "success",
          title: "Documento registrado",
        });

        form.reset();

        $("#id_unidad").val(null).trigger("change");

        manejarTipoDocumento();

        bootstrap.Modal.getInstance(
          document.getElementById("modalAgregarDocumento"),
        ).hide();

        obtenerDocumentos();
      } else {
        Swal.fire({
          icon: "error",
          title: data.message || "Error al registrar",
        });
      }
    } catch (err) {
      console.error(err);
    }
  });

  //=====================================================
  // FORM EDITAR
  //=====================================================

  const formEditar = document.getElementById("formEditarDocumento");

  if (formEditar) {
    formEditar.addEventListener("submit", async (e) => {
      e.preventDefault();

      console.log("ACTUALIZANDO");

      const formData = new FormData(formEditar);

      try {
        const response = await fetch(
          "../../Servidor/solicitudes/documentacion_unidades_demo/actualizar_documento.php",
          {
            method: "POST",
            body: formData,
          },
        );

        const data = await response.json();

        console.log(data);

        if (data.success) {
          Swal.fire({
            icon: "success",
            title: "Documento actualizado",
          });

          bootstrap.Modal.getInstance(
            document.getElementById("modalEditarDocumento"),
          ).hide();

          obtenerDocumentos();
        } else {
          Swal.fire({
            icon: "error",
            title: data.message || "Error al actualizar",
          });
        }
      } catch (error) {
        console.error(error);
      }
    });
  }
});

//=====================================================
// MOSTRAR SECCIONES
//=====================================================

function manejarTipoDocumento() {
  const tipo = document.getElementById("tipo_documento").value;

  const seccionCFDI = document.getElementById("seccionCFDI");

  const seccionComprobante = document.getElementById("seccionComprobante");

  const seccionEvidencia = document.getElementById("seccionEvidencia");

  //=========================================
  // OCULTAR TODO
  //=========================================

  seccionCFDI.classList.add("d-none");

  seccionComprobante.classList.add("d-none");

  seccionEvidencia.classList.add("d-none");

  //=========================================
  // CFDI
  //=========================================

  if (tipo === "CFDI XML") {
    seccionCFDI.classList.remove("d-none");
  }

  //=========================================
  // FACTURA PDF
  //=========================================

  if (tipo === "FACTURA PDF") {
    seccionCFDI.classList.remove("d-none");
  }

  //=========================================
  // COMPROBANTE
  //=========================================

  if (tipo === "COMPROBANTE PAGO") {
    seccionComprobante.classList.remove("d-none");
  }

  //=========================================
  // EVIDENCIA
  //=========================================

  if (tipo === "EVIDENCIA") {
    seccionEvidencia.classList.remove("d-none");
  }

  document.querySelectorAll('input[type="file"]').forEach((input) => {
    input.value = "";
  });
}

//=====================================================
// OBTENER UNIDADES
//=====================================================

async function obtenerUnidades() {
  try {
    const response = await fetch(
      "../../Servidor/solicitudes/incidencias_unidades/obtener_incidencias_unidades.php",
    );

    const data = await response.json();

    const select = document.getElementById("id_unidad");

    select.innerHTML = `
            <option value="">
                Seleccione unidad
            </option>
        `;

    data.unidades.forEach((unidad) => {
      select.innerHTML += `
                <option value="${unidad.id_unidad}">

                    ${unidad.nombre_marca}
                    ${unidad.nombre_modelo}

                    | VIN: ${unidad.vin}

                    | PLACA: ${unidad.placa}

                </option>
            `;
    });

    //=========================================
    // SELECT2
    //=========================================

    $("#id_unidad").select2({
      placeholder: "Buscar unidad...",

      width: "100%",

      dropdownParent: $("#modalAgregarDocumento"),
    });
    //=========================================
    // SELECT2 EDITAR
    //=========================================
    const selectEditar = document.getElementById("edit_id_unidad");

    if (selectEditar) {
      selectEditar.innerHTML = select.innerHTML;

      $("#edit_id_unidad").select2({
        placeholder: "Buscar unidad...",
        width: "100%",
        dropdownParent: $("#modalEditarDocumento"),
      });
    }
  } catch (error) {
    console.error(error);
  }
}

//=====================================================
// OBTENER DOCUMENTOS
//=====================================================
async function obtenerDocumentos() {
  try {
    const response = await fetch(
      "../../Servidor/solicitudes/documentacion_unidades_demo/obtener_documentos.php",
    );

    const data = await response.json();

    const tbody = document.getElementById("documentosBody");

    tbody.innerHTML = "";

    data.documentos.forEach((doc) => {
      tbody.innerHTML += `
                <tr>

                    <td>
                        <button 
                          class="btn btn-warning btn-sm btnEditarDocumento"
                          data-id="${doc.id_documento}">
                            <i class="fa fa-edit"></i>
                        </button>
                    </td>

                    <td>${doc.id_documento}</td>

                    <td>${doc.tipo_documento}</td>

                    <td>${doc.nombre_documento ?? "-"}</td>

                    <td>${doc.placa ?? "-"}</td>

                    <td>${doc.vin ?? "-"}</td>

                    <td>${doc.folio ?? "-"}</td>

                    <td>${doc.uuid ?? "-"}</td>

                    <td>
                    $${parseFloat(doc.subtotal || 0).toLocaleString("es-MX", {
                      minimumFractionDigits: 2,
                      maximumFractionDigits: 2,
                    })}
                    </td>

                    <td>${doc.fecha_documento ?? "-"}</td>

                    <td>

                        ${
                          doc.archivo_xml
                            ? `<a target="_blank" href="../../Servidor/archivos/documentacion/xml/${doc.archivo_xml}">XML</a>`
                            : "-"
                        }

                        ${
                          doc.archivo_pdf
                            ? ` | <a target="_blank" href="../../Servidor/archivos/documentacion/pdf/${doc.archivo_pdf}">PDF</a>`
                            : ""
                        }

                        ${
                          doc.archivo_comprobante
                            ? ` | <a target="_blank" href="../../Servidor/archivos/documentacion/comprobantes/${doc.archivo_comprobante}">PAGO</a>`
                            : ""
                        }

                    </td>

                </tr>
            `;
    });
  } catch (error) {
    console.error(error);
  }
}

//=====================================================
// ABRIR MODAL EDITAR
//=====================================================

document.addEventListener("click", async (e) => {
  const btn = e.target.closest(".btnEditarDocumento");

  if (!btn) return;

  const id = btn.dataset.id;

  try {
    const response = await fetch(
      `../../Servidor/solicitudes/documentacion_unidades_demo/obtener_documento.php?id=${id}`,
    );

    const data = await response.json();

    if (!data.success) {
      throw new Error(data.message);
    }

    const doc = data.documento;

    document.getElementById("edit_id_documento").value = doc.id_documento;

    document.getElementById("edit_tipo_documento").value =
      doc.tipo_documento ?? "";

    document.getElementById("edit_nombre_documento").value =
      doc.nombre_documento ?? "";

    document.getElementById("edit_folio").value = doc.folio ?? "";

    document.getElementById("edit_uuid").value = doc.uuid ?? "";

    document.getElementById("edit_total").value = doc.total ?? "";

    document.getElementById("edit_observaciones").value =
      doc.observaciones ?? "";

    document.getElementById("edit_categoria").value = doc.categoria ?? "";

    document.getElementById("edit_fecha_documento").value =
      doc.fecha_documento ?? "";

    document.getElementById("edit_rfc_emisor").value = doc.rfc_emisor ?? "";

    document.getElementById("edit_rfc_receptor").value = doc.rfc_receptor ?? "";

    document.getElementById("edit_subtotal").value = doc.subtotal ?? "";

    document.getElementById("edit_iva").value = doc.iva ?? "";

    $("#edit_id_unidad").val(doc.id_unidad).trigger("change");

    //=====================================
    // MOSTRAR SECCIONES SEGUN TIPO
    //=====================================

    manejarTipoDocumentoEditar();

    new bootstrap.Modal(document.getElementById("modalEditarDocumento")).show();
  } catch (error) {
    console.error(error);

    Swal.fire({
      icon: "error",
      title: "Error al cargar documento",
    });
  }
});

//=====================================================
// MOSTRAR SECCIONES EDITAR
//=====================================================

function manejarTipoDocumentoEditar() {
  const tipo = document.getElementById("edit_tipo_documento").value;

  const cfdi = document.getElementById("edit_seccionCFDI");

  const comprobante = document.getElementById("edit_seccionComprobante");

  const evidencia = document.getElementById("edit_seccionEvidencia");

  cfdi.classList.add("d-none");
  comprobante.classList.add("d-none");
  evidencia.classList.add("d-none");

  if (tipo === "CFDI XML" || tipo === "FACTURA PDF") {
    cfdi.classList.remove("d-none");
  }

  if (tipo === "COMPROBANTE PAGO") {
    comprobante.classList.remove("d-none");
  }

  if (tipo === "EVIDENCIA") {
    evidencia.classList.remove("d-none");
  }

  document
    .querySelectorAll('#modalEditarDocumento input[type="file"]')
    .forEach((input) => {
      input.value = "";
    });
}

const editTipoDocumento = document.getElementById("edit_tipo_documento");

if (editTipoDocumento) {
  editTipoDocumento.addEventListener("change", manejarTipoDocumentoEditar);
}
