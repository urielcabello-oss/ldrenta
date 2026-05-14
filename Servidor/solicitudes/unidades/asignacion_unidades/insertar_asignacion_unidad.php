<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../../../lib/PHPMailer-master/src/Exception.php';
require '../../../lib/PHPMailer-master/src/PHPMailer.php';
require '../../../lib/PHPMailer-master/src/SMTP.php';

include("../../../conexion.php");
$noombre_archivo = "";
$id_asignaciones = 0;
$valorcolaboradorasignacion = 0;

if (!isset($_GET['imprimircartareponsiva'])) {
    echo "entro a insertar";
    if (
        isset($_POST['idunidad'])
        && isset($_POST['tipoasignacionunidad'])
        && isset($_POST['fechasignacion'])
        && isset($_POST['fechadevolucion'])
        && isset($_POST['colaboradorasignacion'])
    ) {

        $valoridunidad = mysqli_real_escape_string($conexion, $_POST['idunidad']);
        $valortipoasignacionunidad = mysqli_real_escape_string($conexion, $_POST['tipoasignacionunidad']);
        $valorfechasignacion = mysqli_real_escape_string($conexion, $_POST['fechasignacion']);
        $valorfechadevolucion = mysqli_real_escape_string($conexion, $_POST['fechadevolucion']);
        $valorcolaboradorasignacion = mysqli_real_escape_string($conexion, $_POST['colaboradorasignacion']);

        //obtenemos la informacion del colaborador para saber si tiene licencia de conducir, si no tiene no se puede asignar la unidad
        $querylicenciaconducir = "SELECT licencias_conducir FROM colaboradores WHERE id_colaborador = '$valorcolaboradorasignacion'";

        // Verificar que el colaborador tenga licencia vigente o permanente
        $queryverificarlicencia = "SELECT COUNT(*) AS total 
                                    FROM licencias_conducir AS lic
                                    WHERE lic.id_colaborador = '$valorcolaboradorasignacion'
                                    AND lic.id_estado_licencia = 1
                                    AND (
                                        lic.fecha_vencimiento >= CURDATE()
                                        OR lic.licencia_permanente = 'PERMANENTE'
                                    )";

        $resultadoLicencia = mysqli_query($conexion, $queryverificarlicencia);
        $filaLicencia = mysqli_fetch_assoc($resultadoLicencia);

        if ($filaLicencia['total'] == 0) {
            // Evita que se envíe cualquier contenido previo
            if (ob_get_length()) {
                ob_clean(); // Limpia cualquier salida previa
            }
            header('Content-Type: text/plain'); // Asegura que el contenido no sea HTML
            echo "error_licencia";
            exit(); // Detiene la ejecución
        }



        // Insertamos la unidad
        $queryinsertarunidad = "INSERT INTO asignacion_unidad_colaborador (id_tipo_asignaciones, id_unidad, id_colaborador, fecha_asignacion, fecha_devolucion, id_estatus_carta_responsiva, id_estatus_comodato) 
                                VALUES ('$valortipoasignacionunidad', '$valoridunidad', '$valorcolaboradorasignacion', '$valorfechasignacion', '$valorfechadevolucion' , 2, 2)";

        if ($ejecutar = mysqli_query($conexion, $queryinsertarunidad)) {
            $queryActualizarEstadoUnidad = "UPDATE unidades SET id_estado_unidad = 4 WHERE id_unidad = '$valoridunidad'";
            if (mysqli_query($conexion, $queryActualizarEstadoUnidad)) {
                echo "Registro y actualización exitosos.";

                if ($ejecutar) {
                    echo "entro a crear pdf";
                    // Obtener el último ID insertado
                    $queryultimo = "SELECT asigpdf.id_asignaciones,
                                asigpdf.id_colaborador,
                                col.nombre_1,
                                col.nombre_2,
                                col.apellido_paterno,
                                col.apellido_materno,
                                mar.nombre_marca,
                                model.nombre_modelo,
                                uni.id_unidad,
                                uni.placa,
                                uni.numero_motor,
                                uni.VIN
                            FROM asignacion_unidad_colaborador AS asigpdf
                            INNER JOIN colaboradores AS col 
                                ON asigpdf.id_colaborador = col.id_colaborador
                            INNER JOIN unidades AS uni
                                ON asigpdf.id_unidad = uni.id_unidad
                            INNER JOIN modelos AS model
                                ON uni.id_modelo = model.id_modelo
                            INNER JOIN marcas AS mar
                                ON model.id_marca = mar.id_marca  
                            ORDER BY asigpdf.id_asignaciones DESC LIMIT 1";

                    $ejecutar = mysqli_query($conexion, $queryultimo);

                    //realizacion del pdf 
                    if ($ejecutar) {
                        $data = mysqli_fetch_array($ejecutar);

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
                        //------------------------------------------ Envío del archivo PDF por correo con PHPMailer -----------------------------------------

                        $correo = "SELECT u.email_corporativo, u.id_colaborador
                                FROM colaboradores AS u
                                WHERE u.id_colaborador = $valorcolaboradorasignacion";
                        $result = $conectar->query($correo);
                        $row = $result->fetch_assoc();
                        $correo = $row['email_corporativo'];
                        //$correo = "uriel.cabello@ldrsolutions.com.mx";

                        $mail = new PHPMailer();

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
                            $mail->addAddress($correo); // Asegúrate de que la variable $correo está definida en tu código.
                            $mail->addBCC('uriel.cabello@ldrsolutions.com.mx'); // Copia oculta

                            $mail->isHTML(true);
                            $mail->Subject = utf8_decode('Notificación de asignación de unidad vehicular'); // Asunto del correo
                            $mail->Body = utf8_decode("Estimado colaborador <strong>$nombre_1 $nombre_2 $apaterno $amaterno.</strong> 
                                <br><br>Te enviamos este correo notificandote que se esta realizando la asignación de tu unidad vehicular.
                                <br><br>
                                Sigue los siguientes pasos para realizar el proceso de asignación de la unidad:
                                <br>
                                <br>
                                Espera a recibir un correo de confirmación solicitando tu presencia física en el Área de Servicios Generales para poder firmar el comodato de asignación.
                                <br>
                                Adicionalmente, se usará parte de tu documentación personal para la creación del documento, información proporcionada por el equipo de RH.
                                <br>
                                <strong>-Licencia de conducir</strong>
                                <br>
                                <strong>-INE</strong>
                                <br>
                                <strong>-Comprobante de domicilio</strong>
                                <br>
                                <strong>-Constancia de situación fiscal</strong>
                                <br>
                                <br>
                                ¡Es de suma importancia que acudas a firmar el documento y que verifiques que tus datos esten correctos para poder adquirir la unidad!
                                <br>
                                <br>
                                Gracias por tu atención.
                                <br>
                                <br>
                                Atentamente,
                                <br>
                                <br>
                                <strong>Servicios Generales - Flotilla LDR</strong>
                                <br>
                                <br>
                                <strong>Acceso a la plataforma: </strong>
                                <br>
                                <a href='https://ldrhsys.ldrhumanresources.com/default.php'>https://ldrhsys.ldrhumanresources.com/default.php</a>");

                            if ($mail->send()) {
                                echo "Correo enviado exitosamente.";
                            }
                        } catch (Exception $e) {
                            echo "Error al enviar el correo: {$mail->ErrorInfo}<br>";
                        }

                        echo "entro a crear pdf";
                        // obtenemos los valores de la unidad y el colaborador al que se le asigna
                        $queryultimo = "SELECT 
                                                    asigpdf.id_asignaciones,
                                                    asigpdf.id_colaborador,
                                                    col.nombre_1,
                                                    col.nombre_2,
                                                    col.apellido_paterno,
                                                    col.apellido_materno,
                                                    col.id_area,
                                                    col.id_puesto,
                                                    col.id_colaborador,
                                                    mar.nombre_marca,
                                                    model.nombre_modelo,
                                                    uni.id_unidad,
                                                    uni.placa,
                                                    uni.numero_motor,
                                                    uni.VIN,
                                                    uni.costo_neto,
                                                    uni.año_unidad,
                                                    lic.numero_licencia,
                                                    lic.fecha_emision,
                                                    lic.fecha_vencimiento,
                                                    area.nombre_area,
                                                    puesto.nombre_puesto,
                                                    lic.licencia_permanente,
                                                    lic.archivo_licencia,
                                                    dom.archivo_domicilio,
                                                    ine.archivo_ine,
                                                    csf.archivo_constancia_situacion_fiscal
                                                FROM asignacion_unidad_colaborador AS asigpdf
                                                INNER JOIN colaboradores AS col 
                                                    ON asigpdf.id_colaborador = col.id_colaborador
                                                INNER JOIN areas AS area
                                                    ON col.id_area = area.id_area
                                                INNER JOIN puestos AS puesto
                                                    ON col.id_puesto = puesto.id_puesto
                                                INNER JOIN unidades AS uni
                                                    ON asigpdf.id_unidad = uni.id_unidad
                                                INNER JOIN modelos AS model
                                                    ON uni.id_modelo = model.id_modelo
                                                INNER JOIN marcas AS mar
                                                    ON model.id_marca = mar.id_marca
                                                LEFT JOIN licencias_conducir AS lic
                                                    ON col.id_colaborador = lic.id_colaborador
                                                LEFT JOIN domicilios AS dom
                                                    ON col.id_colaborador = dom.id_colaborador
                                                LEFT JOIN ines AS ine
                                                    ON col.id_colaborador = ine.id_colaborador
                                                LEFT JOIN constancias_situacion_fiscal AS csf
                                                    ON col.id_colaborador = csf.id_colaborador
                                                WHERE asigpdf.id_asignaciones = $id_asignaciones
                                                ORDER BY asigpdf.id_asignaciones DESC 
                                                LIMIT 1";



                        $ejecutar = mysqli_query($conexion, $queryultimo);

                        if ($ejecutar) {
                            $row = $ejecutar->fetch_array();
                            $id_unidad = $row['id_unidad'];
                            $id_colaborador = $row['id_colaborador'];
                            $nombre_1 = $row['nombre_1'];
                            $nombre_2 = $row['nombre_2'];
                            $apaterno = $row['apellido_paterno'];
                            $amaterno = $row['apellido_materno'];
                            $area = $row['nombre_area'];
                            $marca = $row['nombre_marca'];
                            $modelo = $row['nombre_modelo'];
                            $placa = $row['placa'];
                            $motor = $row['numero_motor'];
                            $vin = $row['VIN'];
                            $costo_neto = $row['costo_neto'];
                            $año_unidad = $row['año_unidad'];
                            $puesto_colaborador = $row['nombre_puesto'];
                            $numero_licencia = $row['numero_licencia'];
                            $fecha_emision = $row['fecha_emision'];
                            $fecha_vencimiento = $row['fecha_vencimiento'];
                            $licencia_permanente = $row['licencia_permanente'];
                            $archivo_licencia = $row['archivo_licencia'];
                            $archivo_domicilio = $row['archivo_domicilio'];
                            $archivo_ine = $row['archivo_ine'];
                            $archivo_constancia_situacion_fiscal = $row['archivo_constancia_situacion_fiscal'];
                        }

                        // Obtener correos de usuarios tipo 2 juridicos
                        $correos = [];
                        $correo_sql = "SELECT cor.email_corporativo
                                        FROM usuarios u
                                        INNER JOIN usuario_modulo_tipo umt 
                                                ON umt.id_usuario = u.id_usuario
                                        INNER JOIN colaboradores cor 
                                                ON cor.id_colaborador = u.id_colaborador
                                        WHERE umt.id_tipo_usuario = 2
                                        AND umt.id_modulo = 1";
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

                        $ejecutar = mysqli_query($conexion, $queryultimo);

                        if ($ejecutar) {
                            $row = $ejecutar->fetch_array();
                            $id_unidad = $row['id_unidad'];
                            $id_colaborador = $row['id_colaborador'];
                            $nombre_1 = $row['nombre_1'];
                            $nombre_2 = $row['nombre_2'];
                            $apaterno = $row['apellido_paterno'];
                            $amaterno = $row['apellido_materno'];
                            $area = $row['nombre_area'];
                            $marca = $row['nombre_marca'];
                            $modelo = $row['nombre_modelo'];
                            $placa = $row['placa'];
                            $numero_motor = $row['numero_motor'];
                            $VIN = $row['VIN'];
                            $costo_neto = $row['costo_neto'];
                            $año_unidad = $row['año_unidad'];
                            $puesto_colaborador = $row['nombre_puesto'];
                            $numero_licencia = $row['numero_licencia'];
                            $fecha_emision = $row['fecha_emision'];
                            $fecha_vencimiento = $row['fecha_vencimiento'];
                            $licencia_permanente = $row['licencia_permanente'];
                            $archivo_licencia = $row['archivo_licencia'];
                            $archivo_domicilio = $row['archivo_domicilio'];
                            $archivo_ine = $row['archivo_ine'];
                            $archivo_constancia_situacion_fiscal = $row['archivo_constancia_situacion_fiscal'];

                            $ruta_archivo = '../../../../Servidor/archivos/files/files_licencias_conducir/' . $archivo_licencia;
                            $ruta_archivo_domicilio = '../../../../Servidor/archivos/files/files_comprobantes_domicilios/' . $archivo_domicilio;
                            $ruta_archivo_ine = '../../../../Servidor/archivos/files/files_ines/' . $archivo_ine;
                            $ruta_archivo_constancia_situacion_fiscal = '../../../../Servidor/archivos/files/files_constancias_situacion_fiscal/' . $archivo_constancia_situacion_fiscal;

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
                                $mail->addBCC('uriel.cabello@ldrsolutions.com.mx'); // Copia oculta

                                $mail->isHTML(true);
                                $mail->Subject = utf8_decode('Solicitud de COMODATO para asignación de unidad vehicular'); // Asunto del correo
                                $mail->Body = utf8_decode("Estimado colaborador del área jurídico.
                                                            <br>
                                                            <br>
                                                            Te enviamos este correo solicitando el <strong>COMODATO</strong> correspondiente a la asignación de la siguiente unidad vehicular: 
                                                            <br>
                                                            <br>
                                                            <strong>$marca $modelo: </strong>
                                                            <br>
                                                            <strong>Placa:</strong> $placa
                                                            <br>
                                                            <strong>Número de motor:</strong> $numero_motor
                                                            <br>
                                                            <strong>VIN:</strong> $VIN
                                                            <br>
                                                            <strong>Costo neto:</strong> $costo_neto
                                                            <br>
                                                            <strong>Año unidad:</strong> $año_unidad
                                                            <br>
                                                            Para el colaborador <strong>$nombre_1 $nombre_2 $apaterno $amaterno</strong> 
                                                            <br>
                                                            <strong>Puesto:</strong> $puesto_colaborador
                                                            <br>
                                                            del área : $area.
                                                            <br> 
                                                            <br>
                                                            Una vez realizado el COMODATO debes subirlo en la plataforma <strong>Flotilla LDR.</strong>
                                                            <br>
                                                            Sigue los siguientes pasos para subir el documento:
                                                            <br>
                                                            <br>
                                                            1. Ingresa a la plataforma Flotilla LDR con tu correo y contraseña.
                                                            <br>
                                                            2. Dirígete al menú en el apartado COMODATOS.
                                                            <br>
                                                            3. Selecciona al usuario con la unidad correspondiente y da clic en el botón SUBIR-COMODATO.
                                                            <br>
                                                            4. Sube el documento correspondiente.
                                                            <br><br>
                                                            <strong>¡Es de suma importancia que se verifique bien la información del comodatario.!</strong>
                                                            <br>
                                                            <br>
                                                            Gracias por su atención.
                                                            <br>
                                                            Atentamente,
                                                            <br>
                                                            <br>
                                                            <strong>Servicios Generales - Flotilla LDR</strong>
                                                            <br>
                                                            <br>
                                                            <strong>Acceso a la plataforma: </strong>
                                                            <br>
                                                            <a href='https://ldrhsys.ldrhumanresources.com/default.php'>https://ldrhsys.ldrhumanresources.com/default.php</a>");

                                $mail->addAttachment('' . $ruta_archivo . '');
                                $mail->addAttachment('' . $ruta_archivo_domicilio . '');
                                $mail->addAttachment('' . $ruta_archivo_ine . '');
                                $mail->addAttachment('' . $ruta_archivo_constancia_situacion_fiscal . '');
                                $mail->addAttachment($ruta_archivo); // Adjuntar el archivo PDF
                                $mail->addAttachment($ruta_archivo_domicilio);
                                $mail->addAttachment($ruta_archivo_ine);
                                $mail->addAttachment($ruta_archivo_constancia_situacion_fiscal);

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
                } else {
                    echo "Error al obtener los datos del último registro insertado.";
                }
            } else {
                echo "Error al insertar la unidad.";
            }
        } else {
            echo "Error al actualizar el estado de la unidad: " . mysqli_error($conexion);
        }
    } else {
        echo "Error al insertar la asignación: " . mysqli_error($conexion);
    }
}
