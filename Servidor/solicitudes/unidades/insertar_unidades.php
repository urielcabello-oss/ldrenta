<?php 

include("../../conexion.php");
//------------------------------------------------------------------CODIGO PPARA OBTENER EL ID DEL USUARIO QUE ESTA HACIENDO EL REGISTRO
if (!isset($_SESSION)) {
    session_start();
}

$creador_unidad = $_SESSION['id_colaborador'];

//------------------------------------------------------------------REALIZAMOS LA INSERCION DE LA UNIDAD OBENIENDO LOS PARAMETROS DEL JS 
if (isset($_POST['marcaunidad']) && isset($_POST['modelounidad']) && isset($_POST['VIN']) 
    && isset($_POST['placaunidad']) && isset($_POST['foliofactura'])&& isset($_POST['motorunidad']) && isset($_POST['colorunidad']) 
    && isset($_POST['tarjetacirculacionunidad']) && isset($_POST['estadounidad']) && isset($_POST['estatusunidad']) 
    && isset($_POST['tipounidad']) && isset($_POST['sedeunidad']) && isset($_POST['tipoadquisicionunidad']) && isset($_POST['fechaadquisicionunidad']) && isset($_POST['añounidad']) && isset($_POST['arrendadora'])) {
    

    $valormarcaunidad = $_POST['marcaunidad'];
    $valormodelounidad = $_POST['modelounidad'];
    $valorVIN = $_POST['VIN'];
    $valorplacaunidad = $_POST['placaunidad'];
    $valormotorunidad = $_POST['motorunidad'];
    $valorañounidad = $_POST['añounidad'];
    $valorcolorunidad = $_POST['colorunidad'];
    $valortarjetacirculacionunidad = $_POST['tarjetacirculacionunidad'];
    $valorestadounidad = $_POST['estadounidad'];
    $valorestatusunidad = $_POST['estatusunidad'];
    $valortipounidad = $_POST['tipounidad'];
    $valorsedeunidad = $_POST['sedeunidad'];
    $valortipoadquisicionunidad = $_POST['tipoadquisicionunidad'];
    $valorfechaadquisicionunidad = $_POST['fechaadquisicionunidad'];
    $valorfoliofactura = $_POST['foliofactura'];
    $valorarrendadora = $_POST['arrendadora'];

 

    echo "marcaunidad: " . $valormarcaunidad . " ";
    echo "modelounidad: " . $valormodelounidad . " ";
    echo "VIN: " . $valorVIN . " ";
    echo "placaunidad: " . $valorplacaunidad . " ";
    echo "motorunidad: " . $valormotorunidad . " ";
    echo "añounidad: " . $valorañounidad . " ";
    echo "colorunidad: " . $valorcolorunidad . " ";
    echo "tarjetacirculacionunidad: " . $valortarjetacirculacionunidad . " ";
    echo "estadounidad: " . $valorestadounidad . " ";
    echo "estatusunidad: " . $valorestatusunidad . " ";
    echo "tipounidad: " . $valortipounidad . " ";
    echo "sedeunidad: " . $valorsedeunidad . " ";
    echo "tipoadquisicionunidad: " . $valortipoadquisicionunidad . " ";
    echo "fechaadquisicionunidad: " . $valorfechaadquisicionunidad . " ";
    echo "foliofactura: " . $valorfoliofactura . " ";
    echo "arrendadora: " . $valorarrendadora . " ";

 


    //obtener documentos de la unidad  
    $nombrearchivoimagenunidad = 'img_' . $valorplacaunidad . '_' . basename($_FILES['imagen_unidad']['name']);

    $rutaarchivoimagenunidad = "../../archivos/imagenes/imagenes_unidades/";

    move_uploaded_file($_FILES['imagen_unidad']['tmp_name'], $rutaarchivoimagenunidad . $nombrearchivoimagenunidad);  


    //insertar la unidad

    $query = "INSERT INTO unidades (
                                    id_creador_unidad,
                                    id_modelo, 
                                    id_estado_unidad, 
                                    id_estatus_unidad, 
                                    id_tipo_unidad, 
                                    id_tipo_adquisicion, 
                                    id_sede, 
                                    vin,
                                    numero_motor, 
                                    placa, 
                                    costo_neto, 
                                    id_color, 
                                    img_unidad, 
                                    fecha_adquisicion, 
                                    año_unidad,
                                    id_arrendadora,
                                    folio_factura) 
                VALUES ('$creador_unidad',
                        '$valormodelounidad', 
                        '$valorestadounidad', 
                        '$valorestatusunidad', 
                        '$valortipounidad', 
                        '$valortipoadquisicionunidad', 
                        '$valorsedeunidad', 
                        '$valorVIN', 
                        '$valormotorunidad', 
                        '$valorplacaunidad', 
                        '$valortarjetacirculacionunidad', 
                        '$valorcolorunidad', 
                        '$nombrearchivoimagenunidad', 
                        '$valorfechaadquisicionunidad', 
                        '$valorañounidad',
                        '$valorarrendadora',
                        '$valorfoliofactura')";

    $ejecutar = mysqli_query($conexion, $query);

    if ($ejecutar) {
        echo "Unidad insertada correctamente";
    }
} else {
    echo "Faltan datos";
}
?>