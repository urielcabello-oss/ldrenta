<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

include("../../../conexion.php");

$id = $_POST['id'];
$impacto = $_POST['impacto'];

$stmt = $conexion->prepare("
UPDATE asignacion_unidad_demo
SET impacto_atencion = ?
WHERE id_asignacion_unidad_demo = ?
");

$stmt->bind_param("ii",$impacto,$id);

if($stmt->execute()){

    echo json_encode([
        "status"=>true
    ]);

}else{

    echo json_encode([
        "status"=>false
    ]);

}