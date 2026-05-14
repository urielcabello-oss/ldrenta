<?php
require '../../lib/dompdf/autoload.inc.php';
use Dompdf\Dompdf;


include("../../../Servidor/conexion.php");

$id = intval($_GET["id_bitacora"]);

$query = "SELECT d.*, 
    c.nombre_1, c.nombre_2, c.apellido_paterno, c.apellido_materno
            FROM bitacora_diaria d 
            LEFT JOIN colaboradores c ON d.id_master_driver = c.id_colaborador 
            WHERE id_bitacora = $id";
$res = mysqli_query($conexion, $query);
$bitacora = mysqli_fetch_assoc($res);

$queryM = "SELECT * FROM bitacora_muestreos WHERE id_bitacora = $id ORDER BY hora ASC";
$resM = mysqli_query($conexion, $queryM);
$muestreos = [];
while($row = mysqli_fetch_assoc($resM)) { $muestreos[] = $row; }

function checkSN($val) {
    return ($val == 1 || strtolower($val)=="si") ? "✔" : "✘";
}

$html = '
<style>
body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
h2 { text-align:center; margin-bottom:5px; color:#808080; }
.header { border-bottom:2px solid #797877ff; margin-bottom:10px; display:flex; justify-content:space-between; align-items:center; }
.header img { height:50px; }
.section-title { background:#565656; color:#fff; font-weight:bold; padding:4px; margin-top:10px; }
table { border-collapse: collapse; width: 100%; margin-top:5px; }
th, td { border: 1px solid #808080; padding: 4px; text-align: center; }
th { background: #f0f0f0; }
.signature { height:50px; border-top:1px solid #000; text-align:center; margin-top:30px; width:45%; display:inline-block; }
.footer { position: fixed; bottom: -10px; left: 0; right: 0; text-align: center; font-size: 10px; color:#555; }
.page-break { page-break-after: always; }
</style>

<div class="header">
  <img class="" src="../../../Cliente/img/LDR_LOGO.png" alt="">
  <div><h2>Bitácora Diaria (V1.0 2025)<br>Pruebas de Desempeño</h2></div>
</div>

<p><strong>Origen:</strong> '.$bitacora["origen"].' | 
<strong>Destino:</strong> '.$bitacora["destino"].' | 
<strong>Fecha:</strong> '.$bitacora["fecha"].'</p>
<p><strong>Master Driver:</strong> '.$bitacora["nombre_1"].' '.$bitacora["nombre_2"].' '.$bitacora["apellido_paterno"].' '.$bitacora["apellido_materno"].'</p>

<div class="section-title">Revisión Previa a la Jornada</div>
<table>
<tr><td>Objetivo de prueba (Rendimiento o Desempeño)</td><td>'.$bitacora["objetivo_prueba"].'</td></tr>
<tr><td>Kilometraje Inicial</td><td>'.$bitacora["kilometraje_inicial"].'</td></tr>
<tr><td>Hora de Inicio de la Jornada </td><td>'.$bitacora["hora_inicio"].'</td></tr>
<tr><td>Nivel de Combustible (Tanque Lleno marcar “✔”)</td><td>'.checkSN($bitacora["combustible_inicio"]).'</td></tr>
<tr><td>Nivel de Urea (Tanque Lleno marcar “✔”)</td><td>'.checkSN($bitacora["urea_inicio"]).'</td></tr>
<tr><td>Presión de Llantas</td><td>'.checkSN($bitacora["llantas_inicio"]).'</td></tr>
<tr><td>Revisión de Niveles (Aceite, Refrigerante y Dirección Hidráulica)</td><td>'.checkSN($bitacora["niveles_inicio"]).'</td></tr>
<tr><td>Códigos de Falla Activos en Tablero.</td><td>'.checkSN($bitacora["fallas_inicio"]).'</td></tr>
<tr><td>Revisión de Fugas en la Unidad.</td><td>'.checkSN($bitacora["fugas_inicio"]).'</td></tr>
<tr><td>Revisión por Golpes o Daños en la unidad.</td><td>'.checkSN($bitacora["golpes_inicio"]).'</td></tr>
<tr><td>Peso de Carga (Toneladas)</td><td>'.$bitacora["peso_carga"].'</td></tr>
</table>

<div class="section-title">Revisión Fin de Jornada</div>
<table>
<tr><td>Kilometraje Final</td><td>'.$bitacora["kilometraje_final"].'</td></tr>
<tr><td>Hora de Fin de la Jornada</td><td>'.$bitacora["hora_fin"].'</td></tr>
<tr><td>Nivel de Combustible (Tanque Lleno marcar “✔”)</td><td>'.checkSN($bitacora["combustible_fin"]).'</td></tr>
<tr><td>Nivel de Urea (Tanque Lleno marcar “✔”)</td><td>'.checkSN($bitacora["urea_fin"]).'</td></tr>
<tr><td>Códigos de Falla Activos en Tablero.</td><td>'.checkSN($bitacora["fallas_fin"]).'</td></tr>
<tr><td>Revisión de Fugas en la Unidad.</td><td>'.checkSN($bitacora["fugas_fin"]).'</td></tr>
<tr><td>Revisión por Golpes o Daños en la unidad.</td><td>'.checkSN($bitacora["golpes_fin"]).'</td></tr>
</table>
<br>

<div style="margin-top:40px; text-align:center;">
  <div class="signature">Nombre y Firma del Operador</div>
  <div class="signature">Nombre y Firma Master Driver</div>
</div>

<div class="footer">LDR Solutions / Dirección Operaciones / Capacitación Operaciones</div>

<div class="page-break"></div>

<h2>Supervisión Durante la Jornada</h2>
<table>
<thead>
<tr>
<th>Hora</th>
<th>RPM/Relación</th>
<th>Velocidad (Km/h)</th>
<th>Temperatura (°C)</th>
<th>Presión Aceite</th>
<th>Presión Aire</th>
<th>Odómetro</th>
</tr>
</thead>
<tbody>';

if (count($muestreos)>0) {
    foreach($muestreos as $m) {
        $html .= '<tr>
        <td>'.$m["hora"].'</td>
        <td>'.$m["rpm_relacion"].'</td>
        <td>'.$m["velocidad"].'</td>
        <td>'.$m["temperatura"].'</td>
        <td>'.$m["presion_aceite"].'</td>
        <td>'.$m["presion_aire"].'</td>
        <td>'.$m["odometro"].'</td>
        </tr>';
    }
} else {
    $html .= '<tr><td colspan="7">No se registraron muestreos</td></tr>';
}
$html .= '</tbody></table>

<div class="section-title">¿Durante la jornada ocurrió algún evento importante a destacar? (Seguridad y/o Consumo)</div>
<p style="margin-bottom:40px; font-size:0.8rem;">'.$bitacora["eventos_importantes"].'</p>

<div class="footer">LDR Solutions / Dirección Operaciones / Capacitación Operaciones</div>
';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("Bitacora_".$bitacora["id_bitacora"].".pdf", ["Attachment" => false]);

?>