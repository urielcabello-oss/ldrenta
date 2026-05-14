<?php
// Debug de POST y SESSION
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();  // 👈 mover arriba

error_log("POST: " . print_r($_POST, true));
error_log("SESSION: " . print_r($_SESSION, true));

include("../../conexion.php");

$id_usuario_demo = $_SESSION['id_colaborador'] ?? 'NO_SESSION';

// Validar datos obligatorios
if (isset($_POST['fechasolicitudunidademo']) 
    && isset($_POST['fechadevolucionunidademo'])) {

    $fechasolicitudunidademo = $_POST['fechasolicitudunidademo'];
    $fechadevolucionunidademo = $_POST['fechadevolucionunidademo'];

    // Características funcionales como filtros
    $nombre_modelo       = $_POST['nombre_modelo'] ?? '';
    $capacidad_carga     = $_POST['capacidad_carga'] ?? '';
    $capacidad_pasajeros = $_POST['capacidad_pasajeros'] ?? '';
    $tipo_combustible    = $_POST['tipo_combustible'] ?? '';
    $traccion            = $_POST['traccion'] ?? '';
    $tipo_carroceria     = $_POST['tipo_carrceria'] ?? '';
    $numero_puertas      = $_POST['numero_puertas'] ?? '';
    $numero_asientos     = $_POST['numero_asientos'] ?? '';
    $tipo_caja           = $_POST['tipo_caja'] ?? '';
    $tipo_frenos         = $_POST['tipo_frenos'] ?? '';
    $suspension          = $_POST['suspension'] ?? '';
    $numero_ejes         = $_POST['numero_ejes'] ?? '';
    $uso_permitido       = $_POST['uso_permitido'] ?? '';
    $camara_reversa      = $_POST['camara_reversa'] ?? '';
    $sensores_reversa    = $_POST['sensores_reversa'] ?? '';
    $busqueda_global = $_POST['busqueda_global'] ?? '';

    // Construcción dinámica del WHERE
    $filtros = "WHERE ung.id_estado_unidad = 1 
                AND ung.id_estatus_unidad = 1 
                AND ung.id_tipo_unidad = 3";

    if ($nombre_modelo !== '')          $filtros .= " AND ung.id_modelo = '$nombre_modelo'";
    if ($capacidad_carga !== '')        $filtros .= " AND ung.capacidad_carga >= '$capacidad_carga'";
    if ($capacidad_pasajeros !== '')    $filtros .= " AND ung.capacidad_pasajeros >= '$capacidad_pasajeros'";
    if ($tipo_combustible !== '')       $filtros .= " AND ung.id_tipo_combustible = '$tipo_combustible'";
    if ($traccion !== '')               $filtros .= " AND ung.id_traccion = '$traccion'";
    if ($tipo_carroceria !== '')        $filtros .= " AND ung.tipo_carrceria LIKE '%$tipo_carroceria%'";
    if ($numero_puertas !== '')         $filtros .= " AND ung.numero_puertas = '$numero_puertas'";
    if ($numero_asientos !== '')        $filtros .= " AND ung.numero_asientos = '$numero_asientos'";
    if ($tipo_caja !== '')              $filtros .= " AND ung.id_tipo_caja = '$tipo_caja'";
    if ($tipo_frenos !== '')            $filtros .= " AND ung.id_tipo_freno = '$tipo_frenos'";
    if ($suspension !== '')             $filtros .= " AND ung.id_tipo_suspencion = '$suspension'";
    if ($numero_ejes !== '')            $filtros .= " AND ung.numero_ejes = '$numero_ejes'";
    if ($uso_permitido !== '')          $filtros .= " AND ung.id_tipo_uso = '$uso_permitido'";
    if ($busqueda_global !== '') {

    $busqueda = $conexion->real_escape_string($busqueda_global);

    $filtros .= " AND (
        ung.vin LIKE '%$busqueda%' OR
        ung.placa LIKE '%$busqueda%' OR
        ung.paso_diferencial LIKE '%$busqueda%' OR
        model.nombre_modelo LIKE '%$busqueda%' OR
        marc.nombre_marca LIKE '%$busqueda%'
    )";
}

    $sql = "SELECT ung.id_unidad, marc.nombre_marca, model.nombre_modelo, ung.placa, ung.vin, ung.paso_diferencial, ung.img_unidad,
                   ung.id_tipo_unidad, unest.estado, unestatus.id_estatus_unidad, sed.ubicacion
            FROM unidades AS ung
            INNER JOIN modelos AS model ON ung.id_modelo = model.id_modelo
            INNER JOIN marcas AS marc ON model.id_marca = marc.id_marca
            INNER JOIN estado_unidad AS unest ON ung.id_estado_unidad = unest.id_estado_unidad
            INNER JOIN estatus_unidades AS unestatus ON ung.id_estatus_unidad = unestatus.id_estatus_unidad
            INNER JOIN sedes AS sed ON ung.id_sede = sed.id_sede
            $filtros";

    // Mostrar el SQL en log y en pantalla (para debug)
    //error_log("SQL Ejecutado: " . $sql);
    //echo "<pre style='background:#f8f9fa;border:1px solid #ccc;padding:10px;'>SQL ejecutado:\n$sql</pre>";

    $resultado = $conexion->query($sql);

    if (!$resultado) {
        die("<div style='color:red;'>❌ Error en la consulta: " . $conexion->error . "</div>");
    }

    //echo "<div style='margin:10px 0;color:blue;'>Registros encontrados: " . $resultado->num_rows . "</div>";

    if ($resultado->num_rows > 0) {

    while ($fila = $resultado->fetch_assoc()) {

        $imagen = !empty($fila['img_unidad'])
            ? "../../Servidor/archivos/imagenes/imagenes_unidades/" . $fila['img_unidad']
            : "../../Cliente/img/unidades/silueta_tracto3.png";

        echo '

        <div class="card-unidad-demo">

            <!-- IMAGEN -->
            <div class="position-relative">

                <img 
                    src="' . $imagen . '"
                    class="card-unidad-img"
                    alt="Unidad demo"
                    onerror="this.src=\'../../Cliente/img/unidades/silueta_tracto3.png\'">

                <span class="badge bg-success position-absolute top-0 end-0 m-3 px-3 py-2">
                    Disponible
                </span>

            </div>

            <!-- BODY -->
            <div class="card-unidad-body">

                <h5 class="card-unidad-title">
                    ' . $fila['nombre_marca'] . ' ' . $fila['nombre_modelo'] . '
                </h5>

                <div class="card-unidad-info">
                    <i class="fas fa-location-dot me-2"></i>
                    ' . $fila['ubicacion'] . '
                </div>

                <div class="card-unidad-info">
                    <i class="fas fa-id-card me-2"></i>
                    Placa: ' . $fila['placa'] . '
                </div>

                <div class="card-unidad-info">
                    <i class="fas fa-barcode me-2"></i>
                    VIN: ' . $fila['vin'] . '
                </div>

                <div class="card-unidad-info">
                    <i class="fas fa-road me-2"></i>
                    Paso diferencial: ' . $fila['paso_diferencial'] . '
                </div>

            </div>

            <!-- FOOTER -->
            <div class="card-unidad-footer">

                <button
                    type="button"
                    class="btn-orange btnmostrarunidademofisicamoral"

                    data-id="' . $fila['id_unidad'] . '"
                    data-id-usuario-demo="' . $id_usuario_demo . '"
                    data-fecha-solicitudemo="' . $fechasolicitudunidademo . '"
                    data-fecha-devoluciondemo="' . $fechadevolucionunidademo . '">

                    <i class="fas fa-user-check me-2"></i>
                    Rentar unidad

                </button>

            </div>

        </div>';
    }

} else {

    echo '
    <div class="alert alert-danger">
        ⚠ No hay unidades disponibles con esas especificaciones.
    </div>';
}
} else {
    echo "<div style='color:red;'>❌ Faltan parámetros obligatorios en POST.</div>";
}
?>
