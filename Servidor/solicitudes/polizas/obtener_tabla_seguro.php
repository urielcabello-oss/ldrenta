<?php
include("../../conexion.php");
if (!isset($_SESSION)) session_start();

// Verificar tipo de usuario
if (!isset($_SESSION['id_tipo_usuario'])) {
    echo "Sesión inválida";
    exit;
}
$id_tipo_usuario = $_SESSION['id_tipo_usuario'];

if (!isset($_POST['id_unidad'])) {
    echo "No se recibio el id de la unidad";
    exit;
}

$id_unidad = $_POST['id_unidad'];

// Query principal
$query = "SELECT aseg.numero_poliza_aseguradora,
                 aseg.id_asignacion_aseguradora,
                 aseg.fecha_alta,
                 aseg.fecha_vencimiento,
                 aseg.documento_aseguradora,
                 unid.id_unidad,
                 catlogo.aseguradora,
                 estat_aseg.estatus,
                 estad_aseg.estado_aseguradora
          FROM asignacion_aseguradora_unidad AS aseg
          INNER JOIN unidades AS unid ON aseg.id_unidad = unid.id_unidad
          INNER JOIN aseguradoras AS catlogo ON aseg.id_aseguradora = catlogo.id_aseguradora
          INNER JOIN estatus_aseguradora AS estat_aseg ON aseg.id_estatus_aseguradora = estat_aseg.id_estatus_aseguradora
          INNER JOIN estado_aseguradora AS estad_aseg ON aseg.id_estado_aseguradora = estad_aseg.id_estado_aseguradora
          WHERE unid.id_unidad = '$id_unidad'";

$ejecutar = $conexion->query($query);

// Encabezado de la tabla
echo '<table class="table table-striped">
        <thead style="background-color:rgba(119, 120, 121, 0.68); color: white;">
            <tr>
                <th></th>
                <th>Unidad</th>
                <th>Folio</th>
                <th>Alta</th>
                <th>Vencimiento</th>
                <th>Aseguradora</th>
                <th>Estatus</th>
                <th>Estado</th>
                <th>Documento</th>
            </tr>
        </thead>
        <tbody>';

// Verificar si hay resultados
if ($ejecutar && $ejecutar->num_rows > 0) {
    while ($data = $ejecutar->fetch_assoc()) {
        echo '<tr>
            <td><button class="btn btn-warning btn-sm btneditarpolizas" data-id="' . $data['id_asignacion_aseguradora'] . '"><i class="fas fa-edit"></i> Editar</button></td>
            <td>' . $data['id_unidad'] . '</td>
            <td>' . $data['numero_poliza_aseguradora'] . '</td>
            <td>' . $data['fecha_alta'] . '</td>
            <td>' . $data['fecha_vencimiento'] . '</td>
            <td>' . $data['aseguradora'] . '</td>
            <td>' . $data['estatus'] . '</td>
            <td>' . $data['estado_aseguradora'] . '</td>
            <td>';
        if (!empty($data['documento_aseguradora']) && $data['documento_aseguradora'] != "SIN ASIGNAR") {
            echo '<a href="../../Servidor/archivos/files/files_unidades/polizas_seguros/' . $data['documento_aseguradora'] . '" target="_blank" class="btn btn-success"><i class="fas fa-eye"></i></a>';
        }
        echo '</td></tr>';
    }
} else {
    echo '<tr><td colspan="9">No se encontraron pólizas</td></tr>';
}

echo '</tbody></table>';
?>
