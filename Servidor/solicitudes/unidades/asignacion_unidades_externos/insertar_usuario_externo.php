<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../../../conexion.php");

// Escapar y asignar valores
function limpiar($valor) {
    return htmlspecialchars(trim($valor));
}

// Verificar campo base obligatorio
if (!isset($_POST['tipousuarioexterno'])) {
    exit("Falta el campo requerido: tipousuarioexterno");
}
$tipousuarioexterno = limpiar($_POST['tipousuarioexterno']);

// Campos comunes
$camposComunes = [
    'nombre1', 'nombre2', 'apaterno', 'amaterno', 'genero',
    'licenciaconducir', 'fechaemision', 'fechavenci',
    'estadolicenciaconducir', 'domicilio'
];

// Archivos obligatorios
$archivosObligatorios = ['archivolicenciaconducir', 'archivodomicilio'];

// Archivos opcionales
$archivosOpcionales = ['archivoINE', 'archivoconsfiscal'];

// Campos para usuarios extranjeros
$camposExtranjero = ['tiporesidencia', 'pasaporte', 'formamigratoria'];
$archivosExtranjero = ['archivocredencialresidencia', 'archivopasaporte'];

// Validar campos comunes obligatorios
foreach ($camposComunes as $campo) {
    if (!isset($_POST[$campo])) {
        exit("Falta el campo requerido: $campo");
    }
}

// Validar archivos obligatorios
foreach ($archivosObligatorios as $archivo) {
    if (!isset($_FILES[$archivo]) || $_FILES[$archivo]['error'] !== 0) {
        exit("Error en el archivo obligatorio: $archivo");
    }
}

// Validar específicos si es usuario extranjero
if ($tipousuarioexterno == "2") {
    foreach ($camposExtranjero as $campo) {
        if (!isset($_POST[$campo])) {
            exit("Falta el campo requerido: $campo");
        }
    }
    foreach ($archivosExtranjero as $archivo) {
        if (!isset($_FILES[$archivo]) || $_FILES[$archivo]['error'] !== 0) {
            exit("Error en el archivo: $archivo");
        }
    }
}

// Limpiar datos comunes
foreach ($camposComunes as $campo) {
    $$campo = limpiar($_POST[$campo]);
}

$licenciaPermanente = $_POST['licenciaPermanente'] ?? 0; // opcional
$estadolicenciaconducir = limpiar($_POST['estadolicenciaconducir']);

// Limpiar datos extranjeros si aplica
if ($tipousuarioexterno == "2") {
    foreach ($camposExtranjero as $campo) {
        $$campo = limpiar($_POST[$campo]);
    }
}

// Carpeta destino para archivos
$rutaArchivos = "../../../../Servidor/archivos/files/files_usuarios_externos/";
if (!is_dir($rutaArchivos)) {
    mkdir($rutaArchivos, 0777, true);
}

// Función para guardar archivo
function guardarArchivo($inputName, $prefijo) {
    global $rutaArchivos;
    $nombreOriginal = basename($_FILES[$inputName]['name']);
    $nombreFinal = $prefijo . '_' . time() . '_' . $nombreOriginal;
    $rutaFinal = $rutaArchivos . $nombreFinal;

    if (!move_uploaded_file($_FILES[$inputName]['tmp_name'], $rutaFinal)) {
        exit("Error al mover archivo: $inputName");
    }

    return $nombreFinal;
}

// Guardar archivos obligatorios
$archivoLicencia = guardarArchivo('archivolicenciaconducir', 'licencia');
$archivoDomicilio = guardarArchivo('archivodomicilio', 'domicilio');

// Guardar archivos opcionales solo si vienen
$archivoINE = '';
if (isset($_FILES['archivoINE']) && $_FILES['archivoINE']['error'] === 0 && $_FILES['archivoINE']['size'] > 0) {
    $archivoINE = guardarArchivo('archivoINE', 'ine');
}

$archivoConstancia = '';
if (isset($_FILES['archivoconsfiscal']) && $_FILES['archivoconsfiscal']['error'] === 0 && $_FILES['archivoconsfiscal']['size'] > 0) {
    $archivoConstancia = guardarArchivo('archivoconsfiscal', 'consfiscal');
}

// Insertar según tipo de usuario externo
if ($tipousuarioexterno == "1") {
    // Usuario nacional
   $sql = "INSERT INTO usuarios_externos (
                id_tipo_usuario_externo, nombre_1, nombre_2, apellido_paterno, apellido_materno, genero,
                licencia_conducir, fecha_emision, fecha_vencimiento, licencia_permanente,
                id_estado_licencia, archivo_licencia, domicilio_residencia,
                archivo_comprobante_domicilio, archivo_ine, archivo_constancia_situacion_fiscal
            ) VALUES (
                '$tipousuarioexterno', '$nombre1', '$nombre2', '$apaterno', '$amaterno', '$genero',
                '$licenciaconducir', '$fechaemision', '$fechavenci', '$licenciaPermanente',
                '$estadolicenciaconducir', '$archivoLicencia', '$domicilio',
                '$archivoDomicilio', '$archivoINE', '$archivoConstancia'
            )";
} elseif ($tipousuarioexterno == "2") {
    // Archivos extranjeros
    $archivoCredencialResidencia = guardarArchivo('archivocredencialresidencia', 'credencialresidencia');
    $archivoPasaporte = guardarArchivo('archivopasaporte', 'pasaporte');

    $sql = "INSERT INTO usuarios_externos (
                id_tipo_usuario_externo, nombre_1, nombre_2, apellido_paterno, apellido_materno, genero,
                licencia_conducir, fecha_emision, fecha_vencimiento, licencia_permanente,
                id_estado_licencia, archivo_licencia, domicilio_residencia,
                archivo_comprobante_domicilio, id_tipo_recidencia, archivo_credencial_residencia,
                pasaporte, archivo_pasaporte, forma_migratoria
            ) VALUES (
                '$tipousuarioexterno', '$nombre1', '$nombre2', '$apaterno', '$amaterno', '$genero',
                '$licenciaconducir', '$fechaemision', '$fechavenci', '$licenciaPermanente',
                '$estadolicenciaconducir', '$archivoLicencia', '$domicilio',
                '$archivoDomicilio', '$tiporesidencia', '$archivoCredencialResidencia',
                '$pasaporte', '$archivoPasaporte', '$formamigratoria'
            )";
} else {
    exit("Tipo de usuario externo no válido.");
}

// Ejecutar consulta
if ($conectar->query($sql) === TRUE) {
    echo "Se insertó correctamente";
} else {
    echo "Error en la inserción: " . $conectar->error;
}


?>


