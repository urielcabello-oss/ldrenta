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
$sql = "SELECT pf.*, 
               col.nombre_1 AS nombre_1_colaborador,
               col.nombre_2 AS nombre_2_colaborador,
               col.apellido_paterno AS apellido_paterno_colaborador,
               col.apellido_materno AS apellido_materno_colaborador
        FROM personas_fisicas pf
        LEFT JOIN colaboradores col ON pf.id_registrador_persona_fisica = col.id_colaborador";

// Aplicar condición según tipo
if ($id_tipo_usuario !== null && $id_tipo_usuario != 4) {
    // Usuarios comunes solo ven lo que registraron
    $sql .= " WHERE pf.id_registrador_persona_fisica = '$colaborador'";
}

$resultado = $conexion->query($sql);

// Mostrar resultados
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>
            <td class='sticky-left-0'>";
                   if ($id_tipo_usuario == 5 || $id_tipo_usuario == 6): // tipos de usuario solicitantes demos 
                echo "<button class='btn fas fa-edit btn-editar_persona_fisica btneditarpersonafisica' data-id='" . $fila['id_persona_fisica'] . "'> </button>";
            endif;
            echo"</td>
            <td class='titulostablaunidades'>" . $fila['id_persona_fisica'] . "</td>
            <td class='titulostablaunidades'>" . $fila['nombre_1'] . " " . $fila['nombre_2'] . " " . $fila['apellido_paterno'] . " " . $fila['apellido_materno'] . "</td>
            <td class='titulostablaunidades'>";
                 if ($fila['genero'] == 'M') echo "MASCULINO"; else if ($fila['genero'] == 'F') echo "FEMENINO"; 
            echo "</td>
            <td class='titulostablaunidades'>" . $fila['curp'] . "</td>
            <td class='titulostablaunidades'>" . $fila['rfc'] . "</td>
            <td class='titulostablaunidades'>" . $fila['domicilio'] . "</td>
            <td class='titulostablaunidades'>" . $fila['contacto_persona_fisica'] . "</td>
            <td class='titulostablaunidades'>" . $fila['domicilio_resguardo_unidad'] . "</td>";

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
                <button class='btn fas fa-id-card btn-ine btnine' data-id='" . $fila['id_persona_fisica'] . "'></button>
            </td>

            <td style='text-align: center;'>
                <button class='btn fa-solid fa-file-pdf btn-curp btncurp' data-id='" . $fila['id_persona_fisica'] . "'>
                </button>
            </td>

            <td style='text-align: center;'>
                <button class='btn fa-solid fa-file-pdf btn-rfc btnrfc' data-id='" . $fila['id_persona_fisica'] . "'></button>
            </td>

            <td style='text-align: center;'>
                <button class='btn fas fa-map-marker-alt btn-domicilio btndomicilio' data-id='" . $fila['id_persona_fisica'] . "'></button>
            </td>

            <td style='text-align: center;'>
                <button class='btn fas fa-map-marker-alt btn-resguardounidad btndomicilioresguardo' data-id='" . $fila['id_persona_fisica'] . "'></button>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='13'>No se encontraron resultados.</td></tr>";
}
?>
