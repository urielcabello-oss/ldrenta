<?php
//activar debug php sirve para pruebas y produccion 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../../conexion.php");

if (isset($_POST['id_unidad']) 
&& isset($_POST['foliotenencia']) 
&& isset($_POST['añotenencia']) 
&& isset($_POST['estatustenencias']) 
&& isset($_POST['montopago']) 
&& isset ($_POST['fechapago']) 
&& isset($_POST['fechavencimiento']) 
&& isset ($_FILES['documento_poliza_tenencia'])) {

    $valor_idunidad = $_POST['id_unidad'];
    $valordocumento_poliza = $_FILES['documento_poliza_tenencia']['name'];

    $valorfoliotenencia = $_POST['foliotenencia'];
    $valorañotenencia = $_POST['añotenencia'];
    $valorestatustenencias = $_POST['estatustenencias'];
    $valormontopago = $_POST['montopago'];
    $valorfechapago = $_POST['fechapago'];
    $valorfechavencimiento = $_POST['fechavencimiento'];

    echo "id_unidad: " . $valor_idunidad . " ";
    echo "documento_poliza: " . $valordocumento_poliza . " ";
    echo "foliotenencia: " . $valorfoliotenencia . " ";
    echo "añotenencia: " . $valorañotenencia . " ";
    echo "estatustenencias: " . $valorestatustenencias . " ";
    echo "montopago: " . $valormontopago . " ";
    echo "fechapago: " . $valorfechapago . " ";
    echo "fechavencimiento: " . $valorfechavencimiento . " ";

 
        $rutaarchivo = "../../archivos/files/files_unidades/polizas_tenencias/";

    //obtener dcumento poliza
    $documento_poliza = $_FILES['documento_poliza_tenencia']['tmp_name'];

    //verificar si se movio el archivo
    if (move_uploaded_file($documento_poliza, $rutaarchivo . $valordocumento_poliza)) {

        //insertar la poliza
        $sql = "INSERT INTO tenencias (id_unidad, folio, año_semestre, id_estatus_tenencias,	monto_pago, fecha_pago,	fecha_vencimiento,	documento_tenencia) 
                    VALUES ('$valor_idunidad', '$valorfoliotenencia', '$valorañotenencia', '$valorestatustenencias', '$valormontopago', '$valorfechapago', '$valorfechavencimiento', '$valordocumento_poliza')";

        $ejecutar = mysqli_query($conexion, $sql);

        if ($ejecutar) {
            echo "Tenencia insertada correctamente";
        } else {
            echo "Error al insertar la tenencia";
        }
    } else {
        echo "no se movio el archivo";
    }
} else {
    echo "faltan datos";
}
