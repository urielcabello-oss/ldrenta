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
$_POST['editarCarga'] = $_POST['editarCarga'] ?: 0;
$_POST['editarPasajeros'] = $_POST['editarPasajeros'] ?: 0;
$_POST['editarPuertas'] = $_POST['editarPuertas'] ?: 0;
$_POST['editarAsientos'] = $_POST['editarAsientos'] ?: 0;
$_POST['editarEjes'] = $_POST['editarEjes'] ?: 0;
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
$anio             = (int)$_POST['editarañounidad'];
$estado           = (int)$_POST['editarEstadoUnidad'];
$estatus          = (int)$_POST['editarEstatusUnidad'];
$tipoUnidad       = (int)$_POST['editarTipoUnidad'];
$sede             = (int)$_POST['editsedeunidad'];
$tipoAdquisicion  = (int)$_POST['editartipoadquisicionunidad'];
$arrendadora      = (int)$_POST['editartipoarrendadoraunidad'];
$folioFactura     = $_POST['editarfoliofacturaunidad'];
$fechaAdquisicion = $_POST['editarfechaadquisicionunidad'];
$pasoDiferencial  = (float)$_POST['editarPasoDiferencial'];
$carga            = (float)$_POST['editarCarga'];
$pasajeros        = (int)$_POST['editarPasajeros'];
$combustible      = (int)$_POST['editarCombustible'];
$traccion         = (int)$_POST['editarTraccion'];
$carroceria       = $_POST['editarCarroceria'];
$puertas          = (int)$_POST['editarPuertas'];
$asientos         = (int)$_POST['editarAsientos'];
$caja             = (int)$_POST['editarCaja'];
$freno            = (int)$_POST['editarFreno'];
$suspencion       = (int)$_POST['editarSuspencion'];
$ejes             = (int)$_POST['editarEjes'];
$uso              = (int)$_POST['editarUso'];

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
    año_unidad = ?,
    id_estado_unidad = ?,
    id_estatus_unidad = ?,
    id_tipo_unidad = ?,
    id_sede = ?,
    id_tipo_adquisicion = ?,
    id_arrendadora = ?,
    folio_factura = ?,
    fecha_adquisicion = ?,
    paso_diferencial = ?,
    capacidad_carga = ?,
    capacidad_pasajeros = ?,
    id_tipo_combustible = ?,
    id_traccion = ?,
    tipo_carrceria = ?,
    numero_puertas = ?,
    numero_asientos = ?,
    id_tipo_caja = ?,
    id_tipo_freno = ?,
    id_tipo_suspencion = ?,
    numero_ejes = ?,
    id_tipo_uso = ?
    $imagenSQL
    WHERE id_unidad = ?";

$stmt = $conexion->prepare($sql);

/* =========================
   TYPES + PARAMS DINÁMICOS
   ========================= */
$types = "isssdiiiiiiiissddiiisiiiiiiiii";

/* =========================
   PARAMETROS BASE
   ========================= */
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
    $pasoDiferencial,
    $carga,
    $pasajeros,
    $combustible,
    $traccion,
    $carroceria,
    $puertas,
    $asientos,
    $caja,
    $freno,
    $suspencion,
    $ejes,
    $uso
];

/* =========================
   TYPES AUTOMATICO
   ========================= */
$typesArray = [
    "i","s","s","s","d","i","i","i","i","i","i","i","i",
    "s","s","d","d","i","i","i","s","i","i","i","i","i","i","i"
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
$conexion->close();