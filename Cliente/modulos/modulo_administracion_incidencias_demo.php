<!-------------------------------------------aqui comienza el contenedor Validacion de los comodatos ----------------------------------------------------------->
<div class="contenedorvalidacionunidades">
    <h5 class="titulosletrasunidades text-nowrap">
        <a class="navbar-brand" href="#"><i class="bi bi-tools"></i> Flotilla - Incidencias (Demo)</a>
    </h5>
    <h4 class="letravalidacionunidadresponsiva text-nowrap"></h4>
</div>

<!-- ========================= -->
<!-- MÓDULO: Registro Incidencias -->
<!-- ========================= -->
<?php
// modulo_incidencias_admin_demo.php
// Maqueta front-end para administración de incidencias (unidades demo id_tipo_unidad = 3)
// Archivo solo UI: usa datos simulados en JavaScript. Reemplaza con endpoints reales cuando tengas backend.
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Administración de Incidencias - Demo</title>
  <!-- Bootstrap 5 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.1/css/bootstrap.min.css" rel="stylesheet">
  <!-- DataTables -->
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <!-- Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { padding: 18px; background: #f7f9fc; }
    .card-compact { padding: 12px; border-radius: 12px; box-shadow: 0 6px 18px rgba(20,20,50,0.04); }
    .chart-wrap { height: 260px; }
    .table-responsive { max-height: 420px; overflow: auto; }
    .badge-status-registrada { background:#f0ad4e; }
    .badge-status-proceso { background:#17a2b8; color:#fff; }
    .badge-status-finalizada { background:#28a745; color:#fff; }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row mb-3">
      <div class="col-12 d-flex align-items-center justify-content-between">
        <h3 class="m-0">Módulo administración - Incidencias (Demo)</h3>
        <div>
          <button id="exportAllCsv" class="btn btn-outline-secondary btn-sm"><i class="bi bi-download"></i> Exportar CSV</button>
          <button id="refreshBtn" class="btn btn-primary btn-sm ms-2"><i class="bi bi-arrow-clockwise"></i> Actualizar</button>
        </div>
      </div>
    </div>

    <!-- filtros y resumen -->
    <div class="row g-3 mb-3">
      <div class="col-md-3">
        <label class="form-label">Rango de fechas</label>
        <div class="input-group">
          <input id="filterFrom" type="date" class="form-control">
          <input id="filterTo" type="date" class="form-control">
        </div>
      </div>
      <div class="col-md-3">
        <label class="form-label">Tipo de incidencia</label>
        <select id="filterTipo" class="form-select">
          <option value="">Todos</option>
          <option value="Daño menor">Daño menor</option>
          <option value="Accidente">Accidente</option>
          <option value="Robo autopartes">Robo de autopartes</option>
          <option value="Robo total">Robo total de la unidad</option>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">Estatus</label>
        <select id="filterEstatus" class="form-select">
          <option value="">Todos</option>
          <option value="Registrada">Registrada</option>
          <option value="En proceso">En proceso</option>
          <option value="Finalizada">Finalizada</option>
        </select>
      </div>
      <div class="col-md-3 d-flex align-items-end">
        <button id="applyFilters" class="btn btn-success me-2">Aplicar</button>
        <button id="clearFilters" class="btn btn-outline-secondary">Limpiar</button>
      </div>
    </div>

    <!-- Dashboard cards + charts -->
    <div class="row mb-4">
      <div class="col-md-3">
        <div class="card card-compact">
          <h6>Total incidencias</h6>
          <div id="cardTotal" class="display-6 fw-bold">0</div>
          <small class="text-muted">(Unidades demo)</small>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card card-compact">
          <h6>Incidencias abiertas</h6>
          <div id="cardAbiertas" class="display-6 fw-bold text-danger">0</div>
          <small class="text-muted">Registrada / En proceso</small>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card card-compact">
          <h6>Incidencias por tipo</h6>
          <div class="chart-wrap mt-2"><canvas id="chartTipo"></canvas></div>
        </div>
      </div>
    </div>

    <div class="row g-3 mb-4">
      <div class="col-md-6">
        <div class="card card-compact">
          <h6>Tendencia mensual</h6>
          <div class="chart-wrap mt-2"><canvas id="chartMensual"></canvas></div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card card-compact">
          <h6>Estatus</h6>
          <div class="chart-wrap mt-2"><canvas id="chartEstatus"></canvas></div>
        </div>
      </div>
    </div>

    <!-- Tabla incidencias -->
    <div class="row">
      <div class="col-12">
        <div class="card p-3">
          <div class="d-flex justify-content-between mb-2">
            <h5 class="mb-0">Listado de incidencias</h5>
            <div>
              <button id="exportFilteredCsv" class="btn btn-outline-primary btn-sm"><i class="bi bi-file-earmark-spreadsheet"></i> Exportar filtradas</button>
            </div>
          </div>
          <div class="table-responsive">
            <table id="incidenciasTable" class="table table-striped table-hover" style="width:100%">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Unidad</th>
                  <th>Tipo</th>
                  <th>Fecha</th>
                  <th>Estatus</th>
                  <th>Reportó</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Modal detalles -->
  <div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <form id="detailForm">
          <div class="modal-header">
            <h5 class="modal-title">Detalle de incidencia</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="detailId">
            <div class="mb-2"><strong>Unidad:</strong> <span id="detailUnidad"></span></div>
            <div class="mb-2"><strong>Tipo:</strong> <span id="detailTipo"></span></div>
            <div class="mb-2"><strong>Fecha:</strong> <span id="detailFecha"></span></div>
            <div class="mb-2"><strong>Estatus:</strong>
              <select id="detailEstatus" class="form-select form-select-sm w-auto d-inline-block ms-2">
                <option>Registrada</option>
                <option>En proceso</option>
                <option>Finalizada</option>
              </select>
            </div>
            <div class="mb-2"><strong>Reportó:</strong> <span id="detailReporto"></span></div>
            <div class="mb-3"><strong>Descripción:</strong><div id="detailDesc" class="border rounded p-2 bg-light"></div></div>

            <div id="detailGallery" class="mb-3"></div>

            <div class="mb-3">
              <label class="form-label">Observaciones del administrador</label>
              <textarea id="detailNotas" class="form-control" rows="3"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Librerías -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

  <script>
    // ------------------------------
    // Datos simulados (reemplazar por fetch a su API)
    // ------------------------------
    const demoIncidencias = [
      { id: 101, id_unidad: 190, unidad: 'FOTON S3 EV (LVBJ3J1C1SW114912)', tipo: 'Daño menor', fecha: '2025-10-20', estatus: 'Registrada', reporto: 'Juan Pérez', descripcion: 'Rayón en parachoques trasero', fotos: [], id_tipo_unidad: 3 },
      { id: 102, id_unidad: 191, unidad: 'FOTON S3 EV (LVBJ3J1C1SW114913)', tipo: 'Accidente', fecha: '2025-11-01', estatus: 'En proceso', reporto: 'María López', descripcion: 'Colisión lateral, requiere grúa', fotos: [], id_tipo_unidad: 3 },
      { id: 103, id_unidad: 200, unidad: 'OTRO MODELO (VIN000000)', tipo: 'Robo de autopartes', fecha: '2025-11-02', estatus: 'Finalizada', reporto: 'Carlos Ruiz', descripcion: 'Robaron batería y faros', fotos: [], id_tipo_unidad: 3 },
      { id: 104, id_unidad: 205, unidad: 'DEMO (VINDEMO205)', tipo: 'Robo total', fecha: '2025-11-03', estatus: 'Registrada', reporto: 'Ana Gómez', descripcion: 'Unidad no localizada', fotos: [], id_tipo_unidad: 3 }
    ];

    // ------------------------------
    // Estado
    // ------------------------------
    let incidencias = [...demoIncidencias]; // copia
    let tableInstance = null;

    // ------------------------------
    // Utilidades
    // ------------------------------
    function applyFiltersToList(list) {
      const fFrom = document.getElementById('filterFrom').value;
      const fTo = document.getElementById('filterTo').value;
      const fTipo = document.getElementById('filterTipo').value;
      const fEstatus = document.getElementById('filterEstatus').value;

      return list.filter(i => {
        if (fTipo && i.tipo !== fTipo) return false;
        if (fEstatus && i.estatus !== fEstatus) return false;
        if (fFrom) {
          if (new Date(i.fecha) < new Date(fFrom)) return false;
        }
        if (fTo) {
          if (new Date(i.fecha) > new Date(fTo)) return false;
        }
        // filtrar por demo id_tipo_unidad=3
        if (i.id_tipo_unidad !== 3) return false;
        return true;
      });
    }

    // ------------------------------
    // Render tabla
    // ------------------------------
    function renderTable(list) {
      const tbody = document.querySelector('#incidenciasTable tbody');
      tbody.innerHTML = '';
      list.forEach(i => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${i.id}</td>
          <td>${i.unidad}</td>
          <td>${i.tipo}</td>
          <td>${i.fecha}</td>
          <td>${renderBadge(i.estatus)}</td>
          <td>${i.reporto}</td>
          <td>
            <button class="btn btn-sm btn-outline-primary" onclick='openDetail(${i.id})'><i class="bi bi-eye"></i></button>
          </td>
        `;
        tbody.appendChild(tr);
      });

      // inicializar/recargar DataTable
      if (tableInstance) {
        try { tableInstance.destroy(); } catch(e){}
      }
      tableInstance = $('#incidenciasTable').DataTable({ pageLength: 6, lengthMenu:[[6,10,25],[6,10,25]] });
    }

    function renderBadge(status){
      if (status==='Registrada') return `<span class="badge badge-status-registrada">${status}</span>`;
      if (status==='En proceso') return `<span class="badge badge-status-proceso">${status}</span>`;
      if (status==='Finalizada') return `<span class="badge badge-status-finalizada">${status}</span>`;
      return status;
    }

    // ------------------------------
    // Charts
    // ------------------------------
    let chartTipoInstance = null, chartMensualInstance = null, chartEstatusInstance = null;

    function renderCharts(filtered) {
      // Totales
      document.getElementById('cardTotal').textContent = filtered.length;
      document.getElementById('cardAbiertas').textContent = filtered.filter(i=> i.estatus!=='Finalizada').length;

      // Tipo
      const tipos = ['Daño menor','Accidente','Robo de autopartes','Robo total'];
      const tipoCounts = tipos.map(t => filtered.filter(i=> i.tipo===t).length);
      const ctxTipo = document.getElementById('chartTipo');
      if (ctxTipo) {
        if (chartTipoInstance) try{ chartTipoInstance.destroy(); }catch{}
        chartTipoInstance = new Chart(ctxTipo, { type: 'polarArea', data: { labels: tipos, datasets:[{ data: tipoCounts }] }, options:{ responsive:true, plugins:{ legend:{position:'right'} } } });
      }

      // Mensual (últimos 6 meses)
      const months = [];
      const labels = [];
      const now = new Date();
      for (let i=5;i>=0;i--) {
        const d = new Date(now.getFullYear(), now.getMonth()-i, 1);
        const key = `${d.getFullYear()}-${(d.getMonth()+1).toString().padStart(2,'0')}`;
        labels.push(d.toLocaleString('default',{month:'short',year:'numeric'}));
        months.push(key);
      }
      const mensualCounts = months.map(k => filtered.filter(i => i.fecha.startsWith(k)).length);
      const ctxMensual = document.getElementById('chartMensual');
      if (ctxMensual) {
        if (chartMensualInstance) try{ chartMensualInstance.destroy(); }catch{}
        chartMensualInstance = new Chart(ctxMensual, { type: 'line', data:{ labels, datasets:[{ label:'Incidencias', data: mensualCounts, tension:0.3, fill:true }] }, options:{ responsive:true, plugins:{ legend:{display:false} } } });
      }

      // Estatus
      const estLabels = ['Registrada','En proceso','Finalizada'];
      const estCounts = estLabels.map(s => filtered.filter(i => i.estatus === s).length);
      const ctxEstatus = document.getElementById('chartEstatus');
      if (ctxEstatus) {
        if (chartEstatusInstance) try{ chartEstatusInstance.destroy(); }catch{}
        chartEstatusInstance = new Chart(ctxEstatus, { type: 'bar', data:{ labels: estLabels, datasets:[{ label:'Cantidad', data: estCounts }] }, options:{ indexAxis:'y', responsive:true, plugins:{ legend:{display:false} } } });
      }
    }

    // ------------------------------
    // Detalle modal
    // ------------------------------
    function openDetail(id) {
      const inc = incidencias.find(x=>x.id===id);
      if (!inc) return;
      document.getElementById('detailId').value = inc.id;
      document.getElementById('detailUnidad').textContent = inc.unidad;
      document.getElementById('detailTipo').textContent = inc.tipo;
      document.getElementById('detailFecha').textContent = inc.fecha;
      document.getElementById('detailEstatus').value = inc.estatus;
      document.getElementById('detailReporto').textContent = inc.reporto;
      document.getElementById('detailDesc').textContent = inc.descripcion;
      document.getElementById('detailNotas').value = inc.notas || '';

      // gallery
      const gallery = document.getElementById('detailGallery');
      gallery.innerHTML = '';
      if (inc.fotos && inc.fotos.length) {
        inc.fotos.forEach(src=>{
          const img = document.createElement('img'); img.src = src; img.style.maxWidth='120px'; img.className='me-2 mb-2 rounded';
          gallery.appendChild(img);
        });
      } else {
        gallery.innerHTML = '<small class="text-muted">No hay imágenes</small>';
      }

      const modal = new bootstrap.Modal(document.getElementById('detailModal'));
      modal.show();
    }

    // Guardar cambios en modal (front-only)
    document.getElementById('detailForm').addEventListener('submit', function(e){
      e.preventDefault();
      const id = Number(document.getElementById('detailId').value);
      const est = document.getElementById('detailEstatus').value;
      const notas = document.getElementById('detailNotas').value;
      const inc = incidencias.find(x=>x.id===id);
      if (!inc) return;
      inc.estatus = est;
      inc.notas = notas;

      // cerrar modal
      const modal = bootstrap.Modal.getInstance(document.getElementById('detailModal'));
      modal.hide();

      // refrescar UI
      applyAndRender();
    });

    // ------------------------------
    // Export CSV
    // ------------------------------
    function exportCsv(list, filename='incidencias_export.csv'){
      const rows = [['ID','Unidad','Tipo','Fecha','Estatus','Reportó','Descripción']];
      list.forEach(i=> rows.push([i.id, i.unidad, i.tipo, i.fecha, i.estatus, i.reporto, i.descripcion]));
      const csv = rows.map(r => r.map(c => `"${(c||'').toString().replace(/"/g,'""')}"`).join(',')).join('\n');
      const blob = new Blob([csv], { type: 'text/csv' });
      const a = document.createElement('a'); a.href = URL.createObjectURL(blob); a.download = filename; a.click();
    }

    // ------------------------------
    // Main: apply filters + render
    // ------------------------------
    function applyAndRender(){
      const filtered = applyFiltersToList(incidencias);
      renderTable(filtered);
      renderCharts(filtered);
    }

    // botones
    document.getElementById('applyFilters').addEventListener('click', ()=> applyAndRender());
    document.getElementById('clearFilters').addEventListener('click', ()=>{
      document.getElementById('filterFrom').value = '';
      document.getElementById('filterTo').value = '';
      document.getElementById('filterTipo').selectedIndex = 0;
      document.getElementById('filterEstatus').selectedIndex = 0;
      applyAndRender();
    });

    document.getElementById('refreshBtn').addEventListener('click', ()=>{
      // en proyecto real: volver a fetch desde API
      applyAndRender();
    });

    document.getElementById('exportAllCsv').addEventListener('click', ()=> exportCsv(incidencias,'incidencias_todas.csv'));
    document.getElementById('exportFilteredCsv').addEventListener('click', ()=> exportCsv(applyFiltersToList(incidencias),'incidencias_filtradas.csv'));

    // Inicialización
    (function init(){
      // en proyecto real: obtener incidencias desde API
      incidencias = [...demoIncidencias];
      applyAndRender();
    })();

  </script>
</body>
</html>


<!-- JS -->
<script src="js/modulo_incidencias_registro.js"></script>