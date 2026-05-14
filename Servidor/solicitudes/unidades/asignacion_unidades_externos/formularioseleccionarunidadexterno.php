<?php
include("../../../conexion.php");

//consulta obtener el ultimo usuario registrado
$queryobtenerultimouserexterno = "SELECT id_usuario_externo, id_tipo_usuario_externo, nombre_1, nombre_2, apellido_paterno, apellido_materno 
                                    FROM usuarios_externos 
                                    ORDER BY id_usuario_externo DESC LIMIT 1";
$result = $conexion->query($queryobtenerultimouserexterno);
if ($result->num_rows > 0) {
    $rowusuarioexterno = $result->fetch_assoc();
    $id_usuario_externo = $rowusuarioexterno['id_usuario_externo'];
}
echo '
        <div class="row">
        <!-----------------------------------------------------------------------Ultimousuario insertado externo-------------------------------------->
        <div class="col-md-5">
            <div class="form-floating">
                <input type="text" class="form-control" id="usuarioexternoasignacion" placeholder="usuarioexternoasignacion" name="usuarioexternoasignacion" value="' . $rowusuarioexterno['nombre_1'] . ' ' . $rowusuarioexterno['nombre_2'] . ' ' . $rowusuarioexterno['apellido_paterno'] . ' ' . $rowusuarioexterno['apellido_materno'] . '"  disabled data-idusuexterno="' . $id_usuario_externo . '">
                <label for="usuarioexternounidadldr">Nombre del usuario externo</label>
            </div>
            <label class="" style="color: white;">*Campo obligatorio</label>
        </div>';

        $queryontenermodelosunidades = "SELECT id_modelo, nombre_modelo FROM modelos";
        $result = $conectar->query($queryontenermodelosunidades);
        echo '<div class="col-md-6">
            <div class="form-floating">
                <select class="form-control selectmodelosasignacion" id="selectmodelosasignacion" placeholder="selectmodelosasignacion" name="selectmodelosasignacion">
                    <option value="">Seleccione un modelo</option>'; // Opción predeterminada
        while ($rowmodelosunidades = $result->fetch_assoc()) {
            // Mostrar cada estado como una opcion
            $selected = ($data['id_modelo'] == $rowmodelosunidades['id_modelo']) ? 'selected' : '';
            echo '<option value="' . $rowmodelosunidades['id_modelo'] . '" ' . $selected . '>' . $rowmodelosunidades['nombre_modelo'] . '</option>';
        }
        echo '</select>
            <label for="modelounidadldr">Modelos</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
    </div>';
?>
    <div class="row">
        <div class="contenedortablasignacionunidades">
              <!--tabla de las unidades-->
  <table class="table table-hover tablasignacionunidades" id="tablasignacionunidades">
    
  </table>
        </div>

    </div>
