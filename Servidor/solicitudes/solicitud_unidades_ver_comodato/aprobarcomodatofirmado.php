<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../../lib/PHPMailer-master/src/Exception.php';
require '../../lib/PHPMailer-master/src/PHPMailer.php';
require '../../lib/PHPMailer-master/src/SMTP.php';

include("../../../Servidor/conexion.php");

// Depuración inicial
echo "Archivo iniciado<br>";

if (isset($_POST['id_asignaciones']) && isset($_FILES['comodato_archivo_sin_firmar'])) {
    echo "Datos recibidos<br>";

    $idasignacion = $_POST['id_asignaciones'];
    $nombrearchivocomodato = 'comodato_' . basename($_FILES['comodato_archivo_sin_firmar']['name']);
    $rutaarchivocomodato = "../../archivos/files/files_unidades/comodato_firmado_por_usuario/";

    if (move_uploaded_file($_FILES['comodato_archivo_sin_firmar']['tmp_name'], $rutaarchivocomodato . $nombrearchivocomodato)) {
        echo "Archivo movido correctamente<br>";

        $queryaprovarcomodatofirmado = "UPDATE asignacion_unidad_colaborador 
                                        INNER JOIN unidades 
                                        ON asignacion_unidad_colaborador.id_unidad = unidades.id_unidad
                                        SET id_estatus_comodato = 4, 
                                            motivo_rechazo_comodato = ' ',
                                            archivo_comodato_firmado = '$nombrearchivocomodato',
                                            unidades.id_estado_unidad = 3  
                                        WHERE id_asignaciones = '$idasignacion'";

        $ejecutarconsulta = mysqli_query($conexion, $queryaprovarcomodatofirmado);
        if (!$ejecutarconsulta) {
            die("Error en consulta de UPDATE: " . mysqli_error($conexion));
        }

        echo "Consulta UPDATE exitosa<br>";

        // Obtener datos para el primer correo
        $query = "SELECT uni.placa, uni.numero_motor, uni.VIN, mar.nombre_marca, model.nombre_modelo,
                         col.nombre_1, col.nombre_2, col.apellido_paterno, col.apellido_materno, col.id_colaborador
                  FROM asignacion_unidad_colaborador AS asigpdf
                  INNER JOIN colaboradores AS col ON asigpdf.id_colaborador = col.id_colaborador
                  INNER JOIN unidades AS uni ON asigpdf.id_unidad = uni.id_unidad
                  INNER JOIN modelos AS model ON uni.id_modelo = model.id_modelo
                  INNER JOIN marcas AS mar ON model.id_marca = mar.id_marca
                  WHERE asigpdf.id_asignaciones = '$idasignacion'";

        $result = mysqli_query($conexion, $query);
        if (!$result) {
            die("Error en consulta SELECT datos unidad: " . mysqli_error($conexion));
        }
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
        $id_colaborador = $row['id_colaborador'];

        // Obtener correo del colaborador
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
            $mail1->Username = 'dscrgoficial@gmail.com';
            $mail1->Password = 'qvfh ncuc iwci ypgq';
            $mail1->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail1->Port = 587;

            $mail1->setFrom('dscrgoficial@gmail.com', 'Flotilla LDR');
            $mail1->addAddress($correo);
            $mail1->addBCC('uriel.cabello@ldrsolutions.com.mx');

            $mail1->isHTML(true);
            $mail1->Subject = utf8_decode('Notificación de asignación de unidad vehicular');
            $mail1->Body = utf8_decode("Estimado colaborador <strong>$nombre_1 $nombre_2 $apaterno $amaterno</strong>,<br><br>
                            Se te asignó la siguiente unidad:<br>
                            <strong>Marca:</strong> $marca<br>
                            <strong>Modelo:</strong> $modelo<br>
                            <strong>Placa:</strong> $placa<br>
                            <strong>Número de motor:</strong> $numero_motor<br>
                            <strong>VIN:</strong> $VIN<br><br>
                            Acude a oficinas corporativas para la entrega oficial de tu unidad.<br><br>
                            Gracias por tu colaboración.<br><br>
                            Atentamente,<br>
                            <strong>Servicios Generales - Flotilla LDR</strong>");

            if ($mail1->send()) {
                echo "Correo enviado al colaborador.<br>";
            } else {
                echo "Error al enviar correo al colaborador: " . $mail1->ErrorInfo;
            }

        } catch (Exception $e) {
            echo "Excepción al enviar correo: {$mail1->ErrorInfo}<br>";
        }

        echo "Fin de proceso con éxito.<br>";
    } else {
        echo "Error al mover archivo.";
    }
} else {
    echo "No se recibieron los datos correctamente.";
}
