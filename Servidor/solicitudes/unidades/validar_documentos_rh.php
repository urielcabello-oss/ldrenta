<?php
include("../../conexion.php");

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];
$tipo = $data['tipo'];
$estatus = $data['estatus'];

$estado = ($estatus === 'APROBADO') ? 1 : 2;

switch($tipo){

    case 'tenencia':
        $tabla = "tenencias";
        $campoId = "id_tenencias";
        break;

    case 'verificacion':
        $tabla = "verificaciones";
        $campoId = "id_verificaciones";
        break;

    case 'licencia':
        $tabla = "licencias_conducir";
        $campoId = "id_licencia";
        break;

    default:
        echo "Tipo inválido";
        exit;
}

$query = "
UPDATE $tabla 
SET estado_validacion = $estado
WHERE $campoId = $id
";

if(mysqli_query($conexion, $query)){
    echo "ok";
}else{
    echo mysqli_error($conexion);
}