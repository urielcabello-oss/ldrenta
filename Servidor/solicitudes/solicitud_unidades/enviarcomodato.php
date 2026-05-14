<?php
include("../../conexion.php");

if (isset($_POST['id_asignaciones']) && isset($_FILES['comodato_archivo_sin_firmar'])) {
    echo "entro a enviarcomodato";
    $valor_idasignacion = $_POST['id_asignaciones'];
    $nombrearchivocomodatofirmado = 'FIRMADO_' . basename($_FILES['comodato_archivo_sin_firmar']['name']);
    $rutaarchivocomodatofirmado = "../../archivos/files/files_unidades/comodato_firmado_por_usuario/";

    if (move_uploaded_file($_FILES['comodato_archivo_sin_firmar']['tmp_name'], $rutaarchivocomodatofirmado . $nombrearchivocomodatofirmado)) {
        echo 'entro a actualizar' . $rutaarchivocomodatofirmado . $nombrearchivocomodatofirmado;

        $sql = "UPDATE asignacion_unidad_colaborador 
                INNER JOIN unidades 
                ON asignacion_unidad_colaborador.id_unidad = unidades.id_unidad
                SET id_estatus_comodato = 4,
                motivo_rechazo_comodato = ' ',
                unidades.id_estado_unidad = 3 ,
                archivo_comodato_firmado = '$nombrearchivocomodatofirmado'
                WHERE id_asignaciones = $valor_idasignacion";
                echo $sql;
        $ejecutar = mysqli_query($conexion, $sql);

        if ($ejecutar) {
            echo "Unidad actualizada correctamente";
        } else {
            echo "Error al actualizar la unidad";
        }
    }else{
        echo "Error al subir el archivo";
    }
}else{
    echo "Faltan datos en el formulario";
}
