<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Vida útil de Unidades Demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
  <style>
    body { background: #0b1020; }
    .page-title { color: #e6e9f0; }
    .card { border: none; border-radius: 1rem; }
    .shadow-soft { box-shadow: 0 10px 30px rgba(0,0,0,.25); }
    .badge-status { font-weight: 600; letter-spacing: .2px; }
    .table thead th { position: sticky; top: 0; background: #0f1533; color:#cbd5e1; z-index:1; }
    .status-dot { width:10px; height:10px; border-radius:50%; display:inline-block; margin-right:6px; }
    .dot-activa { background:#0d6efd; }
    .dot-proxima { background:#ffc107; }
    .dot-venta { background:#dc3545; }
    .progress { height: 10px; background:#1b2347; }
    .progress-bar { border-radius: 10px; }
    .search-input::placeholder { color:#9aa3b2; }
    .filter-pill { cursor:pointer; }
    .offcanvas { --bs-offcanvas-bg: #0f1533; color: #e6e9f0; }
    .offcanvas .form-label { color:#9aa3b2; }
  </style>
</head>
<body>
  <div class="container-fluid py-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 gap-3">
      <h1 class="page-title h3 m-0">Vida útil de Unidades Demo</h1>
      <div class="d-flex gap-2">
        <button class="btn btn-light btn-sm" data-bs-toggle="offcanvas" data-bs-target="#filtros"><i class="bi bi-sliders"></i> Filtros</button>
        <button id="btnExport" class="btn btn-outline-light btn-sm">Exportar CSV</button>
      </div>
    </div>

    <!-- KPIs -->
    <div class="row g-3 mb-4">
      <div class="col-12 col-md-3">
        <div class="card bg-dark text-light shadow-soft">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <small class="text-secondary">Total unidades</small>
                <h3 id="kpiTotal" class="mb-0">0</h3>
              </div>
              <span class="status-dot dot-activa"></span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-3">
        <div class="card bg-dark text-light shadow-soft">
          <div class="card-body">
            <small class="text-secondary">Activas (&lt; 48 meses)</small>
            <h3 id="kpiActivas" class="mb-0">0</h3>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-3">
        <div class="card bg-dark text-light shadow-soft">
          <div class="card-body">
            <small class="text-secondary">Próximas a venta (48–59)</small>
            <h3 id="kpiProximas" class="mb-0">0</h3>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-3">
        <div class="card bg-dark text-light shadow-soft">
          <div class="card-body">
            <small class="text-secondary">Para vender (≥ 60)</small>
            <h3 id="kpiVenta" class="mb-0">0</h3>
          </div>
        </div>
      </div>
    </div>

    <!-- Chart -->
    <div class="row g-3 mb-4">
      <div class="col-12 col-lg-4">
        <div class="card bg-dark text-light shadow-soft h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6 class="m-0">Distribución por estado</h6>
            </div>
            <canvas id="estadoChart"></canvas>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-8">
        <div class="card bg-dark text-light shadow-soft h-100">
          <div class="card-body">
            <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
              <div class="input-group">
                <span class="input-group-text bg-dark text-secondary border-secondary">Buscar</span>
                <input id="search" type="search" class="form-control bg-dark text-light border-secondary search-input" placeholder="Marca, modelo, placas, VIN...">
              </div>
              <div class="d-flex gap-2 flex-wrap">
                <span class="badge text-bg-primary filter-pill" data-status="ACTIVA"><span class="status-dot dot-activa"></span> Activas</span>
                <span class="badge text-bg-warning filter-pill" data-status="PROXIMA"><span class="status-dot dot-proxima"></span> Próximas</span>
                <span class="badge text-bg-danger filter-pill" data-status="VENTA"><span class="status-dot dot-venta"></span> Para vender</span>
                <span class="badge text-bg-secondary filter-pill" data-status="ALL">Mostrar todo</span>
              </div>
            </div>
            <div class="table-responsive" style="max-height: 60vh;">
              <table class="table table-dark table-hover align-middle mb-0" id="tablaUnidades">
                <thead>
                  <tr>
                    <th>Unidad</th>
                    <th>VIN / Placas</th>
                    <th>Fecha Alta</th>
                    <th>Edad</th>
                    <th>Vida útil</th>
                    <th>Estado</th>
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

    <!-- Offcanvas filtros -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="filtros">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title">Filtros avanzados</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <div class="mb-3">
          <label class="form-label">Rango de edad (meses)</label>
          <div class="d-flex gap-2">
            <input id="minMeses" type="number" class="form-control bg-dark text-light border-secondary" placeholder="mín" min="0" />
            <input id="maxMeses" type="number" class="form-control bg-dark text-light border-secondary" placeholder="máx" min="0" />
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Sede (opcional)</label>
          <input id="sede" type="text" class="form-control bg-dark text-light border-secondary" placeholder="Ej. CDMX" />
        </div>
        <button id="btnAplicarFiltros" class="btn btn-light w-100">Aplicar filtros</button>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // ==========================
    // Utilidades de fecha/vida
    // ==========================
    const VIDA_UTIL_MESES = 60; // 5 años

    function monthsBetween(d1, d2){
      // d1, d2: Date
      let months = (d2.getFullYear() - d1.getFullYear()) * 12;
      months += d2.getMonth() - d1.getMonth();
      // Ajuste por día del mes
      if (d2.getDate() < d1.getDate()) months -= 1;
      return Math.max(0, months);
    }

    function formatDateMX(dateStr){
      const d = new Date(dateStr);
      if (isNaN(d)) return '-';
      const dd = String(d.getDate()).padStart(2,'0');
      const mm = String(d.getMonth()+1).padStart(2,'0');
      const yyyy = d.getFullYear();
      return `${dd}/${mm}/${yyyy}`;
    }

    function calcularEstado(meses){
      if (meses >= 60) return { clave:'VENTA', texto:'Para vender', clase:'danger', dot:'dot-venta' };
      if (meses >= 48) return { clave:'PROXIMA', texto:'Próxima a venta', clase:'warning', dot:'dot-proxima' };
      return { clave:'ACTIVA', texto:'Activa', clase:'primary', dot:'dot-activa' };
    }

    function progresoVida(meses){
      const pct = Math.min(100, Math.round((meses/VIDA_UTIL_MESES)*100));
      return pct;
    }

    // =====================================================
    // Datos (DEMO): Sustituye por fetch a tu endpoint PHP
    // =====================================================
    // Estructura esperada por unidad:
    // { id:1, marca:'Ford', modelo:'Ranger', anio:2021, vin:'XYZ', placas:'ABC-123', fecha_alta:'2021-09-15', sede:'CDMX' }
    let unidades = [
      { id:1, marca:'Nissan', modelo:'Frontier', anio:2021, vin:'1N6BA07A05N512345', placas:'ABC-123-A', fecha_alta:'2021-08-10', sede:'CDMX' },
      { id:2, marca:'Toyota', modelo:'Hilux', anio:2020, vin:'JT1234567890HILUX', placas:'XYZ-987-B', fecha_alta:'2020-07-01', sede:'MTY' },
      { id:3, marca:'Chevrolet', modelo:'S10', anio:2019, vin:'9BG123456789S1001', placas:'HJK-456-C', fecha_alta:'2019-06-20', sede:'GDL' },
      { id:4, marca:'Ford', modelo:'Ranger', anio:2018, vin:'1FT123456789RANGER', placas:'QWE-852-D', fecha_alta:'2018-05-05', sede:'CDMX' },
      { id:5, marca:'RAM', modelo:'700', anio:2017, vin:'3C6TRVBGXHE123456', placas:'LMN-321-E', fecha_alta:'2017-04-15', sede:'QRO' },
    ];

    // Ejemplo de cómo conectarlo a tu backend PHP (descomenta y ajusta URL):
    // async function cargarUnidades(){
    //   const r = await fetch('Servidor/unidades_demo/obtener_unidades_demo.php');
    //   unidades = await r.json();
    //   render();
    // }

    // ==========================
    // Renderizado principal
    // ==========================
    const tbody = document.querySelector('#tablaUnidades tbody');
    const searchInput = document.getElementById('search');
    const minMeses = document.getElementById('minMeses');
    const maxMeses = document.getElementById('maxMeses');
    const sedeInput = document.getElementById('sede');
    const kpiTotal = document.getElementById('kpiTotal');
    const kpiActivas = document.getElementById('kpiActivas');
    const kpiProximas = document.getElementById('kpiProximas');
    const kpiVenta = document.getElementById('kpiVenta');

    let filtroEstado = 'ALL';

    function aplicarFiltros(data){
      const q = (searchInput.value || '').toLowerCase();
      const min = minMeses.value ? parseInt(minMeses.value,10) : null;
      const max = maxMeses.value ? parseInt(maxMeses.value,10) : null;
      const sede = (sedeInput.value || '').toLowerCase();

      const hoy = new Date();
      return data.filter(u=>{
        const meses = monthsBetween(new Date(u.fecha_alta), hoy);
        const texto = `${u.marca} ${u.modelo} ${u.placas} ${u.vin}`.toLowerCase();
        const enBusqueda = !q || texto.includes(q);
        const enMin = (min===null) || (meses >= min);
        const enMax = (max===null) || (meses <= max);
        const enSede = !sede || (String(u.sede||'').toLowerCase().includes(sede));
        const estado = calcularEstado(meses).clave;
        const enEstado = (filtroEstado==='ALL') || (estado===filtroEstado);
        return enBusqueda && enMin && enMax && enSede && enEstado;
      });
    }

    function actualizarKPIs(data){
      const hoy = new Date();
      const counts = { ACTIVA:0, PROXIMA:0, VENTA:0 };
      data.forEach(u=>{
        const meses = monthsBetween(new Date(u.fecha_alta), hoy);
        counts[calcularEstado(meses).clave]++;
      });
      kpiTotal.textContent = data.length;
      kpiActivas.textContent = counts.ACTIVA;
      kpiProximas.textContent = counts.PROXIMA;
      kpiVenta.textContent = counts.VENTA;
      actualizarChart(counts);
    }

    let chartRef = null;
    function actualizarChart(counts){
      const ctx = document.getElementById('estadoChart');
      const data = {
        labels: ['Activas', 'Próximas', 'Para vender'],
        datasets: [{ data: [counts.ACTIVA, counts.PROXIMA, counts.VENTA] }]
      };
      if(chartRef){ chartRef.destroy(); }
      chartRef = new Chart(ctx, { type:'doughnut', data });
    }

    function renderTabla(data){
      const hoy = new Date();
      tbody.innerHTML = '';
      data.forEach(u=>{
        const meses = monthsBetween(new Date(u.fecha_alta), hoy);
        const estado = calcularEstado(meses);
        const pct = progresoVida(meses);
        const restante = Math.max(0, VIDA_UTIL_MESES - meses);
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>
            <div class="fw-semibold">${u.marca} ${u.modelo} <small class="text-secondary">${u.anio||''}</small></div>
            <div class="text-secondary small">Sede: ${u.sede||'-'}</div>
          </td>
          <td>
            <div class="small">VIN: <span class="text-light">${u.vin||'-'}</span></div>
            <div class="small">Placas: <span class="text-light">${u.placas||'-'}</span></div>
          </td>
          <td>${formatDateMX(u.fecha_alta)}</td>
          <td>
            <div class="fw-semibold">${meses} meses</div>
            <div class="text-secondary small">Restan ${restante} meses</div>
          </td>
          <td style="min-width:220px">
            <div class="d-flex align-items-center gap-2">
              <div class="progress flex-grow-1">
                <div class="progress-bar bg-${estado.clase}" role="progressbar" style="width:${pct}%" aria-valuenow="${pct}" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <span class="small text-secondary">${pct}%</span>
            </div>
            <div class="small text-secondary">Meta: 60 meses</div>
          </td>
          <td>
            <span class="badge text-bg-${estado.clase} badge-status"><span class="status-dot ${estado.dot}"></span>${estado.texto}</span>
          </td>
          <td>
            <div class="btn-group btn-group-sm" role="group">
              <button class="btn btn-outline-light" title="Detalle" onclick="verDetalle(${u.id})">Detalle</button>
              <button class="btn btn-outline-light" title="Recordatorio venta" onclick="programarRecordatorio(${u.id})">Recordatorio</button>
            </div>
          </td>
        `;
        tbody.appendChild(tr);
      });
    }

    function render(){
      const filtradas = aplicarFiltros(unidades);
      renderTabla(filtradas);
      actualizarKPIs(unidades); // KPIs sobre total (cambia a 'filtradas' si prefieres)
    }

    // ==========================
    // Acciones demo
    // ==========================
    function verDetalle(id){
      const u = unidades.find(x=>x.id===id);
      if(!u) return;
      const hoy = new Date();
      const meses = monthsBetween(new Date(u.fecha_alta), hoy);
      const restante = Math.max(0, VIDA_UTIL_MESES - meses);
      const fechaCorte = new Date(u.fecha_alta);
      fechaCorte.setMonth(fechaCorte.getMonth()+VIDA_UTIL_MESES);
      alert(`Unidad: ${u.marca} ${u.modelo}\nVIN: ${u.vin}\nAlta: ${formatDateMX(u.fecha_alta)}\nEdad: ${meses} meses\nRestante: ${restante} meses\nFecha objetivo (60 meses): ${formatDateMX(fechaCorte.toISOString())}`);
    }

    function programarRecordatorio(id){
      // Aquí podrías abrir una modal o disparar un fetch a PHP para programar un recordatorio
      alert('Recordatorio programado (demo). ID Unidad: '+id);
    }

    // ==========================
    // Eventos UI
    // ==========================
    document.querySelectorAll('.filter-pill').forEach(b=>{
      b.addEventListener('click', ()=>{
        filtroEstado = b.dataset.status;
        render();
      });
    });

    document.getElementById('btnAplicarFiltros').addEventListener('click', ()=>{
      render();
    });

    searchInput.addEventListener('input', ()=>render());

    document.getElementById('btnExport').addEventListener('click', ()=>{
      exportCSV(aplicarFiltros(unidades));
    });

    // ==========================
    // Export CSV
    // ==========================
    function exportCSV(data){
      const hoy = new Date();
      const rows = [
        ['ID','Marca','Modelo','Año','VIN','Placas','Sede','FechaAlta','EdadMeses','Restantes','Estado']
      ];
      data.forEach(u=>{
        const meses = monthsBetween(new Date(u.fecha_alta), hoy);
        const restante = Math.max(0, VIDA_UTIL_MESES - meses);
        const estado = calcularEstado(meses).texto;
        rows.push([
          u.id, u.marca, u.modelo, u.anio||'', u.vin||'', u.placas||'', u.sede||'', formatDateMX(u.fecha_alta), meses, restante, estado
        ]);
      });
      const csv = rows.map(r=>r.map(v=>`"${String(v).replaceAll('"','""')}"`).join(',')).join('\n');
      const blob = new Blob([csv], {type:'text/csv;charset=utf-8;'});
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url; a.download = 'vida_util_unidades_demo.csv';
      document.body.appendChild(a); a.click(); a.remove(); URL.revokeObjectURL(url);
    }

    // ==========================
    // Inicio
    // ==========================
    // cargarUnidades(); // <- cuando conectes el backend
    render(); // demo
  </script>
  <!-- Iconos opcionales -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</body>
</html>
