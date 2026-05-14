document.addEventListener("DOMContentLoaded", function () {
  const flotillaBody = document.getElementById("flotillaBody");
  let dataTableInstance = null;

  function crearFiltros() {
    if (document.querySelector("#flotillaTable thead tr.filters")) return;

    const thead = document.querySelector("#flotillaTable thead");
    const ths = thead.querySelectorAll("tr th");
    const filterRow = document.createElement("tr");
    filterRow.classList.add("filters");

    ths.forEach((th, i) => {
      const title = th.textContent.toLowerCase();
      const cell = document.createElement("th");

      // Columnas con SELECT
      if (["modelo", "marca", "estatus", "tipo de unidad", "sede"].some(t => title.includes(t))) {
        const select = document.createElement("select");
        select.className = "form-select form-select-sm";
        select.innerHTML = `<option value="">Todos</option>`;
        if (dataTableInstance) {
          dataTableInstance
            .column(i)
            .data()
            .unique()
            .sort()
            .each(d => { if(d) select.innerHTML += `<option value="${d}">${d}</option>` });
        }
        select.onchange = () => dataTableInstance.column(i).search(select.value).draw();
        cell.appendChild(select);
      }
      // Columnas con input
      else if (!title.includes("acciones") && !title.includes("maps")) {
        const input = document.createElement("input");
        input.className = "form-control form-control-sm";
        input.placeholder = th.textContent;
        input.onkeyup = () => dataTableInstance.column(i).search(input.value).draw();
        cell.appendChild(input);
      }

      filterRow.appendChild(cell);
    });

    thead.prepend(filterRow);
  }

  function loadFlotilla() {
    fetch("../../Servidor/solicitudes/unidades/obtener_unidades_demo.php")
      .then(r => r.ok ? r.text() : Promise.reject("HTTP " + r.status))
      .then(html => {
        if (dataTableInstance) dataTableInstance.destroy();
        flotillaBody.innerHTML = html;

        // Inicializa DataTable
        dataTableInstance = $("#flotillaTable").DataTable({

  pageLength: 10,
  order: [[1, "desc"]],

  dom: 'Bfrtip',

  buttons: [

    {
      extend: 'csvHtml5',
      text: 'EXCEL',
      className: 'btn btn-success btn-sm',
      title: 'Reporte_Unidades_Demo',
      exportOptions: {
        columns: [1,2,3,4,5,6,7,8,9,10]
      }
    },

    {
      extend: 'pdfHtml5',
      text: 'PDF',
      className: 'btn btn-danger btn-sm',
      title: 'Reporte_Flotilla_Demo',
      orientation: 'landscape',
      pageSize: 'A4',
      exportOptions: {
        columns: [1,2,3,4,5,6,7,8,9,10]
      }
    }

  ],

  language: {
    url: "https://cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
  }

});

        crearFiltros();
      })
      .catch(err => console.error("Error flotilla:", err));
  }

  loadFlotilla();
});
