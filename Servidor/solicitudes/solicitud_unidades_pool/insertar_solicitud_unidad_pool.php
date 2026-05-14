<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../../lib/PHPMailer-master/src/Exception.php';
require '../../lib/PHPMailer-master/src/PHPMailer.php';
require '../../lib/PHPMailer-master/src/SMTP.php';

include("../../conexion.php");
$nombre_archivo = "";
$ruta_archivo = "";
$id_asignaciones = 0;
$valorcolaboradorasignacion = 0;

session_start();
$id_usuario = $_SESSION['id_usuario'];

if (
    isset($_POST['id_unidad']) &&
    isset($_POST['sederecoleccionpool']) &&
    isset($_POST['fechasolicitudunidadpool']) &&
    isset($_POST['horasolicitudunidadpool']) &&
    isset($_POST['sededevolucionunidadpool']) &&
    isset($_POST['fechadevolucionunidadpool']) &&
    isset($_POST['horadevolucionunidadpool'])
) {
    $valoridunidad = mysqli_real_escape_string($conexion, $_POST['id_unidad']);
    $id_colaborador = $_SESSION['id_colaborador'];

    $sederecoleccionpool = mysqli_real_escape_string($conexion, $_POST['sederecoleccionpool']);
    $fechasolicitudunidadpool = mysqli_real_escape_string($conexion, $_POST['fechasolicitudunidadpool']);
    $horasolicitudunidadpool = mysqli_real_escape_string($conexion, $_POST['horasolicitudunidadpool']);
    $sededevolucionunidadpool = mysqli_real_escape_string($conexion, $_POST['sededevolucionunidadpool']);
    $fechadevolucionunidadpool = mysqli_real_escape_string($conexion, $_POST['fechadevolucionunidadpool']);
    $horadevolucionunidadpool = mysqli_real_escape_string($conexion, $_POST['horadevolucionunidadpool']);

    // Insertamos la unidad
    $queryinsertarsolicitudunidadpool = "INSERT INTO asignacion_unidad_colaborador (id_tipo_asignaciones, 
                                                                                    id_unidad, 
                                                                                    id_colaborador, 
                                                                                    fecha_asignacion, 
                                                                                    fecha_devolucion,
                                                                                    hora_recoleccion,
                                                                                    hora_devolucion, 
                                                                                    id_estatus_carta_responsiva, 
                                                                                    id_estatus_comodato) 
                                                VALUES (1, 
                                                '$valoridunidad', 
                                                '$id_colaborador', 
                                                '$fechasolicitudunidadpool', 
                                                '$fechadevolucionunidadpool', 
                                                '$horasolicitudunidadpool', 
                                                '$horadevolucionunidadpool', 
                                                1, 
                                                1)";

    if ($ejecutar = mysqli_query($conexion, $queryinsertarsolicitudunidadpool)) {
        $queryActualizarEstadoUnidad = "UPDATE unidades SET id_estado_unidad = 4 WHERE id_unidad = '$valoridunidad'";
        if (mysqli_query($conexion, $queryActualizarEstadoUnidad)) {
            echo "Registro y actualización exitosos.";

            $queryultimo = "SELECT asigpdf.id_asignaciones, col.nombre_1, col.nombre_2, col.apellido_paterno, col.apellido_materno, mar.nombre_marca, model.nombre_modelo, uni.id_unidad, uni.placa, uni.numero_motor, uni.VIN
                            FROM asignacion_unidad_colaborador AS asigpdf
                            INNER JOIN colaboradores AS col ON asigpdf.id_colaborador = col.id_colaborador
                            INNER JOIN unidades AS uni ON asigpdf.id_unidad = uni.id_unidad
                            INNER JOIN modelos AS model ON uni.id_modelo = model.id_modelo
                            INNER JOIN marcas AS mar ON model.id_marca = mar.id_marca  
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

                require("../../lib/fpdf186/fpdf.php");

                class PDF extends FPDF
                {
                    function Header()
                    {
                        $this->SetY(20);
                        $this->Image('../../../Cliente/img/logos/ldr_logo.jpeg', 10, 10, 20);
                        $this->Ln(20);
                    }

                    function Footer()
                    {
                        $this->SetY(-25);
                        $this->SetFont('Arial', 'I', 8);
                        $this->Cell(0, 5, utf8_decode('LDR Solutions, S.A. de C.V.'), 0, 1, 'C');
                        $this->Cell(0, 5, utf8_decode('Corporativo Punta Santa Fe, Prol. Paseo de la Reforma 1015, Piso 24, Santa Fe, Contadero'), 0, 1, 'C');
                        $this->Cell(0, 5, utf8_decode('Cuajimalpa de Morelos, C.P. 05348, Ciudad de México'), 0, 1, 'C');
                        $this->Ln(2);
                        $this->Cell(0, 5, utf8_decode('Página ') . $this->PageNo(), 0, 0, 'C');
                    }
                }

                $pdf = new PDF();
                $pdf->SetMargins(17, 20, 17);
                $pdf->AddPage();
                $pdf->SetFont('Arial', 'B', 13);
                $pdf->Ln(3);
                $pdf->MultiCell(0, 0, utf8_decode("CARTA PRÉSTAMO DE UNIDAD "), 0, 'C');
                $pdf->Ln(7);

                $pdf->SetFont('Arial', '', 11);
                $pdf->MultiCell(0, 7, utf8_decode("El suscrito C. $nombre_1 $nombre_2 $apaterno $amaterno, por este conducto manifiesto que en este acto recibo en préstamo, el vehículo que se detalla a continuación: "));
                $pdf->Ln(5);

                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(0, 7, utf8_decode('1. Vehículo:'), 0, 1);
                $pdf->SetFont('Arial', '', 11);

                $datosVehiculo = [
                    "Marca: $marca",
                    "Modelo: $modelo",
                    "Placas: $placa",
                    "Número de Motor: $numero_motor",
                    "Número de Serie: $VIN",
                ];

                foreach ($datosVehiculo as $dato) {
                    $pdf->Cell(0, 7, utf8_decode($dato), 0, 1);
                }

                $pdf->Ln(5);
                $pdf->MultiCell(0, 7, utf8_decode("Con las especificaciones e inventario que se detallan en la Responsiva de Vehículos correspondiente."));
                $pdf->Ln(5);

                $pdf->MultiCell(0, 7, utf8_decode("De igual manera manifiesto que me encuentro facultado para operar el vehículo con base a sus características y que cuento con la licencia tipo ______________, número __________________, con fecha del vencimiento ______________________, expedida por _____________."));
                $pdf->Ln(5);

                $pdf->MultiCell(0, 7, utf8_decode("Declaro estar conforme con el vehículo, el cual recibo en condiciones de uso, y con todos los accesorios necesarios para su operación con seguridad, mismo que utilizaré exclusivamente para la actividad indicada en la Responsiva de Vehículos."));
                $pdf->Ln(5);

                $pdf->MultiCell(0, 7, utf8_decode("Asimismo, me hago sabedor y manifiesto mi conformidad y compromiso para dar cumplimiento a los Lineamientos implementados por la empresa, los que se tienen por aquí reproducidos para todos los efectos legales a que haya lugar. "));
                $pdf->Ln(5);

                $pdf->MultiCell(0, 7, utf8_decode("En todo momento el vehículo deberá ser utilizado para las actividades indicadas en la Responsiva de Vehículos, y nunca destinarse para otros usos, ni prestarse a otra persona, ya que, en caso de algún siniestro, de cualquier índole, el colaborador será responsable de cualquier gasto o costo que se origine por cualquier siniestro o percance, siendo el único responsable de los daños que se causen al vehículo, así como a cualquier tercero, en sus bienes o su persona."));
                $pdf->Ln(5);

                $pdf->MultiCell(0, 7, utf8_decode("En virtud de ello otorgo a LDR Solutions, S. A. de C.V., sus filiales o subsidiarias, así como empresas relacionadas, EL FINIQUITO MÁS AMPLIO procedente conforme a derecho, renunciando en este acto en forma expresa a cualquier acción de carácter civil, incluyendo la acción de responsabilidad objetiva y a la de daño moral, penal, administrativa o de cualquier otra naturaleza, que tenga por objeto directo o indirecto exigir o constituir responsabilidad en contra de LDR Solutions, S. A. de C.V. así como a todas sus filiales, subsidiarias y/o empresas relacionadas por cualquier hecho que se encuentre relacionado directa o indirectamente con la utilización del vehículo. "));
                $pdf->Ln(5);


                $pdf->MultiCell(0, 7, utf8_decode("De igual manera me obligo a responder por los daños que se llegaran a ocasionar a cualquier persona o bienes, debiendo absorber y liquidar en un plazo no mayor a 5 días, los costos que resulten de los daños derivados de la utilización del vehículo, obligándome a sacar en paz a salvo a LDR Solutions, S. A. de C.V., así como a todas sus filiales, subsidiarias y/o empresas relacionadas; de cualquier reclamo que se pretenda hacer en contra con tal motivo. Asimismo, me obligo a resarcir cualquier daño y cumplir con cualquier obligación de pago que surja frente a terceros, frente a LDR Solutions, S. A. de C.V. y frente a sus trabajadores, colaboradores, directivos o funcionarios, así como a pagar las erogaciones de asesoría, consultoría, gastos y costas de procedimientos o litigios judiciales mediante los cuales esté involucrado el vehículo, hasta la conclusión de dichos procedimientos. "));
                $pdf->Ln(5);

                $pdf->MultiCell(0, 7, utf8_decode("HAGO CONSTAR y reconozco expresamente que el vehículo referido, lo recibo en buen estado, para la realización de las actividades referidas en la Responsiva de Vehículos, obligándome a conservarlo en buen estado, utilizarlo para lo que está destinado y a entregarlo al término de las actividades, responsabilizándome del mismo bajo cualquier circunstancia, en términos de los artículos 134, fracción VI y 135, fracciones III y IX de la Ley Federal del Trabajo. En consecuencia, cualquier contravención al correcto uso del vehículo, así como de las disposiciones y lineamientos contenidos en la presente asignación, con independencia de las responsabilidades de carácter penal, administrativa, civil o cualquier otra que se derive, podrá ser causal de rescisión de la relación laboral con mi Patrón, en términos de las fracciones V, VI y XV del artículo 47 de la Ley Federal del Trabajo. "));
                $pdf->Ln(7);

                $pdf->MultiCell(0, 7, utf8_decode("La firma de la presente Carta es válida para cada ocasión que sea utilizado el vehículo, en términos de la Responsiva de Vehículos firmada al efecto. "));
                $pdf->Ln(20);

                $pdf->SetFont('Arial', 'B', 11);
                $pdf->Cell(90, 7, utf8_decode('Comodatario'), 0, 0, 'C');
                $pdf->Cell(90, 7, utf8_decode('Autoriza'), 0, 1, 'C');
                $pdf->Cell(90, 30, '_________________________', 0, 0, 'C');
                $pdf->Cell(90, 30, '_________________________', 0, 1, 'C');

                $nombre_archivo = 'responsiva_placa_' . $placa . '_asignacion_' . $id_asignaciones . '.pdf';
                $ruta_archivo = '../../../Servidor/archivos/files/files_unidades/responsiva_sin_asignar/' . $nombre_archivo;

                $pdf->Output('F', $ruta_archivo);

                if (file_exists($ruta_archivo)) {
                    $query_actualizar = "UPDATE asignacion_unidad_colaborador SET archivo_responsiva_sin_asignar = '$nombre_archivo' WHERE id_asignaciones = '$id_asignaciones'";
                    mysqli_query($conexion, $query_actualizar);

                    $correo = "SELECT u.correo FROM usuarios AS u INNER JOIN colaboradores AS c ON u.id_colaborador = c.id_colaborador WHERE u.id_colaborador = $id_colaborador";
                    $result = $conexion->query($correo);
                    $row = $result->fetch_assoc();
                    $correo = $row['correo'];

                    $mail = new PHPMailer(true);

                    try {
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'notificacion@ldrsolutions.com.mx';
                        $mail->Password = 'ppiz zylc bpod tczi';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;

                        $mail->SMTPDebug = 2;
                        $mail->Debugoutput = 'html';

                        if (empty($correo)) {
                            throw new Exception("Correo vacío");
                        }

                        $mail->setFrom('notificacion@ldrsolutions.com.mx', 'Flotilla LDR');
                        $mail->addAddress($correo);
                        $mail->addBCC('uriel.cabello@ldrsolutions.com.mx');

                        $mail->isHTML(true);
                        $mail->Subject = 'Responsiva de asignación de unidad';
                        $mail->Body = utf8_decode("Estimado colaborador $nombre_1 $nombre_2 $apaterno $amaterno. Has recibido la carta responsiva correspondiente a la asignación de tu unidad vehicular.
                                <br><br>
                                Sigue los siguientes pasos para realizar el proceso de adquisición de la unidad:
                                <br>
                                1. Descarga el archivo adjunto.
                                <br>
                                2. Verifica que tus datos y los de la unidad estén correctos.
                                <br>
                                3. Firma la carta responsiva.
                                <br>
                                4. Sube el documento en la plataforma Flotilla Interna LDR. (Recuerda que debes estar logeado o dado de alta en el sistema).
                                <br>
                                5. Espera a que te llegue un correo de confirmación para poder adquirir la unidad.
                                <br><br>
                                ¡Es de suma importancia que firmes y verifiques que los datos sean correctos para poder realizar la adquisición!
                                <br>
                                Gracias por tu atención.
                                <br>
                                Atentamente,
                                <br>
                                Equipo de Flotilla Interna LDR");
                        if (!file_exists($ruta_archivo)) {
                            throw new Exception("No existe el archivo PDF");
                        }

                        $mail->addAttachment($ruta_archivo, $nombre_archivo);

                        $mail->send();
                        echo "Correo enviado correctamente";
                    } catch (Exception $e) {
                        echo "Error al enviar: " . $mail->ErrorInfo;
                    }
                }
                exit();
            } else {
                echo "Error al obtener los datos del último registro insertado.";
            }
        } else {
            echo "Error al actualizar el estado de la unidad: " . mysqli_error($conexion);
        }
    } else {
        echo "Error al insertar la asignación: " . mysqli_error($conexion);
    }
}
