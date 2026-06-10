document.addEventListener("DOMContentLoaded", function () {
  const unidadInput = document.getElementById("unidadInput");
  const unidadList = document.getElementById("unidadList");
  const tipoSelect = document.getElementById("tipoInput");
  const maintTableBody = document.getElementById("maintBody");
  const maintenanceForm = document.getElementById("maintenanceForm");
  const tallerSelect = document.getElementById("tallerSelect");

  let selectedUnidadId = null;
  let dataTableInstance = null;
  let mantenimientosData = [];

  // ---------------------------
  // Buscar unidades (autocompletado)
  // ---------------------------
  unidadInput.addEventListener("input", () => {
    const query = unidadInput.value.trim();
    if (query.length < 2) {
      unidadList.innerHTML = "";
      return;
    }

    fetch(
      `../../Servidor/solicitudes/unidades/mantenimientos_unidades_flotilla/obtener_unidades_mantenimiento_flotilla.php?q=${encodeURIComponent(
        query,
      )}`,
    )
      .then((res) => res.json())
      .then((data) => {
        unidadList.innerHTML = "";
        data.forEach((u) => {
          const item = document.createElement("button");
          item.type = "button";
          item.className = "list-group-item list-group-item-action";
          item.textContent = `${u.vin || ""} - ${u.nombre_modelo || ""} - ${
            u.nombre_marca || ""
          } - ${u.placa || ""}`;
          item.addEventListener("click", () => {
            unidadInput.value = item.textContent;
            selectedUnidadId = u.id_unidad;
            const unidadIdInput = document.getElementById("unidadIdInput");
            if (unidadIdInput) unidadIdInput.value = selectedUnidadId;
            unidadList.innerHTML = "";
          });
          unidadList.appendChild(item);
        });
      })
      .catch((err) => console.error("Error al cargar unidades:", err));
  });

  // ---------------------------
  // Cargar tipos de mantenimiento (para select)
  // ---------------------------
  function cargarTiposEnSelect() {
    return fetch(
      "../../Servidor/solicitudes/unidades/mantenimientos_unidades_flotilla/tipo_mantenimiento.php",
    )
      .then((res) => res.json())
      .then((data) => {
        if (!tipoSelect) return data;
        tipoSelect.innerHTML = `<option value="">-- Seleccionar tipo --</option>`;
        data.forEach((tm) => {
          const opt = document.createElement("option");
          opt.value = tm.id_tipo_mantenimiento;
          opt.textContent = tm.nombre_tipo_mantenimiento;
          tipoSelect.appendChild(opt);
        });
        return data;
      })
      .catch((err) => {
        console.error("Error al cargar tipos de mantenimiento:", err);
        return [];
      });
  }

  // ==========================================
  // CARGAR TALLERES
  // ==========================================

  function cargarTalleres() {
    fetch(
      "../../Servidor/solicitudes/unidades/mantenimientos_unidades_flotilla/obtener_talleres.php",
    )
      .then((res) => res.json())
      .then((data) => {
        tallerSelect.innerHTML = `
        <option value="">
          Seleccionar taller
        </option>
      `;

        data.forEach((taller) => {
          const option = document.createElement("option");

          option.value = taller.id_taller;

          option.textContent = taller.nombre_taller;

          tallerSelect.appendChild(option);
        });
      })
      .catch((err) => {
        console.error("Error talleres:", err);
      });
  }

  // Cargar tipos inicialmente
  cargarTiposEnSelect();
  cargarTalleres();

  // ---------------------------
  // Cards resumen
  // ---------------------------
  function updateCards(data) {
    const now = new Date();
    const mesActual = now.getMonth();
    const añoActual = now.getFullYear();

    let thisMonth = 0;
    let totalMantenimientos = data.length;
    let enProceso = 0;
    let pendientes = 0;
    let finalizados = 0;
    let atrasados = 0;
    let totalCost = 0;

    let preventivo = 0;
    let correctivo = 0;

    data.forEach((m) => {
      // =========================
      // FECHA INGRESO (MES ACTUAL)
      // =========================
      const fecha = new Date(m.fecha_ingreso);
      if (fecha.getMonth() === mesActual && fecha.getFullYear() === añoActual) {
        thisMonth++;
      }

      // =========================
      // COSTO
      // =========================
      totalCost += Number(m.costo_estimado || 0);

      // =========================
      // ESTATUS (NORMALIZADO)
      // =========================
      const estatus = (m.estatus || "").toLowerCase();

      if (estatus.includes("proceso") || estatus.includes("taller")) {
        enProceso++;
      }

      if (estatus.includes("pendiente")) {
        pendientes++;
      }

      if (estatus.includes("final")) {
        finalizados++;
      }

      // atrasados (regla simple)
      if (m.proximo_fecha) {
        const prox = new Date(m.proximo_fecha);
        if (prox < now && !estatus.includes("final")) {
          atrasados++;
        }
      }

      // =========================
      // TIPO
      // =========================
      const tipo = (m.tipo || "").toLowerCase();

      if (tipo === "preventivo") preventivo++;
      if (tipo === "correctivo") correctivo++;
    });

    // =========================
    // % preventivo vs correctivo
    // =========================
    const total = preventivo + correctivo;

    const percentPrev = total ? ((preventivo / total) * 100).toFixed(1) : 0;
    const percentCorr = total ? ((correctivo / total) * 100).toFixed(1) : 0;

    console.log("cardThisMonth", document.getElementById("cardThisMonth"));
    console.log(
      "cardTotalMantenimientos",
      document.getElementById("cardTotalMantenimientos"),
    );
    console.log("cardCost", document.getElementById("cardCost"));
    console.log("cardAvgDays", document.getElementById("cardAvgDays"));
    console.log("cardEnProceso", document.getElementById("cardEnProceso"));
    console.log("cardPendientes", document.getElementById("cardPendientes"));
    console.log("cardFinalizados", document.getElementById("cardFinalizados"));
    console.log("cardAtrasados", document.getElementById("cardAtrasados"));

    // =========================
    // INYECTAR EN DOM
    // =========================
    document.getElementById("cardThisMonth").textContent = thisMonth;
    document.getElementById("cardTotalMantenimientos").textContent =
      totalMantenimientos;
    document.getElementById("cardCost").textContent =
      `$${totalCost.toLocaleString()}`;

    document.getElementById("cardAvgDays").innerHTML =
      `Prev: ${percentPrev}% <br> Corr: ${percentCorr}%`;

    document.getElementById("cardEnProceso").textContent = enProceso;
    document.getElementById("cardPendientes").textContent = pendientes;
    document.getElementById("cardFinalizados").textContent = finalizados;
    document.getElementById("cardAtrasados").textContent = atrasados;
  }

  // ---------------------------
  // Gráficas (Chart.js)
  // ---------------------------
  function updateCharts(counts, statusCounts) {
    // Doughnut: tipos
    const ctxType = document.getElementById("chartTypes");
    if (ctxType) {
      if (window.chartTypesInstance) {
        try {
          window.chartTypesInstance.destroy();
        } catch {}
      }
      window.chartTypesInstance = new Chart(ctxType, {
        type: "doughnut",
        data: {
          labels: ["Preventivo", "Correctivo", "Mixto"],
          datasets: [
            {
              data: [
                counts.preventivo || 0,
                counts.correctivo || 0,
                counts.mixto || 0,
              ],
              backgroundColor: ["#1d61a1ff", "#2db4aeff", "#dc7835ff"],
            },
          ],
        },
        options: {
          plugins: {
            legend: { position: "bottom" },
            title: { display: false },
          },
          responsive: true,
          maintainAspectRatio: false,
        },
      });
    }

    // Bar horizontal: estatus
    const ctxStatus = document.getElementById("chartStatus");
    if (ctxStatus) {
      if (window.chartStatusInstance) {
        try {
          window.chartStatusInstance.destroy();
        } catch {}
      }

      const statusLabels = Object.keys(statusCounts || {});
      const statusData = statusLabels.map((l) => statusCounts[l] || 0);
      const labelsFinal = statusLabels.length ? statusLabels : ["Sin datos"];
      const dataFinal = statusData.length ? statusData : [0];

      const colors = labelsFinal.map((label) => {
        const low = (label || "").toString().toLowerCase();
        if (low.includes("pendiente")) return "#b7ca4cff";
        if (low.includes("finalizado") || low.includes("terminado"))
          return "#239e75ff";
        if (
          low.includes("en taller") ||
          low.includes("en curso") ||
          low.includes("proceso")
        )
          return "#3183a3ff";
        return "#9E9E9E";
      });

      window.chartStatusInstance = new Chart(ctxStatus, {
        type: "bar",
        data: {
          labels: labelsFinal,
          datasets: [
            {
              label: "Cantidad",
              data: dataFinal,
              backgroundColor: colors,
              borderWidth: 1,
            },
          ],
        },
        options: {
          indexAxis: "y",
          responsive: true,
          maintainAspectRatio: false,
          scales: { x: { beginAtZero: true } },
          plugins: { legend: { display: false }, title: { display: false } },
        },
      });
    }
  }

  // ---------------------------
  // Crear fila de filtros (si no existe)
  // ---------------------------
  function crearFilaFiltros(data) {
    if (document.querySelector("#maintTable thead tr.filters")) return;
    const thead = document.querySelector("#maintTable thead");
    if (!thead) return;

    const ths = Array.from(thead.querySelectorAll("tr th"));
    const keyMap = {
      id: "id_unidad",
      modelo: "modelo",
      vin: "vin",
      "tipo mantenimiento": "tipo",
      estatus: "estatus",
      ingreso: "fecha_ingreso",
      salida: "fecha_salida",
      kilometraje: "km_actual",
      taller: "nombre_taller",
      costo: "costo_estimado",
    };

    const filterRow = document.createElement("tr");
    filterRow.classList.add("filters");

    ths.forEach((th, colIndex) => {
      const title = th.textContent.trim().toLowerCase();
      const filterTd = document.createElement("th");

      if (title.includes("acciones") || title === "") {
        filterTd.innerHTML = "";
      } else if (
        title.includes("tipo mantenimiento") ||
        title.includes("estatus")
      ) {
        const select = document.createElement("select");
        select.className = "form-select form-select-sm";
        select.innerHTML = `<option value="">Todos</option>`;

        const field = keyMap[title] || null;
        if (field) {
          const uniqueValues = Array.from(
            new Set(data.map((d) => (d[field] !== undefined ? d[field] : ""))),
          );
          uniqueValues
            .filter((v) => v !== null && v !== undefined && v !== "")
            .forEach((v) => {
              const opt = document.createElement("option");
              opt.value = v;
              opt.textContent = v;
              select.appendChild(opt);
            });
        }

        select.addEventListener("change", () => {
          if (!dataTableInstance) return;
          dataTableInstance
            .column(colIndex)
            .search(select.value ? "^" + select.value + "$" : "", true, false)
            .draw();
        });

        filterTd.appendChild(select);
      } else {
        const input = document.createElement("input");
        input.type = "text";
        input.placeholder = `${th.textContent.trim()}`;
        input.className = "form-control form-control-sm";
        input.addEventListener("keyup", () => {
          if (!dataTableInstance) return;
          dataTableInstance.column(colIndex).search(input.value).draw();
        });
        filterTd.appendChild(input);
      }

      filterRow.appendChild(filterTd);
    });

    thead.prepend(filterRow);
  }

  // ---------------------------
  // Cargar mantenimientos y render
  // ---------------------------
  function loadMantenimientos() {
    fetch(
      "../../Servidor/solicitudes/unidades/mantenimientos_unidades_flotilla/obtener_mantenimientos.php",
    )
      .then((res) => res.json())
      .then((data) => {
        // Actualizar cards
        updateCards(data);

        mantenimientosData = data; // 👈 guardar original completo

        // destruir DataTable previo
        if (dataTableInstance) {
          try {
            dataTableInstance.destroy();
          } catch {}
        }

        // limpiar tabla
        if (maintTableBody) maintTableBody.innerHTML = "";

        const counts = { preventivo: 0, correctivo: 0, mixto: 0 };
        const statusCounts = {};

        function formatNumber(value) {
          const num = Number(String(value).replace(/,/g, ""));
          if (isNaN(num)) return 0;
          return num.toLocaleString("es-MX");
        }

        // Helper de kilometraje
        function renderKilometraje(m) {
          if (m.km_manual && m.km_manual > 0) {
            return `<span class="text-warning fw-bold km-tooltip" data-bs-toggle="tooltip" title="Manual">
      ${formatNumber(m.km_manual)} km
    </span>`;
          } else if (m.km_actual && m.km_actual > 0) {
            return `<span class="text-primary fw-bold km-tooltip" data-bs-toggle="tooltip" title="Telematics">
      ${formatNumber(m.km_actual)} km
    </span>`;
          } else {
            return `<span class="text-muted km-tooltip" data-bs-toggle="tooltip" title="Sin dato">0 km</span>`;
          }
        }

        data.forEach((m) => {
          const tr = document.createElement("tr");
          tr.innerHTML = `
    <td class="txtmantenimientos">${m.id_unidad}</td>
    <td class="txtmantenimientos">${m.modelo || "-"}</td>
    <td class="txtmantenimientos">${m.vin || "-"}</td>
    <td class="txtmantenimientos">${m.tipo || "-"}</td>
    <td class="txtmantenimientos">${m.estatus || "-"}</td>
    <td class="txtmantenimientos">${m.fecha_ingreso || "-"}</td>
    <td class="txtmantenimientos">${m.fecha_salida || "-"}</td>
    <td class="txtmantenimientos">${renderKilometraje(m)}</td>
    <td class="txtmantenimientos">
 ${m.nombre_taller || "-"}
    </td>
    <td class="txtmantenimientos">$${formatNumber(m.costo_estimado)}</td>
    <td class="txtmantenimientos" title="${m.descripcion_trabajo || ""}">
  ${(m.descripcion_trabajo || "-").substring(0, 50)}...
</td>
    <td class="txtmantenimientos">

  <!-- EDITAR -->
  <button 
    class="btn btn-sm btn-outline-primary me-1"
    type="button"
    onclick='openEditModal(${JSON.stringify(m).replace(/'/g, "&apos;")})'>
    <i class="bi bi-pencil"></i>
  </button>

  <!-- VER EVIDENCIAS -->
  <button 
    class="btn btn-sm btn-outline-success"
    type="button"
    onclick='verEvidencias(${JSON.stringify(m).replace(/'/g, "&apos;")})'>
    <i class="bi bi-images"></i>
  </button>

</td>
  `;
          if (maintTableBody) maintTableBody.appendChild(tr);

          counts[m.tipo?.toLowerCase()] =
            (counts[m.tipo?.toLowerCase()] || 0) + 1;
          statusCounts[m.estatus] = (statusCounts[m.estatus] || 0) + 1;
        });

        // Crear fila de filtros con valores únicos
        crearFilaFiltros(data);

        // Inicializar tooltips
        const tooltipTriggerList = [].slice.call(
          document.querySelectorAll(".km-tooltip"),
        );
        tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Inicializar DataTable
        if (window.jQuery && window.jQuery.fn && window.jQuery.fn.dataTable) {
          dataTableInstance = $("#maintTable").DataTable({
            pageLength: 5,
            lengthMenu: [
              [5, 10, 25, 50, 100, -1],
              [5, 10, 25, 50, 100, "Todos"],
            ],
            order: [[0, "desc"]],
            language: {
              url: "https://cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
            },
          });
        }

        // Actualizar gráficas con los conteos
        updateCharts(counts, statusCounts);
      })
      .catch((err) => {
        console.error("Error al cargar mantenimientos:", err);
      });
  }
  window.loadMantenimientos = loadMantenimientos;

  // Cargar al inicio
  loadMantenimientos();

  // -------------------------------
  // Guardar mantenimiento
  // -------------------------------
  maintenanceForm.addEventListener("submit", function (e) {
    e.preventDefault();

    if (!selectedUnidadId) {
      alert("Por favor selecciona una unidad.");
      return;
    }

    const formData = new FormData(maintenanceForm);
    formData.append("id_unidad", selectedUnidadId);

    // Solo km_manual
    const kmInput = document.getElementById("kmInput");
    if (kmInput) {
      formData.append("km_manual", kmInput.value || "");
    }

    const url =
      "../../Servidor/solicitudes/unidades/mantenimientos_unidades_flotilla/guardar_mantenimiento.php";

    fetch(url, { method: "POST", body: formData, credentials: "same-origin" })
      .then((res) => res.json())
      .then((resp) => {
        if (resp.success) {
          alert(resp.message || "Guardado correctamente");
          maintenanceForm.reset();
          selectedUnidadId = null;
          unidadList.innerHTML = "";
          loadMantenimientos();

          const modalEl = document.getElementById("maintenanceModal");
          const modalInstance =
            bootstrap.Modal.getInstance(modalEl) ||
            new bootstrap.Modal(modalEl);
          modalInstance.hide();
          document.body.classList.remove("modal-open");
          document
            .querySelectorAll(".modal-backdrop")
            .forEach((el) => el.remove());
        } else {
          alert("Error: " + (resp.message || "respuesta inválida"));
        }
      })
      .catch((err) => {
        console.error(err);
        alert("Error al guardar mantenimiento");
      });
  });

  // ---------------------------
  // Nuevo mantenimiento (preparar modal)
  // ---------------------------
  const btnNewMaintenance = document.getElementById("btnNewMaintenance");
  if (btnNewMaintenance) {
    btnNewMaintenance?.addEventListener("click", function () {
      maintenanceForm.reset();
      selectedUnidadId = null;
      unidadInput.readOnly = false;
      document.getElementById("kmInput").readOnly = false;
      document.getElementById("unidadIdInput").value = "";
      tipoSelect.selectedIndex = 0;
      document.getElementById("maintenanceModalLabel").textContent =
        "Registrar nuevo mantenimiento";
      new bootstrap.Modal(document.getElementById("maintenanceModal")).show();
    });
  }

  // ---------------------------
  // Cargar tipos (reutilizable)
  // ---------------------------
  function loadTiposMantenimiento() {
    return cargarTiposEnSelect();
  }

  // ---------------------------
  // Exportar CSV
  // ---------------------------
  const exportBtn = document.getElementById("exportCsv");
  if (exportBtn) {
    exportBtn.addEventListener("click", () => {
      let rows = [
        [
          "Unidad",
          "Modelo",
          "VIN",
          "Tipo mantenimiento",
          "Estatus",
          "Ingreso",
          "Salida",
          "Kilometraje",
          "Taller",
          "Costo",
          "Descripción",
        ],
      ];

      // 🔍 Obtener filtros de DataTable
      let searchGlobal = dataTableInstance
        ? dataTableInstance.search().toLowerCase()
        : "";

      // 🔍 Obtener filtros por columna (inputs y selects)
      const filters = [];
      document
        .querySelectorAll("#maintTable thead tr.filters th")
        .forEach((th, index) => {
          const input = th.querySelector("input, select");
          filters[index] = input ? input.value.toLowerCase() : "";
        });

      // 🧠 Mapear columnas con tus datos reales
      const columnMap = [
        "id_unidad",
        "modelo",
        "vin",
        "tipo",
        "estatus",
        "fecha_ingreso",
        "fecha_salida",
        "km_actual",
        "nombre_taller",
        "costo_estimado",
        "descripcion_trabajo",
      ];

      // 🔥 FILTRAR SOBRE EL JSON ORIGINAL
      const dataFiltrada = mantenimientosData.filter((m) => {
        // 🔍 Filtro global
        if (searchGlobal) {
          const texto = Object.values(m).join(" ").toLowerCase();
          if (!texto.includes(searchGlobal)) return false;
        }

        // 🔍 Filtros por columna
        for (let i = 0; i < filters.length; i++) {
          const val = filters[i];
          if (!val) continue;

          const field = columnMap[i];
          if (!field) continue;

          const dato = (m[field] || "").toString().toLowerCase();

          if (!dato.includes(val)) return false;
        }

        return true;
      });

      // 🧾 Generar CSV (SIN recortes 🔥)
      dataFiltrada.forEach((m) => {
        rows.push([
          m.id_unidad,
          m.modelo || "",
          m.vin || "",
          m.tipo || "",
          m.estatus || "",
          m.fecha_ingreso || "",
          m.fecha_salida || "",
          m.km_manual || m.km_actual || 0,
          m.nombre_taller || "",
          m.costo_estimado || 0,
          m.descripcion_trabajo || "", // 🔥 COMPLETO
        ]);
      });

      const csv = rows
        .map((r) =>
          r
            .map((c) => `"${(c || "").toString().replace(/"/g, '""')}"`)
            .join(","),
        )
        .join("\n");

      const BOM = "\uFEFF";
      const blob = new Blob([BOM + csv], {
        type: "text/csv;charset=utf-8;",
      });

      const a = document.createElement("a");
      a.href = URL.createObjectURL(blob);
      a.download = "mantenimientos_filtrados.csv";
      a.click();
    });
  }

  // ---------------------------
  // Limpiar modal al cerrarlo
  // ---------------------------
  // 🧹 Limpiar modal al cerrarla
  const maintenanceModalEl = document.getElementById("maintenanceModal");

  maintenanceModalEl.addEventListener("hidden.bs.modal", function () {
    maintenanceForm.reset();
    selectedUnidadId = null;
    unidadInput.readOnly = false;
    document.getElementById("kmInput").readOnly = false;
    document.getElementById("unidadIdInput").value = "";
    tipoSelect.selectedIndex = 0;
  });
  // ---------------------------
  // Gráfica telemetría (Half Doughnut estilo medidor)
  // ---------------------------
  function loadTelemetriaChart() {
    fetch(
      "../../Servidor/solicitudes/unidades/mantenimientos_unidades_flotilla/obtener_unidades_telemetria_demo.php",
    )
      .then((res) => res.json())
      .then((data) => {
        const counts = { con: 0, sin: 0 };
        data.forEach((u) => {
          if (u.tiene_telemetria) counts.con += 1;
          else counts.sin += 1;
        });

        const total = counts.con + counts.sin;
        const porcentajeCon = total
          ? ((counts.con / total) * 100).toFixed(1)
          : 0;

        // Crear gráfico semicircular
        const ctx = document.getElementById("chartTelemetria");
        if (ctx) {
          if (window.chartTelemetriaInstance) {
            try {
              window.chartTelemetriaInstance.destroy();
            } catch {}
          }
          window.chartTelemetriaInstance = new Chart(ctx, {
            type: "doughnut",
            data: {
              labels: ["Con telemetría", "Sin telemetría"],
              datasets: [
                {
                  data: [counts.con, counts.sin],
                  backgroundColor: ["#5a4d92ff", "#be2177ff"],
                  borderWidth: 0,
                },
              ],
            },
            options: {
              rotation: -90, // inicia desde la parte inferior
              circumference: 180, // solo media circunferencia
              cutout: "70%", // grosor del anillo
              responsive: true,
              maintainAspectRatio: false,
              plugins: {
                legend: {
                  position: "bottom",
                },
                title: {
                  display: true,
                  text: `Unidades con telemetría: ${porcentajeCon}%`,
                  font: { size: 16, weight: "bold" },
                },
                tooltip: {
                  callbacks: {
                    label: (ctx) => `${ctx.label}: ${ctx.raw} unidades`,
                  },
                },
              },
            },
          });
        }

        // Botón export CSV
        const exportBtn = document.getElementById("exportTelemetriaCsv");
        if (exportBtn) {
          exportBtn.onclick = () => {
            const rows = [
              ["Unidad", "Modelo", "VIN", "Km actual", "Tiene telemetria"],
            ];
            data.forEach((u) => {
              rows.push([
                u.id_unidad,
                u.nombre_modelo || "",
                u.vin || "",
                u.ultimo_kilometraje || 0,
                u.tiene_telemetria ? "Si" : "No",
              ]);
            });
            const csv = rows
              .map((r) =>
                r
                  .map((c) => `"${(c || "").toString().replace(/"/g, '""')}"`)
                  .join(","),
              )
              .join("\n");
            const BOM = "\uFEFF";
            const blob = new Blob([BOM + csv], {
              type: "text/csv;charset=utf-8;",
            });
            const a = document.createElement("a");
            a.href = URL.createObjectURL(blob);
            a.download = "unidades_telemetria.csv";
            a.click();
          };
        }
      })
      .catch((err) => console.error("Error al cargar telemetría:", err));
  }

  // Llamar a telemetría independiente
  loadTelemetriaChart();
});

window.verEvidencias = function (mantenimiento) {
  let contenido = "";

  // ==========================
  // FACTURA
  // ==========================
  if (mantenimiento.factura) {
    contenido += `
      <div class="mb-4">
        <h6>Factura</h6>

        <a 
          href="../../Servidor/archivos/files/files_mantenimientos_flotilla/facturas_mantenimientos_flotilla/${mantenimiento.factura}" 
          target="_blank"
          class="btn btn-danger btn-sm">

          <i class="bi bi-file-earmark-pdf"></i>
          Ver factura
        </a>
      </div>
    `;
  }

  // ==========================
  // EVIDENCIAS
  // ==========================
  const evidencias = [
    {
      titulo: "Tarjeta de circulación",
      archivo: mantenimiento.foto_tarjeta_circulacion,
    },
    {
      titulo: "Odómetro",
      archivo: mantenimiento.foto_odometro,
    },
    {
      titulo: "Cara de llanta",
      archivo: mantenimiento.foto_llanta,
    },
    {
      titulo: "Desgaste de llanta",
      archivo: mantenimiento.foto_desgaste,
    },
  ];

  evidencias.forEach((ev) => {
    if (ev.archivo) {
      contenido += `
        <div class="col-md-6 mb-3 text-center">

          <h6>${ev.titulo}</h6>

          <a 
            href="../../Servidor/archivos/files/files_mantenimientos_flotilla/evidencias/${ev.archivo}" 
            target="_blank">

            <img 
              src="../../Servidor/archivos/files/files_mantenimientos_flotilla/evidencias/${ev.archivo}"
              class="img-fluid rounded border shadow-sm"
              style="max-height:250px; object-fit:cover;">
          </a>

        </div>
      `;
    }
  });

  // Si no hay nada
  if (!contenido) {
    contenido = `
      <div class="alert alert-warning mb-0">
        No hay evidencias registradas.
      </div>
    `;
  }

  // Insertar contenido
  document.getElementById("contenidoEvidencias").innerHTML = `
    <div class="row">
      ${contenido}
    </div>
  `;

  // Abrir modal
  const modal = new bootstrap.Modal(document.getElementById("modalEvidencias"));

  modal.show();
};
