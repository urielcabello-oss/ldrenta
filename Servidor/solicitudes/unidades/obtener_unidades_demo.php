<?php
include("../../conexion.php");

if (!isset($_SESSION)) {
    session_start();
}

$colaborador = $_SESSION['id_colaborador'];

// Query base
$sql = "SELECT
    ung.id_unidad,
    marc.nombre_marca,
    model.nombre_modelo,
    ung.placa,
    ung.numero_motor,
    ung.vin,
    ung.ultimo_kilometraje,
    ung.ciudad,
    ung.municipio,
    unest.estado,
    sed.ubicacion,
    tipunid.tipo_unidad,
    ubi.ubicacion_unidad,
    arr.arrendadora,

    CONCAT(
        c.nombre_1, ' ',
        IFNULL(c.nombre_2, ''), ' ',
        c.apellido_paterno, ' ',
        IFNULL(c.apellido_materno, '')
    ) AS supervisor

FROM unidades AS ung
INNER JOIN modelos AS model ON ung.id_modelo = model.id_modelo
INNER JOIN marcas AS marc ON model.id_marca = marc.id_marca
INNER JOIN estado_unidad AS unest ON ung.id_estado_unidad = unest.id_estado_unidad
INNER JOIN tipo_unidad AS tipunid ON ung.id_tipo_unidad = tipunid.id_tipo_unidad
INNER JOIN sedes AS sed ON ung.id_sede = sed.id_sede
INNER JOIN arrendadora AS arr ON ung.id_arrendadora = arr.id_arrendadora


LEFT JOIN ubicaciones AS ubi ON ung.id_ubicacion = ubi.id_ubicacion
LEFT JOIN supervisores AS s ON ung.id_supervisor = s.id_supervisor
LEFT JOIN usuarios AS u ON s.id_usuario = u.id_usuario
LEFT JOIN colaboradores AS c ON u.id_colaborador = c.id_colaborador";

$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {

        // Botón único (sin tipo de usuario)
        $btnEditar = "<button class='btn btneditarunidadesdemo fas fa-edit' data-id='" . $fila['id_unidad'] . "'>
                      </button>";

        echo "<tr>
            <td class='sticky-left-0'>{$btnEditar}</td>
            <td class='titulostablaunidades sticky-left-25'>{$fila['id_unidad']}</td>
            <td class='titulostablaunidades sticky-left-50'>{$fila['nombre_marca']}</td>
            <td class='titulostablaunidades sticky-left-75'>{$fila['nombre_modelo']}</td>
            <td class='titulostablaunidades'>{$fila['placa']}</td>
            <td class='titulostablaunidades'>{$fila['numero_motor']}</td>
            <td class='titulostablaunidades'>{$fila['vin']}</td>
            <td class='titulostablaunidades'>" .
            (!empty($fila['supervisor'])
                ? $fila['supervisor']
                : "<span style='color:#ffc107;font-weight:bold;'>Sin supervisor</span>"
            ) .
            "</td>
            <td class='titulostablaunidades'>{$fila['arrendadora']}</td>
            <td class='titulostablaunidades'>{$fila['estado']}</td>
            <td class='titulostablaunidades'>{$fila['tipo_unidad']}</td>
            <td class='titulostablaunidades'>{$fila['ubicacion']}</td>
            <td class='titulostablaunidades'>{$fila['ubicacion_unidad']}</td>
            <td class='titulostablaunidades'>{$fila['ciudad']}</td>
            <td class='titulostablaunidades'>{$fila['municipio']}</td>
            <td class='titulostablaunidades'>" .
            ($fila['ultimo_kilometraje'] == 0.00
                ? '<span class="text-danger">Unidad sin telemetría</span>'
                : number_format($fila['ultimo_kilometraje'], 2, '.', ',') . ' km'
            ) .
            "</td>

            <td>
                <button class='btn btn-sm btn-mapa btnubicacionunidad' data-vin='{$fila['vin']}'>
                    <i class='fa-solid fa-location-dot'></i>
                </button>
            </td>

            <td class='titulostablaunidades text-center'>
                <button class='btn btn-aseguradora btnpolizasunidades fa-solid fa-file-pdf' data-id='{$fila['id_unidad']}'>
                </button>
            </td>

            <td class='titulostablaunidades text-center'>
                <button class='btn btn-tenencias btntenencias fa-solid fa-file-pdf' data-id='{$fila['id_unidad']}'>
                </button>
            </td>

            <td class='titulostablaunidades text-center'>
                <button class='btn btn-verificaciones btnverificaciones fa-solid fa-file-pdf' data-id='{$fila['id_unidad']}'>
                </button>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='15'>No se encontraron resultados.</td></tr>";
}
