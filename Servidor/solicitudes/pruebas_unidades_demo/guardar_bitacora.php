<?php
include("../../conexion.php");
header('Content-Type: application/json; charset=utf-8');
//-----------------------------------------------------------------------obtenemos el id del colaborador para saber quien es el que esta logeado
if (!isset($_SESSION)) {
    session_start();
}

$colaborador = $_SESSION['id_colaborador'];

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conexion->set_charset('utf8mb4');

function boolField($name){
  return isset($_POST[$name]) ? 1 : 0;
}

try {
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método no permitido');
  }

  // Sanitización básica
  $id_prueba         = (int)($_POST['id_prueba'] ?? 0);
  $fecha             = trim($_POST['fecha'] ?? '');
  $objetivo_prueba   = trim($_POST['objetivo_prueba'] ?? '');
  $origen            = trim($_POST['origen'] ?? '');
  $destino           = trim($_POST['destino'] ?? '');
  $peso_carga        = isset($_POST['peso_carga']) && $_POST['peso_carga'] !== '' ? (float)$_POST['peso_carga'] : null;

  // Inicio jornada
  $kilometraje_inicial = isset($_POST['kilometraje_inicial']) ? (int)$_POST['kilometraje_inicial'] : null;
  $hora_inicio         = trim($_POST['hora_inicio'] ?? '');
  $combustible_inicio  = boolField('combustible_inicio');
  $urea_inicio         = boolField('urea_inicio');
  $llantas_inicio      = boolField('llantas_inicio');
  $niveles_inicio      = boolField('niveles_inicio');
  $fallas_inicio       = boolField('fallas_inicio');
  $fugas_inicio        = boolField('fugas_inicio');
  $danos_inicio        = boolField('danos_inicio');

  // Fin jornada
  $kilometraje_final = isset($_POST['kilometraje_final']) ? (int)$_POST['kilometraje_final'] : null;
  $hora_fin          = trim($_POST['hora_fin'] ?? '');
  $combustible_fin   = boolField('combustible_fin');
  $urea_fin          = boolField('urea_fin');
  $fallas_fin        = boolField('fallas_fin');
  $fugas_fin         = boolField('fugas_fin');
  $danos_fin         = boolField('danos_fin');

  $eventos_importantes = trim($_POST['eventos_importantes'] ?? '');

  // Validaciones mínimas
  if ($id_prueba <= 0) { throw new RuntimeException('Falta id_prueba.'); }
  if ($fecha === '')   { throw new RuntimeException('Falta fecha.'); }
  if ($objetivo_prueba === '') { throw new RuntimeException('Falta objetivo de prueba.'); }
  if ($kilometraje_inicial === null || $kilometraje_final === null) { throw new RuntimeException('Kilometrajes requeridos.'); }
  if ($hora_inicio === '' || $hora_fin === '') { throw new RuntimeException('Horas de inicio/fin requeridas.'); }

  $conexion->begin_transaction();

  // Insertamos los datos 
  $sql = "INSERT INTO bitacora_diaria (
            id_prueba, fecha, origen, destino, id_master_driver,
            objetivo_prueba, kilometraje_inicial, hora_inicio,
            combustible_inicio, urea_inicio, llantas_inicio, niveles_inicio,
            fallas_inicio, fugas_inicio, golpes_inicio, peso_carga,
            kilometraje_final, hora_fin, combustible_fin, urea_fin,
            fallas_fin, fugas_fin, golpes_fin, eventos_importantes
          ) VALUES (
            ?,?,?,?,?, ?,?,?, ?,?,?,?,?, ?,?,?, ?,?,?, ?,?,?, ?,?
          )";

  // Nota: la cadena de tipos tiene 25 caracteres (uno por cada parametro)
  $stmt = $conexion->prepare($sql);
  $stmt->bind_param(
    'isssisisiiiiiiidisiiiiis',
    $id_prueba, $fecha, $origen, $destino, $colaborador,
    $objetivo_prueba, $kilometraje_inicial, $hora_inicio,
    $combustible_inicio, $urea_inicio, $llantas_inicio, $niveles_inicio,
    $fallas_inicio, $fugas_inicio, $danos_inicio, $peso_carga,
    $kilometraje_final, $hora_fin, $combustible_fin, $urea_fin,
    $fallas_fin, $fugas_fin, $danos_fin, $eventos_importantes
  );
  $stmt->execute();
  $id_bitacora = $stmt->insert_id;

  // Insert muestreos
  if (!empty($_POST['muestreos']) && is_array($_POST['muestreos'])) {
    $sqlM = "INSERT INTO bitacora_muestreos (
              id_bitacora, hora, rpm_relacion, velocidad, temperatura, presion_aceite, presion_aire, odometro
            ) VALUES (?,?,?,?,?,?,?,?)";
    $stmtM = $conexion->prepare($sqlM);

    foreach ($_POST['muestreos'] as $m) {
      if (!is_array($m)) continue;
      $hora            = trim($m['hora'] ?? '');
      $rpm_relacion    = trim($m['rpm_relacion'] ?? '');
      $velocidad       = ($m['velocidad'] === '' ? null : (float)$m['velocidad']);
      $temperatura     = ($m['temperatura'] === '' ? null : (float)$m['temperatura']);
      $presion_aceite  = ($m['presion_aceite'] === '' ? null : (float)$m['presion_aceite']);
      $presion_aire    = ($m['presion_aire'] === '' ? null : (float)$m['presion_aire']);
      $odometro        = ($m['odometro'] === '' ? null : (int)$m['odometro']);

      $stmtM->bind_param('issddddi',
        $id_bitacora, $hora, $rpm_relacion,
        $velocidad, $temperatura, $presion_aceite, $presion_aire,
        $odometro
      );
      $stmtM->execute();
    }
  }

  $conexion->commit();

echo json_encode([
  'status' => 'success',
  'message' => 'Bitácora registrada correctamente',
  'id_bitacora' => $id_bitacora
]);
exit;

}
catch (Throwable $e) {
  if ($conexion) { $conexion->rollback(); }
  http_response_code(400);
  echo json_encode([
    'status' => 'error',
    'message' => $e->getMessage()
  ]);
  exit;
}

