<?php
include("../../conexion.php");

if (isset($_POST['id_persona_fisica'])) {
    $id = $_POST['id_persona_fisica'];

    // Datos generales
    $nombre1 = $_POST['editarnombrepersonafisica1'] ?? '';
    $nombre2 = $_POST['editarnombrepersonafisica2'] ?? '';
    $apaterno = $_POST['editarapaternopersonafisica'] ?? '';
    $amaterno = $_POST['editaramaternopersonafisica'] ?? '';
    $genero = $_POST['editargeneropersonafisica'] ?? '';
    $ine = $_POST['editarinepersonafisica'] ?? '';
    $vigencia_ine = $_POST['editarvigenciainepersonafisica'] ?? '';
    $curp = $_POST['editarcurppersonafisica'] ?? '';
    $rfc = $_POST['editarrfcpersonafisica'] ?? '';
    $domicilio = $_POST['editardomiciliopersonafisica'] ?? '';

    // Rutas
    $rutas = [
        'domicilio' => "../../archivos/files/files_asignacion_demo/files_domicilio/",
        'ine'       => "../../archivos/files/files_asignacion_demo/files_ines/",
        'curp'      => "../../archivos/files/files_asignacion_demo/files_CURP/",
        'rfc'       => "../../archivos/files/files_asignacion_demo/files_RFC/"
    ];

    // Función para procesar archivo
    function procesarArchivo($campo, $prefijo, $ruta, $id, $columna, $nombre1, $conexion) {
        if (!empty($_FILES[$campo]['name'])) {
            $archivo_nombre = $prefijo . "_" . $nombre1 . "_" . basename($_FILES[$campo]['name']);
            $archivo_tmp = $_FILES[$campo]['tmp_name'];
            $ruta_destino = $ruta . $archivo_nombre;

            if (move_uploaded_file($archivo_tmp, $ruta_destino)) {
                $query = "UPDATE personas_fisicas SET $columna = '$archivo_nombre' WHERE id_persona_fisica = '$id'";
                if (mysqli_query($conexion, $query)) {
                    echo "Archivo $columna actualizado correctamente.<br>";
                } else {
                    echo "Error al actualizar $columna.<br>";
                }
            } else {
                echo "Error al mover archivo $columna.<br>";
            }
        }
    }

    // Procesar cada archivo
    procesarArchivo('editararchivodomicilio', 'DOMICILIO', $rutas['domicilio'], $id, 'archivo_domicilio', $nombre1, $conexion);
    procesarArchivo('editararchivoINEpersonafisica', 'INE', $rutas['ine'], $id, 'archivo_ine', $nombre1, $conexion);
    procesarArchivo('editararchivoCURPpersonafisica', 'CURP', $rutas['curp'], $id, 'archivo_curp', $nombre1, $conexion);
    procesarArchivo('editararchivoRFCpersonafisica', 'RFC', $rutas['rfc'], $id, 'archivo_rfc', $nombre1, $conexion);

    // Actualizar otros datos
    $query = "UPDATE personas_fisicas SET 
                nombre_1 = '$nombre1', 
                nombre_2 = '$nombre2', 
                apellido_paterno = '$apaterno', 
                apellido_materno = '$amaterno', 
                genero = '$genero', 
                seccion = '$ine', 
                vigencia = '$vigencia_ine', 
                curp = '$curp', 
                rfc = '$rfc', 
                domicilio = '$domicilio' 
              WHERE id_persona_fisica = '$id'";
    
    if (mysqli_query($conexion, $query)) {
        echo "Datos personales actualizados correctamente.<br>";
    } else {
        echo "Error al actualizar los datos personales.<br>";
    }
}
?>
