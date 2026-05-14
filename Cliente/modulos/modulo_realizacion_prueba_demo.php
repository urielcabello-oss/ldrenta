<?php
include("../../Servidor/conexion.php");

if (!isset($_SESSION)) {
    session_start();
}

// Verificar que la sesión tenga los datos necesarios
if (!isset($_SESSION['id_colaborador']) || !isset($_SESSION['id_tipo_usuario'])) {
    echo "Sesión inválida";
    exit;
}

$colaborador = $_SESSION['id_colaborador'];
$id_tipo_usuario = $_SESSION['id_tipo_usuario'];

?>

<!-- Contenedor -->
<div class="contenedoropcionesunidades">
    <h2 class="titulosletrarealizacionpruebademo text-nowrap">Administración de prueba</h2>
    <div class="d-flex justify-content-end">
        <?php if ($id_tipo_usuario == 6 || $id_tipo_usuario == 11): // tipos de usuario solicitantes demos ?>
        <button class="btn btn-registrar m-2" onclick="window.history.back()"><i class="fa-solid fa-arrow-left"></i> Regresar </button>
        <?php endif; ?>
    </div>
</div>
<!-----------------------------------------------------------------card con informacion de la unidad y solicitud demo--------------------------------------->
<div class="contenedorrealizacionprueba">
    <?php
    if (isset($_GET['id_unidad'])) {
        $id_asignacion = $_GET['id_unidad'];

        $consulta = "SELECT 
                    a.id_asignacion_unidad_demo,
                    a.id_unidad,
                    a.id_colaborador_que_asigna,
                    a.id_persona_fisica,
                    a.id_persona_moral,
                    a.fecha_prestamo,
                    a.fecha_devolucion,
                    a.objetivo_prestamo,
                    a.comentarios,
                    u.img_unidad,
                    pf.id_persona_fisica,
                    pf.nombre_1,
                    pf.nombre_2,
                    pf.apellido_paterno,
                    pf.apellido_materno,
                    pm.id_persona_moral,
                    pm.organizacion_institucion,
                    model.nombre_modelo,
                    unid.placa,
                    unid.vin,
                    unid.id_telematics,
                    ca.nombre_1 AS nombre1colaborador,
                    ca.nombre_2 AS nombre2colaborador,
                    ca.apellido_paterno AS apellidopcolaborador,
                    ca.apellido_materno AS apellidomcolaborador,
                    usr.avatar AS avatar_colaborador,
                    epd.estado_prueba
                FROM asignacion_unidad_demo AS a
                LEFT JOIN unidades AS u ON a.id_unidad = u.id_unidad
                LEFT JOIN personas_fisicas AS pf ON a.id_persona_fisica = pf.id_persona_fisica
                LEFT JOIN personas_morales AS pm ON a.id_persona_moral = pm.id_persona_moral
                LEFT JOIN modelos AS model ON u.id_modelo = model.id_modelo
                LEFT JOIN unidades AS unid ON a.id_unidad = unid.id_unidad
                LEFT JOIN colaboradores AS ca ON a.id_colaborador_que_asigna = ca.id_colaborador
                LEFT JOIN usuarios AS usr ON usr.id_colaborador = ca.id_colaborador
                LEFT JOIN estado_pruebas_demos AS epd ON a.id_estado_prueba_demo = epd.id_estado_prueba_demo
                WHERE a.id_asignacion_unidad_demo = ?";

        $stmt = $conexion->prepare($consulta);
        $stmt->bind_param("i", $id_asignacion);
        $stmt->execute();
        $resultado = $stmt->get_result();

        while ($fila = $resultado->fetch_assoc()) {
            if (($fila['id_persona_fisica'] || $fila['id_persona_moral'])) {
                $nombre = $fila['id_persona_fisica'] ? $fila['nombre_1'] . ' ' . $fila['nombre_2'] . ' ' . $fila['apellido_paterno'] . ' ' . $fila['apellido_materno'] : $fila['organizacion_institucion'];
                $id_telematics = $fila['id_telematics'];
                $id_asignacion_unidad_demo = $fila['id_asignacion_unidad_demo'];

                $img = $fila['img_unidad'];
                $ruta_servidor = "../../Servidor/archivos/imagenes/imagenes_unidades/";
                $ruta_completa = $ruta_servidor . $img;
                $ruta_url = $ruta_servidor . $img;
                $ruta_fallback = "../../Cliente/img/unidades/silueta_tracto3.png";

                echo "<div class='contenido-card'>";

                echo "<div class='contenedor-imagen'>";
                if (!empty($img) && file_exists($ruta_completa)) {
                    echo "<img class='imgunidadpruebademo' src='" . htmlspecialchars($ruta_url) . "' alt='Imagen de la unidad'>";
                } else {
                    echo "<img class='imgunidadpruebademo' src='" . htmlspecialchars($ruta_fallback) . "' alt='Imagen no disponible'>";
                }
                echo "</div>";

                echo "<form action='' method='post'>";
                echo "<div class='row'>";
                echo "<div class='col-md-6'>";
                echo "<label for='nombre' class='letrasinfounidademoprueba'><b>Nombre del usuario/empresa:</b></label>";
                echo "<input type='text' class='form-control letrasinfounidademoprueba' id='nombre' name='nombre' value='" . $nombre . "' readonly>";
                echo "</div>";
                echo "<div class='col-6'>";
                echo "<label for='solicitante' class='letrasinfounidademoprueba'><b>Solicitante:</b></label>";
                echo "<input type='text' class='form-control letrasinfounidademoprueba' id='solicitante' name='solicitante' value='" . $fila['nombre1colaborador'] . ' ' . $fila['nombre2colaborador'] . ' ' . $fila['apellidopcolaborador'] . ' ' . $fila['apellidomcolaborador'] . "' readonly>";
                echo "</div>";
                echo "<div class='col-3'>";
                echo "<label for='fecha_prestamo' class='letrasinfounidademoprueba'><b>Fecha Préstamo:</b></label>";
                echo "<input type='text' class='form-control letrasinfounidademoprueba' id='fecha_prestamo' name='fecha_prestamo' value='" . $fila['fecha_prestamo'] . "' readonly>";
                echo "</div>";
                echo "<div class='col-3'>";
                echo "<label for='fecha_devolucion' class='letrasinfounidademoprueba'><b>Fecha Devolución:</b></label>";
                echo "<input type='text' class='form-control letrasinfounidademoprueba' id='fecha_devolucion' name='fecha_devolucion' value='" . $fila['fecha_devolucion'] . "' readonly>";
                echo "</div>";
                echo "<div class='col-2'>";
                echo "<label for='fecha_devolucion' class='letrasinfounidademoprueba'><b>Placa:</b></label>";
                echo "<input type='text' class='form-control letrasinfounidademoprueba' id='placa' name='placa' value='" . $fila['placa'] . "' readonly>";
                echo "</div>";
                echo "</div>";
                echo "<div class='row'>";
                echo "<div class='col-6'>";
                echo "<label for='objetivo_prestamo' class='letrasinfounidademoprueba'><b>Objetivo Préstamo:</b></label>";
                echo "<textarea class='form-control letrasinfounidademoprueba' id='objetivo_prestamo' name='objetivo_prestamo' rows='4' readonly>" . $fila['objetivo_prestamo'] . "</textarea>";
                echo "</div>";
                echo "<div class='col-6'>";
                echo "<label for='comentarios' class='letrasinfounidademoprueba'><b>Comentarios:</b></label>";
                echo "<textarea class='form-control letrasinfounidademoprueba' id='comentarios' name='comentarios' rows='4' readonly>" . $fila['comentarios'] . "</textarea>";
                echo "</div>";
                echo "</div>";
                echo "</form>";
                echo "</div>"; // contenido-card
            }
        }
        $stmt->close();
    } else {
        echo "<h1>ID de asignación no proporcionado.</h1>";
    }
    ?>
</div>

<!-----------------------------------------------------------------modulo de registro de la prueba demo ------------------------------------------------------------>
<div class="contenedorealizaciondeprueba">
    <?php
    if (isset($_GET['id_unidad'])) {
        $id_asignacion = $_GET['id_unidad'];

        $consulta = "SELECT 
                    a.id_asignacion_unidad_demo,
                    a.id_unidad,
                    a.id_estado_prueba_demo,
                    model.nombre_modelo,
                    unid.placa,
                    unid.vin,
                    epd.estado_prueba,
                    a.reporte_final_prueba,
                    a.id_estado_prueba_demo
                FROM asignacion_unidad_demo AS a
                LEFT JOIN unidades AS u ON a.id_unidad = u.id_unidad
                LEFT JOIN modelos AS model ON u.id_modelo = model.id_modelo
                LEFT JOIN unidades AS unid ON a.id_unidad = unid.id_unidad
                LEFT JOIN estado_pruebas_demos AS epd ON a.id_estado_prueba_demo = epd.id_estado_prueba_demo
                WHERE a.id_asignacion_unidad_demo = ?";

        $stmt = $conexion->prepare($consulta);
        $stmt->bind_param("i", $id_asignacion);
        $stmt->execute();
        $resultado = $stmt->get_result();

        while ($fila = $resultado->fetch_assoc()) {
            $id_asignacion = $fila['id_asignacion_unidad_demo'];
            $estado = $fila['id_estado_prueba_demo'];
            $reporte_final = $fila['reporte_final_prueba'];
            $id_estado_prueba_demo = $fila['id_estado_prueba_demo'];

            // Contar pruebas
            $sqlTotalPruebas = "SELECT COUNT(*) AS total FROM pruebas_unidad_demo WHERE id_asignacion_unidad_demo = ?";
            $stmtTotal = $conexion->prepare($sqlTotalPruebas);
            $stmtTotal->bind_param("i", $id_asignacion);
            $stmtTotal->execute();
            $resTotal = $stmtTotal->get_result();
            $filaTotal = $resTotal->fetch_assoc();
            $totalPruebas = $filaTotal['total'];
            $stmtTotal->close();

            echo "<h2 class='text-center titulosletrarealizacionpruebademoestatus'>Realización de prueba demo</h2>";
            echo "<h2 class='titulosletraconteopruebas'><strong>Pruebas realizadas:</strong> $totalPruebas</h2>";
            if ($id_tipo_usuario == 9 || $id_tipo_usuario == 11): // tipos de usuario solicitantes demos
                // Mostrar botón según estado
                if ($estado == 1 || $estado == null) { // NO SE HA REALIZADO
                    echo "<button type='button' class='btn btn-primera_prueba realizacion_prueba' data-idpruebademo='$id_asignacion'>
                Realizar primera prueba
              </button>";
                } elseif ($estado == 2) { // EN PROCESO
                    echo "<button type='button' class='btn btn-segunda_prueba realizacion_prueba' data-idpruebademo='$id_asignacion'>
                Realizar prueba: " . ($totalPruebas + 1) . "
              </button>";
                    echo "<button type='button' class='btn btn-tercera_prueba finalizar_prueba' data-idpruebademo='$id_asignacion'>
                Finalizar pruebas
              </button>";
                } elseif ($estado == 3) { // FINALIZADA
                    echo "<p class='text-success'><strong>Proceso finalizado.</strong></p>";
                }
            endif;

            // ----------------------------------------------------------------------------Botón de subir reporte final---------------------------------------------------
            if ($id_tipo_usuario == 11): // tipos de usuario solicitantes demos
                if (empty($reporte_final) || $reporte_final == null) {
                    if ($id_estado_prueba_demo == 3) {
                        echo "<button type='button' class='btn btn-reporte_final subir_reporte_final' data-idpruebademo='$id_asignacion'  style='text-align: center;'>
                    Subir reporte final
                </button>";
                    }
                }
            endif;

            // código que muestra la tabla de pruebas
            $consulta_pruebas = "SELECT 
                    p.id_prueba,
                    p.id_asignacion_unidad_demo,
                    p.fecha_prueba,
                    p.nombre_del_conductor,
                    p.id_tipo_prueba_demo,
                    p.origen_inicial,
                    p.origen_destino,
                    p.temperatura,
                    p.revoluciones,
                    p.velocidad,
                    p.kilometraje,
                    p.foto_cluster,
                    p.foto_unidad,
                    p.comentarios,
                    crp.nombre_1,
                    crp.nombre_2,
                    crp.apellido_paterno,
                    crp.apellido_materno,
                    pru.prueba_demo
                FROM pruebas_unidad_demo AS p
                LEFT JOIN colaboradores AS crp ON p.id_colaborador_registra_prueba = crp.id_colaborador
                LEFT JOIN tipos_pruebas_demo AS pru ON p.id_tipo_prueba_demo = pru.id_tipo_prueba_demo
                WHERE p.id_asignacion_unidad_demo = ?
                ORDER BY fecha_prueba ASC";

            $stmti = $conexion->prepare($consulta_pruebas);
            $stmti->bind_param("i", $id_asignacion);
            $stmti->execute();
            $resultado = $stmti->get_result();

            echo "<div class='table-responsive'>
            <table class='table table-hover tablaunidades' id='tablaUnidades'>
            <thead class='table-light' style='background-color: #a4bae273'>
                <tr>
                    <th class='letratablapruebademo'>#</th>
                    <th class='letratablapruebademo'>Fecha y Hora Prueba</th>
                    <th class='letratablapruebademo'>Nombre del Conductor</th>
                    <th class='letratablapruebademo'>Tipo Prueba</th>
                    <th class='letratablapruebademo'>Origen Inicial</th>
                    <th class='letratablapruebademo'>Destino Final</th>
                    <th class='letratablapruebademo'>Temperatura</th>
                    <th class='letratablapruebademo'>Revoluciones</th>
                    <th class='letratablapruebademo'>Velocidad</th>
                    <th class='letratablapruebademo'>Kilometraje inicial</th>
                    <th class='letratablapruebademo'>Clúster</th>
                    <th class='letratablapruebademo'>Unidad</th>
                    <th class='letratablapruebademo'>Registrador de prueba</th>
                    <th class='letratablapruebademo'>Comentarios</th>
                    <th class='letratablapruebademo'>Bitácora diaria</th>
                </tr>
            </thead>
            <tbody>";

            $contador = 1;
            $primer_fecha = null;
            $ultima_fecha = null;
            while ($fila = $resultado->fetch_assoc()) {
                $id_prueba = $fila['id_prueba'];
                // Guardar la primera fecha (solo la primera vez que entra al bucle)
    if ($primer_fecha === null) {
        $primer_fecha = new DateTime($fila['fecha_prueba']);
        $primer_fecha->setTimezone(new DateTimeZone('America/Mexico_City'));
    }

    // Actualizar la última fecha en cada iteración (al final será la última del ciclo)
    $temp_fecha = new DateTime($fila['fecha_prueba']);
    $temp_fecha->setTimezone(new DateTimeZone('America/Mexico_City'));
    $ultima_fecha = $temp_fecha;
    
                echo "<tr>";
                echo "<td class='letratablapruebademo'>" . ($contador++) . "</td>";
                $fecha_prueba = new DateTime($fila['fecha_prueba']);
                $fecha_prueba->setTimezone(new DateTimeZone('America/Mexico_City'));
                echo "<td class='letratablapruebademo'>" . $fecha_prueba->format('d/m/Y H:i:s') . "</td>";
                echo "<td class='letratablapruebademo'>" . ($fila['nombre_del_conductor']) . "</td>";
                echo "<td class='letratablapruebademo'>" . ($fila['prueba_demo']) . "</td>";
                echo "<td class='letratablapruebademo'>" . ($fila['origen_inicial']) . "</td>";
                echo "<td class='letratablapruebademo'>" . ($fila['origen_destino']) . "</td>"; 
                echo "<td class='letratablapruebademo'>" . ($fila['temperatura']) . " °C</td>";
                echo "<td class='letratablapruebademo'>" . number_format($fila['revoluciones'], 0, '', ',') . " RPM</td>";
                echo "<td class='letratablapruebademo'>" . number_format($fila['velocidad'], 1, ',', '.') . " km/h</td>";
                echo "<td class='letratablapruebademo'>" . number_format($fila['kilometraje'], 0, '', ',') . " km</td>";
                echo "<td class='letratablapruebademo' style='text-align: center;'>
                <a href='../../Servidor/archivos/files/files_asignacion_demo/pruebas_unidades_demo/fotos_cluster/" . ($fila['foto_cluster']) . "' target='_blank'>
                    <button class='btn btn-sm btn-tablero'><i class='fas fa-dashboard'></i></button>
                </a>
              </td>";
                echo "<td class='letratablapruebademo' style='text-align: center;'>
                <a href='../../Servidor/archivos/files/files_asignacion_demo/pruebas_unidades_demo/fotos_unidad_exterior/" . ($fila['foto_unidad']) . "' target='_blank'>
                    <button class='btn btn-sm btn-unidad-exterior'><i class='fas fa-car-side'></i></button>
                </a>
              </td>";
              echo "<td class='letratablapruebademo'>" . ($fila['nombre_1'] . ' ' . $fila['nombre_2'] . ' ' . $fila['apellido_paterno'] . ' ' . $fila['apellido_materno']) . "</td>";
                echo "<td class='letratablapruebademo'>" . ($fila['comentarios']) . "</td>";
                echo "<td class='letratablapruebademo' style='text-align: center;'>
                    <button class='fas fa-book btn btn-sm btn-bitacora btn_realizar_bitacora' data-idprueba='" . $id_prueba . "'></button>
              </td>";
                echo "</tr>";
            }
        // Ya fuera del bucle, formateamos el rango de fechas
        $fecha_prueba_estimada = '';
        if ($primer_fecha && $ultima_fecha) {
            $fecha_prueba_estimada = $primer_fecha->format('d/m/Y') . ' - ' . $ultima_fecha->format('d/m/Y');
        }

            $stmti->close();
        }


        echo "</tbody></table>";

        $stmt->close();
    } else {
        echo "<h1>ID de asignación no proporcionado.</h1>";
    }
    ?>
</div>
</div>

<!--codigo que muestra la tabla de la prueba monitoriada por telematics-->
<?php if ($id_tipo_usuario == 11 || $id_tipo_usuario == 6): ?>
<div class="container-fluid" id="contenedorrealizacionpruebademoestatus">
    <h2 class='text-center titulosletrarealizacionpruebademoestatus'>Monitoreo Smart Connect</h2>
    <h2 class='text-right titulosletrafechasmonitoreo'>
    Fecha estimada de monitoreo: <?php echo $fecha_prueba_estimada; ?>
</h2>
   <div class="row">
        <div class="col-md-6">
            <div class="form-floating">
                <input type="date" class="form-control" id="fechaInicio" name="fechaInicio">
                <label for="fechaInicio">Fecha de Inicio</label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-floating">
                <input type="date" class="form-control" id="fechaFin" name="fechaFin">
                <label for="fechaFin">Fecha de Fin</label>
            </div>
        </div>
    </div>
    <br>
    <button type="button" class="btn btn-primary" id="btnObtenerDatos" style="text-align: center;">Obtener datos de la prueba</button>
    <br><br>
    
    <!-- Contenedor para las cards -->
<div class="row" id="cardsResumen" style="margin-top:20px;"></div>
<br>
<div class="table-responsive" id="tablaTelematicsContainer" style="display:none;">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="letratablapruebademo">Fecha</th>
                    <th class="letratablapruebademo">Consumo Combustible</th>
                    <th class="letratablapruebademo">Distancia Recorrida</th>
                    <th class="letratablapruebademo">Horas Motor</th>
                    <th class="letratablapruebademo">Horas Motor Ralenti</th>
                    <th class="letratablapruebademo">Combustible Ralenti</th>
                    <th class="letratablapruebademo">AdBlue Level</th>
                    <th class="letratablapruebademo">Uso Freno Total</th>
                    <th class="letratablapruebademo">Precio Combustible</th>
                </tr>
            </thead>
            <tbody id="tablaTelematicsBody"></tbody>
        </table>
    </div>
    <!-- Loader -->
<div id="loaderTelematics" style="display:none;text-align:center;">
    <div class="spinner-border text-primary" role="status"></div>
    <p>Cargando datos de Telematics...</p>
</div>

</div>
<script>
document.getElementById('btnObtenerDatos').addEventListener('click', function () {
    let fechaInicio = document.getElementById('fechaInicio').value;
    let fechaFin = document.getElementById('fechaFin').value;
    let idAsignacionUnidadDemo = "<?php echo $id_asignacion_unidad_demo; ?>";

    if (!fechaInicio || !fechaFin) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Por favor selecciona las fechas de monitoreo.'
        });
        return;
    }

    document.getElementById('loaderTelematics').style.display = "block";

    fetch(`../../Cliente/js/api/obtener_campos_prueba_telematics.php?fi=${fechaInicio}&ff=${fechaFin}&idAsignacionUnidadDemo=${idAsignacionUnidadDemo}`)
        .then(res => res.json())
        .then(data => {
            let tbody = document.getElementById('tablaTelematicsBody');
            tbody.innerHTML = "";

            if (Array.isArray(data)) {
                let totalKm = 0, totalHoras = 0, totalDiesel = 0, totalRalenti = 0, totalRalentiHoras = 0, totalAdBlue = 0;
                let velMax = 0, velSum = 0, registros = 0, rpmMax = 0;

                data.forEach(row => {
                    totalKm += parseFloat(row.distanciaTotalRec ?? 0);
                    totalHoras += parseFloat(row.hrmotorTotal ?? 0);
                    totalDiesel += parseFloat(row.consumoTotalComb ?? 0);
                    totalRalenti += parseFloat(row.combustibleRelentiTotal ?? 0);
                    totalRalentiHoras += parseFloat(row.hrmotorRelentiTotal ?? 0);
                    totalAdBlue += parseFloat(row.adbluelevel ?? 0);

                    let vel = parseFloat(row.velocidadMax ?? 0);
                    velMax = vel > velMax ? vel : velMax;
                    velSum += parseFloat(row.velocidadPromedio ?? 0);
                    rpmMax = Math.max(rpmMax, parseFloat(row.rpmMaximas ?? 0));

                    registros++;

                    let tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td class="letratablapruebademo">${row.FECHA}</td>
                        <td class="letratablapruebademo">${row.consumoTotalComb ?? 0}</td>
                        <td class="letratablapruebademo">${row.distanciaTotalRec ?? 0}</td>
                        <td class="letratablapruebademo">${row.hrmotorTotal ?? 0}</td>
                        <td class="letratablapruebademo">${row.hrmotorRelentiTotal ?? 0}</td>
                        <td class="letratablapruebademo">${row.combustibleRelentiTotal ?? 0}</td>
                        <td class="letratablapruebademo">${row.adbluelevel ?? 0}</td>
                        <td class="letratablapruebademo">${row.usoFrenoTotal ?? 0}</td>
                        <td class="letratablapruebademo">${row.precioCombustible ?? 0}</td>
                    `;
                    tbody.appendChild(tr);
                });

                let rendimiento = totalKm && totalDiesel ? (totalKm / totalDiesel).toFixed(1) : 0;
                let velPromedio = registros ? (velSum / registros).toFixed(1) : 0;
                let porcentajeRalenti = totalHoras ? ((totalRalentiHoras / totalHoras) * 100).toFixed(0) : 0;

                let cardsHTML = `
                    <div class="col-md-2 cardTele"><h3>${totalKm.toFixed(0)} km</h3><p>Kilómetros Recorridos</p></div>
                    <div class="col-md-2 cardTele"><h3>${totalHoras.toFixed(0)} hrs</h3><p>Horas Motor</p></div>
                    <div class="col-md-2 cardTele"><h3>${totalDiesel.toFixed(0)} l</h3><p>Litros de Diésel Consumido</p></div>
                    <div class="col-md-2 cardTele"><h3>${rendimiento} km/l</h3><p>Rendimiento Promedio</p></div>
                    <div class="col-md-2 cardTele"><h3>${totalRalenti.toFixed(0)} l</h3><p>Litros de Combustible en Ralenti</p></div>
                    <div class="col-md-2 cardTele"><h3>${rpmMax.toLocaleString()}</h3><p>RPM Máximas</p></div>
                    <div class="col-md-2 cardTele"><h3>${totalAdBlue.toFixed(0)} l</h3><p>Litros de Ad Blue Consumido</p></div>
                    <div class="col-md-2 cardTele"><h3>${velMax} km/h</h3><p>Velocidad Máxima Alcanzada</p></div>
                    <div class="col-md-2 cardTele"><h3>${velPromedio} km/h</h3><p>Velocidad Promedio</p></div>
                    <div class="col-md-2 cardTele"><h3>${porcentajeRalenti} %</h3><p>Porcentaje de Horas en Ralenti</p></div>
                `;
                document.getElementById('cardsResumen').innerHTML = cardsHTML;
                document.getElementById('cardsResumen').style.display = "flex";
                document.getElementById('loaderTelematics').style.display = "none";
                document.getElementById('tablaTelematicsContainer').style.display = "block";
            } else {
                Swal.fire({ icon: "warning", title: "Sin datos", text: "No se encontraron datos para el rango seleccionado." });
                document.getElementById('loaderTelematics').style.display = "none";
                document.getElementById('tablaTelematicsContainer').style.display = "none";
            }
        })
        .catch(err => {
            console.error(err);
            Swal.fire({ icon: "error", title: "Error", text: "Error al obtener los datos de Telematics." });
            document.getElementById('loaderTelematics').style.display = "none";
            document.getElementById('tablaTelematicsContainer').style.display = "none";
        });
});
</script>

<?php endif; ?>

<br><br>
<br><br>
<!--------------------------------------------------------------------------modal para registrar las pruebas demos por unidad-------------------->
<!--modal-->
<div class="modal fade modalregistrarpruebas" id="modalregistrarpruebas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Prueba unidad demo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodalpruebademo"></button>
            </div>
            <div class="modal-body" id="modalregistrarpruebasbody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btncerrarmodalpruebademo" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnregistrarpruebademo">Registrar PRUEBA</button>
            </div>
        </div>
    </div>
</div>

<!----------------------------------------------------------------modal para registrar los resultados de las pruebas--------------------------------->
<!--modal-->
<div class="modal fade modalregistrarresultados" id="modalregistrarresultados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Resultados</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodalresultados"></button>
            </div>
            <div class="modal-body" id="modalregistrarresultadosbody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btncerrarmodalresultados" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btnregistrarresultados" id="btnregistrarresultados">Registrar</button>
            </div>
        </div>
    </div>
</div>

<!----------------------------------------------------------------modal para registrar la bitacora diaria--------------------------------->
<!--modal-->
<div class="modal fade modalregistrarbitacora" id="modalregistrarbitacora" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Resultados</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarmodalresultados"></button>
            </div>
            <div class="modal-body" id="modalregistrarbitacorabody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btncerrarmodalresultados" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btnregistrarresultados" id="btnregistrarresultados">Registrar</button>
            </div>
        </div>
    </div>
</div>

<!--pruebas unidades demo-->
<script src="../js/pruebas_unidades_demo/realizacion_pruebas_demos.js"></script>
<!--pruebas unidades demo-->
<script src="../js/pruebas_unidades_demo/realizacion_prueba_bitacora.js"></script>
<!--js para subir el reporte final de la prueba demo-->
<script src="../js/pruebas_unidades_demo/reporte_final_pruebas.js"></script>
<!--js para filtrar la tabla de unidades-->
<script src="../js/unidades/filtrar_tabla.js"></script>