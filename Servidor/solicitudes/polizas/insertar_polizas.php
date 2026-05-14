<?php
//activar debug php sirve para pruebas y produccion 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../../conexion.php");

if (isset($_POST['id_unidad']) 
&& isset($_POST['nombreaseguradora']) 
&& isset($_POST['identificadopolizaseguro']) 
&& isset($_POST['fechaaltaseguro']) 
&& isset($_POST['fechavencimientoaseguradora']) 
&& isset ($_POST['estadoaseguradora']) 
&& isset($_POST['estatusaseguradora']) 
&& isset ($_FILES['documento_poliza'])) {

    $valor_idunidad = $_POST['id_unidad'];
    $valordocumento_poliza = $_FILES['documento_poliza']['name'];

    $valornombreaseguradora = $_POST['nombreaseguradora'];
    $valoridentificadopolizaseguro = $_POST['identificadopolizaseguro'];
    $valorfechaaltaseguro = $_POST['fechaaltaseguro'];
    $valorfechavencimientoaseguradora = $_POST['fechavencimientoaseguradora'];
    $valorestadoaseguradora = $_POST['estadoaseguradora'];
    $valorestatusaseguradora = $_POST['estatusaseguradora'];

    echo "id_unidad: " . $valor_idunidad . " ";
    echo "documento_poliza: " . $valordocumento_poliza . " ";
    echo "nombreaseguradora: " . $valornombreaseguradora . " ";
    echo "identificadopolizaseguro: " . $valoridentificadopolizaseguro . " ";
    echo "fechaaltaseguro: " . $valorfechaaltaseguro . " ";
    echo "fechavencimientoaseguradora: " . $valorfechavencimientoaseguradora . " ";
    echo "estadoaseguradora: " . $valorestadoaseguradora . " ";
    echo "estatusaseguradora: " . $valorestatusaseguradora . " ";

 
        $rutaarchivo = "../../archivos/files/files_unidades/polizas_seguros/";

    //obtener dcumento poliza
    $documento_poliza = $_FILES['documento_poliza']['tmp_name'];

    //verificar si se movio el archivo
    if (move_uploaded_file($documento_poliza, $rutaarchivo . $valordocumento_poliza)) {

        //insertar la poliza
        $sql = "INSERT INTO asignacion_aseguradora_unidad (id_unidad, id_aseguradora, numero_poliza_aseguradora, fecha_alta, fecha_vencimiento, id_estatus_aseguradora,	id_estado_aseguradora,	documento_aseguradora) 
                    VALUES ('$valor_idunidad', '$valornombreaseguradora', '$valoridentificadopolizaseguro', '$valorfechaaltaseguro', '$valorfechavencimientoaseguradora', '$valorestatusaseguradora', '$valorestadoaseguradora', '$valordocumento_poliza')";

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
    echo "faltan datos";
}
