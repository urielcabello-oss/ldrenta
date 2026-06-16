<?php
include("../../conexion.php");

if (!isset($_POST['id_unidad'])) {
    exit("Datos incompletos");
}

$idUnidad = (int)$_POST['id_unidad'];

$imagenSQL = "";
$nombreImagen = null;

/* =========================
   MANEJO DE IMAGEN OPCIONAL
   ========================= */
if (isset($_FILES['imagen_unidad']) && $_FILES['imagen_unidad']['error'] === 0) {

    $nombreImagen = "img_" . time() . ".png";

    $rutaFisica = __DIR__ . "/../../archivos/imagenes/imagenes_unidades/";

    if (!is_dir($rutaFisica)) {
        mkdir($rutaFisica, 0777, true);
    }

    if (move_uploaded_file($_FILES['imagen_unidad']['tmp_name'], $rutaFisica . $nombreImagen)) {
        $imagenSQL = ", img_unidad = ?";
    } else {
        echo "Error al mover archivo";
        exit;
    }
}

function obtenerEstadoActual($idUnidad) {
    global $conectar;

    $sql = "SELECT id_estado_unidad 
            FROM unidades 
            WHERE id_unidad = ?";

    $stmt = $conectar->prepare($sql);
    $stmt->bind_param("i", $idUnidad);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
        return (int)$row['id_estado_unidad'];
    }

    return null;
}

function tieneAsignacionActiva($conectar, $idUnidad) {

    $sql = "SELECT COUNT(*) as total
            FROM asignacion_unidad_demo
            WHERE id_unidad = ?
            AND estado = 1";

    $stmt = $conectar->prepare($sql);
    $stmt->bind_param("i", $idUnidad);
    $stmt->execute();
    $res = $stmt->get_result();

    $row = $res->fetch_assoc();

    return $row['total'] > 0;
}

/* =========================
   NORMALIZAR VALORES VACÍOS
   ========================= */
$_POST['editarCostoNeto'] = $_POST['editarCostoNeto'] ?: 0;

/* =========================
   VARIABLES TIPADAS
   ========================= */
$modelo           = (int)$_POST['modeloeditarunidad'];
$vin              = $_POST['editarVIN'];
$placa            = $_POST['editarPlaca'];
$motor            = $_POST['editarNumeroMotor'];
$costoNeto        = (float)$_POST['editarCostoNeto'];
$color            = (int)$_POST['editarColor'];
$anio             = (int)$_POST['editarAnioUnidad'];
$estado           = (int)$_POST['editarEstadoUnidad'];

// 🔴 VALIDACIÓN DE FLUJO (ANTI-ROTO)
$estadoActual = obtenerEstadoActual($idUnidad);

if ($estadoActual == 3 && $estado != 3) {

    echo json_encode([
        "success" => false,
        "message" => "No puedes cambiar el estado de una unidad RENTADA"
    ]);
    exit;
}

$estadoNuevo = (int)$_POST['editarEstadoUnidad'];
$estadoActual = obtenerEstadoActual($idUnidad);

// ❌ PROHIBIR cambios manuales a estados de flujo (RENTADA y PRE-ASIGNACIÓN)
if (in_array($estadoNuevo, [3, 4]) && $estadoActual != $estadoNuevo) {

    echo json_encode([
        "success" => false,
        "message" => "No puedes asignar manualmente estados de flujo (PRE-ASIGNACIÓN o RENTADA). Debe hacerse desde el módulo Rentar unidad."
    ]);
    exit;
}
$estatus          = (int)$_POST['editarEstatusUnidad'];
$tipoUnidad       = (int)$_POST['editarTipoUnidad'];
$sede             = (int)$_POST['editsedeunidad'];
$tipoAdquisicion  = (int)$_POST['editartipoadquisicionunidad'];
$arrendadora      = (int)$_POST['editartipoarrendadoraunidad'];
$folioFactura     = $_POST['editarfoliofacturaunidad'];
$fechaAdquisicion = $_POST['editarfechaadquisicionunidad'];
$editsupervisor = !empty($_POST['editsupervisor']) ? (int)$_POST['editsupervisor'] : null;
$editubicacion = !empty($_POST['editubicacion']) ? (int)$_POST['editubicacion'] : null;
$editarCiudad     = $_POST['editarCiudad'];
$editarMunicipio  = $_POST['editarMunicipio'];


/* =========================
   SQL DINÁMICO
   ========================= */
$sql = "UPDATE unidades SET
    id_modelo = ?,
    vin = ?,
    placa = ?,
    numero_motor = ?,
    costo_neto = ?,
    id_color = ?,
    anio_unidad = ?,
    id_estado_unidad = ?,
    id_estatus_unidad = ?,
    id_tipo_unidad = ?,
    id_sede = ?,
    id_tipo_adquisicion = ?,
    id_arrendadora = ?,
    folio_factura = ?,
    fecha_adquisicion = ?,
    id_supervisor = ?,
    id_ubicacion = ?,
    ciudad = ?,
    municipio = ?
    $imagenSQL
    WHERE id_unidad = ?";

$stmt = $conectar->prepare($sql);

$params = [
    $modelo,
    $vin,
    $placa,
    $motor,
    $costoNeto,
    $color,
    $anio,
    $estado,
    $estatus,
    $tipoUnidad,
    $sede,
    $tipoAdquisicion,
    $arrendadora,
    $folioFactura,
    $fechaAdquisicion,
    $editsupervisor,
    $editubicacion,
    $editarCiudad,
    $editarMunicipio
];

$typesArray = [
    "i", // modelo
    "s", // vin
    "s", // placa
    "s", // motor
    "d", // costo
    "i", // color
    "i", // año
    "i", // estado
    "i", // estatus
    "i", // tipo unidad
    "i", // sede
    "i", // tipo adquisicion
    "i", // arrendadora
    "s", // folio
    "s", // fecha
    "i", // supervisor
    "i", // ubicacion
    "s", // ciudad
    "s"  // municipio
];

if ($nombreImagen) {
    $params[] = $nombreImagen;
    $typesArray[] = "s";
}

$params[] = $idUnidad;
$typesArray[] = "i";

$types = implode("", $typesArray);


$stmt->bind_param($types, ...$params);

/* =========================
   EJECUTAR
   ========================= */
if ($stmt->execute()) {
    echo json_encode([
    "success" => true,
    "message" => "OK"
]);
} else {
    echo json_encode([
    "success" => false,
    "message" => $stmt->error
]);
exit;
}

$stmt->close();
$conectar->close();