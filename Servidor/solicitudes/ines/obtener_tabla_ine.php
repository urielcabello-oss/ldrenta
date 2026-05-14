<?php 
include("../../Servidor/conexion.php");


if (!isset($_SESSION)) {
    session_start();
}

// Query para obtener solo los campos requeridos
$queryobtenerinescolaboradores = "SELECT inescolab.id_ine,
                                    colab.nombre_1,
                                    colab.nombre_2,
                                    colab.apellido_paterno,
                                    colab.apellido_materno,
                                    inescolab.seccion,
                                    inescolab.vigencia,
                                    inescolab.archivo_ine
                                FROM ines AS inescolab
                                INNER JOIN colaboradores AS colab 
                                ON inescolab.id_colaborador = colab.id_colaborador";

$resultado = $conexion->query($queryobtenerinescolaboradores);

if ($resultado->num_rows > 0) {
    $contador = 1;
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>
                <td class='titulostabladocumentos'>".$contador."</td>
                <td class='titulostabladocumentos'>".$fila['nombre_1']." ".$fila['nombre_2']." ".$fila['apellido_paterno']." ".$fila['apellido_materno']."</td>
                <td class='titulostabladocumentos'>".$fila['seccion']."</td>
                <td class='titulostabladocumentos'>".$fila['vigencia']."</td>
                <td class='titulostabladocumentos'>";
                if (!empty($fila['archivo_ine'])) {
                    echo '<a href="../../Servidor/archivos/files/files_ines/' . $fila['archivo_ine'] . '" target="_blank" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>';
                }
                echo '</td>
            </tr>';
        $contador++;
    }
} else {
    echo "<tr><td colspan='7'>No se encontraron resultados.</td></tr>";
}
?>