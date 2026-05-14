<?php
include("../../../conexion.php");
if (!isset($_SESSION)) session_start();

$id_asignacion = $_POST['id_asignacion'] ?? null;
$comentarios = $_POST['comentarios'] ?? [];
$id_colaborador_juridico = $_SESSION['id_colaborador'] ?? 1; // <-- Ajusta según tu sesión real

if (!$id_asignacion || empty($comentarios)) {
    echo "Error: faltan datos";
    exit;
}

$stmt = $conexion->prepare("
    INSERT INTO observaciones_documentos_juridico 
    (id_asignacion_unidad_demo, campo_archivo, comentario, id_colaborador_juridico, fecha, visto_por_usuario)
    VALUES (?, ?, ?, ?, NOW(), 0)
");

if (!$stmt) {
    die("Error al preparar la consulta: " . $conexion->error);
}

foreach ($comentarios as $campo => $valor) {
    if (is_array($valor)) {
        foreach ($valor as $comentario) {
            if (trim($comentario) !== '') {
                $stmt->bind_param("issi", $id_asignacion, $campo, $comentario, $id_colaborador_juridico);
                $stmt->execute();
            }
        }
    } else {
        if (trim($valor) !== '') {
            $stmt->bind_param("issi", $id_asignacion, $campo, $valor, $id_colaborador_juridico);
            $stmt->execute();
        }
    }
}

echo "ok";
