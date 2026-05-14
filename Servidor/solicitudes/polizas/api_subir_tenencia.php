<?php
// 🔥 PERMITIR CORS
header("Access-Control-Allow-Origin: https://ldrhsys.ldrhumanresources.com");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// 🔥 RESPUESTA PARA PREFLIGHT (MUY IMPORTANTE)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}
$ruta = __DIR__ . "/../../archivos/files/files_unidades/polizas_tenencias/";

if (!file_exists($ruta)) {
    mkdir($ruta, 0777, true);
}

$nombre = time() . "_" . preg_replace('/[^A-Za-z0-9.\-_]/', '_', $_FILES['documento']['name']);

if (move_uploaded_file($_FILES['documento']['tmp_name'], $ruta . $nombre)) {
    echo $nombre; // 👈 regresas el nombre
} else {
    echo "error";
}
?>