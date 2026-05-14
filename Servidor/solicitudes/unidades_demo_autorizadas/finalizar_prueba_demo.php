<?php 
//actualizamos en la base de datos el estatus de la unidad para finalizar la prueba y enviar correo a telematics para solicitar la baja de la unidad

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../../lib/PHPMailer-master/src/Exception.php';
require '../../lib/PHPMailer-master/src/PHPMailer.php';
require '../../lib/PHPMailer-master/src/SMTP.php';

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

if(isset($_POST['id_asignacion'])){

    $id_asignacion = $_POST['id_asignacion'];

    $query = "UPDATE asignacion_unidad_demo SET id_estado_prueba_demo = 5
                WHERE id_asignacion_unidad_demo = '$id_asignacion'";
    $result = mysqli_query($conexion, $query);
    
    if($result){
    echo "Prueba finalizada ccorrectamente";

    $querinfobajaunidad = "SELECT 
                                aud.id_asignacion_unidad_demo,
                                un.id_unidad,
                                un.id_modelo,
                                un.placa,
                                un.vin,
                                un.numero_motor,
                                model.nombre_modelo,
                                marc.nombre_marca
                            FROM asignacion_unidad_demo AS aud
                            INNER JOIN unidades AS un
                                ON aud.id_unidad = un.id_unidad
                            INNER JOIN modelos AS model
                                ON un.id_modelo = model.id_modelo
                            INNER JOIN marcas AS marc
                                ON model.id_marca = marc.id_marca
                            WHERE aud.id_asignacion_unidad_demo = '$id_asignacion'";

    $resultinfobajaunidad = mysqli_query($conexion, $querinfobajaunidad);

    if($resultinfobajaunidad){
        $data = mysqli_fetch_array($resultinfobajaunidad);

        $id_asignacion_unidad_demo = $data['id_asignacion_unidad_demo'];
        $id_unidad = $data['id_unidad'];
        $placa = $data['placa'];
        $vin = $data['vin'];
        $numero_motor = $data['numero_motor'];
        $marca = $data['nombre_marca'];
        $modelo = $data['nombre_modelo'];
    }

    // Obtener correos...
    $correos = [];
    $correo_sql = "SELECT u.id_colaborador, 
                          u.id_tipo_usuario,
                          cor.id_colaborador,
                          cor.email_corporativo
                   FROM usuarios AS u 
                   INNER JOIN colaboradores AS cor
                   ON u.id_colaborador = cor.id_colaborador
                   WHERE u.id_tipo_usuario = 12";
    $correo_result = $conexion->query($correo_sql);
    while ($correo_row = $correo_result->fetch_assoc()) {
        if (!empty($correo_row['email_corporativo'])) {
            $correos[] = $correo_row['email_corporativo'];
        }
    }

    foreach ($correos as $correo) {
        echo "Correo: $correo <br>";
    }

    // Enviar correo
    try {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'notificacion@ldrsolutions.com.mx';
        $mail->Password = 'ppiz zylc bpod tczi';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('dscrgoficial@gmail.com', 'Flotilla LDR');
        foreach ($correos as $correo) {
            $mail->addAddress($correo);
        }
        $mail->addBCC('uriel.cabello@ldrsolutions.com.mx');

        $mail->isHTML(true);
                                $mail->Subject = utf8_decode('Baja de unidad DEMO'); // Asunto del correo
                                $mail->Body = utf8_decode("
    <div style='font-family: Arial, sans-serif; font-size: 14px; color: #333;'>
        <p>Estimado colaborador,</p>

        <p>
            Te enviamos este correo para solicitar la <strong style='color: #b20000;'>BAJA</strong> de información de la siguiente unidad vehicular <strong>DEMO</strong>:
        </p>

        <table style='border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px; margin-top: 10px;'>
            <tr>
                <td style='padding: 6px;'><strong>Marca / Modelo:</strong></td>
                <td style='padding: 6px;'>$marca $modelo</td>
            </tr>
            <tr>
                <td style='padding: 6px;'><strong>Placa:</strong></td>
                <td style='padding: 6px;'>$placa</td>
            </tr>
            <tr>
                <td style='padding: 6px;'><strong>Número de motor:</strong></td>
                <td style='padding: 6px;'>$numero_motor</td>
            </tr>
            <tr>
                <td style='padding: 6px;'><strong>VIN:</strong></td>
                <td style='padding: 6px;'>$vin</td>
            </tr>
        </table>

        <p style='margin-top: 20px;'>Gracias por tu atención.</p>

        <p>
            Atentamente,<br>
            <strong>Comercial - Flotilla LDR</strong>
        </p>

        <p>
            <strong>Acceso a la plataforma:</strong><br>
            <a href='https://ldrhsys.ldrhumanresources.com/default.php' style='color: #1a73e8; text-decoration: none;'>
                https://ldrhsys.ldrhumanresources.com/default.php
            </a>
        </p>
    </div>");

                                if ($mail->send()) {
                                    echo "Correo enviado exitosamente.";
                                } else {
                                    echo "Error al enviar el correo: " . $mail->ErrorInfo;
                                }
                            } catch (Exception $e) {
                                echo "Error al enviar el correo: {$mail->ErrorInfo}<br>";
                            }
                        }
                    } else {
                        echo "Error al enviar el correo: " . $mail->ErrorInfo;
                    }

                    echo "Correo enviado exitosamente.";

?>