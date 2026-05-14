<?php 
include("../../Servidor/conexion.php");
if (!isset($_SESSION)) {
    session_start();
}

$arreglo_unidades_pool = array();

// Consulta para obtener unidades preasignadas
$sqlobtenerunidadvercartaresponsiva = "SELECT unid.img_unidad,
            unidasigcolab.id_asignaciones,
            unidasigcolab.id_unidad,
            unidasigcolab.id_colaborador,
            unidasigcolab.id_estatus_carta_responsiva,
            colab.nombre_1,
            colab.nombre_2,
            colab.apellido_paterno,
            colab.apellido_materno,
            unidasigcolab.politica_aceptada,
            model.nombre_modelo,
            unid.placa,
            unid.id_tipo_unidad,
            unidasigcolab.fecha_asignacion,
            unidasigcolab.fecha_devolucion
        FROM asignacion_unidad_colaborador AS unidasigcolab
        INNER JOIN unidades AS unid 
        ON unidasigcolab.id_unidad = unid.id_unidad
        INNER JOIN modelos AS model 
        ON unid.id_modelo = model.id_modelo 
        INNER JOIN colaboradores AS colab 
        ON unidasigcolab.id_colaborador = colab.id_colaborador";

$resultado = $conexion->query($sqlobtenerunidadvercartaresponsiva);



// Recoger y ordenar resultados
while ($fila = $resultado->fetch_assoc()) {
    $arreglo_unidades_pool[] = $fila;
}

function ordenarPorFechapool($a, $b) {
    $fechaA = isset($a['fecha_asignacion']) ? strtotime($a['fecha_asignacion']) : 0;
    $fechaB = isset($b['fecha_asignacion']) ? strtotime($b['fecha_asignacion']) : 0;
    return $fechaA - $fechaB;
}
usort($arreglo_unidades_pool, 'ordenarPorFechapool');

// Vista Cards
echo '<div id="vistaCards">';
foreach ($arreglo_unidades_pool as $fila) {
    if ($fila['id_estatus_carta_responsiva'] != 2 && $fila['id_tipo_unidad'] == 2) {
        echo '<div class="card mb-3">';
        if ($fila['id_estatus_carta_responsiva'] == 4) {
            echo "<div class='alerta d-flex align-items-center'>
                <img src='../../Cliente/videos/actualizar.gif' class='me-2 imgalertasucces'> 
                <h6 class='txtvalidacioncomodato'><b>Responsiva: Subida</b></h6>
            </div>";
        } elseif ($fila['id_estatus_carta_responsiva'] == 3) {
            echo "<div class='alerta d-flex align-items-center'>
                <img src='../../Cliente/videos/warning-red.gif' class='me-2 imgalertasucces'> 
                <h6 class='txtvalidacioncomodato'><b>Responsiva: Regresada</b></h6>
            </div>";
        }
        echo '
            <div class="cardheader">
                <img src="../../Servidor/archivos/imagenes/imagenes_unidades/' . $fila['img_unidad'] . '" class="card-img-top img-fluid imgcard" onerror="this.src=\'../../Cliente/img/unidades/carro_desconocido.png\'" alt="...">
            </div>
            <div class="card-body">
                <h6 class="card-title txteatlevalidacioncomodato"><b>' . $fila['nombre_1'] . ' ' . $fila['nombre_2'] . ' ' . $fila['apellido_paterno'] . ' ' . $fila['apellido_materno'] . '</b></h6>
                <h6 class="card-title txteatlevalidacioncomodato"><b>' . $fila['nombre_modelo'] . '</b></h6>
                <h6 class="card-text txteatlevalidacioncomodato"><i class="fas fa-car me-2"></i><b>Placa: </b>' . $fila['placa'] . '</h6>
                <h6 class="card-text txteatlevalidacioncomodato"><i class="fas fa-calendar-check me-2"></i><b>Asignación: </b>' . date('d-m-Y', strtotime($fila['fecha_asignacion'])) . '</h6>
                <h6 class="card-text txteatlevalidacioncomodato"><i class="fas fa-undo-alt me-2"></i><b>Devolución: </b>' . ($fila['fecha_devolucion'] != '0000-00-00' ? date('d-m-Y', strtotime($fila['fecha_devolucion'])) : '') . '</h6>
                <button type="button" class="btn mt-3 btnmosrarmodalunidadsolicitud" data-idunidad="' . $fila['id_unidad'] . '" data-id="' . $fila['id_asignaciones'] . '">Verificar responsiva</button>
            </div>
        </div>';
    }
}
echo '</div>'; // Fin Cards

// Vista Tabla
echo '<div id="vistaTabla" style="display: none;">
    <div class="table-responsive">
        <table class="table table-hover tablaunidades" id="tablaUnidades">
            <thead class="table-light">
                <tr>
                    <th class="titulostablaverificarcomodato">Nombre del colaborador</th>
                    <th class="titulostablaverificarcomodato">Modelo</th>
                    <th class="titulostablaverificarcomodato">Placa</th>
                    <th class="titulostablaverificarcomodato">Asignación</th>
                    <th class="titulostablaverificarcomodato">Devolución</th>
                    <th class="titulostablaverificarcomodato">Ver</th>
                    <th class="titulostablaverificarcomodato">Estado</th>
                </tr>
            </thead>
            <tbody>';

foreach ($arreglo_unidades_pool as $fila) {
    if ($fila['id_estatus_carta_responsiva'] != 2 && $fila['id_tipo_unidad'] == 2) {
        $nombre = trim($fila['nombre_1'] . ' ' . $fila['nombre_2'] . ' ' . $fila['apellido_paterno'] . ' ' . $fila['apellido_materno']);
        echo '<tr>
            <td class="titulostablaverificarcomodato">' . htmlspecialchars($nombre) . '</td>
            <td class="titulostablaverificarcomodato">' . htmlspecialchars($fila['nombre_modelo']) . '</td>
            <td class="titulostablaverificarcomodato">' . htmlspecialchars($fila['placa']) . '</td>
            <td class="titulostablaverificarcomodato">' . date('d-m-Y', strtotime($fila['fecha_asignacion'])) . '</td>
            <td class="titulostablaverificarcomodato">' . ($fila['fecha_devolucion'] != '0000-00-00' ? date('d-m-Y', strtotime($fila['fecha_devolucion'])) : '') . '</td>
            <td class="titulostablaverificarcomodato"><button type="button" class="btn btn-sm btnmosrarmodalunidadsolicitud btntablaverificarresponsiva" data-idunidad="' . $fila['id_unidad'] . '" data-id="' . $fila['id_asignaciones'] . '">Responsiva</button></td>
            <td class="titulostablaverificarcomodato">';
                if ($fila['id_estatus_carta_responsiva'] == 4) {
                    echo '<div class="d-flex align-items-center">
                            <img src="../../Cliente/videos/actualizar.gif" class="me-2" style="width:24px;">
                            <span><b>Responsiva: Subida</b></span>
                          </div>';
                } elseif ($fila['id_estatus_carta_responsiva'] == 3) {
                    echo '<div class="d-flex align-items-center">
                            <img src="../../Cliente/videos/warning-red.gif" class="me-2" style="width:24px;">
                            <span><b>Responsiva: Regresada</b></span>
                          </div>';
                }
        echo '</td>
        </tr>';
    }
}

echo '</tbody></table></div></div>';
?>
