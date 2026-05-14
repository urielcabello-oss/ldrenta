<?php 
include("../../Servidor/conexion.php");


if (!isset($_SESSION)) {
    session_start();
}

// Query para obtener solo los campos requeridos
$queryobtenerlicenciasconducir = "SELECT lc.id_licencia,
                                    colab.nombre_1,
                                    colab.nombre_2,
                                    colab.apellido_paterno,
                                    colab.apellido_materno,
                                    lc.numero_licencia,
                                    lc.fecha_emision,
                                    lc.fecha_vencimiento,
                                    lc.licencia_permanente,
                                    estadliconducir.estado_licencia_conducir,
                                    lc.archivo_licencia
                                FROM licencias_conducir AS lc
                                INNER JOIN colaboradores AS colab 
                                ON lc.id_colaborador = colab.id_colaborador
                                INNER JOIN estado_licencia_conducir AS estadliconducir 
                                ON lc.id_estado_licencia = estadliconducir.id_estado_licencia";

$resultado = $conexion->query($queryobtenerlicenciasconducir);

if ($resultado->num_rows > 0) {
    $contador = 1;
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>
                <td class='titulostabladocumentos'>".$contador."</td>
                <td class='titulostabladocumentos'>".$fila['nombre_1']." ".$fila['nombre_2']." ".$fila['apellido_paterno']." ".$fila['apellido_materno']."</td>
                <td class='titulostabladocumentos'>".$fila['numero_licencia']."</td>
                <td class='titulostabladocumentos'>".$fila['fecha_emision']."</td>
                <td class='titulostabladocumentos'>".$fila['fecha_vencimiento']."</td>
                <td class='titulostabladocumentos'>".$fila['licencia_permanente']."</td>
                <td class='titulostabladocumentos'>".$fila['estado_licencia_conducir']."</td>
                <td class='titulostabladocumentos'>";
                if (!empty($fila['archivo_licencia'])) {
                    echo '<a href="../../Servidor/archivos/files/files_licencias_conducir/' . $fila['archivo_licencia'] . '" target="_blank" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>';
                }
                echo '</td>
            </tr>';
        $contador++;
    }
} else {
    echo "<tr><td colspan='7'>No se encontraron resultados.</td></tr>";
}
?>