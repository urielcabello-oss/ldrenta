<div>
    <h5>Busca el nombre del colaborador</h5>
    <div class="contenedorasignacionunidades">
        <div class="row">
            <?php
            include("../../../conexion.php");
            //realizar consulta a la base de datos para obtener los colaboradores
            $sqltipodirectivos = "SELECT 
    colaboradores.id_colaborador, 
    colaboradores.id_puesto, 
    pues.nombre_puesto, 
    colaboradores.nombre_1, 
    colaboradores.nombre_2, 
    colaboradores.apellido_paterno, 
    colaboradores.apellido_materno, 
    colaboradores.numero_colaborador
FROM colaboradores
INNER JOIN puestos AS pues ON pues.id_puesto = colaboradores.id_puesto
";
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
                echo '<option data-id="' . $rowtipodirectivos['id_colaborador'] . '" value="' . $rowtipodirectivos['nombre_1'] . ' ' . $rowtipodirectivos['nombre_2'] . ' ' . $rowtipodirectivos['apellido_paterno'] . ' ' . $rowtipodirectivos['apellido_materno'] . ' - ' . $rowtipodirectivos['nombre_puesto'] . '">' . $rowtipodirectivos['nombre_1'] . ' ' . $rowtipodirectivos['nombre_2'] . ' ' . $rowtipodirectivos['apellido_paterno'] . ' ' . $rowtipodirectivos['apellido_materno'] . ' - ' . $rowtipodirectivos['numero_colaborador'] . ' - ' . $rowtipodirectivos['nombre_puesto'] . '</option>';
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