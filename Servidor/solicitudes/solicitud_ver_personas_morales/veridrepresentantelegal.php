<?php
include "../../conexion.php";

if (isset($_POST['id_persona_idrepresentantelegal'])) {
    $id_persona_moral = $_POST['id_persona_idrepresentantelegal'];

    $sqlobtenerinepersomoral = "SELECT archivo_identificacion_representante_legal 
                                    FROM personas_morales
                                    WHERE id_persona_moral = '$id_persona_moral'";

    $result = $conexion->query($sqlobtenerinepersomoral);
    $row = $result->fetch_assoc();

    echo '<div class="col archivodocumentopersonafisica">';
    if (!empty($row['archivo_identificacion_representante_legal'])) {
        $archivo_identificacion_representante_legal = $row['archivo_identificacion_representante_legal'];
        echo '<p class="card-text">Descarga el archivo:
        <a href="../../Servidor/archivos/files/files_asignacion_demo/personas_morales/files_id/' . $archivo_identificacion_representante_legal . '" target="_blank" class="btn btn-warning">Abrir</a>
        <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="../../Servidor/archivos/files/files_asignacion_demo/personas_morales/files_id/' . $archivo_identificacion_representante_legal . '#toolbar=0&navpanes=0&scrollbar=0" frameborder="0" style="width:100%;height:500px;"></iframe>
        </div>
      </p>';
    }
    echo '</div>';
}
