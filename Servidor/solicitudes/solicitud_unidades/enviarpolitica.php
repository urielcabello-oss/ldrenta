<?php
include("../../conexion.php");

if (isset($_POST['id_asignaciones']) && isset($_FILES['archivo_responsiva_sin_asignar'])) {
    echo"entro a enviarpolitica";
    $valor_idasignacion = $_POST['id_asignaciones'];
    $nombrearchivocartaresponsivafirmada = 'FIRMADO_' . basename($_FILES['archivo_responsiva_sin_asignar']['name']);
    $rutaarchivocartaresponsibafirmada = "../../archivos/files/files_unidades/responsiva_firmada_por_usuario/";

    if (move_uploaded_file($_FILES['archivo_responsiva_sin_asignar']['tmp_name'], $rutaarchivocartaresponsibafirmada . $nombrearchivocartaresponsivafirmada)) {
        echo 'entro a actualizar' .$rutaarchivocartaresponsibafirmada . $nombrearchivocartaresponsivafirmada;
        
        $sql = "UPDATE asignacion_unidad_colaborador 
                SET id_estatus_carta_responsiva = 4,
                motivo_rechazo = ' ',
                archivo_responsiva_firmada = '$nombrearchivocartaresponsivafirmada',
                politica_aceptada = 'ACEPTADA'
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
