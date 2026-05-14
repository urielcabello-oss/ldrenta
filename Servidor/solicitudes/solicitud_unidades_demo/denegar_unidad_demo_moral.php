<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//obtenemos el id del colaborador para saber quien es el que esta logeado
if (!isset($_SESSION)) {
    session_start();
}

$colaborador = $_SESSION['id_colaborador'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../../lib/PHPMailer-master/src/Exception.php';
require '../../lib/PHPMailer-master/src/PHPMailer.php';
require '../../lib/PHPMailer-master/src/SMTP.php';

include("../../../Servidor/conexion.php");

if (isset($_POST['id_unidad'])
&& isset($_POST['id_asignacion_demo'])
&& isset($_POST['descripcionegacionunidademofisica'])) {

    $id_unidad = $_POST['id_unidad'];
    $id_asignacion_demo = $_POST['id_asignacion_demo'];
    $descripcionegacionunidademofisica = $_POST['descripcionegacionunidademofisica'];

    echo "Datos recibidos<br>";
    echo "DEBUG: id_asignacion_demo = $id_asignacion_demo<br>";
    echo "DEBUG: id_unidad = $id_unidad<br>";
    echo "DEBUG: descripcionegacionunidademofisica = $descripcionegacionunidademofisica<br>";

    $queryrechazarautorizacion = "UPDATE asignacion_unidad_demo 
                                        INNER JOIN unidades 
                                        ON asignacion_unidad_demo.id_unidad = unidades.id_unidad
                                        SET id_autorizador = $colaborador, 
                                            autorizacion = 'RECHAZADA',
                                            motivo_rechazo_unidad_demo = '$descripcionegacionunidademofisica',
                                            unidades.id_estado_unidad = 1  
                                        WHERE id_asignacion_unidad_demo = '$id_asignacion_demo'";

        $ejecutarconsulta = mysqli_query($conexion, $queryrechazarautorizacion);
        if (!$ejecutarconsulta) {
            die("Error en consulta de UPDATE: " . mysqli_error($conexion));
        }

        echo "Consulta UPDATE exitosa<br>";


 // Obtener datos para enviar el correo al solicitande la de unidad demo
        //sud = solicitante unidad demo
        //aud = asignacion unidad demo
        //pf = persona fisica
        //uni = unidad
        //mar = marca
        //model = modelo
        //caud = colaborador autorizador unidad demo

        $querycorreosolicitandeunidademo = "SELECT uni.placa, 
                            uni.numero_motor, 
                            uni.VIN, 
                            uni.costo_neto,
                            uni.año_unidad,
                            mar.nombre_marca, 
                            model.nombre_modelo,
                            sud.nombre_1, 
                            sud.nombre_2, 
                            sud.apellido_paterno, 
                            sud.apellido_materno, 
                            sud.id_colaborador,
                            pm.organizacion_institucion,
                            aud.objetivo_prestamo,
                            aud.solicitar_master_driver,
                            aud.comentarios,
                            aud.motivo_rechazo_unidad_demo,
                            caud.nombre_1 AS nombre_1_colaborador_autorizador,
                            caud.nombre_2 AS nombre_2_colaborador_autorizador,
                            caud.apellido_paterno AS apellido_paterno_colaborador_autorizador,
                            caud.apellido_materno AS apellido_materno_colaborador_autorizador
                  FROM asignacion_unidad_demo AS aud
                  INNER JOIN colaboradores AS sud 
                    ON aud.id_colaborador_que_asigna = sud.id_colaborador
                  LEFT JOIN personas_morales AS pm 
                    ON aud.id_persona_moral = pm.id_persona_moral
                  INNER JOIN unidades AS uni 
                    ON aud.id_unidad = uni.id_unidad
                  INNER JOIN modelos AS model 
                    ON uni.id_modelo = model.id_modelo
                  INNER JOIN marcas AS mar 
                    ON model.id_marca = mar.id_marca
                  INNER JOIN colaboradores AS caud 
                    ON aud.id_autorizador = caud.id_colaborador
                  WHERE aud.id_asignacion_unidad_demo = '$id_asignacion_demo'";

        $result = mysqli_query($conexion, $querycorreosolicitandeunidademo);
        if (!$result) {
            die("Error en consulta SELECT datos unidad: " . mysqli_error($conexion));
        }
        $row = mysqli_fetch_assoc($result);

        $nombre_1 = $row['nombre_1'];
        $nombre_2 = $row['nombre_2'];
        $apaterno = $row['apellido_paterno'];
        $amaterno = $row['apellido_materno'];
        $organizacion_institucion = $row['organizacion_institucion'];
        $placa = $row['placa'];
        $numero_motor = $row['numero_motor'];
        $VIN = $row['VIN'];
        $marca = $row['nombre_marca'];
        $modelo = $row['nombre_modelo'];
        $costo_neto = $row['costo_neto'];
        $año_unidad = $row['año_unidad'];
        $motivo_rechazo_unidad_demo = $row['motivo_rechazo_unidad_demo'];
        $id_colaborador = $row['id_colaborador'];
        $objetivo_prestamo = $row['objetivo_prestamo'];
        $solicitar_master_driver = $row['solicitar_master_driver'];
        $comentarios = $row['comentarios'];
        $nombre_1_colaborador_autorizador = $row['nombre_1_colaborador_autorizador'];
        $nombre_2_colaborador_autorizador = $row['nombre_2_colaborador_autorizador'];
        $apellido_paterno_colaborador_autorizador = $row['apellido_paterno_colaborador_autorizador'];
        $apellido_materno_colaborador_autorizador = $row['apellido_materno_colaborador_autorizador'];


        // Obtener correo del colaborador que esta solicitando la unidad demo
         $correo_query = "SELECT email_corporativo FROM colaboradores WHERE id_colaborador ='$id_colaborador'";
         $correo_result = mysqli_query($conexion, $correo_query);
         if (!$correo_result) {
             die("Error en consulta SELECT correo colaborador: " . mysqli_error($conexion));
         }
        $correo_row = mysqli_fetch_assoc($correo_result);
        $correo = $correo_row['email_corporativo'];
        //$correo = "uriel.cabello@ldrsolutions.com.mx";

        // Enviar correo al colaborador
        try {
            $mail1 = new PHPMailer();
            $mail1->isSMTP();
            $mail1->Host = 'smtp.gmail.com';
            $mail1->SMTPAuth = true;
            $mail1->Username = 'notificacion@ldrsolutions.com.mx';
            $mail1->Password = 'ppiz zylc bpod tczi';
            $mail1->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail1->Port = 587;

            $mail1->setFrom('notificacion@ldrsolutions.com.mx', 'Flotilla LDR');
            $mail1->addAddress($correo);
            $mail1->addBCC('uriel.cabello@ldrsolutions.com.mx');

            $mail1->isHTML(true);
            $mail1->Subject = utf8_decode('Notificación de rechazo de unidad vehicular DEMO');
$mail1->Body = utf8_decode("
    <p>Estimado colaborador <strong>$nombre_1 $nombre_2 $apaterno $amaterno</strong>,</p>

    <p>Te informamos que la unidad vehicular <strong>DEMO</strong> que solicitaste para la siguiente organización/institución: $organizacion_institucion</p>

    <p>Ha sido <strong>rechazada</strong> por el siguiente motivo:</p>

    <p>$motivo_rechazo_unidad_demo</p>
    
    <p>Autorizador: $nombre_1_colaborador_autorizador $nombre_2_colaborador_autorizador $apellido_paterno_colaborador_autorizador $apellido_materno_colaborador_autorizador</p><br>
    
    <p>Información de la unidad:</p>

    <table style='border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px;'>
        <tr><td style='padding: 6px;'><strong>Marca:</strong></td><td style='padding: 6px;'>$marca</td></tr>
        <tr><td style='padding: 6px;'><strong>Modelo:</strong></td><td style='padding: 6px;'>$modelo</td></tr>
        <tr><td style='padding: 6px;'><strong>Placa:</strong></td><td style='padding: 6px;'>$placa</td></tr>
        <tr><td style='padding: 6px;'><strong>Número de motor:</strong></td><td style='padding: 6px;'>$numero_motor</td></tr>
        <tr><td style='padding: 6px;'><strong>VIN:</strong></td><td style='padding: 6px;'>$VIN</td></tr>
    </table>

    <p>Si es necesario volver a solicitar la unidad o seleccionar la correcta, puedes hacerlo desde la plataforma.</p>

    <p>Atentamente,<br>
    <strong>Flotilla - LDR</strong></p>

    <p><strong>Acceso a la plataforma:</strong><br>
    <a href='https://ldrhsys.ldrhumanresources.com/default.php'>https://ldrhsys.ldrhumanresources.com/default.php</a></p>
");

            if ($mail1->send()) {
                echo "Correo enviado al colaborador.<br>";
            } else {
                echo "Error al enviar correo al colaborador: " . $mail1->ErrorInfo;
            }

        } catch (Exception $e) {
            echo "Excepción al enviar correo: {$mail1->ErrorInfo}<br>";
        }

        if ($ejecutarconsulta) {
            echo "Unidad actualizada correctamente.";
        } else {
            echo "Error al actualizar la unidad.";
        }

        echo "Fin de proceso con éxito.<br>";
    } else {
    echo "No se recibieron los datos correctamente.";
}

?>