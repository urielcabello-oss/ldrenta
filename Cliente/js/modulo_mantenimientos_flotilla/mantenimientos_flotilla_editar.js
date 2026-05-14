// =========================
// Editar Mantenimiento DEMO
// =========================
document.addEventListener("DOMContentLoaded", async () => {
  const editForm = document.getElementById("editMaintenanceForm");
  const tipoSelect = document.getElementById("editTipoInput");
  const estatusSelect = document.getElementById("editEstatus");
  const endpointTipos =
    "../../Servidor/solicitudes/unidades/mantenimientos_unidades_flotilla/tipo_mantenimiento.php";
  const endpointGuardar =
    "../../Servidor/solicitudes/unidades/mantenimientos_unidades_flotilla/editar_mantenimiento.php";
  const endpointEstatus =
    "../../Servidor/solicitudes/unidades/mantenimientos_unidades_flotilla/estatus_mantenimiento.php";

  if (!editForm) return;

  // =========================
  // Cargar tipos de mantenimiento
  // =========================
  async function cargarTipos() {
    try {
      const res = await fetch(endpointTipos);
      if (!res.ok) throw new Error("Error al obtener tipos de mantenimiento");

      const data = await res.json();
      tipoSelect.innerHTML = '<option value="">-- Seleccionar tipo --</option>';

      data.forEach((tipo) => {
        const opt = document.createElement("option");
        opt.value = tipo.id_tipo_mantenimiento;
        opt.textContent = tipo.tipo || tipo.nombre_tipo_mantenimiento;
        tipoSelect.appendChild(opt);
      });
    } catch (err) {
      console.error("Error cargando tipos:", err);
    }
  }

  // =========================
  // Abrir modal con datos
  // =========================
  window.openEditModal = async (mantenimiento) => {
    console.log(
      "ID estatus que viene:",
      mantenimiento.id_estatus_mantenimiento,
    );

    // Esperar que los estatus estén cargados
    if (estatusSelect.options.length <= 1) {
      await cargarEstatus();
    }

    if (tipoSelect.options.length <= 1) {
      await cargarTipos();
    }

    document.getElementById("editUnidadIdInput").value =
      mantenimiento.id_unidad || "";

    document.getElementById("editUnidadInput").value =
      `${mantenimiento.modelo || ""} (${mantenimiento.vin || ""})`;

    document.getElementById("editIdMantenimiento").value =
      mantenimiento.id_mantenimiento || "";

    tipoSelect.value = mantenimiento.id_tipo_mantenimiento || "";
    estatusSelect.value = String(mantenimiento.id_estatus_mantenimiento || "");
    console.log("Valor asignado al select:", estatusSelect.value);

    // Kilometraje (manual o telematics)
    const kmInput = document.getElementById("editKmInput");
    let kmValue = "";

    if (mantenimiento.km_manual && mantenimiento.km_manual > 0) {
      kmValue = mantenimiento.km_manual;
    } else if (mantenimiento.km_actual && mantenimiento.km_actual > 0) {
      kmValue = mantenimiento.km_actual;
    }

    kmInput.value = kmValue;

    // Si es telematics, bloquea el campo de kilometraje
    if (mantenimiento.km_actual && !mantenimiento.km_manual) {
      kmInput.readOnly = true;
    } else {
      kmInput.readOnly = false;
    }

    // Fechas y otros datos
    document.getElementById("editFechaIngreso").value =
      mantenimiento.fecha_ingreso || "";
    document.getElementById("editFechaSalida").value =
      mantenimiento.fecha_salida && mantenimiento.fecha_salida !== "0000-00-00"
        ? mantenimiento.fecha_salida
        : "";
    document.getElementById("editTallerInput").value =
      mantenimiento.taller || "";
    document.getElementById("editCostoInput").value =
      mantenimiento.costo_estimado || "";
    document.getElementById("editDescInput").value =
      mantenimiento.descripcion_trabajo || "";
    document.getElementById("editProximoKm").value =
      mantenimiento.proximo_km || "";
    document.getElementById("editProximoFecha").value =
      mantenimiento.proximo_fecha &&
      mantenimiento.proximo_fecha !== "0000-00-00"
        ? mantenimiento.proximo_fecha
        : "";

    // Limpia archivo factura
    document.getElementById("editFacturaFile").value = "";

    // Mostrar modal
    const modal = new bootstrap.Modal(
      document.getElementById("editMaintenanceModal"),
    );
    modal.show();
  };

  async function cargarEstatus() {
    try {
      const res = await fetch(endpointEstatus);
      if (!res.ok) throw new Error("Error al obtener estatus");

      const data = await res.json();
      estatusSelect.innerHTML =
        '<option value="">-- Seleccionar estatus --</option>';

      data.forEach((est) => {
        const opt = document.createElement("option");
        opt.value = est.id_estatus_mantenimiento;
        opt.textContent = est.estatus;
        estatusSelect.appendChild(opt);
      });
    } catch (err) {
      console.error("Error cargando estatus:", err);
    }
  }

  // =========================
  // Guardar cambios (enviar al backend)
  // =========================
  editForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = new FormData(editForm);

    // Aseguramos enviar los campos opcionales solo si tienen valor
    const optionalFields = [
      "id_tipo_mantenimiento",
      "id_estatus_mantenimiento",
      "fecha_salida",
      "taller",
      "costo_estimado",
      "descripcion_trabajo",
      "proximo_km",
      "proximo_fecha",
      "km_actual",
      "km_manual",
    ];

    optionalFields.forEach((field) => {
      const input = editForm.querySelector(`[name="${field}"]`);
      if (input && !input.value) formData.delete(field); // eliminar si está vacío
    });

    try {
      const res = await fetch(endpointGuardar, {
        method: "POST",
        body: formData,
      });
      const result = await res.json();

      if (result.success) {
        alert("✅ Mantenimiento actualizado correctamente");
        const modal = bootstrap.Modal.getInstance(
          document.getElementById("editMaintenanceModal"),
        );
        modal.hide();
        if (window.loadMantenimientos) window.loadMantenimientos(); // recargar lista
      } else {
        alert(
          "⚠️ Error al actualizar: " + (result.message || "Error desconocido"),
        );
      }
    } catch (error) {
      console.error("Error al actualizar mantenimiento:", error);
      alert("❌ Error al actualizar mantenimiento. Revisa la consola.");
    }
  });

  // =========================
  // Inicialización
  // =========================
  await cargarTipos();
  await cargarEstatus();
});
