<?php
include("../../../conexion.php");

// Archivo temporal donde guardaremos los eventos
$cacheFile = __DIR__ . '/cache_eventos.json';

// Verificar si existe cache y tiene menos de 5 minutos
if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < 300)) {
    $data_api = json_decode(file_get_contents($cacheFile), true);
} else {
    $url_api_fechas = "https://apipic.ldrhumanresources.com/api/course-schedules/dates";
    $ch = curl_init($url_api_fechas);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response_api = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $data_api = [];
    if ($http_code == 200 && $response_api) {
        $data_api = json_decode($response_api, true);
    }

    file_put_contents($cacheFile, json_encode($data_api));
}

echo json_encode($data_api);
