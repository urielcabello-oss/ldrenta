<div>
    <h5>Busca el nombre del colaborador</h5>
    <div class="contenedorasignacionunidades">
        <div class="row">
            <?php
            include("../../../conexion.php");
            //realizar consulta a la base de datos para obtener los colaboradores
            $sqltipodirectivos = "SELECT 
    personas_fisicas.id_persona_fisica,
    personas_fisicas.nombre_1, 
    personas_fisicas.nombre_2, 
    personas_fisicas.apellido_paterno, 
    personas_fisicas.apellido_materno
FROM personas_fisicas";
            $result = $conectar->query($sqltipodirectivos);
            if ($result->num_rows > 0) {
                // Recorrer los resultados y mostrar las opciones
            echo '<div class="col-md-7">
    <div class="form-floating">
        <input type="text" class="form-control tipodirectivo" id="tipodirectivo" placeholder="tipodirectivo" name="tipodirectivo" list="datalisttipodirectivo">
            <label for="colaboradorldr">Colaborador</label>
            <datalist id="datalisttipodirectivo">';
            while ($rowtipodirectivos = $result->fetch_assoc()) {
                // Mostrar cada colaborador como una opción
                echo '<option data-id="' . $rowtipodirectivos['id_persona_fisica'] . '" value="' . $rowtipodirectivos['nombre_1'] . ' ' . $rowtipodirectivos['nombre_2'] . ' ' . $rowtipodirectivos['apellido_paterno'] . ' ' . $rowtipodirectivos['apellido_materno'] . '">' . $rowtipodirectivos['nombre_1'] . ' ' . $rowtipodirectivos['nombre_2'] . ' ' . $rowtipodirectivos['apellido_paterno'] . ' ' . $rowtipodirectivos['apellido_materno'] . '</option>';
            }
            echo '</datalist>
    </div>
    <label class="" style="color: white;">*Campo obligatorio</label>
</div>';
        }
            ?>


            <!-----------------------------------------------Select modelos-------------------------------------->
            <div class="col-md-5">
                <div class="form-floating">
                    <select class="form-control" name="selectmodelosasignacion" id="selectmodelosasignacion">
                    </select>
                    <label for="marcaunidadldr">Modelos</label>
                </div>
            </div>
        </div>
        
    <label class="" style="color: white;">*Campo obligatorio</label>
    </div>

    <div class="row">
        <div class="contenedortablasignacionunidades">
              <!--tabla de las unidades-->
  <table class="table table-hover tablasignacionunidades" id="tablasignacionunidades">
    
  </table>
        </div>

    </div>
</div>