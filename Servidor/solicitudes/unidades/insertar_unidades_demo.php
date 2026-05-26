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
    "costo_neto" => obtener("costoneto"),
    "id_color" => obtener("colorunidad"),
    "fecha_adquisicion" => obtener("fechaadquisicionunidad"),
    "anio_unidad" => obtener("anounidad"),
    "id_arrendadora" => obtener("arrendadora"),
    "folio_factura" => obtener("foliofactura"),
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
    "anio_unidad",
    "folio_factura",
    "vin",
    "id_arrendadora"
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

$validar = $conexion->prepare("
SELECT id_unidad 
FROM unidades 
WHERE vin = ? OR placa = ?
");

$validar->bind_param(
    "ss",
    $valores["vin"],
    $valores["placa"]
);

$validar->execute();

$resultado = $validar->get_result();

if ($resultado->num_rows > 0) {
    echo "Duplicate";
    exit;
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
        anio_unidad,
        id_arrendadora,
        folio_factura,
        paso_diferencial
    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
");

$stmt->bind_param(
    "iiiiiiisssdissiisd",
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
    $valores["anio_unidad"],
    $valores["id_arrendadora"],
    $valores["folio_factura"],
    $valores["paso_diferencial"]
);

if ($stmt->execute()) {
    echo "Unidad insertada correctamente";
} else {
    echo "Error al insertar la unidad";
}
