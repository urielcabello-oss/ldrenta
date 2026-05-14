<?php 
include("../../conexion.php");
if(isset($_POST['colaboradorine'])
&& isset($_POST['seccionine'])
&& isset($_POST['vigenciaine'])
&& isset($_FILES['archivoine'])){
    $valorcolaboradorine = $_POST['colaboradorine'];
    $valorseccionine = $_POST['seccionine'];
    $valorvigenciaine = $_POST['vigenciaine'];
    $valorarchivoine = $_FILES['archivoine'];

    echo "colaboradorine: " . $valorcolaboradorine . " ";
    echo "seccionine: " . $valorseccionine . " ";
    echo "vigenciaine: " . $valorvigenciaine . " ";
    echo "archivoine: " . $valorarchivoine . " ";

    //obtener documentos de la licencia
    $nombrearchivoine = 'ine_' . $valorcolaboradorine . '_' . basename($_FILES['archivoine']['name']);

    $rutaarchivoine = "../../archivos/files/files_ines/";

    move_uploaded_file($_FILES['archivoine']['tmp_name'], $rutaarchivoine . $nombrearchivoine);

    //insertar la licencia

    $queryinsertarine = "INSERT INTO ines (id_colaborador,
                                            seccion,
                                            vigencia,
                                            archivo_ine)
                        VALUES ('$valorcolaboradorine',
                                '$valorseccionine',
                                '$valorvigenciaine',
                                '$nombrearchivoine')";

    echo $queryinsertarine;

    $ejecutarinsertarine = mysqli_query($conexion, $queryinsertarine);

    if ($ejecutarinsertarine) {
        echo "INE ineinsertado correctamente";
    }
}else{
    echo "Faltan datos en el formulario.";
}
?>