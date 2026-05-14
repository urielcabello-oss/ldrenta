<?php
include("../../Servidor/conexion.php");
if (!isset($_SESSION)) {
    session_start();
}

/*
  Aquí puedes unir tus 3 queries si quieres,
  o repetir la lógica que ya usas en tus cards.
*/

$sql = "SELECT 
    a.id_asignaciones,
    a.id_unidad,
    a.id_tipo_asignaciones,
    a.estado,
    u.placa,
    u.vin,
    mo.nombre_modelo,
    a.fecha_asignacion,
    c.nombre_1 AS col_nombre1,
    c.nombre_2 AS col_nombre2,
    c.apellido_paterno AS col_ap,
    c.apellido_materno AS col_am,
    ue.nombre_1 AS ue_nombre1,
    ue.nombre_2 AS ue_nombre2,
    ue.apellido_paterno AS ue_ap,
    ue.apellido_materno AS ue_am
FROM asignacion_unidad_colaborador a
LEFT JOIN unidades u ON a.id_unidad = u.id_unidad
LEFT JOIN modelos mo ON u.id_modelo = mo.id_modelo
LEFT JOIN colaboradores c ON a.id_colaborador = c.id_colaborador
LEFT JOIN usuarios_externos ue ON a.id_usuario_externo = ue.id_usuario_externo";



$resultado = $conexion->query($sql);
?>

<div class="table-responsive">
<table class="table table-hover align-middle" id="tablaUnidadesAsignadas">
  <thead class="table-light">
    <tr>
      <th>Asignado a</th>
      <th>Modelo</th>
      <th>Placa</th>
      <th>VIN</th>
      <th>Tipo asignacion</th>
      <th>Fecha Asignación</th>
      <th>Estado</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>

<?php while($row = $resultado->fetch_assoc()): 

$nombre = $row['col_nombre1'] 
    ? $row['col_nombre1'].' '.$row['col_nombre2'].' '.$row['col_ap'].' '.$row['col_am']
    : $row['ue_nombre1'].' '.$row['ue_nombre2'].' '.$row['ue_ap'].' '.$row['ue_am'];

$tipo = $row['id_tipo_asignaciones'] == 1 ? 'Temporal' : 'Exclusivo';

$estadoTxt = $row['estado'] == 2 ? 'Devuelto' : 'Activo';
$badgeEstado = $row['estado'] == 2 
    ? '<span class="badge bg-success">Devuelto</span>' 
    : '<span class="badge bg-primary">Activo</span>';
?>

<tr>
  <td><?= $nombre ?></td>
  <td><?= $row['nombre_modelo'] ?></td>
  <td><?= $row['placa'] ?></td>
  <td><?= $row['vin'] ?></td>
  <td><span class="badge bg-secondary"><?= $tipo ?></span></td>
  <td><?= $row['fecha_asignacion'] ?></td>
  <td><?= $badgeEstado ?></td>

  <td>
  <button 
    class="btn btn-sm btn-primary btnentregaunidad"
    data-id="<?= $row['id_unidad'] ?>">
    Ver
  </button>

<?php if($row['estado'] == 1): ?>
  <button 
    class="btn btn-sm btn-warning"
    onclick="devolverUnidad(<?= $row['id_asignaciones'] ?>,<?= $row['id_unidad'] ?>)">
    Devolver<i class="fas fa-undo"></i>
  </button>
<?php else: ?>
  <span class="ms-2 badge bg-success">Devuelta</span>
<?php endif; ?>
</td>

</tr>

<?php endwhile; ?>

  </tbody>
</table>
</div>
