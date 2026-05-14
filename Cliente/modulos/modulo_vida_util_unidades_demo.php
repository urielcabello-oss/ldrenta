
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="contenedorvalidacionunidades">
  <h5 class="titulosletrasunidades text-nowrap">Vida Útil Unidades Demo</h5>
  <h4 class="letravalidacionunidadresponsiva text-nowrap"></h4>
</div>

<div class="contenedorcardunidadescomodatoresponsiva">
  <div class="container-fluid py-4">

    <!-- Cards -->
    <div class="row mb-4">
      <div class="col-md-3">
        <div class="card text-center bg-dark text-white p-1">
          <div class="card-body">
            <h6 class="fs-6">Total unidades</h6>
            <h6 id="totalUnidades" class="fs-6">0</h6>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card text-center text-white p-1"  style="background-color: #5586cee7;">
          <div class="card-body">
            <h6>Activas (&lt; 48 meses)</h6>
            <h6 id="totalActivas" class="fs-6">0</h6>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card text-center text-dark p-1" style="background-color: #e2ba35ff;">
          <div class="card-body">
            <h6>Próximas venta (48-59 meses)</h6>
            <h6 id="totalProximas" class="fs-6">0</h6>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card text-center text-white p-1" style="background-color: #4abb83ff;">
          <div class="card-body">
            <h6>Para vender (&ge; 60 meses)</h6>
            <h6 id="totalVenta" class="fs-6">0</h6>
          </div>
        </div>
      </div>
    </div>

    <!-- Gráfica + Tabla -->
    <div class="row mb-8">
      <div class="col-md-4">
        <canvas id="graficaEstados"></canvas>
      </div>
      <div class="col-md-8">
        <div class="table-responsive">
          <table id="tablaVidaUtil" class="table table-hover align-middle w-100" >
            <thead>
              <tr>
                <th>Unidad</th>
                <th>Fecha Alta</th>
                <th>Edad</th>
                <th>Vida útil</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
              <?php
              include("../../Servidor/conexion.php");

              $vida_util_meses = 60;
              $fecha_actual = new DateTime();
              $contadorEstados = ["Activa" => 0, "Próxima" => 0, "Venta" => 0];

              $query = "SELECT 
                          un.id_unidad,
                          un.fecha_alta,
                          un.placa,
                          un.vin,
                          un.numero_motor,
                          un.año_unidad,
                          un.ultimo_kilometraje,
                          un.fecha_adquisicion,
                          un.id_sede,
                          m.nombre_modelo AS modelo,
                          ma.nombre_marca AS marca,
                          s.ubicacion
                        FROM unidades AS un
                        INNER JOIN modelos AS m ON un.id_modelo = m.id_modelo
                        INNER JOIN marcas AS ma ON m.id_marca = ma.id_marca
                        INNER JOIN sedes  AS s ON un.id_sede   = s.id_sede
                        WHERE un.id_tipo_unidad = 3";

              $result = mysqli_query($conexion, $query);
              $unidades = [];
              while ($row = mysqli_fetch_assoc($result)) {
                $unidades[] = $row;
              }

              foreach ($unidades as $u) {
    $fecha_alta = new DateTime($u['fecha_alta']);
    $fecha_alta_iso = $fecha_alta->format('Y-m-d');   // para ordenar
    $fecha_alta_vista = $fecha_alta->format('d/m/Y'); // para mostrar

    $diff = $fecha_actual->diff($fecha_alta);
    $meses_usados = ($diff->y * 12) + $diff->m;
    $porcentaje = min(100, max(0, ($meses_usados / $vida_util_meses) * 100));

    $kilometraje = intval($u['ultimo_kilometraje']);
    $vida_util_km = 25000;

    // ----- Determinar estado -----
    if ($kilometraje >= $vida_util_km || $meses_usados >= 18) {
        $estado = "Para vender";
        $colorBarra = "progress-bar-venta";
        $colorBadge = "badge-venta";
        $contadorEstados["Venta"]++;
    } elseif ($meses_usados >= 48) {
        $estado = "Próxima a venta";
        $colorBarra = "progress-bar-proxima";
        $colorBadge = "badge-proxima";
        $contadorEstados["Próxima"]++;
    } else {
        $estado = "Activa";
        $colorBarra = "progress-bar-activa";
        $colorBadge = "badge-activa";
        $contadorEstados["Activa"]++;
    }

    // Mostrar la fila
    echo "<tr>
            <td><strong>".htmlspecialchars($u['marca'])." ".htmlspecialchars($u['modelo'])."</strong><br>
                <small>VIN: ".htmlspecialchars($u['vin'])."<br>
                Placas: ".htmlspecialchars($u['placa'])."<br>
                Sede: ".htmlspecialchars($u['ubicacion'])."<br>
                Kilometraje: ".number_format($kilometraje)." Km</small>
            </td>
            <td data-order=\"{$fecha_alta_iso}\">{$fecha_alta_vista}</td>
            <td>{$meses_usados} meses</td>
            <td>
              <div class='progress'>
  <div class='progress-bar <?php echo $colorBarra; ?>' role='progressbar' style='width: <?php echo $porcentaje; ?>%;'>
    <?php echo max(0, $vida_util_meses - $meses_usados); ?> meses restantes
  </div>
</div>

              <div><small>".($vida_util_km - $kilometraje > 0 
                  ? number_format($vida_util_km - $kilometraje)." km restantes"
                  : "Vida útil de km agotada")."</small></div>
            </td>
            <td><span class='badge {$colorBadge}'>{$estado}</span></td>
          </tr>";
}


              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>

<script>
  // Cards
  document.getElementById("totalUnidades").innerText = <?php echo count($unidades); ?>;
  document.getElementById("totalActivas").innerText = <?php echo $contadorEstados["Activa"]; ?>;
  document.getElementById("totalProximas").innerText = <?php echo $contadorEstados["Próxima"]; ?>;
  document.getElementById("totalVenta").innerText   = <?php echo $contadorEstados["Venta"]; ?>;

  // Donut Chart
  new Chart(document.getElementById("graficaEstados"), {
    type: 'doughnut',
    data: {
      labels: ['Activas', 'Próximas', 'Para vender'],
      datasets: [{
        data: [<?php echo $contadorEstados["Activa"]; ?>, <?php echo $contadorEstados["Próxima"]; ?>, <?php echo $contadorEstados["Venta"]; ?>],
        backgroundColor: ['#5586cee7', '#cfa935ff', '#4abb83ff']
      }]
    }
  });

  // DataTables: paginación + filtros por columna
  $(function () {
    // Duplicar encabezado para filtros
    $('#tablaVidaUtil thead tr').clone(true).addClass('filters').appendTo('#tablaVidaUtil thead');

    const table = $('#tablaVidaUtil').DataTable({
      pageLength: 3,
      lengthMenu: [[3,5,10,25,50,100,-1],[3,5,10,25,50,100,'Todos']],
      order: [[1,'desc']],           // orden por Fecha Alta (usa data-order)
      orderCellsTop: true,           // necesario al usar doble thead
      language: { url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json' },
      initComplete: function () {
        const api = this.api();

        api.columns().every(function (colIdx) {
          const column = this;
          const headerCell = $('.filters th').eq($(column.header()).index());
          const title = $(column.header()).text().trim();

          // Sin filtro en "Vida útil" (col 3)
          if (colIdx === 3) { $(headerCell).html(''); return; }

          // Select para "Estado"
          if (title.toLowerCase().includes('estado')) {
            const select = $(`
              <select class="form-select-dashboard form-select-sm">
                <option value="">Todos</option>
                <option value="Activa">Activa</option>
                <option value="Próxima a venta">Próxima a venta</option>
                <option value="Para vender">Para vender</option>
              </select>
            `).appendTo(headerCell.empty());

            select.on('change', function () {
              const val = $.fn.dataTable.util.escapeRegex($(this).val());
              column.search(val ? '^' + val + '$' : '', true, false).draw();
            });
          } else {
            // Inputs texto para demás columnas
            const input = $(`<input type="text" class="form-control form-control-sm" placeholder="Filtrar ${title}" />`)
              .appendTo(headerCell.empty());

            input.on('keyup change', function () {
              if (column.search() !== this.value) {
                column.search(this.value).draw();
              }
            });
          }
        });
      }
    });
  });
</script>
