<?php 
// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../../conexion.php");


//-----------------------------------------------------------------------obtenemos el id del colaborador para saber quien es el que esta logeado
if (!isset($_SESSION)) {
    session_start();
}

$colaborador = $_SESSION['id_colaborador'];


//-----------------------------------------------------------Inicia el flujo de insertar la prueba solicitando por post la informacion del js
if (isset($_POST['id_asignacion_unidad_demo'])
&& isset($_POST['nombre_conductor'])
&& isset($_POST['tipo_prueba'])
&& isset($_POST['origen_inicial'])
&& isset($_POST['origen_destino'])
&& isset($_POST['temperatura'])
&& isset($_POST['revoluciones'])
&& isset($_POST['velocidad'])
&& isset($_POST['kilometraje'])
&& isset($_FILES['foto_cluster'])
&& isset($_FILES['foto_unidad_exterior'])
&& isset($_POST['comentarios_pruebas_demo'])) {


    $valorid_asignacion_unidad_demo = $_POST['id_asignacion_unidad_demo'];
    $valornombre_conductor = $_POST['nombre_conductor'];
    $valortipo_prueba = $_POST['tipo_prueba'];
    $valororigen_inicial = $_POST['origen_inicial'];
    $valororigen_destino = $_POST['origen_destino'];
    $valortemperatura = $_POST['temperatura'];
    $valorrevoluciones = $_POST['revoluciones'];
    $valorvelocidad = $_POST['velocidad'];
    $valorkilometraje = $_POST['kilometraje'];
    $valorfoto_cluster = $_FILES['foto_cluster'];
    $valorfoto_unidad_exterior = $_FILES['foto_unidad_exterior'];
    $valorcomentarios_pruebas_demo = $_POST['comentarios_pruebas_demo'];

    echo "id_asignacion_unidad_demo: " . $valorid_asignacion_unidad_demo . " ";
    echo "nombre_conductor: " . $valornombre_conductor . " ";
    echo "tipo_prueba: " . $valortipo_prueba . " ";
    echo "origen_inicial: " . $valororigen_inicial . " ";
    echo "origen_destino: " . $valororigen_destino . " ";
    echo "temperatura: " . $valortemperatura . " ";
    echo "revoluciones: " . $valorrevoluciones . " ";
    echo "velocidad: " . $valorvelocidad . " ";
    echo "kilometraje: " . $valorkilometraje . " ";
    echo "foto_cluster: " . $_FILES['foto_cluster']['name'] . " ";
    echo "foto_unidad_exterior: " . $_FILES['foto_unidad_exterior']['name'] . " ";
    echo "comentarios_pruebas_demo: " . $valorcomentarios_pruebas_demo . " ";

    //obtener las fotos correspondientes
    $nombrefoto_cluster = 'foto_cluster_' . $valornombre_conductor . '_' . basename($_FILES['foto_cluster']['name']);
    $nombrefoto_unidad_exterior = 'foto_unidad_exterior_' . $valornombre_conductor . '_' . basename($_FILES['foto_unidad_exterior']['name']);

    $rutafoto_cluster = "../../archivos/files/files_asignacion_demo/pruebas_unidades_demo/fotos_cluster/";
    $rutafoto_unidad_exterior = "../../archivos/files/files_asignacion_demo/pruebas_unidades_demo/fotos_unidad_exterior/";

    move_uploaded_file($_FILES['foto_cluster']['tmp_name'], $rutafoto_cluster . $nombrefoto_cluster);
    move_uploaded_file($_FILES['foto_unidad_exterior']['tmp_name'], $rutafoto_unidad_exterior . $nombrefoto_unidad_exterior);

    
    //actualizamos el estado de la asignacion en la tabla asignacion_unidad_demo
    $querycontarpruebas = "SELECT COUNT(*) AS total FROM pruebas_unidad_demo WHERE id_asignacion_unidad_demo = '$valorid_asignacion_unidad_demo'";
    $resultadocontarpruebas = mysqli_query($conexion, $querycontarpruebas);
    $fila = mysqli_fetch_assoc($resultadocontarpruebas);
    $totalpruebas = $fila['total'];

if ($totalpruebas == 0) {
    // Primera prueba: se actualiza el estado a EN PROCESO
    $queryactualizarasignacion = "UPDATE asignacion_unidad_demo SET id_estado_prueba_demo = 2 WHERE id_asignacion_unidad_demo = '$valorid_asignacion_unidad_demo'";
    $resultadoactualizarasignacion = mysqli_query($conexion, $queryactualizarasignacion);
}


    //insertar la prueba
    $queryinsertarprueba = "INSERT INTO pruebas_unidad_demo (id_asignacion_unidad_demo,
                                                            fecha_prueba,
                                                            nombre_del_conductor,
                                                            id_tipo_prueba_demo,
                                                            origen_inicial,
                                                            origen_destino,
                                                            temperatura,
                                                            revoluciones,
                                                            velocidad,
                                                            kilometraje,
                                                            foto_cluster,
                                                            foto_unidad,
                                                            comentarios,
                                                            id_colaborador_registra_prueba)
                                VALUES ('$valorid_asignacion_unidad_demo',
                                        NOW(),
                                        '$valornombre_conductor',
                                        '$valortipo_prueba',
                                        '$valororigen_inicial',
                                        '$valororigen_destino',
                                        '$valortemperatura',
                                        '$valorrevoluciones',
                                        '$valorvelocidad',
                                        '$valorkilometraje',
                                        '$nombrefoto_cluster',
                                        '$nombrefoto_unidad_exterior',
                                        '$valorcomentarios_pruebas_demo',
                                        '$colaborador')";
    $resultadoprueba = $conexion->query($queryinsertarprueba);
    if ($resultadoprueba) {
    echo "Prueba insertada correctamente";
} else {
    echo "Error al insertar prueba: " . $conexion->error;
}
}
?>


