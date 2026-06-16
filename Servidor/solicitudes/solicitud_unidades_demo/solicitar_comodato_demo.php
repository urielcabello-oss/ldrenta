<?php

ob_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../lib/PHPMailer-master/src/Exception.php';
require '../../lib/PHPMailer-master/src/PHPMailer.php';
require '../../lib/PHPMailer-master/src/SMTP.php';

include("../../conexion.php");

$response = [
    "success" => false,
    "message" => ""
];

// =====================================================
// VALIDAR DATOS POST
// =====================================================

if (
    !isset($_POST['id_unidad']) ||
    !isset($_POST['id_colaborador']) ||
    !isset($_POST['fechasolicitudunidademo']) ||
    !isset($_POST['fechadevolucionunidademo'])
) {

    $response["message"] =
        "No llegaron todos los datos requeridos";

    echo json_encode($response);

    exit;
}

// =====================================================
// RECIBIR DATOS
// =====================================================

$id_unidad = mysqli_real_escape_string(
    $conexion,
    $_POST['id_unidad']
);

$id_colaborador = mysqli_real_escape_string(
    $conexion,
    $_POST['id_colaborador']
);

$fecha_prestamo = mysqli_real_escape_string(
    $conexion,
    $_POST['fechasolicitudunidademo']
);

$fecha_devolucion = mysqli_real_escape_string(
    $conexion,
    $_POST['fechadevolucionunidademo']
);

$id_persona_fisica =
    !empty($_POST['id_persona_fisica'])
    ? mysqli_real_escape_string(
        $conexion,
        $_POST['id_persona_fisica']
    )
    : "NULL";

$id_persona_moral =
    !empty($_POST['id_persona_moral'])
    ? mysqli_real_escape_string(
        $conexion,
        $_POST['id_persona_moral']
    )
    : "NULL";

$objetivo = isset($_POST['objetivo_prueba_demo'])
    ? mysqli_real_escape_string(
        $conexion,
        $_POST['objetivo_prueba_demo']
    )
    : '';

$comentarios = isset($_POST['comentarios_pruebas_demo'])
    ? mysqli_real_escape_string(
        $conexion,
        $_POST['comentarios_pruebas_demo']
    )
    : '';

$emplacamiento =
    isset($_POST['emplacamiento_ldr']) &&
    $_POST['emplacamiento_ldr'] == '1'
    ? 1
    : 2;

$seguro =
    isset($_POST['asegurar_ldr']) &&
    $_POST['asegurar_ldr'] == '1'
    ? 1
    : 2;

// =====================================================
// INSERTAR SOLICITUD
// =====================================================

$queryInsertar = "
    INSERT INTO asignacion_unidad_demo
    (
        id_unidad,
        id_colaborador_que_asigna,
        id_persona_fisica,
        id_persona_moral,
        fecha_prestamo,
        fecha_devolucion,
        objetivo_prestamo,
        comentarios,
        solicitar_emplacamiento_ldr,
        solicitar_seguro_ldr,
        estado,
        id_estatus_comodato_demo
    )
    VALUES
    (
        '$id_unidad',
        '$id_colaborador',
        $id_persona_fisica,
        $id_persona_moral,
        '$fecha_prestamo',
        '$fecha_devolucion',
        '$objetivo',
        '$comentarios',
        '$emplacamiento',
        '$seguro',
        '1',
        '1'
    )
";

$resultadoInsertar = mysqli_query(
    $conexion,
    $queryInsertar
);

if (!$resultadoInsertar) {

    $response["message"] =
        "Error INSERT: " . mysqli_error($conexion);

    echo json_encode($response);

    exit;
}

$id_asignacion_demo =
    mysqli_insert_id($conexion);

// =====================================================
// ACTUALIZAR ESTADO UNIDAD
// =====================================================

$queryUnidad = "
    UPDATE unidades
    SET id_estado_unidad = 3
    WHERE id_unidad = '$id_unidad'
";

mysqli_query($conexion, $queryUnidad);

// =====================================================
// OBTENER INFORMACIÓN COMPLETA
// =====================================================

$queryInfo = "
SELECT
    au.*,

    u.placa,
    u.numero_motor,
    u.VIN,

    mo.nombre_modelo,
    ma.nombre_marca,

    c.nombre_1,
    c.nombre_2,
    c.apellido_paterno,
    c.apellido_materno,

    pf.nombre_1 AS pf_nombre_1,
    pf.nombre_2 AS pf_nombre_2,
    pf.apellido_paterno AS pf_apellido_paterno,
    pf.apellido_materno AS pf_apellido_materno,
    pf.archivo_ine,
    pf.archivo_curp,
    pf.archivo_domicilio,
    pf.archivo_domicilio_resguardo_unidad,
    pf.archivo_rfc,

    pm.organizacion_institucion,
    pm.archivo_identificacion_representante_legal,
    pm.archivo_poder_representante_legal,
    pm.archivo_rfc_moral,
    pm.archivo_domiclio_moral,
    pm.archivo_domicilio_resguardo_unidad,

    aec.nombre_archivo,
    aees.nombre_archivo_estatus_sociales

FROM asignacion_unidad_demo au

INNER JOIN unidades u
ON au.id_unidad = u.id_unidad

INNER JOIN modelos mo
ON u.id_modelo = mo.id_modelo

INNER JOIN marcas ma
ON mo.id_marca = ma.id_marca

INNER JOIN colaboradores c
ON au.id_colaborador_que_asigna = c.id_colaborador

LEFT JOIN personas_fisicas pf
ON au.id_persona_fisica = pf.id_persona_fisica

LEFT JOIN personas_morales pm
ON au.id_persona_moral = pm.id_persona_moral

LEFT JOIN archivos_escritura_constitutiva aec
ON pm.id_persona_moral = aec.id_persona_moral

LEFT JOIN archivos_escritura_estatus_sociales aees
ON pm.id_persona_moral = aees.id_persona_moral

WHERE au.id_asignacion_unidad_demo = '$id_asignacion_demo'
";

$resultInfo = mysqli_query(
    $conexion,
    $queryInfo
);

if (!$resultInfo) {

    $response["message"] =
        "Error consulta info: " .
        mysqli_error($conexion);

    echo json_encode($response);

    exit;
}

$info = mysqli_fetch_assoc($resultInfo);

// =====================================================
// ARMAR DOCUMENTOS
// =====================================================

$lista_documentos = "";

if (!empty($info['id_persona_fisica'])) {

    // =================================================
    // PERSONA FISICA
    // =================================================

    $base =
        "https://ldrenta.ldrhumanresources.com/Servidor/archivos/files/files_asignacion_demo/personas_fisicas/";

    $documentos = [

        "INE" =>
        $base . "files_ines/" .
            $info['archivo_ine'],

        "CURP" =>
        $base . "files_CURP/" .
            $info['archivo_curp'],

        "DOMICILIO" =>
        $base . "files_domicilio/" .
            $info['archivo_domicilio'],

        "DOMICILIO RESGUARDO" =>
        $base . "files_domicilio/" .
            $info['archivo_domicilio_resguardo_unidad'],

        "RFC" =>
        $base . "files_RFC/" .
            $info['archivo_rfc'],
    ];
} else {

    // =================================================
    // PERSONA MORAL
    // =================================================

    $base =
        "https://ldrenta.ldrhumanresources.com/Servidor/archivos/files/files_asignacion_demo/personas_morales/";

    $documentos = [

        "Identificación representante legal" =>
        $base . "files_id/" .
            $info['archivo_identificacion_representante_legal'],

        "Poder representante legal" =>
        $base . "files_poder/" .
            $info['archivo_poder_representante_legal'],

        "RFC moral" =>
        $base . "files_RFC/" .
            $info['archivo_rfc_moral'],

        "Comprobante domicilio" =>
        $base . "files_domicilio/" .
            $info['archivo_domiclio_moral'],

        "Domicilio de resguardo de la unidad" =>
        $base . "files_domicilioresguardounidad/" .
            $info['archivo_domicilio_resguardo_unidad'],

        "Escritura constitutiva" =>
        $base . "files_escrituraconstitutiva/" .
            $info['nombre_archivo'],

        "Escritura de los estatutos sociales" =>
        $base . "files_estatusociales/" .
            $info['nombre_archivo_estatus_sociales'],
    ];
}

$lista_documentos .= "<ul>";

foreach ($documentos as $nombre => $url) {

    if (!empty($url) && $url != $base) {

        $lista_documentos .= "
            <li>
                <a href='$url' target='_blank'>
                    $nombre
                </a>
            </li>
        ";
    }
}

$lista_documentos .= "</ul>";

// =====================================================
// OBTENER CORREOS JURIDICO
// =====================================================

$queryCorreos = "
SELECT DISTINCT
    c.email_corporativo
FROM usuario_rol ur
INNER JOIN usuarios u
    ON ur.id_usuario = u.id_usuario
INNER JOIN colaboradores c
    ON u.id_colaborador = c.id_colaborador
WHERE ur.idrol = 3
";

$resultadoCorreos =
    mysqli_query($conexion, $queryCorreos);

if (!$resultadoCorreos) {

    $response["message"] =
        "Error consulta correos: " .
        mysqli_error($conexion);

    echo json_encode($response);

    exit;
}

$correos = [];

while (
    $row = mysqli_fetch_assoc(
        $resultadoCorreos
    )
) {

    if (!empty($row['email_corporativo'])) {

        $correos[] =
            $row['email_corporativo'];
    }
}

if (empty($correos)) {

    $response["message"] =
        "No se encontraron correos jurídicos";

    echo json_encode($response);

    exit;
}

// =====================================================
// ENVIAR CORREO
// =====================================================

try {

    $mail = new PHPMailer(true);


    $mail->isSMTP();

    $mail->Host = 'smtp.gmail.com';

    $mail->SMTPAuth = true;

    $mail->Username =
        'notificacion@ldrsolutions.com.mx';

    $mail->Password =
        'ppiz zylc bpod tczi';

    $mail->SMTPSecure =
        PHPMailer::ENCRYPTION_STARTTLS;

    $mail->Port = 587;

    $mail->setFrom(
        'notificacion@ldrsolutions.com.mx',
        'LDRenta'
    );

    foreach ($correos as $correo) {

        $mail->addAddress($correo);
    }

    $mail->addBCC(
        'uriel.cabello@ldrsolutions.com.mx'
    );

    $mail->isHTML(true);

    $mail->Subject =
        utf8_decode(
            'Nueva solicitud de contrato unidad RENTA'
        );

    $nombreSolicitante =
        $info['nombre_1'] . ' ' .
        $info['nombre_2'] . ' ' .
        $info['apellido_paterno'] . ' ' .
        $info['apellido_materno'];

    $personaAsignada = '';

    if (!empty($info['id_persona_fisica'])) {

        $personaAsignada =
            $info['pf_nombre_1'] . ' ' .
            $info['pf_nombre_2'] . ' ' .
            $info['pf_apellido_paterno'] . ' ' .
            $info['pf_apellido_materno'];
    } else {

        $personaAsignada =
            $info['organizacion_institucion'];
    }

    $mail->Body = utf8_decode("
        <h2>
            Nueva solicitud de contrato unidad RENTA
        </h2>

        <hr>

        <p>
            <strong>Solicitud:</strong>
            #$id_asignacion_demo
        </p>

        <p>
            <strong>Solicitante:</strong>
            $nombreSolicitante
        </p>

        <p>
            <strong>Persona asignada:</strong>
            $personaAsignada
        </p>

        <p>
            <strong>Unidad:</strong>
            {$info['nombre_marca']}
            {$info['nombre_modelo']}
        </p>

        <p>
            <strong>Placa:</strong>
            {$info['placa']}
        </p>

        <p>
            <strong>Número motor:</strong>
            {$info['numero_motor']}
        </p>

        <p>
            <strong>VIN:</strong>
            {$info['VIN']}
        </p>

        <p>
            <strong>Fecha préstamo:</strong>
            $fecha_prestamo
        </p>

        <p>
            <strong>Fecha devolución:</strong>
            $fecha_devolucion
        </p>

        <p>
            <strong>Objetivo:</strong>
            <br>
            $objetivo
        </p>

        <p>
            <strong>Comentarios:</strong>
            <br>
            $comentarios
        </p>

        <hr>

        <h3>
            Documentos para descarga
        </h3>

        $lista_documentos

        <hr>

        <p>
            Favor de revisar la solicitud
            en la plataforma.
        </p>
    ");

    $mail->send();

    $response["success"] = true;

    $response["message"] =
        "Solicitud registrada correctamente";
} catch (Exception $e) {

    $response["success"] = true;

    $response["message"] =
        "Solicitud registrada, pero el correo falló";
}

// =====================================================
// RESPUESTA FINAL
// =====================================================

ob_clean();

echo json_encode($response);
exit;
