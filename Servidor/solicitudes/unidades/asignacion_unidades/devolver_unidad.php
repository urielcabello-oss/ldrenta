<?php
include("../../../conexion.php");

$idAsignacion = intval($_POST['id_asignaciones']);
$idUnidad = intval($_POST['id_unidad']);

$conexion->begin_transaction();

try {

  $sql1 = "UPDATE asignacion_unidad_colaborador 
           SET estado = 2,
               fecha_devolucion = CURDATE(),
               hora_devolucion = CURTIME()
           WHERE id_asignaciones = ?";

  $stmt1 = $conexion->prepare($sql1);
  $stmt1->bind_param("i", $idAsignacion);
  $stmt1->execute();

  $sql2 = "UPDATE unidades 
           SET id_estado_unidad = 1 
           WHERE id_unidad = ?";

  $stmt2 = $conexion->prepare($sql2);
  $stmt2->bind_param("i", $idUnidad);
  $stmt2->execute();

  $conexion->commit();

  echo json_encode(["status"=>true,"msg"=>"Unidad devuelta correctamente"]);

} catch (Exception $e) {

  $conexion->rollback();
  echo json_encode(["status"=>false,"msg"=>"Error al devolver unidad"]);

}
