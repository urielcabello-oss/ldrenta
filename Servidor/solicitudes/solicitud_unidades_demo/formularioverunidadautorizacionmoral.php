<?php
include("../../conexion.php");

if (
    isset($_POST['idunidad']) &&
    isset($_POST['idasignaciondemo']) &&
    isset($_POST['idpersonamoral'])
) {
    $idunidad = $_POST['idunidad'];
    $idasignaciondemo = $_POST['idasignaciondemo'];
    $idpersonamoral = $_POST['idpersonamoral'];

    $img_unidad = '';
    $nombre_modelo = '';
    $nombre_marca = '';
    $fecha_prestamo = '';
    $tipo_unidad = '';
    $ubicacion = '';
    $vin = '';
    $numero_motor = '';
    $placa = '';
    $tarjeta_circulacion = '';
    $objetivo_prestamo = '';
    $comentarios = '';
    $colaboradorqueasigna = '';
    $$colaboradorqueasigna = '';
    $persona_moral = '';
    $solicitar_master_driver = '';
    $color = '';

    $query = "SELECT u.id_unidad,
                    u.id_modelo,
                    u.id_sede,
                    u.vin,
                    u.numero_motor,
                    u.placa,
                    u.costo_neto,
                    u.id_color,
                    u.img_unidad,
                    col.nombre_1,
                    col.nombre_2,
                    col.apellido_paterno,
                    col.apellido_materno,
                    marc.nombre_marca,
                    mode.nombre_modelo,
                    sed.ubicacion,
                    asigun.fecha_prestamo,
                    asigun.fecha_devolucion, 
                    asigun.objetivo_prestamo,
                    asigun.comentarios, 
                    asigun.solicitar_master_driver,
                    asigun.solicitar_emplacamiento_ldr,
                    asigun.solicitar_seguro_ldr,
                    unidcolor.color_unidad,
                    pm.organizacion_institucion
            FROM asignacion_unidad_demo AS asigun
            INNER JOIN unidades AS u ON asigun.id_unidad = u.id_unidad
            INNER JOIN modelos AS mode ON u.id_modelo = mode.id_modelo
            INNER JOIN marcas AS marc ON mode.id_marca = marc.id_marca
            INNER JOIN sedes AS sed ON u.id_sede = sed.id_sede
            INNER JOIN unidad_color AS unidcolor ON u.id_color = unidcolor.id_color
            INNER JOIN colaboradores AS col ON asigun.id_colaborador_que_asigna = col.id_colaborador
            INNER JOIN personas_morales AS pm ON asigun.id_persona_moral = pm.id_persona_moral
            WHERE asigun.id_asignacion_unidad_demo = '$idasignaciondemo'";

    $resultado = $conexion->query($query);

    if ($fila = $resultado->fetch_assoc()) {
        $img_unidad = $fila['img_unidad'];
        $colaboradorqueasigna = $fila['nombre_1'] . ' ' . $fila['nombre_2'] . ' ' . $fila['apellido_paterno'] . ' ' . $fila['apellido_materno'];
        $persona_moral = $fila['organizacion_institucion'];
        $nombre_modelo = $fila['nombre_modelo'];
        $nombre_marca = $fila['nombre_marca'];
        $fecha_prestamo = $fila['fecha_prestamo'];
        $fecha_devolucion = $fila['fecha_devolucion'];
        $objetivo_prestamo = $fila['objetivo_prestamo'];
        $comentarios = $fila['comentarios'];
        $solicitar_master_driver = $fila['solicitar_master_driver'];
        $solicitar_emplacamiento_ldr = $fila['solicitar_emplacamiento_ldr'];
        $solicitar_seguro_ldr = $fila['solicitar_seguro_ldr'];
        $ubicacion = $fila['ubicacion'];
        $vin = $fila['vin'];
        $numero_motor = $fila['numero_motor'];
        $placa = $fila['placa'];
        $tarjeta_circulacion = $fila['costo_neto'];
        $color = $fila['color_unidad'];
    }

    echo '
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col-12 text-center">
          <img src="../../Servidor/archivos/imagenes/imagenes_unidades/' . htmlspecialchars($img_unidad) . '" 
               class="img-fluid rounded shadow-sm" 
               style="max-height: 180px; object-fit: contain;"
               alt="Imagen unidad" 
               onerror="this.src=\'../../Cliente/img/unidades/silueta_tracto3.png\'">
        </div>
      </div>
      
      <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Marca</label>
        <input type="text" class="form-control" value="' . htmlspecialchars($nombre_marca) . '" disabled>
      </div>

        <div class="col-md-6">
          <label class="form-label">Modelo</label>
          <input type="text" class="form-control" value="' . htmlspecialchars($nombre_modelo) . '" disabled>
        </div>

        <div class="col-md-6">
          <label class="form-label">Colaborador que asigna</label>
          <input type="text" class="form-control" value="' . htmlspecialchars($colaboradorqueasigna) . '" disabled>
        </div>

        <div class="col-md-6">
          <label class="form-label">Institución/organización préstamo</label>
          <input type="text" class="form-control" value="' . htmlspecialchars($persona_moral) . '" disabled>
        </div>

       <div class="col-md-4">
          <label class="form-label">¿Requiere Master Driver?</label>
          <input type="text" class="form-control" style="font-weight: bold;" value="' . ($solicitar_master_driver == 1 ? 'Sí requiere Master Driver' : 'No requiere Master Driver') . '" disabled>
        </div>

       <div class="col-md-4">
          <label class="form-label">¿Requiere Master Driver?</label>
          <input type="text" class="form-control" style="font-weight: bold;" value="' . ($solicitar_emplacamiento_ldr == 1 ? 'Sí requiere Emplacar LDR' : 'No requiere Emplacar LDR') . '" disabled>
        </div>

       <div class="col-md-4">
          <label class="form-label">¿Requiere Master Driver?</label>
          <input type="text" class="form-control" style="font-weight: bold;" value="' . ($solicitar_seguro_ldr == 1 ? 'Sí requiere seguro' : 'No requiere seguro') . '" disabled>
        </div>
        
        <div class="col-md-3">
          <label class="form-label">Fecha de préstamo</label>
          <input type="text" class="form-control" value="' . htmlspecialchars($fecha_prestamo) . '" disabled>
        </div>

        <div class="col-md-3">
          <label class="form-label">Fecha de devolución</label>
          <input type="text" class="form-control" value="' . htmlspecialchars($fecha_devolucion) . '" disabled>
        </div>

        <div class="col-md-3">
          <label class="form-label">Color</label>
          <input type="text" class="form-control" value="' . htmlspecialchars($color) . '" disabled>
        </div>

        <div class="col-md-3">
          <label class="form-label">VIN</label>
          <input type="text" class="form-control" value="' . htmlspecialchars($vin) . '" disabled>
        </div>

        <div class="col-md-3">
          <label class="form-label">N° Motor</label>
          <input type="text" class="form-control" value="' . htmlspecialchars($numero_motor) . '" disabled>
        </div>

        <div class="col-md-3">
          <label class="form-label">Placa</label>
          <input type="text" class="form-control" value="' . htmlspecialchars($placa) . '" disabled>
        </div>

        <div class="col-md-3">
          <label class="form-label">Sede</label>
          <input type="text" class="form-control" value="' . htmlspecialchars($ubicacion) . '" disabled>
        </div>

        <div class="col-md-3">
          <label class="form-label">Costo neto</label>
          <input type="text" class="form-control" value="$' . htmlspecialchars($tarjeta_circulacion) . ' MXN" disabled>
        </div>

        <div class="col-md-12">
          <label class="form-label">Objetivo del préstamo</label>
          <textarea class="form-control" rows="2" disabled>' . htmlspecialchars($objetivo_prestamo) . '</textarea>
        </div>

        <div class="col-md-12">
          <label class="form-label">Comentarios</label>
          <textarea class="form-control" rows="2" disabled>' . htmlspecialchars($comentarios) . '</textarea>
        </div>
      </div>
    </div>';
}
?>
