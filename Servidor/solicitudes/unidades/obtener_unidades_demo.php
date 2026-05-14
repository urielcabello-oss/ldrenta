<?php
include(__DIR__ . "/../../conexion.php");

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

// Query base
$sql = "SELECT 
    ung.id_unidad,
    marc.nombre_marca,
    model.nombre_modelo,
    ung.placa,
    ung.vin,
    ung.paso_diferencial,
    ung.ultimo_kilometraje,
    unest.estado,
    sed.ubicacion,
    tipunid.tipo_unidad
FROM unidades AS ung
INNER JOIN modelos AS model ON ung.id_modelo = model.id_modelo
INNER JOIN marcas AS marc ON model.id_marca = marc.id_marca
INNER JOIN estado_unidad AS unest ON ung.id_estado_unidad = unest.id_estado_unidad
INNER JOIN tipo_unidad AS tipunid ON ung.id_tipo_unidad = tipunid.id_tipo_unidad
INNER JOIN sedes AS sed ON ung.id_sede = sed.id_sede
LEFT JOIN asignacion_unidad_demo AS asign ON ung.id_unidad = asign.id_unidad
WHERE tipunid.id_tipo_unidad = 3"; // Solo unidades demo



$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {

        // Botón de edición según tipo de usuario
        $btnEditar = "";
        if ($id_tipo_usuario == 1) {
            $btnEditar = "<button class='btn btn-editarunidades btneditarunidades fas fa-edit' data-id='" . $fila['id_unidad'] . "'>
                            
                          </button>";
        } else { // Demo
            $btnEditar = "<button class='btn btn-editarunidades btneditarunidadesdemo fas fa-edit' data-id='" . $fila['id_unidad'] . "'>
                          </button>";
        }

        echo "<tr>
            <td class='sticky-left-0'>{$btnEditar}</td>
            <td class='titulostablaunidades sticky-left-25'>" . $fila['id_unidad'] . "</td>
            <td class='titulostablaunidades sticky-left-50'>" . $fila['nombre_marca'] . "</td>
            <td class='titulostablaunidades sticky-left-75'>" . $fila['nombre_modelo'] . "</td>
            <td class='titulostablaunidades'>" . $fila['placa'] . "</td>
            <td class='titulostablaunidades'>" . $fila['vin'] . "</td>
            <td class='titulostablaunidades'>" . $fila['paso_diferencial'] . "</td>
            <td class='titulostablaunidades'>" . $fila['estado'] . "</td>
            <td class='titulostablaunidades'>" . $fila['tipo_unidad'] . "</td>
            <td class='titulostablaunidades'>" . $fila['ubicacion'] . "</td>
            <td class='titulostablaunidades'>" . ($fila['ultimo_kilometraje'] == 0.00 ? '<span class="text-danger">Unidad sin telemetría</span>' : number_format($fila['ultimo_kilometraje'], 2, '.', ',') . ' km') . "</td>
            <td>
                <button class='btn btn-sm btn-mapa btnubicacionunidad' data-vin='{$fila['vin']}'>
                    <i class='fa-solid fa-location-dot'></i> 
                </button>
            </td>
            <td class='titulostablaunidades' style='text-align: center;'>
                <button class='btn btn-aseguradora btnpolizasunidades fa-solid fa-file-pdf' data-id='{$fila['id_unidad']}'>
                </button>
            </td>
            <td class='titulostablaunidades' style='text-align: center;'>
                <button class='btn btn-tenencias btntenencias fa-solid fa-file-pdf' data-id='{$fila['id_unidad']}'>
                </button>
            </td>
            <td class='titulostablaunidades' style='text-align: center;'>
                <button class='btn btn-verificaciones btnverificaciones fa-solid fa-file-pdf' data-id='{$fila['id_unidad']}'>
                </button>
            </td>
            <td style='text-align:center'>
    <button class='btn btn-warning btnsolicitartraslado'
  data-id_unidad='{$fila['id_unidad']}'
  data-modelo='{$fila['nombre_modelo']}'
  data-placa='{$fila['placa']}'
  data-sede='{$fila['ubicacion']}'>
  <i class='fa-solid fa-truck'></i>
</button>
    </td>
        </tr>
";
    }
} else {
    echo "<tr><td colspan='15'>No se encontraron resultados.</td></tr>";
}
