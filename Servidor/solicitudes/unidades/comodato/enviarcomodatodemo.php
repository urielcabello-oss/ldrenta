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

if (isset($_FILES['archivo_subir_comodato'])
    && isset($_POST['id_unidad'])
    && isset($_POST['id_colaborador_que_asigna'])
    && isset($_POST['id_asignacion_unidad_demo'])) {

    echo"entro subir comodato";

    $valor_idasignacion = $_POST['id_asignacion_unidad_demo'];
    $valor_idunidad = $_POST['id_unidad'];
    $valor_colaborador = $_POST['id_colaborador_que_asigna'];

    $nombrearchivocomodato = 'comodato_demo_' . basename($_FILES['archivo_subir_comodato']['name']);
    $rutaarchivocomodato = "../../../archivos/files/files_unidades/comodato_demos/";

    if (move_uploaded_file($_FILES['archivo_subir_comodato']['tmp_name'], $rutaarchivocomodato . $nombrearchivocomodato)) {
        $sql = "UPDATE asignacion_unidad_demo 
                SET id_estatus_comodato_demo = 3,
                id_creador_comodato_demo = $id_creador_comodato,
                fecha_creacion_comodato = NOW(),
                archivo_comodato_sin_firmar = '$nombrearchivocomodato'
                WHERE id_asignacion_unidad_demo = $valor_idasignacion";
                
                // guardar la placa en la tabla unidades
             // guardar la placa en la tabla unidades y quien la capturó
                if (isset($_POST['nueva_placa_demo']) && !empty(trim($_POST['nueva_placa_demo']))) {
                    $nueva_placa_demo = mysqli_real_escape_string($conexion, trim($_POST['nueva_placa_demo']));

                    // actualizar placa en tabla unidades
                    mysqli_query($conexion, "UPDATE unidades SET placa = '$nueva_placa_demo' WHERE id_unidad = $valor_idunidad");

                    // registrar quién capturó la placa
                    mysqli_query($conexion, "UPDATE asignacion_unidad_demo SET id_usuario_captura_placa = $id_creador_comodato WHERE id_asignacion_unidad_demo = $valor_idasignacion");
                }
        $ejecutar = mysqli_query($conexion, $sql);


        // Obtener datos de la unidad y colaborador
        $query = "SELECT uni.placa, 
                         uni.numero_motor, 
                         uni.VIN,
                         mar.nombre_marca, 
                         model.nombre_modelo,
                         col.nombre_1, 
                         col.nombre_2, 
                         col.apellido_paterno, 
                         col.apellido_materno,
                         cap.nombre_1 AS nombre1_capturador,
                        cap.nombre_2 AS nombre2_capturador,
                        cap.apellido_paterno AS apellido_paterno_capturador,
                        cap.apellido_materno AS apellido_materno_capturador,
                         asigpdf.archivo_comodato_sin_firmar,
                         asigpdf.fecha_prestamo,
                         asigpdf.fecha_devolucion,
                         pf.nombre_1 as nombre1_persona_fisica, 
                         pf.nombre_2 as nombre2_persona_fisica, 
                         pf.apellido_paterno as apellido_paterno_persona_fisica, 
                         pf.apellido_materno as apellido_materno_persona_fisica,
                         pm.organizacion_institucion
                  FROM asignacion_unidad_demo AS asigpdf
                  INNER JOIN colaboradores AS col ON asigpdf.id_colaborador_que_asigna = col.id_colaborador
                  LEFT JOIN colaboradores AS cap ON asigpdf.id_usuario_captura_placa = cap.id_colaborador
                  INNER JOIN unidades AS uni ON asigpdf.id_unidad = uni.id_unidad
                  INNER JOIN modelos AS model ON uni.id_modelo = model.id_modelo
                  INNER JOIN marcas AS mar ON model.id_marca = mar.id_marca
                  LEFT JOIN personas_fisicas AS pf ON asigpdf.id_persona_fisica = pf.id_persona_fisica
                  LEFT JOIN personas_morales AS pm ON asigpdf.id_persona_moral = pm.id_persona_moral
                  WHERE asigpdf.id_asignacion_unidad_demo = $valor_idasignacion";

        $result = mysqli_query($conexion, $query);
        $row = mysqli_fetch_assoc($result);

        $nombre_1 = $row['nombre_1'];
        $nombre_2 = $row['nombre_2'];
        $apaterno = $row['apellido_paterno'];
        $amaterno = $row['apellido_materno'];
        $nombre_1_persona_fisica = $row['nombre1_persona_fisica'];
        $nombre_2_persona_fisica = $row['nombre2_persona_fisica'];
        $apaterno_persona_fisica = $row['apellido_paterno_persona_fisica'];
        $amaterno_persona_fisica = $row['apellido_materno_persona_fisica'];
        $organizacion_institucion = $row['organizacion_institucion'];
        $placa = $row['placa'];
        $numero_motor = $row['numero_motor'];
        $VIN = $row['VIN'];
        $marca = $row['nombre_marca'];
        $modelo = $row['nombre_modelo'];
        $fecha_prestamo = $row['fecha_prestamo'];
        $fecha_devolucion = $row['fecha_devolucion'];
        $archivo_comodato = $row['archivo_comodato_sin_firmar'];
        $ruta_archivo = $rutaarchivocomodato . $archivo_comodato;
        $nombre_capturador = trim(
        $row['nombre1_capturador'] . ' ' .
        $row['nombre2_capturador'] . ' ' .
        $row['apellido_paterno_capturador'] . ' ' .
        $row['apellido_materno_capturador']
        );

        //------------------------------------------ Envío del archivo PDF por correo con PHPMailer -----------------------------------------

                        $correo = "SELECT u.email_corporativo, u.id_colaborador
                                FROM colaboradores AS u
                                WHERE u.id_colaborador = $valor_colaborador";
                        $result = $conectar->query($correo);
                        $row = $result->fetch_assoc();
                        $correo = $row['email_corporativo'];
                        //$correo = "uriel.cabello@ldrsolutions.com.mx";

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
            $mail->addAddress($correo);
            $mail->addBCC('uriel.cabello@ldrsolutions.com.mx');

            // Adjuntar archivo si existe
            if (file_exists($ruta_archivo)) {
                $mail->addAttachment($ruta_archivo, $archivo_comodato);
                
            }

            $mail->isHTML(true);
            $mail->Subject = utf8_decode('Notificación de COMODATO UNIDAD DEMO');
            $mail->Body = utf8_decode("
                <p>Estimado colaborador <strong>$nombre_1 $nombre_2 $apaterno $amaterno</strong>,</p>

                <p>Se ha generado el documento denominado <strong>COMODATO</strong> para la siguiente unidad vehicular:</p>

                <table style='border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px;'>
                    <tr><td style='padding: 6px;'><strong>Unidad:</strong></td><td style='padding: 6px;'>$marca $modelo</td></tr>
                    <tr><td style='padding: 6px;'><strong>Placa capturada por:</strong></td><td style='padding: 6px;'>$nombre_capturador</td></tr>
                    <tr><td style='padding: 6px;'><strong>Placa:</strong></td><td style='padding: 6px;'>$placa</td></tr>
                    <tr><td style='padding: 6px;'><strong>Número de motor:</strong></td><td style='padding: 6px;'>$numero_motor</td></tr>
                    <tr><td style='padding: 6px;'><strong>VIN:</strong></td><td style='padding: 6px;'>$VIN</td></tr>
                    <tr><td style='padding: 6px;'><strong>Fecha de prestamo:</strong></td><td style='padding: 6px;'>$fecha_prestamo</td></tr>
                    <tr><td style='padding: 6px;'><strong>Fecha de devolución:</strong></td><td style='padding: 6px;'>$fecha_devolucion</td></tr>
                </table>

                <br>

                <p><strong>Usuario / Institución:</strong><br>
                $nombre_1_persona_fisica $nombre_2_persona_fisica $apaterno_persona_fisica $amaterno_persona_fisica $organizacion_institucion</p>

                <p>En este correo se adjunta el documento <strong>sin firma</strong> para su revisión.</p>

                <p>Gracias por su atención.</p>

                <p>Atentamente,<br>
                <strong>Jurídico - Flotilla LDR</strong></p>
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
