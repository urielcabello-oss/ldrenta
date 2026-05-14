<?php 

include("../../../conexion.php");
if (isset($_POST['tipodirectivo'])) {
    $id_tipo_directivo = $_POST['tipodirectivo'];

    //echo "tipodirectivo: " . $id_tipo_directivo . " ";

    //realizar consulta a la base de datos para obtener los colaboradores
    $sqlcolaboradores = "SELECT  c.*
                            FROM colaboradores AS c
                            INNER JOIN directivos as dir
                            ON c.id_colaborador = dir.id_colaborador
                            AND dir.id_tipo_directivo = '$id_tipo_directivo'";

    $result = $conectar->query($sqlcolaboradores);

    echo '<option value="">Seleccione un colaborador</option>'; // Opción predeterminada
    while ($rowcolaborador = $result->fetch_assoc()) {
        // Mostrar cada estado como una opcion
        echo '<option value="' . $rowcolaborador['id_colaborador'] . '">' . $rowcolaborador['nombre_1'] . ' ' . $rowcolaborador['nombre_2'] . ' ' .$rowcolaborador['apellido_paterno'] . ' ' . $rowcolaborador['apellido_materno'] . '</option>';
    }
    }else{
        echo"no se obtuvo tipo directivo";
    }

?>
