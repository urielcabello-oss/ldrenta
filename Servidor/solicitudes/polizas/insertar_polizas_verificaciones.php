<?php
//activar debug php sirve para pruebas y produccion 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../../conexion.php");

if (isset($_POST['id_unidad'])
&& isset($_POST['añoverificacion'])
&& isset($_POST['semestreverificacion'])
&& isset($_POST['fechaverificacion'])
&& isset($_POST['fechaproximaverificacion'])
&& isset($_POST['estatusverificacion'])){

    $valor_idunidad = $_POST['id_unidad'];
    $valor_folioverificacion = $_POST['folioverificacion'];
    $valor_montoverificacion = $_POST['montoverificacion'];
    $valor_anoverificacion = $_POST['añoverificacion'];
    $valor_semestreverificacion = $_POST['semestreverificacion'];
    $valor_fechaverificacion = $_POST['fechaverificacion'];
    $valor_fechaproximaverificacion = $_POST['fechaproximaverificacion'];
    $valor_estatusverificacion = $_POST['estatusverificacion'];

    echo "id_unidad: " . $valor_idunidad . " ";
    echo "folioverificacion: " . $valor_folioverificacion . " ";
    echo "montoverificacion: " . $valor_montoverificacion . " ";
    echo "añoverificacion: " . $valor_anoverificacion . " ";
    echo "semestreverificacion: " . $valor_semestreverificacion . " ";
    echo "fechaverificacion: " . $valor_fechaverificacion . " ";
    echo "fechaproximaverificacion: " . $valor_fechaproximaverificacion . " ";
    echo "estatusverificacion: " . $valor_estatusverificacion . " ";

    //insertar la poliza
        $sql = "INSERT INTO verificaciones (id_unidad, id_estatus_verificacion, fecha_verificacion, fecha_siguiente_verificacion, año, id_semestre, folio, monto) 
                    VALUES ('$valor_idunidad', '$valor_estatusverificacion', '$valor_fechaverificacion', '$valor_fechaproximaverificacion', '$valor_anoverificacion', '$valor_semestreverificacion', '$valor_folioverificacion', '$valor_montoverificacion')";

        $ejecutar = mysqli_query($conexion, $sql);

        if ($ejecutar) {
            echo "Verificacion insertada correctamente";
        } else {
            echo "Error al insertar la verificacion";
        }
}else{
    echo "Faltan datos";
}

?>