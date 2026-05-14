<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer as PHPMailerPHPMailer;

require '../../lib/PHPMailer-master/src/Exception.php';
require '../../lib/PHPMailer-master/src/PHPMailer.php';
require '../../lib/PHPMailer-master/src/SMTP.php';

include("../../../Servidor/conexion.php");

if (isset($_POST['idasignacion'])) {
    echo "entro el if de actualizacion";

    $idasignacion = $_POST['idasignacion'];

    $queryobtenerid_tipo_unidad = "SELECT u.id_unidad,
                                            tipounid.id_tipo_unidad,
                                            tipounid.tipo_unidad,
                                            asigun.id_asignaciones
                                    FROM asignacion_unidad_colaborador AS asigun
                                    INNER JOIN unidades AS u
                                    ON asigun.id_unidad = u.id_unidad
                                    INNER JOIN tipo_unidad AS tipounid
                                    ON u.id_tipo_unidad = tipounid.id_tipo_unidad
                                    WHERE id_asignaciones ='$idasignacion'";


    $resultado = mysqli_query($conexion, $queryobtenerid_tipo_unidad);
    $fila = mysqli_fetch_array($resultado);
    $id_tipo_unidad = $fila['id_tipo_unidad'];

    if ($id_tipo_unidad == 2) {
        $queryaprobarcartaresponsiva = "UPDATE asignacion_unidad_colaborador 
                                        INNER JOIN unidades 
                                        ON asignacion_unidad_colaborador.id_unidad = unidades.id_unidad
                                        SET id_estatus_carta_responsiva = 2, 
                                        id_estatus_comodato = 4, 
                                        motivo_rechazo = ' ',
                                        unidades.id_estado_unidad = 3 
                                         WHERE id_asignaciones = '$idasignacion'";
        $ejecutarconsulta = mysqli_query($conexion, $queryaprobarcartaresponsiva);

       
    }else{
        $queryaprobarcartaresponsiva = "UPDATE asignacion_unidad_colaborador 
                                    SET id_estatus_carta_responsiva = 2, 
                                    id_estatus_comodato = 2, 
                                    motivo_rechazo = ' '  
                                    WHERE id_asignaciones = '$idasignacion'";
    $ejecutarconsulta = mysqli_query($conexion, $queryaprobarcartaresponsiva);

    if ($ejecutarconsulta) {
            echo "entro la consulta";
            //obtenemos el archivo de la responsiba firmada dependiendo del usuario
            $queryenviarresponsivafirmada = "SELECT asigpdf.id_asignaciones,
                                    asigpdf.id_colaborador,
                                    col.nombre_1,
                                    col.nombre_2,
                                    col.apaterno,
                                    col.amaterno,
                                    mar.nombre_marca,
                                    model.nombre_modelo,
                                    uni.id_unidad,
                                    uni.placa,
                                    uni.numero_motor,
                                    uni.VIN,
                                    asigpdf.archivo_responsiva_firmada
                                FROM asignacion_unidad_colaborador AS asigpdf
                                INNER JOIN colaboradores AS col 
                                    ON asigpdf.id_colaborador = col.id_colaborador
                                INNER JOIN unidades AS uni
                                    ON asigpdf.id_unidad = uni.id_unidad
                                INNER JOIN modelos AS model
                                    ON uni.id_modelo = model.id_modelo
                                INNER JOIN marcas AS mar
                                    ON model.id_marca = mar.id_marca 
                                WHERE id_asignaciones = '$idasignacion'";

            $ejecutar = mysqli_query($conexion, $queryenviarresponsivafirmada);

            if ($ejecutar) {
                echo "entro el if de la consulta de la responsiva firmada";
                $data = mysqli_fetch_array($ejecutar);
                $id_asignaciones = $data['id_asignaciones'];
                $id_colaborador = $data['id_colaborador'];
                $nombre_1usu = $data['nombre_1'];
                $nombre_2usu = $data['nombre_2'];
                $apaternousu = $data['apaterno'];
                $amaternousu = $data['amaterno'];
                $marca = $data['nombre_marca'];
                $modelo = $data['nombre_modelo'];
                $id_unidad = $data['id_unidad'];
                $placa = $data['placa'];
                $numero_motor = $data['numero_motor'];
                $VIN = $data['VIN'];
                $archivo_responsiva_firmada = $data['archivo_responsiva_firmada'];

                $ruta_archivo = '../../archivos/files/files_unidades/responsiva_firmada_por_usuario/' . $archivo_responsiva_firmada;


                //enviar responsiva firmada
                if (file_exists($ruta_archivo)) {
                    echo "si existe el archivo";
                    //------------------------------------------ Envío del archivo PDF por correo con PHPMailer -----------------------------------------

                    $correo = "SELECT u.correo,
                               u.id_tipo_usuario,
                               c.nombre_1,
                               c.nombre_2, 
                               c.apaterno,
                               c.amaterno
                    FROM usuarios AS u
                    INNER JOIN colaboradores AS c
                    ON u.id_colaborador = c.id_colaborador
                    WHERE u.id_tipo_usuario = 2";

                    $result = $conectar->query($correo);
                    while ($row = $result->fetch_assoc()) {
                        $correo = $row['correo'];

                        $nombre_1 = $row['nombre_1'];
                        $nombre_2 = $row['nombre_2'];
                        $apaterno = $row['apaterno'];
                        $amaterno = $row['amaterno'];

                        $mail = new PHPMailer();
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'dscrgoficial@gmail.com';
                        $mail->Password = 'qvfh ncuc iwci ypgq';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;

                        $mail->setFrom('dscrgoficial@gmail.com', 'Flotilla LDR');
                        $mail->addAddress($correo); // Asegúrate de que la variable $correo está definida en tu código.
                        $mail->addBCC('uriel.cabello@ldrsolutions.com.mx'); // Copia oculta

                        $mail->isHTML(true);
                        $mail->Subject = utf8_decode('Solicitud de COMODATO para asignación de unidad vehicular'); // Asunto del correo
                        $mail->Body = utf8_decode("Estimado colaborador $nombre_1 $nombre_2 $apaterno $amaterno. 
                                    <br>
                                    <br>
                                    Te enviamos este correo solicitando el COMODATO correspondiente a la asignación de la siguiente unidad vehicular: 
                                    <br>
                                    <br>
                                    $marca $modelo: 
                                    <br>
                                    Placa: $placa
                                    <br>
                                    Número de motor: $numero_motor
                                    <br>
                                    VIN: $VIN
                                    <br>
                                    Para el colaborador $nombre_1usu $nombre_2usu $apaternousu $amaternousu del área : ***  .
                                    <br> 
                                    <br>
                                    Una vez realizado el COMODATO debes subirlo en la plataforma Flotilla Interna LDR.
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
                                    ¡Es de suma importancia que se verifique bien la información del comodatario.!
                                    <br>
                                    <br>
                                    Gracias por su atención.
                                    <br>
                                    Atentamente,
                                    <br>
                                    <br>
                                    Equipo de Flotilla Interna LDR");
                        $mail->addAttachment($ruta_archivo, $archivo_responsiva_firmada); // Adjuntar el archivo PDF

                        if ($mail->send()) {
                            echo "Correo enviado exitosamente.";
                        } else {
                            echo "Error al enviar el correo: " . $mail->ErrorInfo;
                        }
                    }
                }else{
                    echo "no existe el archivo";
                }
                exit();
            }
        }

    }
}else{
    echo "no se recibieron los datos";
}

