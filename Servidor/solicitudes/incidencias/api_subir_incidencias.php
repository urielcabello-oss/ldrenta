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

$ruta = __DIR__ . "/../../archivos/files/files_unidades/incidencias/";

// 🔥 CREAR CARPETA SI NO EXISTE
if (!file_exists($ruta)) {
    mkdir($ruta, 0777, true);
}

$respuesta = [];

if (isset($_FILES['imagenes'])) {

    $total = count($_FILES['imagenes']['name']);

    for ($i = 0; $i < $total; $i++) {

        if ($_FILES['imagenes']['name'][$i] != "") {

            $nombreOriginal = $_FILES['imagenes']['name'][$i];
            $tmp = $_FILES['imagenes']['tmp_name'][$i];

            // 🔥 LIMPIAR NOMBRE
            $nombreLimpio = preg_replace('/[^A-Za-z0-9.\-_]/', '_', $nombreOriginal);

            // 🔥 NOMBRE FINAL
            $nombre = time() . "_" . $i . "_" . $nombreLimpio;

            if (move_uploaded_file($tmp, $ruta . $nombre)) {
                $respuesta[] = $nombre;
            }
        }
    }
}

// 🔥 RESPUESTA IGUAL QUE TENENCIA (pero múltiple)
echo json_encode($respuesta);