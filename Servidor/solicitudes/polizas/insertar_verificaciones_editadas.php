<?php 
include("../../conexion.php");

if (isset($_POST['id_verificacion'])
    && isset($_POST['folioverificacioneditar'])
    && isset($_POST['montoverificacioneditar'])
    && isset($_POST['añoverificacioneditar'])
    && isset($_POST['verificacionsemestreeditar'])
    && isset($_POST['fechaverificacioneditar'])
    && isset($_POST['fechaproximaverificacioneditar'])
    && isset($_POST['estatusverificacioneditar']))
    {


$valorid_verificacion = $_POST['id_verificacion'];
$valoreditarfolioverificacioneditar = $_POST['folioverificacioneditar'];
$valoreditarmontoverificacioneditar = $_POST['montoverificacioneditar'];
$valoreditarañoverificacioneditar = $_POST['añoverificacioneditar'];
$valoreditarsemestreverificacioneditar = $_POST['verificacionsemestreeditar'];
$valoreditarfechaverificacioneditar = $_POST['fechaverificacioneditar'];
$valoreditarfechaproximaverificacioneditar = $_POST['fechaproximaverificacioneditar'];
$valoreditarestatusverificacioneditar = $_POST['estatusverificacioneditar'];

echo "id_verificacion: " . $valorid_verificacion . " ";
echo "folioverificacioneditar: " . $valoreditarfolioverificacioneditar . " ";
echo "montoverificacioneditar: " . $valoreditarmontoverificacioneditar . " ";
echo "añoverificacioneditar: " . $valoreditarañoverificacioneditar . " ";
echo "verificacionsemestreeditar: " . $valoreditarsemestreverificacioneditar . " ";
echo "fechaverificacioneditar: " . $valoreditarfechaverificacioneditar . " ";
echo "fechaproximaverificacioneditar: " . $valoreditarfechaproximaverificacioneditar . " ";
echo "estatusverificacioneditar: " . $valoreditarestatusverificacioneditar . " ";

//insertar la poliza
            echo "entro a la actualizacion";
            $sql = "UPDATE verificaciones
                        SET id_estatus_verificacion = '$valoreditarestatusverificacioneditar', 
                            fecha_verificacion = '$valoreditarfechaverificacioneditar', 
                            fecha_siguiente_verificacion = '$valoreditarfechaproximaverificacioneditar', 
                            año = '$valoreditarañoverificacioneditar', 
                            id_semestre  = '$valoreditarsemestreverificacioneditar', 
                            folio = '$valoreditarfolioverificacioneditar', 
                            monto = '$valoreditarmontoverificacioneditar' WHERE id_verificaciones= $valorid_verificacion";

            $ejecutar = mysqli_query($conexion, $sql);
            if ($ejecutar) {
                echo "Verificacion insertada correctamente";
            } else {
                echo "Error al insertar la verificacion";
            }
    }else {
        echo "faltan datos";
    }
?>