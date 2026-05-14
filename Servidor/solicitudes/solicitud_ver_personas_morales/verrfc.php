<?php
include "../../conexion.php";

if (isset($_POST['id_persona_rfc'])) {
    $id_persona_moral = $_POST['id_persona_rfc'];

    $sqlobtenerinepersomoral = "SELECT archivo_rfc_moral 
                                    FROM personas_morales
                                    WHERE id_persona_moral = '$id_persona_moral'";

    $result = $conexion->query($sqlobtenerinepersomoral);
    $row = $result->fetch_assoc();

    echo '<div class="col archivodocumentopersonafisica">';
    if (!empty($row['archivo_rfc_moral'])) {
        $archivo_rfc_moral = $row['archivo_rfc_moral'];
        echo '<p class="card-text">Descarga el archivo:
        <a href="../../Servidor/archivos/files/files_asignacion_demo/personas_morales/files_RFC/' . $archivo_rfc_moral . '" target="_blank" class="btn btn-warning">Abrir</a>
        <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="../../Servidor/archivos/files/files_asignacion_demo/personas_morales/files_RFC/' . $archivo_rfc_moral . '#toolbar=0&navpanes=0&scrollbar=0" frameborder="0" style="width:100%;height:500px;"></iframe>
        </div>
      </p>';
    }
    echo '</div>';
}
