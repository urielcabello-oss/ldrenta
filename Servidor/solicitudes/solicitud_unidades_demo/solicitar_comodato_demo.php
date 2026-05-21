<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION)) {
    session_start();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../lib/PHPMailer-master/src/Exception.php';
require '../../lib/PHPMailer-master/src/PHPMailer.php';
require '../../lib/PHPMailer-master/src/SMTP.php';

include("../../conexion.php");

// =====================================================
// VALIDAR DATOS POST
// =====================================================

if (
    isset($_POST['id_unidad']) &&
    isset($_POST['id_colaborador']) &&
    isset($_POST['fechasolicitudunidademo']) &&
    isset($_POST['fechadevolucionunidademo'])
) {

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

        die("Error INSERT: " .
            mysqli_error($conexion));
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
    // OBTENER CORREOS JURIDICO
    // =====================================================

    $idrol_juridico = 3;

    $queryCorreos = "
        SELECT
            col.email_corporativo
        FROM usuario_rol ur
        INNER JOIN usuarios u
            ON ur.id_usuario = u.id_usuario
        INNER JOIN colaboradores col
            ON u.id_colaborador = col.id_colaborador
        WHERE ur.idrol = '$idrol_juridico'
    ";

    $resultadoCorreos =
        mysqli_query($conexion, $queryCorreos);

    $correos = [];

    while ($row = mysqli_fetch_assoc($resultadoCorreos)) {

        if (!empty($row['email_corporativo'])) {

            $correos[] =
                $row['email_corporativo'];
        }
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
            'PASSWORD';

        $mail->SMTPSecure = 'tls';

        $mail->Port = 587;

        $mail->setFrom(
            'notificacion@ldrsolutions.com.mx',
            'LDRenta'
        );

        foreach ($correos as $correo) {

            $mail->addAddress($correo);
        }

        $mail->isHTML(true);

        $mail->Subject =
            'Nueva solicitud de comodato DEMO';

        $mail->Body = "
            <h2>
                Nueva solicitud de unidad DEMO
            </h2>

            <p>
                ID solicitud:
                <strong>
                    $id_asignacion_demo
                </strong>
            </p>

            <p>
                Fecha préstamo:
                <strong>
                    $fecha_prestamo
                </strong>
            </p>

            <p>
                Fecha devolución:
                <strong>
                    $fecha_devolucion
                </strong>
            </p>

            <p>
                Objetivo:
                <br>
                $objetivo
            </p>

            <p>
                Favor de revisar la solicitud.
            </p>
        ";

        $mail->send();
    } catch (Exception $e) {

        error_log(
            'Error correo DEMO: ' .
                $mail->ErrorInfo
        );
    }

    // =====================================================
    // RESPUESTA FINAL
    // =====================================================

    echo "success";
} else {

    echo "No llegaron datos POST";
}
