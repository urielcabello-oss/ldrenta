<?php 
include("../../../conexion.php");
if (isset($_POST['tipodirectivo'])) {
    $id_tipo_directivo = $_POST['tipodirectivo'];

    //realizar la consulta a la base de datos para obtener los modelos
    $sqlmodelos = "SELECT  id_modelo, nombre_modelo
                            FROM modelos";
    $result = $conectar->query($sqlmodelos);

    echo '<option value="">Seleccione un modelo</option>'; // Opción predeterminada
    while ($row = $result->fetch_assoc()) {
        // Mostrar cada estado como una opcion
        echo '<option value="' . $row['id_modelo'] . '">' . $row['nombre_modelo'] . '</option>';
    }

}else{
    echo"no se obtuvo colaborador";
}
?>