<?php

error_reporting(0);
ini_set('display_errors', 0);
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../lib/PHPMailer-master/src/Exception.php';
require '../../lib/PHPMailer-master/src/PHPMailer.php';
require '../../lib/PHPMailer-master/src/SMTP.php';

include("../../conexion.php");

header('Content-Type: application/json');

if (
    isset($_POST['id_unidad']) &&
    isset($_POST['destino']) &&
    isset($_POST['motivo'])
) {

    $id_unidad = mysqli_real_escape_string($conexion, $_POST['id_unidad']);
    $destino   = mysqli_real_escape_string($conexion, $_POST['destino']);
    $motivo    = mysqli_real_escape_string($conexion, $_POST['motivo']);
    $origen    = mysqli_real_escape_string($conexion, $_POST['origen'] ?? '');

    $id_colaborador = $_SESSION['id_colaborador'];

    /*------------------------------------------------*/
    /* INSERTAR SOLICITUD */
    /*------------------------------------------------*/

    $sql = "INSERT INTO solicitudes_traslado_unidades
            (id_unidad, ubicacion_origen, ubicacion_destino, motivo, fecha_solicitud, estatus)
            VALUES
            ('$id_unidad','$origen','$destino','$motivo',NOW(),'PENDIENTE')";

    if (!mysqli_query($conexion, $sql)) {
        echo json_encode([
            "status" => false,
            "msg" => "Error al registrar la solicitud"
        ]);
        exit;
    }

    /*------------------------------------------------*/
    /* OBTENER INFORMACIÓN DE LA UNIDAD */
    /*------------------------------------------------*/

    $queryUnidad = "SELECT 
    uni.id_unidad,
    uni.placa,
    uni.vin,
    uni.numero_motor,
    mar.nombre_marca,
    model.nombre_modelo
FROM unidades AS uni
INNER JOIN modelos AS model ON uni.id_modelo = model.id_modelo
INNER JOIN marcas AS mar ON model.id_marca = mar.id_marca
WHERE uni.id_unidad = '$id_unidad'";


    $resultadoUnidad = mysqli_query($conexion, $queryUnidad);

    if (!$resultadoUnidad) {
        echo json_encode([
            "status" => false,
            "msg" => mysqli_error($conexion),
            "query" => $queryUnidad
        ]);
        exit;
    }

    $unidad = mysqli_fetch_assoc($resultadoUnidad);

    $marca  = $unidad['nombre_marca'];
    $modelo = $unidad['nombre_modelo'];
    $placa  = $unidad['placa'];
    $vin    = $unidad['vin'];
    $motor  = $unidad['numero_motor'];

    /*------------------------------------------------*/
    /* OBTENER NOMBRE DEL SOLICITANTE */
    /*------------------------------------------------*/

    $sqlColab = "SELECT 
        nombre_1,nombre_2,apellido_paterno,apellido_materno
        FROM colaboradores
        WHERE id_colaborador = '$id_colaborador'";

    $resColab = mysqli_query($conexion, $sqlColab);
    $colab = mysqli_fetch_assoc($resColab);

    $solicitante = trim(
        $colab['nombre_1'] . " " .
            $colab['nombre_2'] . " " .
            $colab['apellido_paterno'] . " " .
            $colab['apellido_materno']
    );

    /*------------------------------------------------*/
    /* OBTENER CORREOS DE LOGISTICA */
    /*------------------------------------------------*/

    $correos = [];

    $correo_sql = "SELECT cor.email_corporativo
                   FROM usuarios u
                   INNER JOIN usuario_modulo_tipo umt 
                        ON umt.id_usuario = u.id_usuario
                   INNER JOIN colaboradores cor 
                        ON cor.id_colaborador = u.id_colaborador
                   WHERE umt.id_tipo_usuario = 4
                   AND umt.id_modulo = 2";

    $correo_result = $conexion->query($correo_sql);

    while ($row = $correo_result->fetch_assoc()) {
        if (!empty($row['email_corporativo'])) {
            $correos[] = $row['email_corporativo'];
        }
    }

    if (empty($correos)) {
        echo json_encode([
            "status" => true,
            "msg" => "Solicitud registrada pero no hay correos de notificación"
        ]);
        exit;
    }

    /*------------------------------------------------*/
    /* ENVIAR CORREO */
    /*------------------------------------------------*/

    try {

        $mail = new PHPMailer(true);

        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'notificacion@ldrsolutions.com.mx';
        $mail->Password = 'ppiz zylc bpod tczi';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('notificacion@ldrsolutions.com.mx', 'Flotilla LDR');

        foreach ($correos as $correo) {
            $mail->addAddress($correo);
        }

        $mail->addCC('geraldine.angulo@ldrsolutions.com'); // copia visible
        $mail->addBCC('uriel.cabello@ldrsolutions.com.mx'); // copia oculta

        $mail->isHTML(true);
        $mail->Subject = 'Nueva solicitud de traslado de unidad';

        $mail->Body = "

        <p>Estimado colaboradores,</p>

        <p>Se ha registrado una <strong style='color:#b20000;'>SOLICITUD DE TRASLADO DE UNIDAD</strong> dentro del sistema <strong>Flotilla LDR</strong>.</p>

        <h3>Información de la unidad</h3>

        <table style='border-collapse: collapse; font-family: Arial; font-size:14px;'>

        <tr>
        <td><strong>Marca / Modelo:</strong></td>
        <td>$marca $modelo</td>
        </tr>

        <tr>
        <td><strong>Placa:</strong></td>
        <td>$placa</td>
        </tr>

        <tr>
        <td><strong>VIN:</strong></td>
        <td>$vin</td>
        </tr>

        <tr>
        <td><strong>Número de motor:</strong></td>
        <td>$motor</td>
        </tr>

        </table>

        <br>

        <h3>Información del traslado</h3>

        <table style='border-collapse: collapse; font-family: Arial; font-size:14px;'>

        <tr>
        <td><strong>Ubicación actual:</strong></td>
        <td>$origen</td>
        </tr>

        <tr>
        <td><strong>Nueva ubicación:</strong></td>
        <td>$destino</td>
        </tr>

        <tr>
        <td><strong>Motivo:</strong></td>
        <td>$motivo</td>
        </tr>

        </table>

        <br>

        <p><strong>Solicitante del traslado:</strong><br>
        $solicitante</p>

        <hr>

        <p><strong>Acceso:</strong><br>
        <a href='https://ldrhsys.ldrhumanresources.com/default.php'>
        https://ldrhsys.ldrhumanresources.com/default.php
        </a></p>

        <br>

        <p>Atentamente,<br>
        <strong>Sistema Flotilla LDR</strong></p>

        ";

        $mail->send();
    } catch (Exception $e) {
        error_log("Error enviando correo traslado: " . $mail->ErrorInfo);
    }

    echo json_encode([
        "status" => true,
        "msg" => "Solicitud registrada correctamente"
    ]);
} else {

    echo json_encode([
        "status" => false,
        "msg" => "Parámetros faltantes"
    ]);
}
