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

if (isset($_POST['institucionorganizacion'])
&& isset($_POST['identificacionlegal'])
&& isset($_POST['viegnciarepresentantelegal'])
&& isset($_FILES['archivoidentificacionrepresentantelegal'])
&& isset($_FILES['archivopoderepresentantelegal'])
&& isset($_POST['rfcpersonamoral'])
&& isset($_FILES['archivoRFCpersonamoral'])
&& isset($_POST['domiciliodomiciliopersonamoral'])
&& isset($_FILES['archivodomiciliopersonamoral'])
&& isset($_POST['domicilioresguardounidad'])
&& isset($_FILES['archivodomicilioresguardounidad'])
&& isset($_POST['contactopersonamoral'])) {

    $valorinstitucionorganizacion = $_POST['institucionorganizacion'];
    $valoridentificacionlegal = $_POST['identificacionlegal'];
    $valorviegnciarepresentantelegal = $_POST['viegnciarepresentantelegal'];
    $valorarchivoidentificacionrepresentantelegal = $_FILES['archivoidentificacionrepresentantelegal'];
    $valorarchivopoderepresentantelegal = $_FILES['archivopoderepresentantelegal'];
    $valorrfcpersonamoral = $_POST['rfcpersonamoral'];
    $valorarchivoRFCpersonamoral = $_FILES['archivoRFCpersonamoral'];
    $valordomiciliodomiciliopersonamoral = $_POST['domiciliodomiciliopersonamoral'];
    $valorarchivodomiciliopersonamoral = $_FILES['archivodomiciliopersonamoral'];
    $valordomicilioresguardounidad = $_POST['domicilioresguardounidad'];
    $valorarchivodomicilioresguardounidad = $_FILES['archivodomicilioresguardounidad'];
    $valorcontactopersonamoral = $_POST['contactopersonamoral'];

    echo "institucionorganizacion: " . $valorinstitucionorganizacion . " ";
    echo "identificacionlegal: " . $valoridentificacionlegal . " ";
    echo "viegnciarepresentantelegal: " . $valorviegnciarepresentantelegal . " ";
    echo "archivoidentificacionrepresentantelegal: " . $valorarchivoidentificacionrepresentantelegal . " ";
    echo "archivopoderepresentantelegal: " . $valorarchivopoderepresentantelegal . " ";
    echo "rfcpersonamoral: " . $valorrfcpersonamoral . " ";
    echo "archivoRFCpersonamoral: " . $valorarchivoRFCpersonamoral . " ";
    echo "domiciliodomiciliopersonamoral: " . $valordomiciliodomiciliopersonamoral . " ";
    echo "archivodomiciliopersonamoral: " . $valorarchivodomiciliopersonamoral . " ";
    echo "domicilioresguardounidad: " . $valordomicilioresguardounidad . " ";
    echo "archivodomicilioresguardounidad: " . $valorarchivodomicilioresguardounidad . " ";
    echo "contactopersonamoral: " . $valorcontactopersonamoral . " ";

    //obtener los documentos correspondientes

    $nombrearchivoidentificacionrepresentantelegal = 'ID_' . $valorviegnciarepresentantelegal . '_' . basename($_FILES['archivoidentificacionrepresentantelegal']['name']);
    $nombrearchivopoderepresentantelegal = 'PODER_' . $valorviegnciarepresentantelegal . '_' . basename($_FILES['archivopoderepresentantelegal']['name']);
    $nombrearchivoRFCpersonamoral = 'RFC_' . $valorrfcpersonamoral . '_' . basename($_FILES['archivoRFCpersonamoral']['name']);
    $nombredarchivodomiciliopersonamoral = 'domicilio_' . $valorrfcpersonamoral . '_' . basename($_FILES['archivodomiciliopersonamoral']['name']);
    $nombrearchivodomicilioresguardounidad = 'domicilioresguardounidad_' . $valorrfcpersonamoral . '_' . basename($_FILES['archivodomicilioresguardounidad']['name']);

    $rutarchivoidentificacionrepresentantelegal = "../../archivos/files/files_asignacion_demo/personas_morales/files_id/";
    $rutarchivopoderepresentantelegal = "../../archivos/files/files_asignacion_demo/personas_morales/files_poder/";
    $rutarchivoRFCpersonamoral = "../../archivos/files/files_asignacion_demo/personas_morales/files_RFC/";
    $routadarchivodomiciliopersonamoral = "../../archivos/files/files_asignacion_demo/personas_morales/files_domicilio/";
    $rutarchivodomicilioresguardounidad = "../../archivos/files/files_asignacion_demo/personas_morales/files_domicilioresguardounidad/";

    move_uploaded_file($_FILES['archivoidentificacionrepresentantelegal']['tmp_name'], $rutarchivoidentificacionrepresentantelegal . $nombrearchivoidentificacionrepresentantelegal);
    move_uploaded_file($_FILES['archivopoderepresentantelegal']['tmp_name'], $rutarchivopoderepresentantelegal . $nombrearchivopoderepresentantelegal);
    move_uploaded_file($_FILES['archivoRFCpersonamoral']['tmp_name'], $rutarchivoRFCpersonamoral . $nombrearchivoRFCpersonamoral);
    move_uploaded_file($_FILES['archivodomiciliopersonamoral']['tmp_name'], $routadarchivodomiciliopersonamoral . $nombredarchivodomiciliopersonamoral);
    move_uploaded_file($_FILES['archivodomicilioresguardounidad']['tmp_name'], $rutarchivodomicilioresguardounidad . $nombrearchivodomicilioresguardounidad);
    $archivosEscritura = [];
    $archivosEstatusSociales = [];

if (isset($_FILES['archivoescrituraconstitutiva'])) {
    foreach ($_FILES['archivoescrituraconstitutiva']['tmp_name'] as $key => $tmp_name) {
        if ($_FILES['archivoescrituraconstitutiva']['error'][$key] === UPLOAD_ERR_OK) {
            $nombreArchivo = 'escrituraconstitutiva_' . $valorrfcpersonamoral . '_' . basename($_FILES['archivoescrituraconstitutiva']['name'][$key]);
            $rutaDestino = "../../archivos/files/files_asignacion_demo/personas_morales/files_escrituraconstitutiva/" . $nombreArchivo;

            move_uploaded_file($tmp_name, $rutaDestino);

            // Guardar nombre para registrar en la BD
            $archivosEscritura[] = $nombreArchivo;
        }
    }
}
if (isset($_FILES['archivoestatusociales'])) {
    foreach ($_FILES['archivoestatusociales']['tmp_name'] as $key => $tmp_name) {
        if ($_FILES['archivoestatusociales']['error'][$key] === UPLOAD_ERR_OK) {
            $nombreArchivoSociales = 'escrituraestatusociales_' . $valorrfcpersonamoral . '_' . basename($_FILES['archivoestatusociales']['name'][$key]);
            $rutaDestinoSociales = "../../archivos/files/files_asignacion_demo/personas_morales/files_estatusociales/" . $nombreArchivoSociales;

            move_uploaded_file($tmp_name, $rutaDestinoSociales);

            // Guardar nombre para registrar en la BD
            $archivosEstatusSociales[] = $nombreArchivoSociales;
        }
    }
}


    //insertar los datos y los archivos

        $queryinsertarpersonamoral = "INSERT INTO personas_morales(
                                                id_registrador_persona_moral,
                                                organizacion_institucion,
                                                identificacion_representante_legal_seccion,
                                                vigencia,
                                                archivo_identificacion_representante_legal,
                                                archivo_poder_representante_legal,
                                                rfc_moral,
                                                archivo_rfc_moral,
                                                domicilio,
                                                archivo_domiclio_moral,
                                                domicilio_resguardo_unidad,
                                                archivo_domicilio_resguardo_unidad,
                                                contacto_persona_moral
                                    ) VALUES (
                                        '$colaborador',
                                        '$valorinstitucionorganizacion',
                                        '$valoridentificacionlegal',
                                        '$valorviegnciarepresentantelegal',
                                        '$nombrearchivoidentificacionrepresentantelegal',
                                        '$nombrearchivopoderepresentantelegal',
                                        '$valorrfcpersonamoral',
                                        '$nombrearchivoRFCpersonamoral',
                                        '$valordomiciliodomiciliopersonamoral',
                                        '$nombredarchivodomiciliopersonamoral',
                                        '$valordomicilioresguardounidad',
                                        '$nombrearchivodomicilioresguardounidad',
                                        '$valorcontactopersonamoral'
                                    )";

                        
                        echo $queryinsertarpersonamoral;

                $resultinsertarpersonamoral = mysqli_query($conexion, $queryinsertarpersonamoral);
                $id_persona_moral = mysqli_insert_id($conexion);

                if($resultinsertarpersonamoral){
                    foreach ($archivosEscritura as $archivo) {
                        $queryArchivo = "INSERT INTO archivos_escritura_constitutiva (id_persona_moral, nombre_archivo) 
                                        VALUES ('$id_persona_moral', '$archivo')";
                        mysqli_query($conexion, $queryArchivo);
                    }
                    foreach ($archivosEstatusSociales as $archivo2) {
                        $queryArchivo2 = "INSERT INTO archivos_escritura_estatus_sociales (id_persona_moral, nombre_archivo_estatus_sociales) 
                                        VALUES ('$id_persona_moral', '$archivo2')";
                        mysqli_query($conexion, $queryArchivo2);
                    }
                    echo "Persona moral insertada";
                } else {
                    echo "Persona moral no insertada";
                }

    
}