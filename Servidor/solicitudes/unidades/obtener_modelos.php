<?php
include("../../conexion.php");

if (isset($_GET['marca_id'])) {
    $marca_id = intval($_GET['marca_id']);
    $sql = "SELECT id_modelo, nombre_modelo FROM modelos WHERE id_marca = $marca_id";
    $result = $conectar->query($sql);

    $modelos = array();
    while ($row = $result->fetch_assoc()) {
        $modelos[] = $row;
    }

    echo json_encode($modelos);
}
?>
