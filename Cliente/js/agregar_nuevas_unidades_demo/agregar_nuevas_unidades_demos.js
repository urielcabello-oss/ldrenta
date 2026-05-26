document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("formRegistrarUnidadDemo");
  const btnRegistrar = document.getElementById("btnregistrarunidad");

  // =========================================
  // AUTO UPPERCASE
  // =========================================

  const placaInput = document.getElementById("placaunidad");
  const vinInput = document.getElementById("vin");

  placaInput.addEventListener("input", () => {
    placaInput.value = placaInput.value.toUpperCase();
  });

  vinInput.addEventListener("input", () => {
    vinInput.value = vinInput.value.toUpperCase();
  });

  // =========================================
  // REGISTRAR
  // =========================================

  btnRegistrar.addEventListener("click", async (e) => {
    e.preventDefault();

    // ==============================
    // CAMPOS
    // ==============================

    const marca = document.getElementById("marcaunidad").value;
    const modelo = document.getElementById("modelounidad").value;
    const placa = placaInput.value.trim();
    const vin = vinInput.value.trim();

    const estado = document.getElementById("estadounidad").value;
    const estatus = document.getElementById("estatusunidad").value;
    const tipo = document.getElementById("tipounidad").value;

    const sede = document.getElementById("sedeunidad").value;
    const adquisicion = document.getElementById("tipoadquisicion").value;
    const arrendadora = document.getElementById("arrendadora").value.trim();

    // ==============================
    // VALIDACIONES
    // ==============================

    if (
      marca === "" ||
      modelo === "" ||
      placa === "" ||
      vin === "" ||
      estado === "" ||
      estatus === "" ||
      tipo === "" ||
      sede === "" ||
      adquisicion === "" ||
      arrendadora === ""
    ) {
      Swal.fire({
        icon: "warning",
        title: "Campos obligatorios",
        text: "Completa todos los campos requeridos",
      });

      return;
    }

    // VALIDAR VIN
    if (vin.length < 17) {
      Swal.fire({
        icon: "warning",
        title: "VIN inválido",
        text: "El VIN debe contener 17 caracteres",
      });

      return;
    }

    // ==============================
    // LOADING
    // ==============================

    btnRegistrar.disabled = true;

    btnRegistrar.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2"></span>
            Registrando...
        `;

    // ==============================
    // FORM DATA
    // ==============================

    const formData = new FormData(form);

    try {
      const response = await fetch(
        "../../Servidor/controllers/agregarUnidadesNuevas/registrar_unidad_demo.php",
        {
          method: "POST",
          body: formData,
        },
      );

      const text = await response.text();

      console.log(text);

      const data = JSON.parse(text);
      // ==============================
      // RESPUESTA
      // ==============================

      if (data.status === "success") {
        Swal.fire({
          icon: "success",
          title: "Unidad registrada",
          text: data.message,
        });

        form.reset();
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: data.message,
        });
      }
    } catch (error) {
      console.error(error);

      Swal.fire({
        icon: "error",
        title: "Error del servidor",
        text: "Ocurrió un error inesperado",
      });
    } finally {
      btnRegistrar.disabled = false;

      btnRegistrar.innerHTML = `
                <i class="fa-solid fa-check me-2"></i>
                Registrar unidad
            `;
    }
  });
});
