<?php 
include("../../conexion.php");
if(isset($_POST['colaboradordomicilio'])
&& isset($_POST['domicilio'])
&& isset($_FILES['archivodomicilio'])){

    $valorcolaboradordomicilio = $_POST['colaboradordomicilio'];
    $valordomicilio = $_POST['domicilio'];
    $valorarchivodomicilio = $_FILES['archivodomicilio'];

    echo "colaboradordomicilio: " . $valorcolaboradordomicilio . " ";
    echo "domicilio: " . $valordomicilio . " "; 

    //obtener documentos del domicilio
    $nombrearchivodomicilio = 'comprobante_domicilio_' . $valorcolaboradordomicilio . '_' . basename($_FILES['archivodomicilio']['name']);

    $rutaarchivodomicilio = "../../archivos/files/files_comprobantes_domicilios/";

    move_uploaded_file($_FILES['archivodomicilio']['tmp_name'], $rutaarchivodomicilio . $nombrearchivodomicilio);

    //insertar la licencia

    $queryinsertardomicilio = "INSERT INTO domicilios (id_colaborador,
                                                            domicilio,
                                                            archivo_domicilio)
                                VALUES ('$valorcolaboradordomicilio',
                                        '$valordomicilio',
                                        '$nombrearchivodomicilio')";


                echo $queryinsertardomicilio;

    $ejecutarinsertardomicilio = mysqli_query($conexion, $queryinsertardomicilio);

    if ($ejecutarinsertardomicilio) {
        echo "Licencia insertada correctamente";
    } else {
        echo "Error al insertar la licencia";
    }
}else{
    echo "Faltan datos";
}
?>