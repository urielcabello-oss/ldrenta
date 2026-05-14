<?php
include "../../conexion.php";

if (isset($_POST['id_persona_escrituraconstitutiva'])) {
    $id_persona_moral = $_POST['id_persona_escrituraconstitutiva'];

    $sql = "SELECT nombre_archivo 
            FROM archivos_escritura_constitutiva
            WHERE id_persona_moral = '$id_persona_moral'";

    $result = $conexion->query($sql);

    echo '<div class="row">';
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $nombre_archivo = $row['nombre_archivo'];

            echo '<div class="col-md-6 mb-3">'; // 2 columnas en desktop
            echo '  <div class="border rounded p-2 shadow-sm">'; // estilo compacto
            echo '      <p class="mb-2">Archivo: 
                          <a href="../../Servidor/archivos/files/files_asignacion_demo/personas_morales/files_escrituraconstitutiva/' 
                          . $nombre_archivo . '" target="_blank" class="btn btn-warning btn-sm">Abrir</a>
                        </p>';
            echo '      <iframe src="../../Servidor/archivos/files/files_asignacion_demo/personas_morales/files_escrituraconstitutiva/' 
                          . $nombre_archivo . '#toolbar=0&navpanes=0&scrollbar=0" 
                          frameborder="0" style="width:100%; height:400px;"></iframe>';
            echo '  </div>';
            echo '</div>';
        }
    } else {
        echo '<p>No hay archivos de escritura constitutiva para esta persona moral.</p>';
    }
    echo '</div>';
}
?>
