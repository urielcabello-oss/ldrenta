<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



include("../../conexion.php");
if (isset($_POST['id_asignacion'])
    && isset($_POST['comentarios_prorroga_demo'])
    && isset($_POST['fecha_prolongacion'])
    && isset($_FILES['comprobante_domicilio'])
    && isset($_FILES['constancia_fiscal'])){

        $valorid_asignacion = $_POST['id_asignacion'];
        $valorcomentarios_prorroga_demo = $_POST['comentarios_prorroga_demo'];
        $valorfecha_prolongacion = $_POST['fecha_prolongacion'];
        $valorcomprobante_domicilio = $_FILES['comprobante_domicilio'];
        $valorconstancia_fiscal = $_FILES['constancia_fiscal'];

        echo "id_asignacion: " . $valorid_asignacion . " ";
        echo "comentarios_prorroga_demo: " . $valorcomentarios_prorroga_demo . " ";
        echo "fecha_prolongacion: " . $valorfecha_prolongacion . " ";

        //obtener documentos de la prorroga
        $nombrecomprobante_domicilio = 'comprobante_domicilio_prorroga_' . $valorid_asignacion . '_' . basename($_FILES['comprobante_domicilio']['name']);
        $nombreconstancia_fiscal = 'constancia_fiscal_prorroga_' . $valorid_asignacion . '_' . basename($_FILES['constancia_fiscal']['name']);

        $rutacomprobante_domicilio = "../../archivos/files/files_asignacion_demo/files_prorroga_demo_autorizadas/";
        $rutaconstancia_fiscal = "../../archivos/files/files_asignacion_demo/files_prorroga_demo_autorizadas/";

        move_uploaded_file($_FILES['comprobante_domicilio']['tmp_name'], $rutacomprobante_domicilio . $nombrecomprobante_domicilio);
        move_uploaded_file($_FILES['constancia_fiscal']['tmp_name'], $rutaconstancia_fiscal . $nombreconstancia_fiscal);

        //insertar la prorroga
        $queryinsertarprorroga = "INSERT INTO prorrogas_unidades_demo (id_asignacion_unidad_demo,
                                                            fecha_prolongacion,
                                                            motivo_prorroga,
                                                            archivo_domicilio,
                                                            archivo_constancia_situacion_fiscal)
                                VALUES ('$valorid_asignacion',
                                        '$valorfecha_prolongacion',
                                        '$valorcomentarios_prorroga_demo',
                                        '$nombrecomprobante_domicilio',
                                        '$nombreconstancia_fiscal')";

        $ejecutarinsertarprorroga = mysqli_query($conexion, $queryinsertarprorroga);
        if ($ejecutarinsertarprorroga) {
            echo "Prorroga insertada correctamente";


        }else{
            echo "Faltan datos";
        }
}else{
    echo "Faltan datos en el formulario.";
}
?>