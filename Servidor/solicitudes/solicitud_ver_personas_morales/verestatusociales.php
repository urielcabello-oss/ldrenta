<?php
include "../../conexion.php";

if (isset($_POST['id_persona_estatusociales'])) {
    $id_persona_moral = $_POST['id_persona_estatusociales'];

    $sql = "SELECT nombre_archivo_estatus_sociales 
            FROM archivos_escritura_estatus_sociales
            WHERE id_persona_moral = '$id_persona_moral'";

    $result = $conexion->query($sql);

    echo '<div class="row">';
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $nombre = $row['nombre_archivo_estatus_sociales'];

            echo '<div class="col-md-6 mb-3">'; // 2 columnas en desktop
            echo '  <div class="border rounded p-2 shadow-sm">'; // más compacto que card
            echo '      <p class="mb-2">Archivo: 
                          <a href="../../Servidor/archivos/files/files_asignacion_demo/personas_morales/files_estatusociales/' 
                          . $nombre . '" target="_blank" class="btn btn-warning btn-sm">Abrir</a>
                        </p>';
            echo '      <iframe src="../../Servidor/archivos/files/files_asignacion_demo/personas_morales/files_estatusociales/' 
                          . $nombre . '#toolbar=0&navpanes=0&scrollbar=0" 
                          frameborder="0" style="width:100%; height:400px;"></iframe>';
            echo '  </div>';
            echo '</div>';
        }
    } else {
        echo '<p>No hay archivos de estatus sociales para esta persona moral.</p>';
    }
    echo '</div>';
}
?>
