<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../lib/PHPMailer-master/src/Exception.php';
require '../../lib/PHPMailer-master/src/PHPMailer.php';
require '../../lib/PHPMailer-master/src/SMTP.php';

include("../../conexion.php");

// Validar POST
if (
    isset($_POST['id_unidad']) &&
    isset($_POST['id_asignacion_demo'])
) {
    $id_unidad = mysqli_real_escape_string($conexion, $_POST['id_unidad']);
    $id_asignacion_demo = mysqli_real_escape_string($conexion, $_POST['id_asignacion_demo']);
    $id_persona_fisica = !empty($_POST['id_persona_fisica']) && $_POST['id_persona_fisica'] !== 'null'
        ? mysqli_real_escape_string($conexion, $_POST['id_persona_fisica']) : null;
    $id_persona_moral = !empty($_POST['id_persona_moral']) && $_POST['id_persona_moral'] !== 'null'
        ? mysqli_real_escape_string($conexion, $_POST['id_persona_moral']) : null;

    // 🔹 Actualizar autorización del jefe directo
    $update = "UPDATE asignacion_unidad_demo 
               SET autorizacion = 'AUTORIZADO JEFE DIRECTO'
               WHERE id_asignacion_unidad_demo = '$id_asignacion_demo'";
    if (!mysqli_query($conexion, $update)) {
        die("❌ Error al actualizar autorización: " . mysqli_error($conexion));
    }

    // 🔹 Consultar datos de la solicitud y la unidad
    $query = "SELECT 
                asig.id_asignacion_unidad_demo,
                asig.fecha_prestamo,
                asig.fecha_devolucion,
                asig.objetivo_prestamo,
                asig.solicitar_master_driver,
                asig.solicitar_emplacamiento_ldr,
                asig.solicitar_seguro_ldr,
                pf.nombre_1, pf.nombre_2, pf.apellido_paterno, pf.apellido_materno,
                pm.organizacion_institucion,
                mar.nombre_marca,
                model.nombre_modelo,
                uni.placa,
                uni.numero_motor,
                uni.vin,
                uni.costo_neto,
                uni.año_unidad,
                col.nombre_1 AS nombre_1_colab,
                col.nombre_2 AS nombre_2_colab,
                col.apellido_paterno AS ap_colab,
                col.apellido_materno AS am_colab,
                area.nombre_area,
                puesto.nombre_puesto
            FROM asignacion_unidad_demo AS asig
            INNER JOIN unidades AS uni ON asig.id_unidad = uni.id_unidad
            INNER JOIN modelos AS model ON uni.id_modelo = model.id_modelo
            INNER JOIN marcas AS mar ON model.id_marca = mar.id_marca
            INNER JOIN colaboradores AS col ON asig.id_colaborador_que_asigna = col.id_colaborador
            INNER JOIN areas AS area ON col.id_area = area.id_area
            INNER JOIN puestos AS puesto ON col.id_puesto = puesto.id_puesto
            LEFT JOIN personas_fisicas AS pf ON asig.id_persona_fisica = pf.id_persona_fisica
            LEFT JOIN personas_morales AS pm ON asig.id_persona_moral = pm.id_persona_moral
            WHERE asig.id_asignacion_unidad_demo = '$id_asignacion_demo'";

    $resultado = mysqli_query($conexion, $query);
    if (!$resultado || mysqli_num_rows($resultado) === 0) {
        die("❌ No se encontraron datos de la asignación.");
    }
    $data = mysqli_fetch_assoc($resultado);

    // Variables
    $marca = $data['nombre_marca'];
    $modelo = $data['nombre_modelo'];
    $placa = $data['placa'];
    $numero_motor = $data['numero_motor'];
    $VIN = $data['vin'];
    $costo_neto = $data['costo_neto'];
    $anio_unidad = $data['año_unidad'];
    $fecha_prestamo = $data['fecha_prestamo'];
    $fecha_devolucion = $data['fecha_devolucion'];
    $objetivo_prestamo = $data['objetivo_prestamo'];
    $solicitar_master_driver = $data['solicitar_master_driver'];
    $solicitar_emplacamiento_ldr = $data['solicitar_emplacamiento_ldr'];
    $solicitar_seguro_ldr = $data['solicitar_seguro_ldr'];
    $organizacion = $data['organizacion_institucion'];

    $usuario_prestamo = trim($data['nombre_1'] . " " . $data['nombre_2'] . " " . $data['apellido_paterno'] . " " . $data['apellido_materno']);
    $solicitante = trim($data['nombre_1_colab'] . " " . $data['nombre_2_colab'] . " " . $data['ap_colab'] . " " . $data['am_colab']);
    $area = $data['nombre_area'];
    $puesto = $data['nombre_puesto'];

    //cadena para ver si requiere master driver y mandarlo por correo
    $requiere_master_driver = ($solicitar_master_driver == 1) ? 'SI REQUIERE MASTER DRIVER' : 'NO REQUIERE MASTER DRIVER';
    $requiere_emplacamiento_ldr = ($solicitar_emplacamiento_ldr == 1) ? 'SI REQUIERE EMPLACAMIENTO' : 'NO REQUIERE EMPLACAMIENTO';
    $resuiere_seguro_ldr = ($solicitar_seguro_ldr == 1) ? 'SI REQUIERE SEGURO' : 'NO REQUIERE SEGURO';

    // 1. Obtener jefe directo de la sesión
    $id_jefe_directo = $_SESSION['id_colaborador'] ?? null;
    $nombre_jefe_directo = "";

    // 2. Consultar su nombre
    if ($id_jefe_directo) {
        $sql_jefe = "SELECT nombre_1, nombre_2, apellido_paterno, apellido_materno 
                 FROM colaboradores 
                 WHERE id_colaborador = '$id_jefe_directo'";
        $res_jefe = $conexion->query($sql_jefe);
        if ($res_jefe && $res_jefe->num_rows > 0) {
            $row_jefe = $res_jefe->fetch_assoc();
            $nombre_jefe_directo = trim($row_jefe['nombre_1'] . ' ' . $row_jefe['nombre_2'] . ' ' .
                $row_jefe['apellido_paterno'] . ' ' . $row_jefe['apellido_materno']);
        }
    }


    // 🔹 Obtener correos de usuarios tipo 7
    $correos = [];
    $correo_sql = "SELECT cor.email_corporativo
               FROM usuarios u
               INNER JOIN usuario_modulo_tipo umt 
                    ON umt.id_usuario = u.id_usuario
               INNER JOIN colaboradores cor 
                    ON cor.id_colaborador = u.id_colaborador
               WHERE umt.id_tipo_usuario = 7
               AND umt.id_modulo = 2";
    $correo_result = $conexion->query($correo_sql);
    while ($row = $correo_result->fetch_assoc()) {
        if (!empty($row['email_corporativo'])) {
            $correos[] = $row['email_corporativo'];
        }
    }

    if (empty($correos)) {
        die("❌ No se encontraron correos de autorizadores.");
    }

    // 🔹 Enviar correo
    try {
        $mail = new PHPMailer(true);
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
        $mail->addBCC('uriel.cabello@ldrsolutions.com.mx'); // copia oculta

        $mail->isHTML(true);
        $mail->Subject = utf8_decode('Autorización de jefe directo para unidad DEMO');
        $mail->Body = utf8_decode("
            <p>Estimados autorizadores,</p>
            <p>El jefe directo <strong>$nombre_jefe_directo</strong> ha <span style='color:green;'>AUTORIZADO</span> la solicitud de la unidad DEMO, ahora  se requiere de su autorización final para continuar con la asignación del vehículo.</p>
            <p>Información de la unidad:</p>
            <table style='border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px;'>
                <tr><td><strong>Marca / Modelo:</strong></td><td>$marca $modelo</td></tr>
                <tr><td><strong>Placa:</strong></td><td>$placa</td></tr>
                <tr><td><strong>Número de motor:</strong></td><td>$numero_motor</td></tr>
                <tr><td><strong>VIN:</strong></td><td>$VIN</td></tr>
                <tr><td><strong>Costo neto:</strong></td><td>$ $costo_neto MXN</td></tr>
                <tr><td><strong>Año de la unidad:</strong></td><td>$anio_unidad</td></tr>
                <tr><td><strong>Fecha préstamo:</strong></td><td>$fecha_prestamo</td></tr>
                <tr><td><strong>Fecha devolución:</strong></td><td>$fecha_devolucion</td></tr>
            </table>

            <p><strong>Usuario / Institución:</strong><br>
            $usuario_prestamo $organizacion</p>

            <p><strong>Objetivo del préstamo:</strong><br>
                $objetivo_prestamo</p>

            <p><strong>¿Requiere Master Driver?:</strong> <strong style='color: #b20000;'>$requiere_master_driver</strong><br>
                <strong>¿LDR emplaca?:</strong> <strong style='color: #b20000;'>$requiere_emplacamiento_ldr</strong><br>
                <strong>¿LDR asegura?:</strong> <strong style='color: #b20000;'>$resuiere_seguro_ldr</strong></p>

            <p><strong>Solicitante:</strong><br>
            $solicitante<br>
            <strong>Área:</strong> $area<br>
            <strong>Puesto:</strong> $puesto</p>

            <p>Ahora puedes ingresar a la plataforma <strong>Flotilla LDR</strong> en el apartado <strong>Autorizaciones</strong> para dar tu veredicto final.</p>

            <hr style='margin: 20px 0;'>

    <p><strong>Pasos para autorizar:</strong></p>
    <ol>
        <li>Ingresa a la plataforma <strong>Flotilla LDR</strong> desde la <strong>INTRANET</strong>.</li>
        <li>Dirígete al menú en el apartado <strong>Autorizaciones</strong>.</li>
        <li>Selecciona al usuario con la unidad correspondiente y haz clic en <strong>Verificar</strong>.</li>
        <li>Presiona <strong>AUTORIZAR</strong> si estás de acuerdo con la asignación, o bien <strong>RECHAZAR</strong> y especifica el motivo.</li>
    </ol>

    <p style='color: #b20000;'><strong>¡Es de suma importancia verificar correctamente la autorización para evitar asignaciones erróneas!</strong></p>

    <p>Gracias por tu atención.</p>

    <p>Atentamente,<br>
    <strong>Comercial - Flotilla LDR</strong></p>

    <p><strong>Acceso a la plataforma:</strong><br>
    <a href='https://ldrhsys.ldrhumanresources.com/default.php'>https://ldrhsys.ldrhumanresources.com/default.php</a></p>
");

        if ($mail->send()) {
            echo "✅ Autorización registrada y correo enviado correctamente.";
        } else {
            echo "❌ Error al enviar el correo: " . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo "❌ Error en PHPMailer: {$mail->ErrorInfo}";
    }
} else {
    echo "❌ Parámetros faltantes en la petición.";
}
