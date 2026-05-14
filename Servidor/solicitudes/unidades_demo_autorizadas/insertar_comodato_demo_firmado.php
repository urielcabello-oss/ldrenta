<!--Comodato firmado-->
<?php 

include("../../conexion.php");
session_start();
$id_creador_comodato = $_SESSION['id_colaborador'];

if (isset($_POST['id_asignacion']) && isset($_FILES['comodato_firmado_demo'])) {
    echo"entro subir comodato";

    $valor_idasignacion = $_POST['id_asignacion'];
    $nombrearchivocomodato = 'COMODATO_FIRMADO_' . basename($_FILES['comodato_firmado_demo']['name']);
    $rutaarchivocomodato = "../../archivos/files/files_unidades/comodato_demos_firmado/";

    if (move_uploaded_file($_FILES['comodato_firmado_demo']['tmp_name'], $rutaarchivocomodato . $nombrearchivocomodato)) {
        $sql = "UPDATE asignacion_unidad_demo 
                SET id_estatus_comodato_demo = 4,
                archivo_comodato_firmado = '$nombrearchivocomodato'
                WHERE id_asignacion_unidad_demo = $valor_idasignacion";
        $ejecutar = mysqli_query($conexion, $sql);

        if ($ejecutar) {
            echo "Unidad actualizada correctamente.";
        } else {
            echo "Error al actualizar la unidad.";
        }

    } else {
        echo "Error al subir el archivo.";
    }

} else {
    echo "Faltan datos en el formulario.";
}
?>
