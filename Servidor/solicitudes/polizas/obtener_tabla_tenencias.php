<?php
include("../../conexion.php");

if (!isset($_SESSION)) session_start();

// Validar sesión y tipo de usuario
if (!isset($_SESSION['id_colaborador']) || !isset($_SESSION['id_tipo_usuario'])) {
    echo "Sesión inválida";
    exit;
}

$id_tipo_usuario = $_SESSION['id_tipo_usuario'];

if (!isset($_POST['id_unidad'])) {
    echo "No se recibio el id de la unidad";
    exit;
}

$id_unidad = $_POST['id_unidad'];

// Query principal de tenencias
$query = "SELECT ten.id_tenencias,
                 ten.id_unidad,
                 ten.folio,
                 ten.año_semestre,
                 ten.id_estatus_tenencias,
                 ten.monto_pago,
                 ten.fecha_pago,
                 ten.fecha_vencimiento,
                 ten.documento_tenencia,
                 estatenencia.estatus
          FROM tenencias AS ten
          INNER JOIN estatus_tenencias AS estatenencia
          ON ten.id_estatus_tenencias = estatenencia.id_estatus_tenencias
          WHERE ten.id_unidad = '$id_unidad'";

$ejecutar = $conexion->query($query);

// Tabla
echo '<table class="table table-striped">
        <thead style="background-color:rgba(119, 120, 121, 0.68); color: white;">
            <tr>
                <th></th>
                <th>Unidad</th>
                <th>Folio</th>
                <th>Año semestre</th>
                <th>Estatus</th>
                <th>Monto</th>
                <th>Pago</th>
                <th>Vencimiento</th>
                <th>Documento</th>
            </tr>
        </thead>
        <tbody>';

if ($ejecutar && $ejecutar->num_rows > 0) {
    while ($data = $ejecutar->fetch_assoc()) {
        echo '<tr>
            <td><button class="btn btn-warning btn-sm btneditartenencias" data-id="' . $data['id_tenencias'] . '"><i class="fas fa-edit"></i> Editar</button></td>
            <td>' . $data['id_unidad'] . '</td>
            <td>' . $data['folio'] . '</td>
            <td>' . $data['año_semestre'] . '</td>
            <td>' . $data['estatus'] . '</td>
            <td>$' . number_format($data['monto_pago'], 2, '.', ',') . ' MXN</td>
            <td>' . $data['fecha_pago'] . '</td>
            <td>' . $data['fecha_vencimiento'] . '</td>
            <td>';
        if (!empty($data['documento_tenencia'])) {
            echo '<a href="../../Servidor/archivos/files/files_unidades/polizas_tenencias/' . $data['documento_tenencia'] . '" target="_blank" class="btn btn-success"><i class="fas fa-eye"></i></a>';
        }
        echo '</td></tr>';
    }
} else {
    echo '<tr><td colspan="9">No se encontraron tenencias</td></tr>';
}

echo '</tbody></table>';
?>
