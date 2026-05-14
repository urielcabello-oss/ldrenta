<?php
include "../../conexion.php";

if (isset($_POST['id_persona_curp'])) {
    $id_persona_fisica = $_POST['id_persona_curp'];

    $sqlobtenercurppersonafisica = "SELECT archivo_curp 
                                    FROM personas_fisicas 
                                    WHERE id_persona_fisica = '$id_persona_fisica'";

    $result = $conexion->query($sqlobtenercurppersonafisica);
    $row = $result->fetch_assoc();

    echo '<div class="col archivodocumentopersonafisica">';
    if (!empty($row['archivo_curp'])) {
        $archivo_curp = $row['archivo_curp'];
        echo '<p class="card-text">Descarga el archivo:
        <a href="../../Servidor/archivos/files/files_asignacion_demo/personas_fisicas/files_CURP/' . $archivo_curp . '" target="_blank" class="btn btn-warning">Abrir</a>
        <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="../../Servidor/archivos/files/files_asignacion_demo/personas_fisicas/files_CURP/' . $archivo_curp . '#toolbar=0&navpanes=0&scrollbar=0" frameborder="0" style="width:100%;height:500px;"></iframe>
        </div>
      </p>';
    }
    echo '</div>';
}
