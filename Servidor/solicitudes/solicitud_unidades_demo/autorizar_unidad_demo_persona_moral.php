<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION)) {
    session_start();
}

$colaborador = $_SESSION['id_colaborador'];

// PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../lib/PHPMailer-master/src/Exception.php';
require '../../lib/PHPMailer-master/src/PHPMailer.php';
require '../../lib/PHPMailer-master/src/SMTP.php';

include("../../../Servidor/conexion.php");

if (isset($_POST['id_unidad'], $_POST['id_asignacion_demo'], $_POST['id_persona_moral'])) {

    $id_asignacion_demo = $_POST['id_asignacion_demo'];
    $id_unidad = $_POST['id_unidad'];
    $id_persona_moral = $_POST['id_persona_moral'];

    echo "Datos recibidos<br>";

    // Actualizar asignación y estado de unidad
    $queryautorizarunidademo = "UPDATE asignacion_unidad_demo 
        INNER JOIN unidades ON asignacion_unidad_demo.id_unidad = unidades.id_unidad
        SET id_autorizador = $colaborador, 
            autorizacion = 'APROVADO',
            unidades.id_estado_unidad = 3
        WHERE id_asignacion_unidad_demo = '$id_asignacion_demo'";

    if (!mysqli_query($conexion, $queryautorizarunidademo)) {
        die("Error en consulta de UPDATE: " . mysqli_error($conexion));
    }
    echo "Consulta UPDATE exitosa<br>";

    // Obtener datos y archivos de la unidad y persona moral
    $query = "SELECT 
                    uni.placa, 
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
                    pm.id_persona_moral, 
                    pm.organizacion_institucion, 
                    pm.archivo_identificacion_representante_legal,
                    pm.archivo_poder_representante_legal, 
                    pm.rfc_moral, 
                    pm.archivo_rfc_moral, 
                    pm.domicilio,
                    pm.archivo_domiclio_moral, 
                    pm.domicilio_resguardo_unidad,
                    pm.archivo_domicilio_resguardo_unidad,
                    aes.id_archivo_escritura_constitutiva,
                    aes.nombre_archivo AS archivo_escritura,
                    aesoc.id_archivos_escritura_estatus_social,
                    aesoc.nombre_archivo_estatus_sociales AS archivo_estatuto,
                    aud.objetivo_prestamo, 
                    aud.solicitar_master_driver, 
                    aud.solicitar_emplacamiento_ldr,
                    aud.solicitar_seguro_ldr,
                    aud.comentarios,
                    aud.fecha_prestamo, 
                    aud.fecha_devolucion,
                    caud.nombre_1 AS nombre_1_colaborador_autorizador,
                    caud.nombre_2 AS nombre_2_colaborador_autorizador,
                    caud.apellido_paterno AS apellido_paterno_colaborador_autorizador,
                    caud.apellido_materno AS apellido_materno_colaborador_autorizador,
                    area.nombre_area, 
                    puesto.nombre_puesto
                FROM asignacion_unidad_demo AS aud
                INNER JOIN colaboradores AS sud 
                    ON aud.id_colaborador_que_asigna = sud.id_colaborador
                INNER JOIN areas AS area 
                    ON sud.id_area = area.id_area
                INNER JOIN puestos AS puesto 
                    ON sud.id_puesto = puesto.id_puesto
                INNER JOIN personas_morales AS pm 
                    ON aud.id_persona_moral = pm.id_persona_moral
                LEFT JOIN archivos_escritura_constitutiva AS aes 
                    ON pm.id_persona_moral = aes.id_persona_moral
                LEFT JOIN archivos_escritura_estatus_sociales AS aesoc 
                    ON pm.id_persona_moral = aesoc.id_persona_moral
                INNER JOIN unidades AS uni 
                    ON aud.id_unidad = uni.id_unidad
                INNER JOIN modelos AS model 
                    ON uni.id_modelo = model.id_modelo
                INNER JOIN marcas AS mar 
                    ON model.id_marca = mar.id_marca
                INNER JOIN colaboradores AS caud 
                    ON aud.id_autorizador = caud.id_colaborador
                WHERE aud.id_asignacion_unidad_demo = '$id_asignacion_demo'
                ORDER BY aes.id_archivo_escritura_constitutiva ASC, aesoc.id_archivos_escritura_estatus_social ASC
                ";


    $result = mysqli_query($conexion, $query);
    if (!$result) {
        die("Error en consulta SELECT datos unidad: " . mysqli_error($conexion));
    }
    $row = mysqli_fetch_assoc($result);

    // Datos del solicitante y unidad
    $nombre_1 = $row['nombre_1'];
    $nombre_2 = $row['nombre_2'];
    $apaterno = $row['apellido_paterno'];
    $amaterno = $row['apellido_materno'];
    $area = $row['nombre_area'];
    $puesto = $row['nombre_puesto'];
    $organizacion_institucion = $row['organizacion_institucion'];
    $placa = $row['placa'];
    $numero_motor = $row['numero_motor'];
    $VIN = $row['VIN'];
    $marca = $row['nombre_marca'];
    $modelo = $row['nombre_modelo'];
    $costo_neto = $row['costo_neto'];
    $año_unidad = $row['año_unidad'];
    $id_colaborador = $row['id_colaborador'];
    $rfc_moral = $row['rfc_moral'];
    $domicilio = $row['domicilio'];
    $domicilio_resguardo_unidad = $row['domicilio_resguardo_unidad'];
    $solicitar_master_driver = $row['solicitar_master_driver'];
    $solicitar_emplacamiento_ldr = $row['solicitar_emplacamiento_ldr'];
    $solicitar_seguro_ldr = $row['solicitar_seguro_ldr'];
    $objetivo_prestamo = $row['objetivo_prestamo'];
    $fecha_prestamo = $row['fecha_prestamo'];
    $fecha_devolucion = $row['fecha_devolucion'];
    $nombre_1_colaborador_autorizador = $row['nombre_1_colaborador_autorizador'];
    $nombre_2_colaborador_autorizador = $row['nombre_2_colaborador_autorizador'];
    $apellido_paterno_colaborador_autorizador = $row['apellido_paterno_colaborador_autorizador'];
    $apellido_materno_colaborador_autorizador = $row['apellido_materno_colaborador_autorizador'];

    //cadena para ver si requiere master driver y mandarlo por correo
    $requiere_master_driver = ($solicitar_master_driver == 1) ? 'SI REQUIERE MASTER DRIVER' : 'NO REQUIERE MASTER DRIVER';
    $requiere_emplacamiento_ldr = ($solicitar_emplacamiento_ldr == 1) ? 'SI REQUIERE EMPLACAMIENTO' : 'NO REQUIERE EMPLACAMIENTO';
    $requiere_seguro_ldr = ($solicitar_seguro_ldr == 1) ? 'SI REQUIERE SEGURO' : 'NO REQUIERE SEGURO';

    // Carpeta base de archivos en el servidor
    $base_url = "https://ldrflotillainterna.ldrhumanresources.com/Servidor/archivos/files/files_asignacion_demo/personas_morales/";

    // Construimos lista de enlaces principales
    $enlaces = [
        "Identificación representante legal" => $base_url . "files_id/" . $row['archivo_identificacion_representante_legal'],
        "Poder representante legal" => $base_url . "files_poder/" . $row['archivo_poder_representante_legal'],
        "RFC moral" => $base_url . "files_RFC/" . $row['archivo_rfc_moral'],
        "Comprobante domicilio" => $base_url . "files_domicilio/" . $row['archivo_domiclio_moral'],
        "Comprobante domicilio resguardo unidad" => $base_url . "files_domicilioresguardounidad/" . $row['archivo_domicilio_resguardo_unidad']
    ];

    // Agregamos archivos de escrituras
    $query_archivos = "SELECT nombre_archivo FROM archivos_escritura_constitutiva WHERE id_persona_moral = '$id_persona_moral'";
    $res_archivos = mysqli_query($conexion, $query_archivos);
    while ($fila_archivo = mysqli_fetch_assoc($res_archivos)) {
        $enlaces["Escritura constitutiva - " . $fila_archivo['nombre_archivo']] = $base_url . "files_escrituraconstitutiva/" . $fila_archivo['nombre_archivo'];
    }

    // Agregamos archivos de estatutos
    $query_estatutos = "SELECT nombre_archivo_estatus_sociales FROM archivos_escritura_estatus_sociales WHERE id_persona_moral = '$id_persona_moral'";
    $res_estatutos = mysqli_query($conexion, $query_estatutos);
    while ($fila_estatuto = mysqli_fetch_assoc($res_estatutos)) {
        $enlaces["Estatuto social - " . $fila_estatuto['nombre_archivo_estatus_sociales']] = $base_url . "files_estatusociales/" . $fila_estatuto['nombre_archivo_estatus_sociales'];
    }

    // Generar lista HTML de enlaces
    $lista_enlaces = "<ul>";
    foreach ($enlaces as $nombre => $url) {
        if (!empty($url)) {
            $lista_enlaces .= "<li><a href='$url' target='_blank'>$nombre</a></li>";
        }
    }
    $lista_enlaces .= "</ul>";

    //enviar correo al colaborador
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
        $mail1->Subject = utf8_decode('Notificación de unidad DEMO autorizada');
        $mail1->Body = utf8_decode("
    <p>Estimado colaborador <strong>$nombre_1 $nombre_2 $apaterno $amaterno</strong>,</p>

    <p>Te informamos que la unidad vehicular <strong>DEMO</strong> que solicitaste para la empresa o institución:</p>

    <p><strong>$organizacion_institucion</strong></p>

    <p>Ha sido <strong>autorizada</strong> por: <strong>$nombre_1_colaborador_autorizador $nombre_2_colaborador_autorizador $apellido_paterno_colaborador_autorizador $apellido_materno_colaborador_autorizador</strong></p>

    <p><strong>Detalles de la unidad asignada:</strong></p>
    <table style='border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px;'>
        <tr><td style='padding: 6px;'><strong>Marca:</strong></td><td style='padding: 6px;'>$marca</td></tr>
        <tr><td style='padding: 6px;'><strong>Modelo:</strong></td><td style='padding: 6px;'>$modelo</td></tr>
        <tr><td style='padding: 6px;'><strong>Placa:</strong></td><td style='padding: 6px;'>$placa</td></tr>
        <tr><td style='padding: 6px;'><strong>Número de motor:</strong></td><td style='padding: 6px;'>$numero_motor</td></tr>
        <tr><td style='padding: 6px;'><strong>VIN:</strong></td><td style='padding: 6px;'>$VIN</td></tr>
        <tr><td style='padding: 6px;'><strong>Fecha préstamo:</strong></td><td style='padding: 6px;'>$fecha_prestamo</td></tr>
        <tr><td style='padding: 6px;'><strong>Fecha devolución:</strong></td><td style='padding: 6px;'>$fecha_devolucion</td></tr>
    </table>

    <p><strong>Objetivo del préstamo:</strong> $objetivo_prestamo</p>
    <p><strong>¿Requiere Master Driver?:</strong> <strong style='color: #b20000;'>$requiere_master_driver</strong><br>
    <strong>¿LDR emplaca?:</strong> <strong style='color: #b20000;'>$requiere_emplacamiento_ldr</strong><br>
    <strong>¿LDR asegura?:</strong><strong style='color: #b20000;'> $requiere_seguro_ldr</strong></p>

    <p>En este momento se está enviando la información y los documentos correspondientes al área jurídica para la elaboración del contrato de <strong>COMODATO</strong>.</p>

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

    //enviamos correo a juridico con la informacion de la unidad cuando se autoriza por parte del usuario
    // Obtener correos de usuarios tipo 2 juridicos
    $correos = [];
    $correo_sql = "SELECT cor.email_corporativo
               FROM usuarios u
               INNER JOIN usuario_modulo_tipo umt 
                    ON umt.id_usuario = u.id_usuario
               INNER JOIN colaboradores cor 
                    ON cor.id_colaborador = u.id_colaborador
               WHERE umt.id_tipo_usuario = 2
               AND umt.id_modulo = 2";
    $correo_result = $conexion->query($correo_sql);
    while ($correo_row = $correo_result->fetch_assoc()) {
        if (!empty($correo_row['email_corporativo'])) {
            $correos[] = $correo_row['email_corporativo'];
        }
    }

    //$correos = ["uriel.cabello@ldrsolutions.com.mx"];

    foreach ($correos as $correo) {
        echo "Correo: $correo <br>";
    }
    $ejecutarconsulta = mysqli_query($conexion, $queryautorizarunidademo);

    try {
        $mail = new PHPMailer();
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
        $mail->addBCC('uriel.cabello@ldrsolutions.com.mx'); // Copia oculta

        $mail->isHTML(true);
        $mail->Subject = utf8_decode('Solicitud COMODATO para asignación unidad DEMO');
        $mail->Body = utf8_decode("
    <p>Estimado colaborador del área jurídica,</p>

    <p>Por medio del presente, solicitamos la elaboración del <strong>COMODATO</strong> correspondiente a la asignación de la siguiente unidad vehicular <strong>DEMO</strong>:</p>

    <table style='border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px;'>
        <tr><td style='padding: 6px;'><strong>Marca / Modelo:</strong></td><td style='padding: 6px;'>$marca $modelo</td></tr>
        <tr><td style='padding: 6px;'><strong>Placa:</strong></td><td style='padding: 6px;'>$placa</td></tr>
        <tr><td style='padding: 6px;'><strong>Número de motor:</strong></td><td style='padding: 6px;'>$numero_motor</td></tr>
        <tr><td style='padding: 6px;'><strong>VIN:</strong></td><td style='padding: 6px;'>$VIN</td></tr>
        <tr><td style='padding: 6px;'><strong>Costo neto:</strong></td><td style='padding: 6px;'>$costo_neto</td></tr>
        <tr><td style='padding: 6px;'><strong>Año de la unidad:</strong></td><td style='padding: 6px;'>$año_unidad</td></tr>
        <tr><td style='padding: 6px;'><strong>Fecha préstamo:</strong></td><td style='padding: 6px;'>$fecha_prestamo</td></tr>
        <tr><td style='padding: 6px;'><strong>Fecha devolución:</strong></td><td style='padding: 6px;'>$fecha_devolucion</td></tr>
    </table>

    <p><strong>Documentos disponibles para descarga:</strong></p>
    $lista_enlaces

    <hr>

     <p><strong>Autorizado por: $nombre_1_colaborador_autorizador $nombre_2_colaborador_autorizador $apellido_paterno_colaborador_autorizador $apellido_materno_colaborador_autorizador</strong></p>

        <p><strong>Solicitante: $nombre_1 $nombre_2 $apaterno $amaterno</strong><br>
        <strong>Área:</strong> $area<br>
        <strong>Puesto:</strong> $puesto</p>

    <><strong>Datos de la persona Moral:</strong><br>
    <strong>Nombre:</strong> $organizacion_institucion<br>
    <strong>RFC:</strong> $rfc_moral<br>
    <strong>Domicilio:</strong> $domicilio<br>
    <strong>Domicilio de resguardo de la unidad:</strong> $domicilio_resguardo_unidad</p>

    <p><strong>¿Requiere Master Driver?:</strong> <strong style='color: #b20000;'>$requiere_master_driver</strong><br>
    <strong>¿LDR emplaca?:</strong> <strong style='color: #b20000;'>$requiere_emplacamiento_ldr</strong><br>
    <strong>¿LDR asegura?:</strong> <strong style='color: #b20000;'>$requiere_seguro_ldr</strong></p>

    <hr style='margin: 20px 0;'>

    <p>Una vez elaborado el contrato de <strong>COMODATO</strong>, por favor súbelo a la plataforma <strong>Flotilla LDR</strong> siguiendo estos pasos:</p>

    <ol>
        <li>Ingresa a la plataforma desde la <strong>INTRANET</strong>.</li>
        <li>Dirígete al menú <strong>COMODATOS DEMOS</strong>.</li>
        <li>Selecciona la persona moral correspondiente y haz clic en <strong>SUBIR-COMODATO</strong>.</li>
        <li>Adjunta el documento generado.</li>
    </ol>

    <p style='color: #b20000;'><strong>¡Es de suma importancia verificar cuidadosamente la información del comodatario!</strong></p>

    <p>Gracias por tu atención.</p>

    <p>Atentamente,<br>
    <strong>Comercial - Flotilla LDR</strong></p>

    <p><strong>Acceso a la plataforma:</strong><br>
    <a href='https://ldrhsys.ldrhumanresources.com/default.php'>https://ldrhsys.ldrhumanresources.com/default.php</a></p>
");

        if ($mail->send()) {
            echo "Correo enviado al área jurídica.<br>";
        } else {
            echo "Error al enviar correo jurídico: " . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo "Excepción al enviar correo jurídico: {$mail->ErrorInfo}<br>";
    }


    //enviamos correo a ADMINISTRADOR PRUEBAS DEMO (Abraham)

    // Obtener correos de usuarios tipo 11 administrador pruebas demos
    $correosadminpruebademo = [];
    $correo_sql = "SELECT cor.email_corporativo
               FROM usuarios u
               INNER JOIN usuario_modulo_tipo umt 
                    ON umt.id_usuario = u.id_usuario
               INNER JOIN colaboradores cor 
                    ON cor.id_colaborador = u.id_colaborador
               WHERE umt.id_tipo_usuario = 11
               AND umt.id_modulo = 2";
    $correo_result = $conexion->query($correo_sql);
    $correo_result = $conexion->query($correo_sql);
    while ($correo_row = $correo_result->fetch_assoc()) {
        if (!empty($correo_row['email_corporativo'])) {
            $correosadminpruebademo[] = $correo_row['email_corporativo'];
        }
    }

    //$correosadminpruebademo = ["uriel.cabello@ldrsolutions.com.mx"];

    foreach ($correosadminpruebademo as $correo) {
        echo "Correo: $correo <br>";
    }
    $ejecutarconsulta = mysqli_query($conexion, $queryautorizarunidademo);

    try {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'notificacion@ldrsolutions.com.mx';
        $mail->Password = 'ppiz zylc bpod tczi';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('notificacion@ldrsolutions.com.mx', 'Flotilla LDR');
        foreach ($correosadminpruebademo as $correo) {
            $mail->addAddress($correo);
        }
        $mail->addBCC('uriel.cabello@ldrsolutions.com.mx'); // Copia oculta

        $mail->isHTML(true);
        $mail->Subject = utf8_decode('Autorización de unidad DEMO');
        $mail->Body = utf8_decode("
    <p>Estimado colaborador,</p>

    <p>Te notificamos que ha sido <strong>autorizada</strong> la asignación de la siguiente unidad vehicular <strong>DEMO</strong> por parte de:</p>

    <p><strong>$nombre_1_colaborador_autorizador $nombre_2_colaborador_autorizador $apellido_paterno_colaborador_autorizador $apellido_materno_colaborador_autorizador</strong></p>

    <p><strong>Detalles de la unidad asignada:</strong></p>
    <table style='border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px;'>
        <tr><td style='padding: 6px;'><strong>Marca / Modelo:</strong></td><td style='padding: 6px;'>$marca $modelo</td></tr>
        <tr><td style='padding: 6px;'><strong>Placa:</strong></td><td style='padding: 6px;'>$placa</td></tr>
        <tr><td style='padding: 6px;'><strong>Número de motor:</strong></td><td style='padding: 6px;'>$numero_motor</td></tr>
        <tr><td style='padding: 6px;'><strong>VIN:</strong></td><td style='padding: 6px;'>$VIN</td></tr>
        <tr><td style='padding: 6px;'><strong>Costo neto:</strong></td><td style='padding: 6px;'>$costo_neto</td></tr>
        <tr><td style='padding: 6px;'><strong>Año de la unidad:</strong></td><td style='padding: 6px;'>$año_unidad</td></tr>
        <tr><td style='padding: 6px;'><strong>Fecha préstamo:</strong></td><td style='padding: 6px;'>$fecha_prestamo</td></tr>
        <tr><td style='padding: 6px;'><strong>Fecha devolución:</strong></td><td style='padding: 6px;'>$fecha_devolucion</td></tr>
    </table>

    <br>

    <p><strong>Solicitante: $nombre_1 $nombre_2 $apaterno $amaterno</strong><br>
        <strong>Área:</strong> $area<br>
        <strong>Puesto:</strong> $puesto</p>

    <p><strong>Empresa o institución:</strong> $organizacion_institucion</p>
    <p><strong>Objetivo del préstamo:</strong> $objetivo_prestamo<p>

    <p><strong>¿Requiere Master Driver?:</strong> <strong style='color: #b20000;'>$requiere_master_driver</strong><br>
    <strong>¿LDR emplaca?:</strong> <strong style='color: #b20000;'>$requiere_emplacamiento_ldr</strong><br>
    <strong>¿LDR asegura?:</strong> <strong style='color: #b20000;'>$requiere_seguro_ldr</strong></p>

    <p>Gracias por tu atención.</p>

    <p>Atentamente,<br>
    <strong>Flotilla - LDR</strong></p>

    <p><strong>Acceso a la plataforma:</strong><br>
    <a href='https://ldrhsys.ldrhumanresources.com/default.php'>https://ldrhsys.ldrhumanresources.com/default.php</a></p>
");


        if ($mail->send()) {
            echo "Correo enviado exitosamente.";
        } else {
            echo "Error al enviar el correo: " . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}<br>";
    }


    //enviamos correo a telematics para que habiliten la unidad

    // Obtener correos de usuarios tipo 12 telematics
    $correostelematics = [];
    $correo_sql = "SELECT cor.email_corporativo
               FROM usuarios u
               INNER JOIN usuario_modulo_tipo umt 
                    ON umt.id_usuario = u.id_usuario
               INNER JOIN colaboradores cor 
                    ON cor.id_colaborador = u.id_colaborador
               WHERE umt.id_tipo_usuario = 12
               AND umt.id_modulo = 2";
    $correo_result = $conexion->query($correo_sql);
    $correo_result = $conexion->query($correo_sql);
    while ($correo_row = $correo_result->fetch_assoc()) {
        if (!empty($correo_row['email_corporativo'])) {
            $correostelematics[] = $correo_row['email_corporativo'];
        }
    }

    //$correostelematics = ["uriel.cabello@ldrsolutions.com.mx"];

    foreach ($correostelematics as $correo) {
        echo "Correo: $correo <br>";
    }
    $ejecutarconsulta = mysqli_query($conexion, $queryautorizarunidademo);
    try {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'notificacion@ldrsolutions.com.mx';
        $mail->Password = 'ppiz zylc bpod tczi';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('notificacion@ldrsolutions.com.mx', 'Flotilla LDR');
        foreach ($correostelematics as $correo) {
            $mail->addAddress($correo);
        }
        $mail->addBCC('uriel.cabello@ldrsolutions.com.mx'); // Copia oculta

        $mail->isHTML(true);
        $mail->Subject = utf8_decode('Alta de unidad DEMO');
        $mail->Body = utf8_decode("
    <p>Estimado colaborador,</p>

    <p>Por medio del presente te solicitamos el alta de la unidad <strong>DEMO</strong> autorizada por parte del siguiente colaborador:</p>

    <p style='margin-left: 20px;'><strong>$nombre_1_colaborador_autorizador $nombre_2_colaborador_autorizador $apellido_paterno_colaborador_autorizador $apellido_materno_colaborador_autorizador</strong></p>

    <p><strong>Detalles de la unidad asignada:</strong></p>
    <table style='border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px; margin-top: 10px;'>
        <tr><td style='padding: 6px;'><strong>Marca / Modelo:</strong></td><td style='padding: 6px;'>$marca $modelo</td></tr>
        <tr><td style='padding: 6px;'><strong>Placa:</strong></td><td style='padding: 6px;'>$placa</td></tr>
        <tr><td style='padding: 6px;'><strong>Número de motor:</strong></td><td style='padding: 6px;'>$numero_motor</td></tr>
        <tr><td style='padding: 6px;'><strong>VIN:</strong></td><td style='padding: 6px;'>$VIN</td></tr>
        <tr><td style='padding: 6px;'><strong>Costo neto:</strong></td><td style='padding: 6px;'>$costo_neto</td></tr>
        <tr><td style='padding: 6px;'><strong>Año de la unidad:</strong></td><td style='padding: 6px;'>$año_unidad</td></tr>
        <tr><td style='padding: 6px;'><strong>Fecha préstamo:</strong></td><td style='padding: 6px;'>$fecha_prestamo</td></tr>
        <tr><td style='padding: 6px;'><strong>Fecha devolución:</strong></td><td style='padding: 6px;'>$fecha_devolucion</td></tr>
    </table>

    <br>

    <p style='color: #b20000; font-weight: bold;'>Es muy importante que se realice el alta de esta unidad para que comience el monitoreo correspondiente.</p>

    <p>Gracias por tu atención.</p>

    <p>Atentamente,<br>
    <strong>Flotilla - LDR</strong></p>

    <p><strong>Acceso a la plataforma:</strong><br>
    <a href='https://ldrhsys.ldrhumanresources.com/default.php'>https://ldrhsys.ldrhumanresources.com/default.php</a></p>
");


        if ($mail->send()) {
            echo "Correo enviado exitosamente.";
        } else {
            echo "Error al enviar el correo: " . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}<br>";
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
