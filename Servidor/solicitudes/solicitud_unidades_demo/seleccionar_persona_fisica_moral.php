<?php
include("../../conexion.php");

if (!isset($_SESSION)
    && isset($_POST['id_unidad'])) {
    session_start();
}

$id_usuario_demo = $_SESSION['id_colaborador'];
$id_unidad_demo = $_POST['id_unidad'];
$data_fecha_solicitudemo = $_POST['data_fecha_solicitudemo'];
$data_fecha_devoluciondemo = $_POST['data_fecha_devoluciondemo'];

?>

    <div class="d-flex justify-content-center mb-3">
        <button type="button" class="btn btn-asignar_persona_fisica me-2 btnasignarpersonafisica" 
            data-idusuario="<?php echo $id_usuario_demo; ?>" 
            data-idunidad="<?php echo $id_unidad_demo; ?>" 
            data-fecha_solicitud="<?php echo $data_fecha_solicitudemo; ?>" 
            data-fecha_devolucion="<?php echo $data_fecha_devoluciondemo; ?>" 
        id="btnasignarpersonafisica"><i class="fa-solid fa-person"></i> Persona física</button>

        <button type="button" class="btn btn-asignar-persona-moral me-2 btnasignarpersonamoral" 
            data-idusuario="<?php echo $id_usuario_demo; ?>" 
            data-idunidad="<?php echo $id_unidad_demo; ?>" 
            data-fecha_solicitud="<?php echo $data_fecha_solicitudemo; ?>" 
            data-fecha_devolucion="<?php echo $data_fecha_devoluciondemo; ?>" 
        id="btnasignarpersonamoral"><i class="fa-solid fa-building-user"></i> Persona moral</button>
        
    </div>
       <!--tabla de las unidades-->
  <table class="table table-hover tablasignacionunidadesdemos" id="tablasignacionunidadesdemos">
    
  </table>
