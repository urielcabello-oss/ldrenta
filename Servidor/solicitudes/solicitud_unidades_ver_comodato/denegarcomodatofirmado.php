<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../../lib/PHPMailer-master/src/Exception.php';
require '../../lib/PHPMailer-master/src/PHPMailer.php';
require '../../lib/PHPMailer-master/src/SMTP.php';

include("../../../Servidor/conexion.php");

if (isset($_POST['idasignacion']) && isset($_POST['descripciondenegacioncomodato'])) {

    $idasignacion = $_POST['idasignacion'];
    $descripciondenegacion = $_POST['descripciondenegacioncomodato'];

    $query = "UPDATE asignacion_unidad_colaborador 
              SET id_estatus_comodato = 7, 
                  motivo_rechazo_comodato = '$descripciondenegacion' 
              WHERE id_asignaciones = '$idasignacion'";
    $ejecutar = mysqli_query($conexion, $query);

    if ($ejecutar) {
        // Obtener datos de la unidad y colaborador
        $query = "SELECT uni.placa, uni.numero_motor, uni.VIN,
                         mar.nombre_marca, model.nombre_modelo,
                         col.nombre_1, col.nombre_2, col.apellido_paterno, col.apellido_materno,
                         asigpdf.archivo_comodato_sin_firmar
                  FROM asignacion_unidad_colaborador AS asigpdf
                  INNER JOIN colaboradores AS col ON asigpdf.id_colaborador = col.id_colaborador
                  INNER JOIN unidades AS uni ON asigpdf.id_unidad = uni.id_unidad
                  INNER JOIN modelos AS model ON uni.id_modelo = model.id_modelo
                  INNER JOIN marcas AS mar ON model.id_marca = mar.id_marca
                  WHERE asigpdf.id_asignaciones = $idasignacion";

        $result = mysqli_query($conexion, $query);
        $row = mysqli_fetch_assoc($result);

        $nombre_1 = $row['nombre_1'];
        $nombre_2 = $row['nombre_2'];
        $apaterno = $row['apellido_paterno'];
        $amaterno = $row['apellido_materno'];
        $placa = $row['placa'];
        $numero_motor = $row['numero_motor'];
        $VIN = $row['VIN'];
        $marca = $row['nombre_marca'];
        $modelo = $row['nombre_modelo'];
        $nombrearchivocomodato = $row['archivo_comodato_sin_firmar'];
        $rutaarchivocomodato = "../../archivos/files/files_unidades/comodato/";  

        // Obtener correos de usuarios tipo 2
        $correos = [];
        $correo_sql = "SELECT u.id_colaborador, 
                                                u.id_tipo_usuario,
                                                cor.id_colaborador,
                                                cor.email_corporativo
                                        FROM usuarios AS u 
                                        INNER JOIN colaboradores AS cor
                                        ON u.id_colaborador = cor.id_colaborador
                                        WHERE u.id_tipo_usuario = 2";
        $correo_result = $conexion->query($correo_sql);
        while ($correo_row = $correo_result->fetch_assoc()) {
            if (!empty($correo_row['email_corporativo'])) {
                $correos[] = $correo_row['email_corporativo'];
            }
        }

        // Enviar correo
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'dscrgoficial@gmail.com';
            $mail->Password = 'qvfh ncuc iwci ypgq';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('dscrgoficial@gmail.com', 'Flotilla LDR');

            foreach ($correos as $correo) {
                $mail->addAddress($correo);
            }
            $mail->addBCC('uriel.cabello@ldrsolutions.com.mx');

            // Adjuntar archivo si existe
            $ruta_completa = $rutaarchivocomodato . $nombrearchivocomodato;
            if (file_exists($ruta_completa)) {
                $mail->addAttachment($ruta_completa, $nombrearchivocomodato);
            }

            $mail->isHTML(true);
            $mail->Subject = utf8_decode('Notificación de COMODATO - Rechazado');
            $mail->Body = utf8_decode("
                Estimado equipo del área jurídico:<br><br>
                El documento denominado <strong>COMODATO</strong> ha sido <strong>rechazado</strong> para la siguiente unidad vehicular:<br><br>
                <strong>Unidad:</strong> $marca $modelo<br>
                <strong>Placa:</strong> $placa<br>
                <strong>Número de motor:</strong> $numero_motor<br>
                <strong>VIN:</strong> $VIN<br><br>
                Asignado al colaborador: <strong>$nombre_1 $nombre_2 $apaterno $amaterno</strong><br><br>
                <strong>Motivo del rechazo:</strong><br>
                <h3 style='color: red;'>$descripciondenegacion</h3><br><br>
                Se adjunta el documento sin firma para su referencia.<br><br>
                Atentamente,<br><br>
                <strong>Servicios Generales - Flotilla LDR</strong>
            ");

            $mail->send();
            echo "Correo enviado exitosamente con archivo adjunto.<br>";
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}<br>";
        }

    } else {
        echo "Error al actualizar el estado del comodato.";
    }

} else {
    echo "Faltan datos en el formulario.";
}
?>
