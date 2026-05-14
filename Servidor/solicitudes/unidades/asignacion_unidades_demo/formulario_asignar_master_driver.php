<?php
include("../../../conexion.php");

// Verificamos que venga la asignación
if (!isset($_POST['id_asignacion'])) {
    echo "<p class='text-danger'>Error: no se recibió id_asignacion.</p>";
    exit;
}

$id_asignacion = $_POST['id_asignacion'];

// 1️⃣ Obtener fechas de la asignación
$sqlFechas = "SELECT fecha_prestamo, fecha_devolucion 
              FROM asignacion_unidad_demo 
              WHERE id_asignacion_unidad_demo = '$id_asignacion'";
$resultFechas = $conexion->query($sqlFechas);

if (!$resultFechas || $resultFechas->num_rows === 0) {
    echo "<p class='text-danger'>No se encontraron fechas para la asignación.</p>";
    exit;
}

$rowFechas = $resultFechas->fetch_assoc();
$fechaInicio = date('Y-m-d', strtotime($rowFechas['fecha_prestamo']));
$fechaFin = date('Y-m-d', strtotime($rowFechas['fecha_devolucion']));

// 2️⃣ Consultar la API externa para obtener las fechas ocupadas
$url_api_fechas = "https://apipic.ldrhumanresources.com/api/course-schedules/dates";
$ch = curl_init($url_api_fechas);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response_api = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$ocupados = [];
if ($http_code == 200 && $response_api) {
    $data_api = json_decode($response_api, true);
    if (is_array($data_api)) {
        foreach ($data_api as $evento) {
            if (!empty($evento['instructor_id']) && !empty($evento['start_date'])) {
                $inicio = date('Y-m-d', strtotime($evento['start_date']));
                $fin = !empty($evento['end_date']) ? date('Y-m-d', strtotime($evento['end_date'])) : $inicio;
                $ocupados[] = [
                    'instructor_id' => $evento['instructor_id'],
                    'inicio' => $inicio,
                    'fin' => $fin
                ];
            }
        }
    }
}

// 3️⃣ Obtener todos los máster drivers
$sqlMasterDrivers = "SELECT 
        colaboradores.id_colaborador, 
        colaboradores.id_puesto, 
        pues.nombre_puesto, 
        colaboradores.nombre_1, 
        colaboradores.nombre_2, 
        colaboradores.apellido_paterno, 
        colaboradores.apellido_materno, 
        colaboradores.numero_colaborador,
        umt.id_tipo_usuario
    FROM usuarios AS usu
    INNER JOIN usuario_modulo_tipo AS umt 
        ON umt.id_usuario = usu.id_usuario
    INNER JOIN colaboradores 
        ON colaboradores.id_colaborador = usu.id_colaborador
    INNER JOIN puestos AS pues 
        ON pues.id_puesto = colaboradores.id_puesto
    WHERE umt.id_tipo_usuario = 9
      AND umt.id_modulo = 2
    ORDER BY colaboradores.numero_colaborador ASC";


$resultado = $conexion->query($sqlMasterDrivers);

// 4️⃣ Filtrar máster drivers disponibles según fechas ocupadas
$disponibles = [];
while ($row = $resultado->fetch_assoc()) {
    $idDriver = $row['id_colaborador'];
    $ocupado = false;

    foreach ($ocupados as $evento) {
        if ($evento['instructor_id'] == $idDriver &&
            !($fechaFin < $evento['inicio'] || $fechaInicio > $evento['fin'])) {
            $ocupado = true;
            break;
        }
    }

    if (!$ocupado) {
        $disponibles[] = $row;
    }
}
?>

<h3 class="mb-3 text-center">Asignar Máster Driver</h3>

<div class="d-flex flex-wrap gap-2 justify-content-center mb-3">
    <?php if (count($disponibles) === 0): ?>
        <p class="text-danger">No hay máster drivers disponibles en estas fechas.</p>
    <?php else: ?>
        <?php foreach ($disponibles as $row): ?>
            <div class="card master-driver-card p-2 cursor-pointer" 
                 data-id="<?= htmlspecialchars($row['id_colaborador']) ?>" 
                 style="width: 180px; cursor: pointer;">
                <div class="card-body text-center">
                    <h6 class="card-title mb-1"><?= htmlspecialchars($row['numero_colaborador']) ?></h6>
                    <p class="card-text mb-0"><?= htmlspecialchars(trim($row['nombre_1'] . ' ' . $row['nombre_2'] . ' ' . $row['apellido_paterno'])) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<input type="hidden" name="id_asignacion" id="id_asignacion" value="<?= htmlspecialchars($id_asignacion) ?>">

<div class="text-center">
    <button type="button" class="btn btn-primary" id="btnasignarmasterdriver" disabled>Asignar Máster Driver</button>
</div>
