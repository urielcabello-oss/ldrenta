<?php
include "../../conexion.php";

if (isset($_POST['id_persona_ine'])) {
    $id_persona_fisica = $_POST['id_persona_ine'];

    $sqlobtenerinepersonafisica = "SELECT archivo_ine 
                                    FROM personas_fisicas 
                                    WHERE id_persona_fisica = '$id_persona_fisica'";

    $result = $conexion->query($sqlobtenerinepersonafisica);
    $row = $result->fetch_assoc();

    echo '<div class="col archivodocumentopersonafisica">';
    if (!empty($row['archivo_ine'])) {
        $archivo_ine = $row['archivo_ine'];
        echo '<p class="card-text">Descarga el archivo:
        <a href="../../Servidor/archivos/files/files_asignacion_demo/personas_fisicas/files_ines/' . $archivo_ine . '" target="_blank" class="btn btn-warning">Abrir</a>
        <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="../../Servidor/archivos/files/files_asignacion_demo/personas_fisicas/files_ines/' . $archivo_ine . '#toolbar=0&navpanes=0&scrollbar=0" frameborder="0" style="width:100%;height:500px;"></iframe>
        </div>
      </p>';
    }
    echo '</div>';
}
