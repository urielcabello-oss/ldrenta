<?php
include "../../conexion.php";

if (isset($_POST['id_persona_rfc'])) {
    $id_persona_fisica = $_POST['id_persona_rfc'];

    $sqlobtenerrfcpersonafisica = "SELECT archivo_rfc
                                    FROM personas_fisicas 
                                    WHERE id_persona_fisica = '$id_persona_fisica'";

    $result = $conexion->query($sqlobtenerrfcpersonafisica);
    $row = $result->fetch_assoc();

    echo '<div class="col archivodocumentopersonafisica">';
    if (!empty($row['archivo_rfc'])) {
        $archivo_rfc = $row['archivo_rfc'];
        echo '<p class="card-text">Descarga el archivo:
        <a href="../../Servidor/archivos/files/files_asignacion_demo/personas_fisicas/files_RFC/' . $archivo_rfc . '" target="_blank" class="btn btn-warning">Abrir</a>
        <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="../../Servidor/archivos/files/files_asignacion_demo/personas_fisicas/files_RFC/' . $archivo_rfc . '#toolbar=0&navpanes=0&scrollbar=0" frameborder="0" style="width:100%;height:500px;"></iframe>
        </div>
      </p>';
    }
    echo '</div>';
}
