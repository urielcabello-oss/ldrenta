<?php 
// mandamos un correo al usuario notificándole que debe presentarse a servicios generales para firmar el comodato
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../../lib/PHPMailer-master/src/Exception.php';
require '../../lib/PHPMailer-master/src/PHPMailer.php';
require '../../lib/PHPMailer-master/src/SMTP.php';

include("../../../Servidor/conexion.php");

$valorcolaboradorasignacion = 0;

if (isset($_POST['idasignacion'])) {    
    $valorcolaboradorasignacion = mysqli_real_escape_string($conexion, $_POST['idasignacion']);

    // obtener la información y el correo del usuario
    $queryinformacioncolaborador = "SELECT auc.id_asignaciones,
                                            auc.id_unidad,
                                            auc.id_colaborador,
                                            colab.nombre_1,
                                            colab.nombre_2,
                                            colab.apellido_paterno,
                                            colab.apellido_materno,
                                            colab.email_corporativo,
                                            mar.nombre_marca,
                                            model.nombre_modelo,
                                            uni.id_unidad,
                                            uni.placa,
                                            uni.numero_motor,
                                            uni.VIN
                                    FROM asignacion_unidad_colaborador AS auc
                                    INNER JOIN colaboradores AS colab ON auc.id_colaborador = colab.id_colaborador
                                    INNER JOIN unidades AS uni ON auc.id_unidad = uni.id_unidad
                                    INNER JOIN modelos AS model ON uni.id_modelo = model.id_modelo
                                    INNER JOIN marcas AS mar ON model.id_marca = mar.id_marca
                                    WHERE auc.id_asignaciones = '$valorcolaboradorasignacion'";

    $resultado = $conexion->query($queryinformacioncolaborador);

    if ($resultado && $data = mysqli_fetch_array($resultado)) {
        $id_asignaciones = $data['id_asignaciones'];
        $nombre_1 = $data['nombre_1'];
        $nombre_2 = $data['nombre_2'];
        $apaterno = $data['apellido_paterno'];
        $amaterno = $data['apellido_materno'];
        $marca = $data['nombre_marca'];
        $modelo = $data['nombre_modelo'];
        $id_unidad = $data['id_unidad'];
        $placa = $data['placa'];
        $numero_motor = $data['numero_motor'];
        $VIN = $data['VIN'];

        // Consulta para obtener el correo
        $correo_sql = "SELECT email_corporativo
               FROM colaboradores
               WHERE id_colaborador = '{$data['id_colaborador']}'";

        
        $result_correo = $conexion->query($correo_sql);
        
        if ($result_correo && $row = $result_correo->fetch_assoc()) {
            $correo = $row['email_corporativo'];

            // Configurar y enviar correo
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'dscrgoficial@gmail.com';
            $mail->Password = 'qvfh ncuc iwci ypgq'; // Asegúrate de proteger esta contraseña
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('dscrgoficial@gmail.com', 'Flotilla LDR');
            $mail->addAddress($correo);
            $mail->addBCC('uriel.cabello@ldrsolutions.com.mx');

            $mail->isHTML(true);
            $mail->Subject = utf8_decode('Notificación de asignación de unidad vehicular');
            $mail->Body = utf8_decode("
                Estimado colaborador <strong>$nombre_1 $nombre_2 $apaterno $amaterno.</strong><br><br>
                Te enviamos este correo solicitándote tu presencia en el área de servicios generales para que verifiques y firmes el documento denominado <strong>COMODATO</strong> para realizar la asignación de la siguiente unidad.<br><br>
                <strong>Marca:</strong> $marca<br>
                <strong>Modelo:</strong> $modelo<br>
                <strong>Placa:</strong> $placa<br>
                <strong>Número de motor:</strong> $numero_motor<br>
                <strong>VIN:</strong> $VIN<br><br>
                ¡Es de suma importancia que verifiques que tus datos estén correctos para poder adquirir la unidad!<br><br>
                Gracias por tu atención.<br><br>
                Atentamente,<br><br>
                <strong>Servicios Generales - Flotilla LDR</strong>
            ");

            if (!$mail->send()) {
                echo "Error al enviar el correo: " . $mail->ErrorInfo;
            } else {
                echo "Correo enviado exitosamente.";
            }
        } else {
            echo "Error: No se encontró el correo del colaborador.";
        }
    } else {
        echo "Error: No se encontró información del colaborador para la asignación.";
    }
}
?>
