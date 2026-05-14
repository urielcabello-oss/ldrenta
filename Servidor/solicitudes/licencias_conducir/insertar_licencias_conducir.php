<?php 
include("../../conexion.php");
if (isset($_POST['colaboradorlicenciaconducir']) 
    && isset($_POST['numerolicenciaconducir']) 
    && isset($_POST['estadolicenciaconducir']) 
    && isset($_POST['fechaemision']) 
    && isset($_POST['fechavencimiento']) 
    && isset($_POST['licenciaPermanente'])
    && isset($_FILES['archivolicenciaconducir'])){


    $valorcolaboradorlicenciaconducir = $_POST['colaboradorlicenciaconducir'];
    $valornumerolicenciaconducir = $_POST['numerolicenciaconducir'];
    $valorestadolicenciaconducir = $_POST['estadolicenciaconducir'];
    $valorfechaemision = $_POST['fechaemision'];
    $valorfechavencimiento = $_POST['fechavencimiento'];
    $valorlicenciaPermanente = $_POST['licenciaPermanente'];
    $valorarchivolicenciaconducir = $_FILES['archivolicenciaconducir'];

    echo "colaboradorlicenciaconducir: " . $valorcolaboradorlicenciaconducir . " ";
    echo "numerolicenciaconducir: " . $valornumerolicenciaconducir . " ";
    echo "estadolicenciaconducir: " . $valorestadolicenciaconducir . " ";
    echo "fechaemision: " . $valorfechaemision . " ";
    echo "licenciaPermanente: " . $valorlicenciaPermanente . " ";
    echo "fechavencimiento: " . $valorfechavencimiento . " ";

    //obtener documentos de la licencia
    $nombrearchivolicenciaconducir = 'licencia_conducir_' . $valornumerolicenciaconducir . '_' . basename($_FILES['archivolicenciaconducir']['name']);

    $rutaarchivolicenciaconducir = "../../archivos/files/files_licencias_conducir/";

    move_uploaded_file($_FILES['archivolicenciaconducir']['tmp_name'], $rutaarchivolicenciaconducir . $nombrearchivolicenciaconducir);

    //insertar la licencia

    $queryinsertarlicencia = "INSERT INTO licencias_conducir (id_colaborador,
                                                            numero_licencia,
                                                            id_estado_licencia,
                                                            fecha_emision,
                                                            fecha_vencimiento,
                                                            licencia_permanente,
                                                            archivo_licencia)
                                VALUES ('$valorcolaboradorlicenciaconducir',
                                        '$valornumerolicenciaconducir',
                                        '$valorestadolicenciaconducir',
                                        '$valorfechaemision',
                                        '$valorfechavencimiento',
                                        '$valorlicenciaPermanente',
                                        '$nombrearchivolicenciaconducir')";


                echo $queryinsertarlicencia;

    $ejecutarinsertarlicencia = mysqli_query($conexion, $queryinsertarlicencia);

    if ($ejecutarinsertarlicencia) {
        echo "Licencia insertada correctamente";
    }else{
        echo "Faltan datos";
    }
}else{
    echo "Faltan datos";
}

?>