<?php 

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

//-----------------------------------------------------------Inicia el flujo para insertar el reporte de la prueba final demo
if (isset($_POST['id_asignacion_unidad_demo'])
&& isset($_FILES['reporte_final'])) {
    
    $valorid_asignacion_unidad_demo = $_POST['id_asignacion_unidad_demo'];
    $valor_reporte_final = $_FILES['reporte_final'];
    $valor_comentarios_finales = $_POST['comentarios_finales'];

    echo "id_asignacion_unidad_demo: " . $valorid_asignacion_unidad_demo . " ";
    echo "reporte_final: " . $_FILES['reporte_final']['name'] . " ";
    echo "comentarios_finales: " . $valor_comentarios_finales . " ";

    $nombre_reporte_final = 'reporte_final_' . $valorid_asignacion_unidad_demo . '_' . basename($_FILES['reporte_final']['name']);

    $ruta_reporte_final = "../../archivos/files/files_asignacion_demo/pruebas_unidades_demo/reportes_finales/";

    move_uploaded_file($_FILES['reporte_final']['tmp_name'], $ruta_reporte_final . $nombre_reporte_final);

    //actualizamos la asignacion para insertar su reporte final
    $querysubirreportefinal = "UPDATE asignacion_unidad_demo SET reporte_final_prueba = '$nombre_reporte_final', 
                                                                    comentarios_finales = '$valor_comentarios_finales', 
                                                                    id_colaborador_sube_reporte_final = '$colaborador' ,
                                                                    id_estado_prueba_demo = 4
                                                            WHERE id_asignacion_unidad_demo = '$valorid_asignacion_unidad_demo'";

    $resultadoreporte = $conexion->query($querysubirreportefinal);
    if ($resultadoreporte) {
        echo "Reporte final insertado correctamente";
    } else {
        echo "Error al insertar reporte final: " . $conexion->error;
    }
    
        // Obtener datos para enviar el correo al solicitande la de unidad demo para notificar que se termino la prueba y si requiere prorroga
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
                            pf.id_persona_fisica,
                            pf.nombre_1 AS nombre_1_persona_fisica,
                            pf.nombre_2 AS nombre_2_persona_fisica,
                            pf.apellido_paterno AS apellido_paterno_persona_fisica,
                            pf.apellido_materno AS apellido_materno_persona_fisica,
                            pf.archivo_ine,
                            pf.curp,
                            pf.archivo_curp,
                            pf.rfc,
                            pf.archivo_rfc,
                            pf.domicilio,
                            pf.archivo_domicilio,
                            pm.organizacion_institucion,
                            aud.objetivo_prestamo,
                            aud.solicitar_master_driver,
                            aud.comentarios,
                            aud.fecha_prestamo,
                            aud.fecha_devolucion,
                            caud.nombre_1 AS nombre_1_colaborador_autorizador,
                            caud.nombre_2 AS nombre_2_colaborador_autorizador,
                            caud.apellido_paterno AS apellido_paterno_colaborador_autorizador,
                            caud.apellido_materno AS apellido_materno_colaborador_autorizador
                  FROM asignacion_unidad_demo AS aud
                  INNER JOIN colaboradores AS sud 
                    ON aud.id_colaborador_que_asigna = sud.id_colaborador
                  LEFT JOIN personas_fisicas AS pf ON aud.id_persona_fisica = pf.id_persona_fisica
                  LEFT JOIN personas_morales AS pm ON aud.id_persona_moral = pm.id_persona_moral
                  INNER JOIN unidades AS uni 
                    ON aud.id_unidad = uni.id_unidad
                  INNER JOIN modelos AS model 
                    ON uni.id_modelo = model.id_modelo
                  INNER JOIN marcas AS mar 
                    ON model.id_marca = mar.id_marca
                  INNER JOIN colaboradores AS caud 
                    ON aud.id_autorizador = caud.id_colaborador
                  WHERE aud.id_asignacion_unidad_demo = '$valorid_asignacion_unidad_demo'";

        $result = mysqli_query($conexion, $querycorreosolicitandeunidademo);
        if (!$result) {
            die("Error en consulta SELECT datos unidad: " . mysqli_error($conexion));
        }
        $row = mysqli_fetch_assoc($result);
        if (!$row) {
            die("No se obtuvieron resultados. Verifica si el id de asignación es válido y que haya datos asociados.");
        }

        echo "<pre>";
        print_r($row);
        echo "</pre>";

            //datos de las personas fisicas o morales
        $nombre_cliente = '';
        if (!empty($row['id_persona_fisica'])) {
            $nombre_cliente = $row['nombre_1_persona_fisica'] . ' ' . 
                            $row['nombre_2_persona_fisica'] . ' ' . 
                            $row['apellido_paterno_persona_fisica'] . ' ' . 
                            $row['apellido_materno_persona_fisica'];
        } elseif (!empty($row['organizacion_institucion'])) {
            $nombre_cliente = $row['organizacion_institucion'];
        }


        $nombre_1 = $row['nombre_1'];
        $nombre_2 = $row['nombre_2'];
        $apaterno = $row['apellido_paterno'];
        $amaterno = $row['apellido_materno'];
        $nombre_1_persona_fisica = $row['nombre_1_persona_fisica'];
        $nombre_2_persona_fisica = $row['nombre_2_persona_fisica'];
        $apellido_paterno_persona_fisica = $row['apellido_paterno_persona_fisica'];
        $apellido_materno_persona_fisica = $row['apellido_materno_persona_fisica'];
        $archivo_ine = $row['archivo_ine'];
        $curp = $row['curp'];
        $archivo_curp = $row['archivo_curp'];
        $rfc = $row['rfc'];
        $archivo_rfc = $row['archivo_rfc'];
        $domicilio = $row['domicilio'];
        $archivo_domicilio = $row['archivo_domicilio'];
        $placa = $row['placa'];
        $numero_motor = $row['numero_motor'];
        $VIN = $row['VIN'];
        $marca = $row['nombre_marca'];
        $modelo = $row['nombre_modelo'];
        $costo_neto = $row['costo_neto'];
        $año_unidad = $row['año_unidad'];
        $fecha_prestamo = $row['fecha_prestamo'];
        $fecha_devolucion = $row['fecha_devolucion'];
        $id_colaborador = $row['id_colaborador'];
        $objetivo_prestamo = $row['objetivo_prestamo'];
        $solicitar_master_driver = $row['solicitar_master_driver'];
        $comentarios = $row['comentarios'];
        $nombre_1_colaborador_autorizador = $row['nombre_1_colaborador_autorizador'];
        $nombre_2_colaborador_autorizador = $row['nombre_2_colaborador_autorizador'];
        $apellido_paterno_colaborador_autorizador = $row['apellido_paterno_colaborador_autorizador'];
        $apellido_materno_colaborador_autorizador = $row['apellido_materno_colaborador_autorizador'];

        //rutas de los archivos
        $ruta_archivo_ine = "../../../Servidor/archivos/files/files_asignacion_demo/personas_fisicas/files_ines/" . $archivo_ine;
        echo "ID colaborador que solicita correo: $id_colaborador<br>";
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
            $mail1->Subject = utf8_decode('Notificación finalización Prueba Demo');
$mail1->Body = utf8_decode("
    <p>Estimado colaborador <strong>$nombre_1 $nombre_2 $apaterno $amaterno</strong>,</p>

    <p>Te informamos que la unidad vehicular <strong>DEMO</strong> que solicitaste para el cliente 
    <strong>$nombre_cliente</strong> ha finalizado la prueba con el Master Driver y se ha subido su reporte final.</p>

    <table style='border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px; margin-top: 10px;'>
        <tr><td style='padding: 6px;'><strong>Marca:</strong></td><td style='padding: 6px;'>$marca</td></tr>
        <tr><td style='padding: 6px;'><strong>Modelo:</strong></td><td style='padding: 6px;'>$modelo</td></tr>
        <tr><td style='padding: 6px;'><strong>Placa:</strong></td><td style='padding: 6px;'>$placa</td></tr>
        <tr><td style='padding: 6px;'><strong>Número de motor:</strong></td><td style='padding: 6px;'>$numero_motor</td></tr>
        <tr><td style='padding: 6px;'><strong>VIN:</strong></td><td style='padding: 6px;'>$VIN</td></tr>
        <tr><td style='padding: 6px;'><strong>Fecha prestamo:</strong></td><td style='padding: 6px;'>$fecha_prestamo</td></tr>
        <tr><td style='padding: 6px;'><strong>Fecha devolución:</strong></td><td style='padding: 6px;'>$fecha_devolucion</td></tr>
    </table>

    <br>

    <p>En caso de requerir una <strong>prórroga</strong> de la unidad, te sugerimos que la solicites desde la plataforma <strong>Flotilla - LDR</strong>.</p>

    <p><strong>Pasos para solicitar la prórroga de la unidad:</strong></p>
    <ol style='font-family: Arial, sans-serif; font-size: 14px; padding-left: 20px;'>
        <li>Accede a la plataforma <strong>Flotilla - LDR</strong> desde la intranet.</li>
        <li>En el menú, selecciona la opción <strong>Asignaciones</strong>.</li>
        <li>Haz clic en el botón <strong>Solicitar prórroga</strong> de la unidad correspondiente.</li>
        <li>Completa el formulario con la nueva fecha de entrega y el motivo de la prórroga.</li>
        <li>Haz clic en <strong>Solicitar prórroga</strong> para enviar tu solicitud.</li>
    </ol>

    <br>

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

}
?>