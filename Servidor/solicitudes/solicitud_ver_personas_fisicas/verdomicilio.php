<?php
include "../../conexion.php";

if (isset($_POST['id_persona_domicilio'])) {
    $id_persona_fisica = $_POST['id_persona_domicilio'];

    $sqlobtenerdomiciliopersonafisica = "SELECT archivo_domicilio 
                                    FROM personas_fisicas 
                                    WHERE id_persona_fisica = '$id_persona_fisica'";

    $result = $conexion->query($sqlobtenerdomiciliopersonafisica);
    $row = $result->fetch_assoc();

    echo '<div class="col archivodocumentopersonafisica">';
    if (!empty($row['archivo_domicilio'])) {
        $archivo_domicilio = $row['archivo_domicilio'];
        echo '<p class="card-text">Descarga el archivo:
        <a href="../../Servidor/archivos/files/files_asignacion_demo/personas_fisicas/files_domicilio/' . $archivo_domicilio . '" target="_blank" class="btn btn-warning">Abrir</a>
        <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="../../Servidor/archivos/files/files_asignacion_demo/personas_fisicas/files_domicilio/' . $archivo_domicilio . '#toolbar=0&navpanes=0&scrollbar=0" frameborder="0" style="width:100%;height:500px;"></iframe>
        </div>
      </p>';
    }
    echo '</div>';
}
