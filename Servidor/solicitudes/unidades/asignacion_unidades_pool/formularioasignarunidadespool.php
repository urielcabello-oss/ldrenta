<div>
    <h5>Selecciona al usuario y la unidad para vizualisar las unidades disponibles</h5>
    <div class="contenedorasignacionunidades">
        <div class="row">
            <!-------------------------------------------select colaboradores--------------------------------------->
            <?php include("../../../conexion.php");

            $sqlcolaboradorespool = "SELECT id_colaborador, nombre_1, nombre_2, apellido_paterno, apellido_materno
                            FROM colaboradores";

            $result = $conectar->query($sqlcolaboradorespool);

            echo '
            <div class="col-md-4">
                <div class="form-floating">
                    <select class="form-control" name="selectcolaboradorasignacionpool" id="selectcolaboradorasignacionpool">
                    <option value="">Seleccione un colaborador</option>'; // Opción predeterminada
            while ($rowcolaboradorpool = $result->fetch_assoc()) {
                // Mostrar cada estado como una opcion
                $selected = ($data['id_colaborador'] == $rowcolaboradorpool['id_colaborador']) ? 'selected' : '';
                echo'<option value="' .  $rowcolaboradorpool['id_colaborador'] . '" ' . $selected . '>' . $rowcolaboradorpool['nombre_1'] . ' ' . $rowcolaboradorpool['nombre_2'] . ' ' . $rowcolaboradorpool['apellido_paterno'] . ' ' . $rowcolaboradorpool['apellido_materno'] . '</option>';
            }
                    echo '</select>
                    <label for="marcaunidadldr">Colaboradores</label>
                </div>
            </div>';
            ?>

            <!-----------------------------------------------Select modelos-------------------------------------->
            <?php include("../../../conexion.php");

            $sqlmodelosasignacionpool = "SELECT id_modelo, nombre_modelo
                                            FROM modelos
                                            WHERE id_modelo IN (4, 5, 6)";

            $result = $conectar->query($sqlmodelosasignacionpool);

            echo '<div class="col-md-4">
                <div class="form-floating">
                    <select class="form-control" name="selectmodelosasignacionpool" id="selectmodelosasignacionpool">
                    <option value="">Seleccione un modelo</option>'; // Opción predeterminada
            while ($rowmodelosasignacionpool = $result->fetch_assoc()) {
                // Mostrar cada estado como una opcion
                $selected = ($data['id_modelo'] == $rowmodelosasignacionpool['id_modelo']) ? 'selected' : '';
                echo'<option value="' .  $rowmodelosasignacionpool['id_modelo'] . '" ' . $selected . '>' . $rowmodelosasignacionpool['nombre_modelo'] . '</option>';
            }
                    echo '</select>
                    <label for="modelounidadldr">Modelos</label>
                </div>
            </div>
        </div>
    </div>';
    ?>

    <div class="row">
        <div class="contenedortablasignacionunidades">
              <!----------------------------------------------tabla de las unidades------------------------------------>
  <table class="table table-hover tablasignacionunidadespool" id="tablasignacionunidadespool">
    
  </table>
        </div>

    </div>
</div>
