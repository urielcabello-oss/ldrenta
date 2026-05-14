<?php
include("../../conexion.php");

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id_colaborador'])) {
    echo "Sesión inválida";
    exit;
}

$creador_unidad = $_SESSION['id_colaborador'];

/* ==============================
   1️⃣ OBTENER DATOS (permitir null)
============================== */

function obtener($campo)
{
    return isset($_POST[$campo]) && $_POST[$campo] !== ''
        ? $_POST[$campo]
        : null;
}

$valores = [
    "id_modelo" => obtener("modelounidad"),
    "id_estado_unidad" => obtener("estadounidad"),
    "id_estatus_unidad" => obtener("estatusunidad"),
    "id_tipo_unidad" => obtener("tipounidad"),
    "id_tipo_adquisicion" => obtener("tipoadquisicionunidad"),
    "id_sede" => obtener("sedeunidad"),
    "vin" => obtener("VIN"),
    "numero_motor" => obtener("motorunidad"),
    "placa" => obtener("placaunidad"),
    "costo_neto" => obtener("tarjetacirculacionunidad"),
    "id_color" => obtener("colorunidad"),
    "fecha_adquisicion" => obtener("fechaadquisicionunidad"),
    "año_unidad" => obtener("añounidad"),
    "id_arrendadora" => obtener("arrendadora"),
    "folio_factura" => obtener("foliofactura"),
    "capacidad_carga" => obtener("capacidad_carga"),
    "capacidad_pasajeros" => obtener("capacidad_pasajeros"),
    "id_tipo_combustible" => obtener("tipo_combustible"),
    "id_traccion" => obtener("traccion"),
    "tipo_carrceria" => obtener("tipo_carroceria"),
    "numero_puertas" => obtener("numero_puertas"),
    "numero_asientos" => obtener("numero_asientos"),
    "id_tipo_caja" => obtener("tipo_caja"),
    "id_tipo_freno" => obtener("tipo_frenos"),
    "id_tipo_suspencion" => obtener("suspension"),
    "numero_ejes" => obtener("numero_ejes"),
    "id_tipo_uso" => obtener("uso_permitido"),
    "paso_diferencial" => obtener("paso_diferencial")
];

/* ==============================
   2️⃣ VALIDAR SOLO LOS CAMPOS OBLIGATORIOS
============================== */

$obligatorios = [
    "id_modelo",
    "id_estado_unidad",
    "id_estatus_unidad",
    "id_tipo_unidad",
    "id_tipo_adquisicion",
    "id_sede",
    "placa",
    "costo_neto",
    "id_color",
    "numero_motor",
    "año_unidad",
    "folio_factura",
    "vin"
];

foreach ($obligatorios as $campo) {
    if (empty($valores[$campo])) {
        echo "Falta campo obligatorio: " . $campo;
        exit;
    }
}

/* ==============================
   3️⃣ MANEJO DE IMAGEN
============================== */

$nombreImagen = null;

if (isset($_FILES['imagen_unidad']) && $_FILES['imagen_unidad']['error'] == 0) {

    $nombreImagen = 'img_' . $valores["placa"] . '_' . basename($_FILES['imagen_unidad']['name']);
    $ruta = "../../archivos/imagenes/imagenes_unidades/";
    move_uploaded_file($_FILES['imagen_unidad']['tmp_name'], $ruta . $nombreImagen);
}

/* ==============================
   4️⃣ PREPARED STATEMENT
============================== */

$stmt = $conexion->prepare("
    INSERT INTO unidades (
        id_creador_unidad,
        id_modelo,
        id_estado_unidad,
        id_estatus_unidad,
        id_tipo_unidad,
        id_tipo_adquisicion,
        id_sede,
        vin,
        numero_motor,
        placa,
        costo_neto,
        id_color,
        img_unidad,
        fecha_adquisicion,
        año_unidad,
        id_arrendadora,
        folio_factura,
        capacidad_carga,
        capacidad_pasajeros,
        id_tipo_combustible,
        id_traccion,
        tipo_carrceria,
        numero_puertas,
        numero_asientos,
        id_tipo_caja,
        id_tipo_freno,
        id_tipo_suspencion,
        numero_ejes,
        id_tipo_uso,
        paso_diferencial
    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
");

/* tipos aproximados (ajusta si necesitas) */
$stmt->bind_param(
"iiiiiiissssisssissiiiiiiiiiiis",
    $creador_unidad,
    $valores["id_modelo"],
    $valores["id_estado_unidad"],
    $valores["id_estatus_unidad"],
    $valores["id_tipo_unidad"],
    $valores["id_tipo_adquisicion"],
    $valores["id_sede"],
    $valores["vin"],
    $valores["numero_motor"],
    $valores["placa"],
    $valores["costo_neto"],
    $valores["id_color"],
    $nombreImagen,
    $valores["fecha_adquisicion"],
    $valores["año_unidad"],
    $valores["id_arrendadora"],
    $valores["folio_factura"],
    $valores["capacidad_carga"],
    $valores["capacidad_pasajeros"],
    $valores["id_tipo_combustible"],
    $valores["id_traccion"],
    $valores["tipo_carrceria"],
    $valores["numero_puertas"],
    $valores["numero_asientos"],
    $valores["id_tipo_caja"],
    $valores["id_tipo_freno"],
    $valores["id_tipo_suspencion"],
    $valores["numero_ejes"],
    $valores["id_tipo_uso"],
    $valores["paso_diferencial"]
);

if ($stmt->execute()) {
    echo "Unidad insertada correctamente";
} else {
    echo "Error al insertar la unidad";
}
