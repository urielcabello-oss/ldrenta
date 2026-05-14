<!--Creación del comodato del lado de jurídico-->
<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../../../lib/PHPMailer-master/src/Exception.php';
require '../../../lib/PHPMailer-master/src/PHPMailer.php';
require '../../../lib/PHPMailer-master/src/SMTP.php';

include("../../../conexion.php");
session_start();
$id_creador_comodato = $_SESSION['id_colaborador'];

if (isset($_POST['id_asignaciones']) && isset($_FILES['archivo_subir_comodato'])) {
    echo"entro subir comodato";
    $valor_idasignacion = $_POST['id_asignaciones'];
    $nombrearchivocomodato = 'comodato_externo_' . basename($_FILES['archivo_subir_comodato']['name']);
    $rutaarchivocomodato = "../../../archivos/files/files_unidades/comodato/";

    if (move_uploaded_file($_FILES['archivo_subir_comodato']['tmp_name'], $rutaarchivocomodato . $nombrearchivocomodato)) {
        $sql = "UPDATE asignacion_unidad_colaborador 
                SET id_estatus_comodato = 3,
                id_creador_comodato = $id_creador_comodato,
                fecha_creacion_comodato = NOW(),
                archivo_comodato_sin_firmar = '$nombrearchivocomodato'
                WHERE id_asignaciones = $valor_idasignacion";
        $ejecutar = mysqli_query($conexion, $sql);


        // Obtener datos de la unidad y colaborador
        $query = "SELECT uni.placa, uni.numero_motor, uni.VIN,
                         mar.nombre_marca, model.nombre_modelo,
                         usuexterno.nombre_1, usuexterno.nombre_2, usuexterno.apellido_paterno, usuexterno.apellido_materno,
                         asigpdf.archivo_comodato_sin_firmar
                  FROM asignacion_unidad_colaborador AS asigpdf
                  INNER JOIN usuarios_externos AS usuexterno ON asigpdf.id_usuario_externo = usuexterno.id_usuario_externo
                  INNER JOIN unidades AS uni ON asigpdf.id_unidad = uni.id_unidad
                  INNER JOIN modelos AS model ON uni.id_modelo = model.id_modelo
                  INNER JOIN marcas AS mar ON model.id_marca = mar.id_marca
                  WHERE asigpdf.id_asignaciones = $valor_idasignacion";

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
        $archivo_comodato = $row['archivo_comodato_sin_firmar'];
        $ruta_archivo = $rutaarchivocomodato . $archivo_comodato;

        // Obtener correos de usuarios tipo 1
        $correos = [];
        $correo_sql = "SELECT u.id_colaborador, 
                                                u.id_tipo_usuario,
                                                cor.id_colaborador,
                                                cor.email_corporativo
                                        FROM usuarios AS u 
                                        INNER JOIN colaboradores AS cor
                                        ON u.id_colaborador = cor.id_colaborador
                                        WHERE u.id_tipo_usuario = 1";
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
            $mail->Password = 'qvfh ncuc iwci ypgq'; // Usa una clave de aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('dscrgoficial@gmail.com', 'Flotilla LDR');

            foreach ($correos as $correo) {
                $mail->addAddress($correo);
            }
            $mail->addBCC('uriel.cabello@ldrsolutions.com.mx');

            // Adjuntar archivo si existe
            if (file_exists($ruta_archivo)) {
                $mail->addAttachment($ruta_archivo, $archivo_comodato);
                
            }

            $mail->isHTML(true);
            $mail->Subject = utf8_decode('Notificación de COMODATO');
            $mail->Body = utf8_decode("
                Estimado equipo de Servicios Generales:<br><br>
                Se ha generado el documento denominado <strong>COMODATO</strong> para la asignación externa de la siguiente unidad vehicular:<br><br>
                <strong>Unidad:</strong> $marca $modelo<br>
                <strong>Placa:</strong> $placa<br>
                <strong>Número de motor:</strong> $numero_motor<br>
                <strong>VIN:</strong> $VIN<br><br>
                Asignado al usuario que no forma parte de la empresa: <strong>$nombre_1 $nombre_2 $apaterno $amaterno</strong><br><br>
                En este correo se adjunta el documento sin firma para su revisión.<br><br>
                Gracias por su atención.<br><br>
                Atentamente,<br><br>
                <strong> Jurídico - Flotilla LDR </strong>
            ");

            $mail->send();
            echo "Correo enviado exitosamente con archivo adjunto.<br>";

        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}<br>";
        }

        if ($ejecutar) {
            echo "Unidad actualizada correctamente.";
        } else {
            echo "Error al actualizar la unidad.";
        }

    } else {
        echo "Error al subir el archivo.";
    }

} else {
    echo "Faltan datos en el formulario.";
}
?>
