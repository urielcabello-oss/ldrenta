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

/* =========================
   NORMALIZAR VALORES VACÍOS
   ========================= */
$_POST['editarPasoDiferencial'] = $_POST['editarPasoDiferencial'] ?: 0;
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
$estatus          = (int)$_POST['editarEstatusUnidad'];
$tipoUnidad       = (int)$_POST['editarTipoUnidad'];
$sede             = (int)$_POST['editsedeunidad'];
$tipoAdquisicion  = (int)$_POST['editartipoadquisicionunidad'];
$arrendadora      = (int)$_POST['editartipoarrendadoraunidad'];
$folioFactura     = $_POST['editarfoliofacturaunidad'];
$fechaAdquisicion = $_POST['editarfechaadquisicionunidad'];
$pasoDiferencial  = (float)$_POST['editarPasoDiferencial'];


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
    paso_diferencial = ?
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
    $pasoDiferencial
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
    "d"  // paso diferencial
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
    echo "OK";
} else {
    echo "Error al actualizar: " . $stmt->error;
}

$stmt->close();
$conectar->close();