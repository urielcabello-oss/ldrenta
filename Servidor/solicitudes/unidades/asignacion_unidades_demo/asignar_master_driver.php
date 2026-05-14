<?php
include("../../../conexion.php");

if (isset($_POST['id_master_driver']) && isset($_POST['id_asignacion'])) {

    $id_master_driver = $_POST['id_master_driver'];
    $id_asignacion = $_POST['id_asignacion'];

    // 1️⃣ Obtener fechas de la asignación
    $row = $conexion->query("SELECT fecha_prestamo, fecha_devolucion 
        FROM asignacion_unidad_demo 
        WHERE id_asignacion_unidad_demo = '$id_asignacion'
    ")->fetch_assoc();

    if (!$row) {
        echo json_encode([
            "success" => false,
            "message" => "No se encontró la asignación solicitada."
        ]);
        exit;
    }

    $fechaAsignacion = new DateTime($row['fecha_prestamo']);
    $fechaDevolucion = new DateTime($row['fecha_devolucion']);

    // 2️⃣ Consultar API externa (endpoint de cursos)
    $url_api_validacion = "https://apipic.ldrhumanresources.com/api/course-schedules/dates";

    $ch = curl_init($url_api_validacion);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response_validacion = curl_exec($ch);
    curl_close($ch);

    $data_validacion = json_decode($response_validacion, true);

    // Si la API no devuelve un array válido
    if (!is_array($data_validacion)) {
        echo json_encode([
            "success" => false,
            "message" => "Error: la API de validación no devolvió un formato válido.",
            "response" => $response_validacion
        ]);
        exit;
    }

    // 3️⃣ Validar disponibilidad solo usando start_date
    $disponible = true;
    $log = []; // ← Aquí almacenamos los mensajes de depuración

    foreach ($data_validacion as $evento) {
        if (!isset($evento['instructor_id']) || !isset($evento['start_date'])) {
            $log[] = "Evento ignorado por datos incompletos.";
            continue;
        }

        // Solo analizamos si el instructor coincide
        if ($evento['instructor_id'] != $id_master_driver) {
            $log[] = "Evento ignorado: instructor {$evento['instructor_id']} distinto al solicitado ($id_master_driver).";
            continue;
        }

        $curso_fecha = new DateTime($evento['start_date']);
        $log[] = "📅 Evaluando fecha curso: " . $curso_fecha->format('Y-m-d H:i:s');

        // Validamos si la fecha está dentro del rango asignado
        if ($curso_fecha >= $fechaAsignacion && $curso_fecha <= $fechaDevolucion) {
            $disponible = false;
            $log[] = "❌ Conflicto detectado: el curso del Master Driver ($id_master_driver) está en el rango solicitado.";
            $fecha_conflicto = $curso_fecha->format('Y-m-d H:i:s');
            break;
        } else {
            $log[] = "✅ Sin conflicto: la fecha no interfiere con el rango (" .
                $fechaAsignacion->format('Y-m-d') . " al " . $fechaDevolucion->format('Y-m-d') . ")";
        }
    }

    // Si se detecta conflicto, no se permite la asignación
    if (!$disponible) {
        echo json_encode([
            "success" => false,
            "message" => "El Master Driver ya tiene un curso asignado en la fecha: $fecha_conflicto",
            "log" => $log,
            "response_api" => $data_validacion
        ]);
        exit;
    }

    // 4️⃣ Asignar Master Driver en tu base de datos
    $stmt = $conexion->prepare("UPDATE asignacion_unidad_demo 
                                SET id_asignar_prueba_demo_master_driver = ? 
                                WHERE id_asignacion_unidad_demo = ?");
    $stmt->bind_param("ii", $id_master_driver, $id_asignacion);

    if (!$stmt->execute()) {
        echo json_encode([
            "success" => false,
            "message" => "Error al asignar Master Driver: " . $stmt->error,
            "log" => $log
        ]);
        exit;
    }
    $stmt->close();

    // 5️⃣ Enviar fechas a la API externa
    $url_api_insert = "https://apipic.ldrhumanresources.com/api/storeDemo";
    $payload_insert = json_encode([
        "instructor_id" => $id_master_driver,
        "reference_id"  => $id_asignacion,
        "start_date"    => $fechaAsignacion->format('Y-m-d'),
        "end_date"      => $fechaDevolucion->format('Y-m-d')
    ]);

    $ch = curl_init($url_api_insert);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload_insert);
    $response_insert = curl_exec($ch);
    $http_code_insert = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    echo json_encode([
        "success" => true,
        "message" => "Master Driver asignado correctamente y fechas registradas en la API.",
        "http_code" => $http_code_insert,
        "log" => $log, // 👀 Mostrar log completo
        "response_insert" => $response_insert
    ]);

} else {
    echo json_encode([
        "success" => false,
        "message" => "Faltan datos: id_master_driver o id_asignacion."
    ]);
}
?>
