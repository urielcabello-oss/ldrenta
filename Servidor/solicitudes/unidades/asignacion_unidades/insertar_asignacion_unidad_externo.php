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
        && isset($_POST['usuarioexternoasignacion'])
    ) {

        $valoridunidad = mysqli_real_escape_string($conexion, $_POST['idunidad']);
        $valortipoasignacionunidad = mysqli_real_escape_string($conexion, $_POST['tipoasignacionunidad']);
        $valorfechasignacion = mysqli_real_escape_string($conexion, $_POST['fechasignacion']);
        $valorfechadevolucion = mysqli_real_escape_string($conexion, $_POST['fechadevolucion']);
        $valorusuexterno = mysqli_real_escape_string($conexion, $_POST['usuarioexternoasignacion']);


        // Insertamos la unidad
        $queryinsertarunidad = "INSERT INTO asignacion_unidad_colaborador (id_tipo_asignaciones, id_unidad, id_usuario_externo, fecha_asignacion, fecha_devolucion, id_estatus_carta_responsiva, id_estatus_comodato) 
                                VALUES ('$valortipoasignacionunidad', '$valoridunidad', '$valorusuexterno', '$valorfechasignacion', '$valorfechadevolucion' , 2, 2)";

        if ($ejecutar = mysqli_query($conexion, $queryinsertarunidad)) {
            $queryActualizarEstadoUnidad = "UPDATE unidades SET id_estado_unidad = 4 WHERE id_unidad = '$valoridunidad'";
            if (mysqli_query($conexion, $queryActualizarEstadoUnidad)) {
                echo "Registro y actualización exitosos.";

                if ($ejecutar) {
                     
                    echo "entro a crear pdf";
                    // Obtener el último ID insertado
                    $queryultimo = "SELECT asigpdf.id_asignaciones,
                                asigpdf.id_usuario_externo ,
                                usuexterno.nombre_1,
                                usuexterno.nombre_2,
                                usuexterno.apellido_paterno,
                                usuexterno.apellido_materno,
                                mar.nombre_marca,
                                model.nombre_modelo,
                                uni.id_unidad,
                                uni.placa,
                                uni.numero_motor,
                                uni.VIN
                            FROM asignacion_unidad_colaborador AS asigpdf
                            INNER JOIN usuarios_externos AS usuexterno
                                ON asigpdf.id_usuario_externo  = usuexterno.id_usuario_externo
                            INNER JOIN unidades AS uni
                                ON asigpdf.id_unidad = uni.id_unidad
                            INNER JOIN modelos AS model
                                ON uni.id_modelo = model.id_modelo
                            INNER JOIN marcas AS mar
                                ON model.id_marca = mar.id_marca  
                            ORDER BY asigpdf.id_asignaciones DESC LIMIT 1";

                    $ejecutar = mysqli_query($conexion, $queryultimo);

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

                        echo "entro a crear pdf y enviar a juridico";
                        // obtenemos los valores de la unidad y el colaborador al que se le asigna
                        $queryultimo = "SELECT 
                                                    asigpdf.id_asignaciones,
                                                    asigpdf.id_usuario_externo,
                                                    usuexterno.nombre_1,
                                                    usuexterno.nombre_2,
                                                    usuexterno.apellido_paterno,
                                                    usuexterno.apellido_materno,
                                                    usuexterno.id_tipo_usuario_externo,
                                                    usuexterno.genero,
                                                    usuexterno.licencia_conducir,
                                                    usuexterno.archivo_licencia,
                                                    usuexterno.domicilio_residencia,
                                                    usuexterno.archivo_comprobante_domicilio,
                                                    usuexterno.archivo_ine,
                                                    usuexterno.archivo_constancia_situacion_fiscal,
                                                    usuexterno.id_tipo_recidencia,
                                                    usuexterno.archivo_credencial_residencia,
                                                    usuexterno.pasaporte,
                                                    usuexterno.archivo_pasaporte,
                                                    usuexterno.forma_migratoria,
                                                    tipusuexterno.tipo_externo,
                                                    mar.nombre_marca,
                                                    model.nombre_modelo,
                                                    uni.id_unidad,
                                                    uni.placa,
                                                    uni.numero_motor,
                                                    uni.VIN,
                                                    uni.costo_neto,
                                                    uni.año_unidad
                                                FROM asignacion_unidad_colaborador AS asigpdf
                                                INNER JOIN usuarios_externos AS usuexterno 
                                                    ON asigpdf.id_usuario_externo = usuexterno.id_usuario_externo
                                                INNER JOIN tipo_usuarios_externos AS tipusuexterno
                                                    ON usuexterno.id_tipo_usuario_externo = tipusuexterno.id_tipo_usuario_externo
                                                INNER JOIN unidades AS uni
                                                    ON asigpdf.id_unidad = uni.id_unidad
                                                INNER JOIN modelos AS model
                                                    ON uni.id_modelo = model.id_modelo
                                                INNER JOIN marcas AS mar
                                                    ON model.id_marca = mar.id_marca
                                                WHERE asigpdf.id_asignaciones = $id_asignaciones
                                                ORDER BY asigpdf.id_asignaciones DESC 
                                                LIMIT 1";



                        $ejecutar = mysqli_query($conexion, $queryultimo);

                        if ($ejecutar) {
                            $row = $ejecutar->fetch_array();
                            $id_unidad = $row['id_unidad'];
                            $id_usuario_externo = $row['id_usuario_externo'];
                            $nombre_1 = $row['nombre_1'];
                            $nombre_2 = $row['nombre_2'];
                            $apaterno = $row['apellido_paterno'];
                            $amaterno = $row['apellido_materno'];
                            $tipo_externo = $row['tipo_externo'];
                            $marca = $row['nombre_marca'];
                            $modelo = $row['nombre_modelo'];
                            $placa = $row['placa'];
                            $motor = $row['numero_motor'];
                            $vin = $row['VIN'];
                            $costo_neto = $row['costo_neto'];
                            $año_unidad = $row['año_unidad'];
                            $licencia_conducir = $row['licencia_conducir'];
                            $archivo_licencia = $row['archivo_licencia'];
                            $domicilio_residencia = $row['domicilio_residencia'];
                            $archivo_comprobante_domicilio = $row['archivo_comprobante_domicilio'];
                            $archivo_ine = $row['archivo_ine'];
                            $archivo_constancia_situacion_fiscal = $row['archivo_constancia_situacion_fiscal'];
                            $id_tipo_recidencia = $row['id_tipo_recidencia'];
                            $archivo_credencial_residencia = $row['archivo_credencial_residencia'];
                            $pasaporte = $row['pasaporte'];
                            $archivo_pasaporte = $row['archivo_pasaporte'];
                            $forma_migratoria = $row['forma_migratoria'];
                        
                        }

                        // Obtener correos de usuarios tipo 2 juridicos
                        $correos = [];
                        $correo_sql = "SELECT u.id_colaborador, 
                                                u.id_tipo_usuario,
                                                cor.id_colaborador,
                                                cor.email_corporativo
                                        FROM usuarios AS u 
                                        INNER JOIN colaboradores AS cor
                                        ON u.id_colaborador = cor.id_colaborador
                                        WHERE u.id_tipo_usuario = 2";
                        $correo_result = $conexion->query($correo_sql);
                        while ($correo_row = $correo_result->fetch_assoc()) {
                            if (!empty($correo_row['email_corporativo'])) {
                                $correos[] = $correo_row['email_corporativo'];
                            }
                        }

                        foreach ($correos as $correo) {
                            echo "Correo: $correo <br>";
                        }

                        $ejecutar = mysqli_query($conexion, $queryultimo);

                        if ($ejecutar) {
                            $row = $ejecutar->fetch_array();
                            $id_unidad = $row['id_unidad'];
                            $id_usuario_externo = $row['id_usuario_externo'];
                            $nombre_1 = $row['nombre_1'];
                            $nombre_2 = $row['nombre_2'];
                            $apaterno = $row['apellido_paterno'];
                            $amaterno = $row['apellido_materno'];
                            $tipo_externo = $row['tipo_externo'];
                            $marca = $row['nombre_marca'];
                            $modelo = $row['nombre_modelo'];
                            $placa = $row['placa'];
                            $motor = $row['numero_motor'];
                            $vin = $row['VIN'];
                            $costo_neto = $row['costo_neto'];
                            $año_unidad = $row['año_unidad'];
                            $licencia_conducir = $row['licencia_conducir'];
                            $archivo_licencia = $row['archivo_licencia'];
                            $domicilio_residencia = $row['domicilio_residencia'];
                            $archivo_comprobante_domicilio = $row['archivo_comprobante_domicilio'];
                            $archivo_ine = $row['archivo_ine'];
                            $archivo_constancia_situacion_fiscal = $row['archivo_constancia_situacion_fiscal'];
                            $id_tipo_recidencia = $row['id_tipo_recidencia'];
                            $archivo_credencial_residencia = $row['archivo_credencial_residencia'];
                            $pasaporte = $row['pasaporte'];
                            $archivo_pasaporte = $row['archivo_pasaporte'];
                            $forma_migratoria = $row['forma_migratoria'];

                            $ruta_archivo_licencia = '../../../../Servidor/archivos/files/files_usuarios_externos/' . $archivo_licencia;
                            $ruta_archivo_comprobante_domicilio = '../../../../Servidor/archivos/files/files_usuarios_externos/' . $archivo_comprobante_domicilio;
                            $ruta_archivo_ine = '../../../../Servidor/archivos/files/files_usuarios_externos/' . $archivo_ine;
                            $ruta_archivo_constancia_situacion_fiscal = '../../../../Servidor/archivos/files/files_usuarios_externos/' . $archivo_constancia_situacion_fiscal;
                            $ruta_archivo_credencial_residencia = '../../../../Servidor/archivos/files/files_usuarios_externos/' . $archivo_credencial_residencia;
                            $ruta_archivo_pasaporte = '../../../../Servidor/archivos/files/files_usuarios_externos/' . $archivo_pasaporte;

                            // Enviar correo a juridico con la informacion de la solicitud

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
                                $mail->Subject = utf8_decode('Solicitud de COMODATO para asignación de unidad vehicular externo'); // Asunto del correo
                                $mail->Body = utf8_decode("Estimado colaborador del área jurídico.
                                                            <br>
                                                            <br>
                                                            Te enviamos este correo solicitando el <strong>COMODATO</strong> correspondiente a la asignación externa de la siguiente unidad vehicular: 
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
                                                            Para el colaborador que no forma parte de la empresa: <strong>$nombre_1 $nombre_2 $apaterno $amaterno</strong> 
                                                            <br>
                                                            <strong>Tipo de usuario:</strong> $tipo_externo
                                                            <br> 
                                                            <strong>Licencia de conducir:</strong> $licencia_conducir
                                                            <br>
                                                            <strong>Domicilio de residencia:</strong> $domicilio_residencia
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

                                $mail->addAttachment('' . $ruta_archivo_licencia . '' );
                                $mail->addAttachment('' .$ruta_archivo_comprobante_domicilio . '' );
                                $mail->addAttachment('' . $ruta_archivo_ine . '' );
                                $mail->addAttachment('' . $ruta_archivo_constancia_situacion_fiscal . '' );
                                $mail->addAttachment('' . $ruta_archivo_credencial_residencia . '' );
                                $mail->addAttachment('' . $ruta_archivo_pasaporte . '');
                                $mail->addAttachment($ruta_archivo_licencia); 
                                $mail->addAttachment($ruta_archivo_comprobante_domicilio); 
                                $mail->addAttachment($ruta_archivo_ine);
                                $mail->addAttachment($ruta_archivo_constancia_situacion_fiscal);
                                $mail->addAttachment($ruta_archivo_credencial_residencia);
                                $mail->addAttachment($ruta_archivo_pasaporte); // Adjuntar el archivo PDF

                                if ($mail->send()) {
                                    echo "Correo enviado exitosamente.";
                                } else {
                                    echo "Error al enviar el correo: " . $mail->ErrorInfo;
                                }
                            } catch (Exception $e) {
                                echo "Error al enviar el correo: {$mail->ErrorInfo}<br>";
                            }
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

