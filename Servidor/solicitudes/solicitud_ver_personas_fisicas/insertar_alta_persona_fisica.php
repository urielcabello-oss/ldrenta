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


//-----------------------------------------------------------Inicia el flujo de asignacion solicitando por post la informacion del js
if (isset($_POST['nombrepersonafisica1'])
&& isset($_POST['apaternopersonafisica'])
&& isset($_POST['amaternopersonafisica'])
&& isset($_POST['generopersonafisica'])
&& isset($_POST['inepersonafisica'])
&& isset($_POST['vigenciainepersonafisica'])
&& isset($_FILES['archivoINEpersonafisica'])
&& isset($_POST['curppersonafisica'])
&& isset($_FILES['archivoCURPpersonafisica'])
&& isset($_POST['rfcpersonafisica'])
&& isset($_FILES['archivoRFCpersonafisica'])
&& isset($_POST['domiciliodomiciliopersonafisica'])
&& isset($_FILES['archivodomicilio'])
&& isset($_POST['domicilioresguardounidad'])
&& isset($_FILES['archivodomicilioresguardounidad'])
&& isset($_POST['contactopersonafisica'])) {

    $valornombrepersonafisica1 = $_POST['nombrepersonafisica1'];
    $valornombrepersonafisica2 = $_POST['nombrepersonafisica2'];
    $valorapaternopersonafisica = $_POST['apaternopersonafisica'];
    $valoramaternopersonafisica = $_POST['amaternopersonafisica'];
    $valorgenepersonafisica = $_POST['generopersonafisica'];
    $valorninepersonafisica = $_POST['inepersonafisica'];
    $valornvigenciainepersonafisica = $_POST['vigenciainepersonafisica'];
    $valornarchivoINEpersonafisica = $_FILES['archivoINEpersonafisica'];
    $valorncurppersonafisica = $_POST['curppersonafisica'];
    $valornarchivoCURPpersonafisica = $_FILES['archivoCURPpersonafisica'];
    $valornrfcpersonafisica = $_POST['rfcpersonafisica'];
    $valornarchivoRFCpersonafisica = $_FILES['archivoRFCpersonafisica'];
    $valordomiciliodomiciliopersonafisica = $_POST['domiciliodomiciliopersonafisica'];
    $valordarchivodomicilio = $_FILES['archivodomicilio'];
    $valordomiciliodomicilioresguardounidad = $_POST['domicilioresguardounidad'];
    $valordarchivodomicilioresguardounidad = $_FILES['archivodomicilioresguardounidad'];
    $valorncontactopersonafisica = $_POST['contactopersonafisica'];

    echo "nombrepersonafisica1: " . $valornombrepersonafisica1 . " ";
    echo "nombrepersonafisica2: " . $valornombrepersonafisica2 . " ";
    echo "apaternopersonafisica: " . $valorapaternopersonafisica . " ";
    echo "amaternopersonafisica: " . $valoramaternopersonafisica . " ";
    echo "generopersonafisica: " . $valorgenepersonafisica . " ";
    echo "inepersonafisica: " . $valorninepersonafisica . " ";
    echo "vigenciainepersonafisica: " . $valornvigenciainepersonafisica . " ";
    echo "archivoINEpersonafisica: " . $valornarchivoINEpersonafisica . " ";
    echo "curppersonafisica: " . $valorncurppersonafisica . " ";
    echo "archivoCURPpersonafisica: " . $valornarchivoCURPpersonafisica . " ";
    echo "rfcpersonafisica: " . $valornrfcpersonafisica . " ";
    echo "archivoRFCpersonafisica: " . $valornarchivoRFCpersonafisica . " ";
    echo "domiciliodomiciliopersonafisica: " . $valordomiciliodomiciliopersonafisica . " ";
    echo "archivodomicilio: " . $valordarchivodomicilio . " ";
    echo "domicilioresguardounidad: " . $valordomiciliodomicilioresguardounidad . " ";
    echo "archivodomicilioresguardounidad: " . $valordarchivodomicilioresguardounidad . " ";
    echo "contactopersonafisica: " . $valorncontactopersonafisica . " ";

    //obtener  los documentos correspondientes
    $nombrearchivoINEpersonafisica = 'INE_' . $valorninepersonafisica . '_' . basename($_FILES['archivoINEpersonafisica']['name']);
    $nombrearchivoCURPpersonafisica = 'CURP_' . $valorncurppersonafisica . '_' . basename($_FILES['archivoCURPpersonafisica']['name']);
    $nombrearchivoRFCpersonafisica = 'RFC_' . $valornrfcpersonafisica . '_' . basename($_FILES['archivoRFCpersonafisica']['name']);
    $nombredarchivodomicilio = 'domicilio_' . $valornombrepersonafisica1 . '_' . basename($_FILES['archivodomicilio']['name']);
    $nombrearchivodomicilioresguardounidad = 'domicilio_resguardo_' . $valornombrepersonafisica1 . '_' . basename($_FILES['archivodomicilioresguardounidad']['name']);

    $rutaarchivoINEpersonafisica = "../../archivos/files/files_asignacion_demo/personas_fisicas/files_ines/";
    $rutaarchivoCURPpersonafisica = "../../archivos/files/files_asignacion_demo/personas_fisicas/files_CURP/";
    $rutaarchivoRFCpersonafisica = "../../archivos/files/files_asignacion_demo/personas_fisicas/files_RFC/";
    $routadarchivodomicilio = "../../archivos/files/files_asignacion_demo/personas_fisicas/files_domicilio/";
    $rutarchivodomicilioresguardounidad = "../../archivos/files/files_asignacion_demo/personas_fisicas/files_domicilio/";

    move_uploaded_file($_FILES['archivoINEpersonafisica']['tmp_name'], $rutaarchivoINEpersonafisica . $nombrearchivoINEpersonafisica);
    move_uploaded_file($_FILES['archivoCURPpersonafisica']['tmp_name'], $rutaarchivoCURPpersonafisica . $nombrearchivoCURPpersonafisica);
    move_uploaded_file($_FILES['archivoRFCpersonafisica']['tmp_name'], $rutaarchivoRFCpersonafisica . $nombrearchivoRFCpersonafisica);
    move_uploaded_file($_FILES['archivodomicilio']['tmp_name'], $routadarchivodomicilio . $nombredarchivodomicilio);
    move_uploaded_file($_FILES['archivodomicilioresguardounidad']['tmp_name'], $rutarchivodomicilioresguardounidad . $nombrearchivodomicilioresguardounidad);
    
    //insertar los datos y los archivos

    $queryinsertarpersonafisica = "INSERT INTO personas_fisicas (id_registrador_persona_fisica,
                                                                nombre_1,
                                                                nombre_2,
                                                                apellido_paterno,
                                                                apellido_materno,
                                                                genero,
                                                                seccion,
                                                                vigencia,
                                                                archivo_ine,
                                                                curp,
                                                                archivo_curp,
                                                                rfc,
                                                                archivo_rfc,
                                                                domicilio,
                                                                archivo_domicilio,
                                                                domicilio_resguardo_unidad,
                                                                archivo_domicilio_resguardo_unidad,
                                                                contacto_persona_fisica)
                                    VALUES ('$colaborador',
                                            '$valornombrepersonafisica1',
                                            '$valornombrepersonafisica2',
                                            '$valorapaternopersonafisica',
                                            '$valoramaternopersonafisica',
                                            '$valorgenepersonafisica',
                                            '$valorninepersonafisica',
                                            '$valornvigenciainepersonafisica',
                                            '$nombrearchivoINEpersonafisica',
                                            '$valorncurppersonafisica',
                                            '$nombrearchivoCURPpersonafisica',
                                            '$valornrfcpersonafisica',
                                            '$nombrearchivoRFCpersonafisica',
                                            '$valordomiciliodomiciliopersonafisica',
                                            '$nombredarchivodomicilio',
                                            '$valordomiciliodomicilioresguardounidad',
                                            '$nombrearchivodomicilioresguardounidad',
                                            '$valorncontactopersonafisica');";

    echo $queryinsertarpersonafisica;

    $ejecutarinsertarpersonafisica = mysqli_query($conexion, $queryinsertarpersonafisica);

    if ($ejecutarinsertarpersonafisica) {
        echo "Persona física insertada";
    }else{
        echo "Persona física no insertada";
    }
}