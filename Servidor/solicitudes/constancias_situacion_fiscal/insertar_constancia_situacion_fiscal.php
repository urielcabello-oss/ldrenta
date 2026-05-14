<?php 
include("../../conexion.php");
if(isset($_POST['colaboradorconstanciafiscal'])
&& isset($_POST['rfcolaborador'])
&& isset($_FILES['archivocomprobantefiscal'])){

    $valorcolaboradorconstaciafiscal = $_POST['colaboradorconstanciafiscal'];
    $valorrfcolaborador = $_POST['rfcolaborador'];
    $valorarchivocnstanciasituacionfiscal = $_FILES['archivocomprobantefiscal'];

    echo "colaboradorconstanciafiscal: " . $valorcolaboradorconstaciafiscal . " ";
    echo "rfcolaborador: " . $valorrfcolaborador . " "; 
    //obtener documentos del domicilio
    $nombrearchivocnstanciasituacionfiscal = 'constancia_situacion_fiscal_' . $valorcolaboradorconstaciafiscal . '_' . basename($_FILES['archivocomprobantefiscal']['name']);

    $rutaarchivoconstanciasituacionfiscal = "../../archivos/files/files_constancias_situacion_fiscal/";

    move_uploaded_file($_FILES['archivocomprobantefiscal']['tmp_name'], $rutaarchivoconstanciasituacionfiscal . $nombrearchivocnstanciasituacionfiscal);

    //insertar la licencia

    $queryinsertarconstanciasituacionfiscal = "INSERT INTO constancias_situacion_fiscal (id_colaborador,
                                                            rfc,
                                                            archivo_constancia_situacion_fiscal)
                                VALUES ('$valorcolaboradorconstaciafiscal',
                                        '$valorrfcolaborador',
                                        '$nombrearchivocnstanciasituacionfiscal')";


                echo $queryinsertarconstanciasituacionfiscal;

    $ejecutarinsertarconstanciasituacionfiscal = mysqli_query($conexion, $queryinsertarconstanciasituacionfiscal);

    if ($ejecutarinsertarconstanciasituacionfiscal) {
        echo "Insertado correctamente";
    }else{
        echo "Error al insertar";
    }
}else{
    echo "Faltan datos en el formulario.";
}
?>