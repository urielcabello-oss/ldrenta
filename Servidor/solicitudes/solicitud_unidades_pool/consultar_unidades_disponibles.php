<?php
error_log("POST: " . print_r($_POST, true));

include ("../../conexion.php");
if (!isset($_SESSION)) {
    session_start();
}

$id_usuario_pool = $_SESSION['id_colaborador'];

if (isset($_POST['sederecoleccionpool']) 
    && isset($_POST['sededevolucionunidadpool']) 
    && isset($_POST['fechasolicitudunidadpool']) 
    && isset($_POST['fechadevolucionunidadpool']) 
    && isset($_POST['horasolicitudunidadpool']) 
    && isset($_POST['horadevolucionunidadpool'])) {

    $sederecoleccionpool = $_POST['sederecoleccionpool'];
    $sededevolucionunidadpool = $_POST['sededevolucionunidadpool'];
    $fechasolicitudunidadpool = $_POST['fechasolicitudunidadpool'];
    $fechadevolucionunidadpool = $_POST['fechadevolucionunidadpool'];
    $horasolicitudunidadpool = $_POST['horasolicitudunidadpool'];
    $horadevolucionunidadpool = $_POST['horadevolucionunidadpool'];
    


//query para obtener el id de las unidades disponibles pool

$sqlobtenerunidadpooldisponible = "SELECT ung.id_unidad,
                                    marc.nombre_marca,  
                                    model.nombre_modelo,
                                    ung.placa,
                                    ung.img_unidad,
                                    ung.id_tipo_unidad,
                                    unest.estado,
                                    unestatus.id_estatus_unidad,
                                    sed.ubicacion
                                FROM unidades AS ung
                                INNER JOIN modelos AS model 
                                ON ung.id_modelo = model.id_modelo 
                                INNER JOIN marcas AS marc 
                                ON model.id_marca = marc.id_marca  
                                INNER JOIN estado_unidad AS unest 
                                ON ung.id_estado_unidad = unest.id_estado_unidad
                                INNER JOIN estatus_unidades AS unestatus
                                ON ung.id_estatus_unidad = unestatus.id_estatus_unidad
                                INNER JOIN sedes AS sed 
                                ON ung.id_sede = sed.id_sede
                                WHERE ung.id_estado_unidad = 1
                                AND ung.id_estatus_unidad = 1
                                AND ung.id_sede = $sederecoleccionpool
                                AND ung.id_tipo_unidad = 2";

$resultado = $conexion->query($sqlobtenerunidadpooldisponible);


if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        echo '
        <div class="">
        <div class="conetenedortarjetaunidadpool d-flex border  p-3 mb-3 align-items-start" style="max-width: 800px;">
            <!-- Imagen del vehículo -->
            <img src="../../Servidor/archivos/imagenes/imagenes_unidades/' . $fila['img_unidad'] . '" alt="Imagen del vehículo" class="imgunidadpoolsolicitud" style="width: 180px; height: auto; border-radius: 8px; margin-right: 20px;" onerror="this.src=\'../../../Cliente/img/unidades/carro_desconocido.png\'">

            <!-- Información del vehículo -->
            <div>
                <h5><strong>' . $fila['nombre_marca'] . ' ' . $fila['nombre_modelo'] . '</strong></h5>
                <p class="mb-1"><i class="fas fa-map-marker-alt me-2"></i><strong>Ubicación:</strong> ' . $fila['ubicacion'] . '</p>
                <p class="mb-1"><i class="fas fa-id-card me-2"></i><strong>Placa:</strong> ' . $fila['placa'] . '</p>
                <button type="button" id="btnmostrarunidadpool" data-id="' . $fila['id_unidad'] . '" class="btn btn-primary mt-2 btnmostrarunidadpool">Verificar</button>
            </div>
        </div>
        </div>';
    }
} else {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            No hay unidades disponibles en esta ubicación.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
}

    }
