<?php 
include("../../conexion.php");

if (isset($_POST['id_tenencia'])
    && isset($_POST['foliotenenciaeditar'])
    && isset($_POST['añotenenciaeditar'])
    && isset($_POST['estatustenenciaeditar'])
    && isset($_POST['montopagoeditar'])
    && isset($_POST['fechapagoeditar'])
    && isset($_POST['fechavencimientoeditar']))
    {


$valorid_tenencia = $_POST['id_tenencia'];
$valoreditarfoliotenenciaeditar = $_POST['foliotenenciaeditar'];
$valoreditarañotenenciaeditar = $_POST['añotenenciaeditar'];
$valoreditarestatustenenciaeditar = $_POST['estatustenenciaeditar'];
$valoreditarmontopagoeditar = $_POST['montopagoeditar'];
$valoreditarfechapagoeditar = $_POST['fechapagoeditar'];
$valoreditarfechavencimientoeditar = $_POST['fechavencimientoeditar'];

echo "id_tenencia: " . $valorid_tenencia . " ";
echo "foliotenenciaeditar: " . $valoreditarfoliotenenciaeditar . " ";
echo "añotenenciaeditar: " . $valoreditarañotenenciaeditar . " ";
echo "estatustenenciaeditar: " . $valoreditarestatustenenciaeditar . " ";
echo "montopagoeditar: " . $valoreditarmontopagoeditar . " ";
echo "fechapagoeditar: " . $valoreditarfechapagoeditar . " ";
echo "fechavencimientoeditar: " . $valoreditarfechavencimientoeditar . " ";

$rutaarchivo = "../../archivos/files/files_unidades/polizas_tenencias/";

if (isset($_FILES['documento_poliza_tenencia_editar'])) {
    $documento_tenencia = $_FILES['documento_poliza_tenencia_editar']['tmp_name'];
    $valordocumento_editar_tenencia = $_FILES['documento_poliza_tenencia_editar']['name'];

        //verificar si se movio el archivo
        if (move_uploaded_file($documento_tenencia, $rutaarchivo . $valordocumento_editar_tenencia)) {
            //insertar la poliza
            echo "entro a la actualizacion";
            $sql = "UPDATE tenencias
                        SET folio = '$valoreditarfoliotenenciaeditar', 
                            año_semestre = '$valoreditarañotenenciaeditar', 
                            id_estatus_tenencias = '$valoreditarestatustenenciaeditar', 
                            monto_pago = '$valoreditarmontopagoeditar', 
                            fecha_pago = '$valoreditarfechapagoeditar', 
                            fecha_vencimiento = '$valoreditarfechavencimientoeditar', 
                            documento_tenencia = '$valordocumento_editar_tenencia' WHERE id_tenencias= $valorid_tenencia";

            $ejecutar = mysqli_query($conexion, $sql);
            if ($ejecutar) {
                echo "Tenencia insertada correctamente";
            } else {
                echo "Error al insertar la tenencia";
            }
        }else {
            echo "no se movio el archivo";
        }

    }else {
        //insertar la poliza
        $sql = "UPDATE tenencias
        SET folio = '$valoreditarfoliotenenciaeditar', 
            año_semestre = '$valoreditarañotenenciaeditar', 
            id_estatus_tenencias = '$valoreditarestatustenenciaeditar', 
            monto_pago = '$valoreditarmontopagoeditar', 
            fecha_pago = '$valoreditarfechapagoeditar', 
            fecha_vencimiento = '$valoreditarfechavencimientoeditar' WHERE id_tenencias= $valorid_tenencia";

            $ejecutar = mysqli_query($conexion, $sql);
            if ($ejecutar) {
            echo "Tenencia insertada correctamente";
            } else {
            echo "Error al insertar la tenencia";
            }
    }
}else {
    echo "faltan datos";
}
    

?>