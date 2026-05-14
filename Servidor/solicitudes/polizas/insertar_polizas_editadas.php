<?php 
include("../../conexion.php");
if ( isset($_POST['id_poliza']) 
    && isset($_POST['nombreaseguradoraeditar']) 
    && isset($_POST['identificadopolizaseguroeditar']) 
    && isset($_POST['fechaaltaseguroeditar']) 
    && isset($_POST['fechavencimientoaseguradoraeditar'])
    && isset($_POST['estadoaseguradoraeditar'])
    && isset($_POST['estatusaseguradoraeditar'])
    ) {

    $valorid_poliza = $_POST['id_poliza'];
    $valoreditarnombreaseguradoraeditar = $_POST['nombreaseguradoraeditar'];
    $valoreditaridentificadopolizaseguroeditar = $_POST['identificadopolizaseguroeditar'];
    $valoreditarfechaaltaseguroeditar = $_POST['fechaaltaseguroeditar'];
    $valoreditarfechavencimientoaseguradoraeditar = $_POST['fechavencimientoaseguradoraeditar'];
    $valoreditarestadoaseguradoraeditar = $_POST['estadoaseguradoraeditar'];
    $valoreditarestatusaseguradoraeditar = $_POST['estatusaseguradoraeditar'];

    echo "id_poliza: " . $valorid_poliza . " ";
    echo "nombreaseguradoraeditar: " . $valoreditarnombreaseguradoraeditar . " ";
    echo "identificadopolizaseguroeditar: " . $valoreditaridentificadopolizaseguroeditar . " ";
    echo "fechaaltaseguroeditar: " . $valoreditarfechaaltaseguroeditar . " ";
    echo "fechavencimientoaseguradoraeditar: " . $valoreditarfechavencimientoaseguradoraeditar . " ";
    echo "estadoaseguradoraeditar: " . $valoreditarestadoaseguradoraeditar . " ";
    echo "estatusaseguradoraeditar: " . $valoreditarestatusaseguradoraeditar . " ";

    
        $rutaarchivo = "../../archivos/files/files_unidades/polizas_seguros/";

    if (isset($_FILES['editar_documento_poliza'])) {
        $documento_poliza = $_FILES['editar_documento_poliza']['tmp_name'];
        $valordocumento_editar_poliza = $_FILES['editar_documento_poliza']['name'];

        //verificar si se movio el archivo
        if (move_uploaded_file($documento_poliza, $rutaarchivo . $valordocumento_editar_poliza)) {
            //insertar la poliza
            $sql = "UPDATE asignacion_aseguradora_unidad 
                        SET id_aseguradora = $valoreditarnombreaseguradoraeditar,
                            numero_poliza_aseguradora = '$valoreditaridentificadopolizaseguroeditar', 
                            fecha_alta = '$valoreditarfechaaltaseguroeditar', 
                            fecha_vencimiento = '$valoreditarfechavencimientoaseguradoraeditar', 
                            id_estatus_aseguradora = '$valoreditarestatusaseguradoraeditar', 
                            id_estado_aseguradora = '$valoreditarestadoaseguradoraeditar', 
                            documento_aseguradora = '$valordocumento_editar_poliza' WHERE id_asignacion_aseguradora= $valorid_poliza";

            $ejecutar = mysqli_query($conexion, $sql);

            if ($ejecutar) {
                echo "Poliza insertada correctamente";
            } else {
                echo "Error al insertar la poliza";
            }
        } else {
            echo "no se movio el archivo";
        }
    } else {
        //insertar la poliza
        $sql = "UPDATE asignacion_aseguradora_unidad 
        SET id_aseguradora = $valoreditarnombreaseguradoraeditar,
            numero_poliza_aseguradora = '$valoreditaridentificadopolizaseguroeditar', 
            fecha_alta = '$valoreditarfechaaltaseguroeditar', 
            fecha_vencimiento = '$valoreditarfechavencimientoaseguradoraeditar', 
            id_estatus_aseguradora = '$valoreditarestatusaseguradoraeditar', 
            id_estado_aseguradora = '$valoreditarestadoaseguradoraeditar' WHERE id_asignacion_aseguradora= $valorid_poliza";

        $ejecutar = mysqli_query($conexion, $sql);

        if ($ejecutar) {
            echo "Poliza insertada correctamente";
        } else {
            echo "Error al insertar la poliza";
        }
    }
} else {
    echo "faltan datos";
}

?>
