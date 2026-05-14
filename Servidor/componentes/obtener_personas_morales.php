<?php 
include("../../Servidor/conexion.php");

if (!isset($_SESSION)) {
    session_start();
}

// Verificar que la sesión tenga los datos necesarios
if (!isset($_SESSION['id_colaborador']) || !isset($_SESSION['id_tipo_usuario'])) {
    echo "Sesión inválida";
    exit;
}

$colaborador = $_SESSION['id_colaborador'];
$id_tipo_usuario = $_SESSION['id_tipo_usuario'];


// Consulta según tipo de usuario
$sql = "SELECT pm.*, 
               col.nombre_1 AS nombre_1_colaborador,
               col.nombre_2 AS nombre_2_colaborador,
               col.apellido_paterno AS apellido_paterno_colaborador,
               col.apellido_materno AS apellido_materno_colaborador
        FROM personas_morales AS pm
        LEFT JOIN colaboradores col 
        ON pm.id_registrador_persona_moral = col.id_colaborador
        WHERE pm.id_registrador_persona_moral = '$colaborador'";


$resultado = $conexion->query($sql);

// Mostrar resultados
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>
            <td class='sticky-left-0'>";
                   if ($id_tipo_usuario == 5 || $id_tipo_usuario == 6): // tipos de usuario solicitantes demos 
                echo "<button class='btn fas fa-edit btn-editar_persona_fisica btneditarpersonafisica' data-id='" . $fila['id_persona_moral'] . "'></button>";
            endif;
            echo"</td>
            <td class='titulostablaunidades'>" . $fila['id_persona_moral'] . "</td>
            <td class='titulostablaunidades'>" . $fila['organizacion_institucion'] . "</td>
            <td class='titulostablaunidades'>" . $fila['rfc_moral'] . "</td>
            <td class='titulostablaunidades'>" . $fila['domicilio'] . "</td>
            <td class='titulostablaunidades'>" . $fila['contacto_persona_moral'] . "</td>
            <td class='titulostablaunidades'>" . $fila['domicilio_resguardo_unidad'] . "</td>
            ";

        // Mostrar nombre del creador solo si el usuario es admin tipo 4
        if ($id_tipo_usuario == 4) {
            echo "<td class='titulostablaunidades'>" . 
                $fila['nombre_1_colaborador'] . " " . 
                $fila['nombre_2_colaborador'] . " " . 
                $fila['apellido_paterno_colaborador'] . " " . 
                $fila['apellido_materno_colaborador'] . 
            "</td>";
        }

        echo "
            <td style='text-align: center;'>
                <button class='btn fas fa-id-card btn-identificacion btnveridrepresentantelegal' data-id='" . $fila['id_persona_moral'] . "'></button>
            </td>
            
            <td style='text-align: center;'>
                <button class='btn fas fa-file-pdf btn-poder btnverpoderrepresentantelegal' data-id='" . $fila['id_persona_moral'] . "'></button>
            </td>

            <td style='text-align: center;'>
                <button class='btn fas fa-file-pdf btn-rfc btnverrfc' data-id='" . $fila['id_persona_moral'] . "'></button>
            </td>

            <td style='text-align: center;'>
                <button class='btn fas fa-map-marker-alt btn-domicilio btnverdomicilio' data-id='" . $fila['id_persona_moral'] . "'></button>
            </td>

            <td style='text-align: center;'>
                <button class='btn fas fa-file-pdf btn-constitutiva btnverescrituraconstitutiva' data-id='" . $fila['id_persona_moral'] . "'></button>
            </td>

            <td style='text-align: center;'>
                <button class='btn fas fa-file-pdf btn-estatutos btnverestatusociales' data-id='" . $fila['id_persona_moral'] . "'></button>
            </td>

            <td style='text-align: center;'>
                <button class='btn fas fa-map-marker-alt btn-resguardounidad btndomicilioresguardo' data-id='" . $fila['id_persona_moral'] . "'></button>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='13'>No se encontraron resultados.</td></tr>";
}
?>
