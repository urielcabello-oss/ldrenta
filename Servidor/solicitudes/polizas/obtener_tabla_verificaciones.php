<?php
include("../../conexion.php");

if (!isset($_SESSION)) session_start();

// Validar sesión
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

// Query principal de verificaciones
$query = "SELECT veri.id_verificaciones,
                 veri.id_unidad,
                 veri.folio,
                 veri.monto,
                 veri.año,
                 veri.fecha_verificacion,
                 veri.fecha_siguiente_verificacion,
                 verisemestre.nombre_semestre,
                 estatusveri.estatus
          FROM verificaciones AS veri
          INNER JOIN estatus_verificacion AS estatusveri
          ON veri.id_estatus_verificacion = estatusveri.id_estatus_verificacion
          INNER JOIN verificacion_semestre AS verisemestre
          ON veri.id_semestre = verisemestre.id_semestre
          WHERE veri.id_unidad = '$id_unidad'";

$ejecutar = $conexion->query($query);

// Tabla
echo '<table class="table table-striped">
        <thead style="background-color:rgba(119, 120, 121, 0.68); color: white;">
            <tr>
                <th></th>
                <th>Unidad</th>
                <th>Folio</th>
                <th>Monto</th>
                <th>Año</th>
                <th>Semestre</th>
                <th>Fecha verificación</th>
                <th>Proxima verificación</th>
                <th>Estatus</th>
            </tr>
        </thead>
        <tbody>';

if ($ejecutar && $ejecutar->num_rows > 0) {
    while ($data = $ejecutar->fetch_assoc()) {
        echo '<tr>
            <td><button class="btn btn-warning btn-sm btneditarverificaciones" data-id="' . $data['id_verificaciones'] . '"><i class="fas fa-edit"></i> Editar</button></td>
            <td>' . $data['id_unidad'] . '</td>
            <td>' . $data['folio'] . '</td>
            <td>$' . number_format($data['monto'], 2, '.', ',') . ' MXN</td>
            <td>' . $data['año'] . '</td>
            <td>' . $data['nombre_semestre'] . '</td>
            <td>' . $data['fecha_verificacion'] . '</td>
            <td>' . $data['fecha_siguiente_verificacion'] . '</td>
            <td>' . $data['estatus'] . '</td>
        </tr>';
    }
} else {
    echo '<tr><td colspan="9">No se encontraron verificaciones</td></tr>';
}

echo '</tbody></table>';
?>
