<?php
include("../../conexion.php");

// Iniciar sesión si no está iniciada
if (!isset($_SESSION)) {
    session_start();
}

// Verificar que la sesión tenga los datos necesarios
if (!isset($_SESSION['id_colaborador']) || !isset($_SESSION['id_tipo_usuario'])) {
    echo "<div class='alert alert-danger'>Sesión inválida</div>";
    exit;
}

$colaborador = $_SESSION['id_colaborador'];
$id_tipo_usuario = $_SESSION['id_tipo_usuario'];

// Validar variables POST
$id_unidad = $_POST['id_unidad'] ?? null;
$data_fecha_solicitudemo = $_POST['data_fecha_solicitudemo'] ?? null;
$data_fecha_devoluciondemo = $_POST['data_fecha_devoluciondemo'] ?? null;

// Si faltan datos obligatorios, detener ejecución
if (!$id_unidad || !$data_fecha_solicitudemo || !$data_fecha_devoluciondemo) {
    echo "<div class='alert alert-danger'>Faltan datos de la solicitud.</div>";
    exit;
}

// Consulta de personas morales
$sql = "SELECT pm.id_persona_moral, 
               pm.id_registrador_persona_moral,
               col.nombre_1 AS nombre_1_colaborador,
               col.nombre_2 AS nombre_2_colaborador,
               col.apellido_paterno AS apellido_paterno_colaborador,
               col.apellido_materno AS apellido_materno_colaborador,
               pm.identificacion_representante_legal_seccion,
               pm.vigencia,
               pm.rfc_moral,
               pm.domicilio,
               pm.organizacion_institucion
        FROM personas_morales pm
        LEFT JOIN colaboradores col ON pm.id_registrador_persona_moral = col.id_colaborador";

// Si no es administrador (tipo 4), limitar registros a los que registró el colaborador
if ($id_tipo_usuario != 4) {
    $sql .= " WHERE pm.id_registrador_persona_moral = '$colaborador'";
}

$sql .= " ORDER BY pm.id_persona_moral DESC";

$resultado = $conexion->query($sql);

// Generar tabla
if ($resultado && $resultado->num_rows > 0) {
    echo "<div class='table-responsive'>
            <table class='table table-hover'>
                <thead class='table-light'>
                    <tr>
                        <th class='titulostablaunidades'>ID</th>
                        <th class='titulostablaunidades'>Organización/institución</th>
                        <th class='titulostablaunidades'>Identificación</th>
                        <th class='titulostablaunidades'>RFC</th>
                        <th class='titulostablaunidades'>Domicilio</th>
                        <th class='titulostablaunidades'>Acción</th>
                    </tr>
                </thead>
                <tbody>";

    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>
                <td class='titulostablaunidades'>{$fila['id_persona_moral']}</td>
                <td class='titulostablaunidades'>{$fila['organizacion_institucion']}</td>
                <td class='titulostablaunidades'>{$fila['identificacion_representante_legal_seccion']}</td>
                <td class='titulostablaunidades'>{$fila['rfc_moral']}</td>
                <td class='titulostablaunidades'>{$fila['domicilio']}</td>
                <td class='titulostablaunidades'>
                    <button class='btn fa-solid fa-eye btnasignarunidademo' 
                        data-id_persona_moral='{$fila['id_persona_moral']}' 
                        data-id_unidad='{$id_unidad}' 
                        data-id_colaborador='{$colaborador}' 
                        data-fecha_solicitudemo='{$data_fecha_solicitudemo}' 
                        data-fecha_devoluciondemo='{$data_fecha_devoluciondemo}'>
                    </button>
                </td>
            </tr>";
    }

    echo "    </tbody>
            </table>
        </div>";
} else {
    echo "<div class='alert alert-warning'>No se encontraron resultados.</div>";
}
?>
