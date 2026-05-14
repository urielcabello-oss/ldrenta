    <!--------------------------------------------------Agregar nuevas licencias de conducir---------------------------------------------------->
    <?php
    include("../../conexion.php");

    //---------------------------------------------------------------AGREGAR LICENCIA------------------------------------------------
    // Realizar la consulta para obtener los colaboradores
    $queryobtenercolaboradores = "SELECT 
                                    id_colaborador, 
                                    colaboradores.id_puesto, 
                                    pues.nombre_puesto, 
                                    nombre_1, 
                                    nombre_2, 
                                    apellido_paterno, 
                                    apellido_materno, 
                                    numero_colaborador 
                                    FROM colaboradores
                                INNER JOIN puestos AS pues 
                                ON pues.id_puesto = colaboradores.id_puesto";
    $result = $conexion->query($queryobtenercolaboradores);
    // Verificar si hay resultados
    if ($result->num_rows > 0) {
        // Recorrer los resultados y mostrar las opciones
        echo '<div class="row">
        <h5><b>Colaborador </b></h5>
            <div class="col-md-10">
        <div class="form-floating">
            <input type="text" class="form-control colaboradorlicenciaconducir" id="colaboradorlicenciaconducir" placeholder="colaboradorlicenciaconducir" name="colaboradorlicenciaconducir" list="datalistcolaborador">
            <label for="colaboradorldr">Colaborador...</label>
            <datalist id="datalistcolaborador">';
        while ($row = $result->fetch_assoc()) {
            // Mostrar cada marca como una opción
            echo '<option data-id="' . $row['id_colaborador'] . '" value="' . $row['nombre_1'] . ' ' . $row['nombre_2'] . ' ' . $row['apellido_paterno'] . ' ' . $row['apellido_materno'] . ' - ' . $row['nombre_puesto'] . '">' . $row['nombre_1'] . ' ' . $row['nombre_2'] . ' ' . $row['apellido_paterno'] . ' ' . $row['apellido_materno'] . ' - ' . $row['numero_colaborador'] . ' - ' . $row['nombre_puesto'] . '</option>';

        }
        echo '</datalist>
    </div>
    <label class="" style="color: white;">*Campo obligatorio</label>
</div>
</div>';
    }
    ?>
    <div class="row">
    <h5><b>Licencia </b></h5>
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" class="form-control numerolicenciaconducir" id="numerolicenciaconducir" placeholder="numerolicenciaconducir" name="numerolicenciaconducir">
            <label for="numerolicenciaconducirldr">Número de licencia</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
    
    <?php
    $queryobtenerestadolicencia = "SELECT id_estado_licencia, estado_licencia_conducir FROM estado_licencia_conducir";
    $result = $conectar->query($queryobtenerestadolicencia);
    // Verificar si hay resultados
    if ($result->num_rows > 0) {
        // Recorrer los resultados y mostrar las opciones
        echo '<div class="col-md-6">
        <div class="form-floating">
            <select class="form-control estadolicenciaconducir" id="estadolicenciaconducir" placeholder="estadolicenciaconducir" name="estadolicenciaconducir">
                <option value="">Seleccione un estado</option>'; // Opción predeterminada

        while ($row = $result->fetch_assoc()) {
            // Mostrar cada marca como una opcion
            $selected = ($row['id_estado_licencia']);
            echo '<option value="' . $row['id_estado_licencia'] . '" ' . $selected . '>' . $row['estado_licencia_conducir'] . '</option>';
        }
        echo '</select>
        <label for="colaboradorldr">Estado</label>
    </div>
    <label class="" style="color: white;">*Campo obligatorio</label>
</div>
</div>'; 
    }
    ?>
<div class="row">
<h5><b>Fechas </b></h5>
    <div class="col-md-6">
        <div class="form-floating">
            <input type="date" class="form-control fechaemision" id="fechaemision" placeholder="fechaemision" name="fechaemision">
            <label for="fechaemisionldr">Emisión</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
    <div class="col-md-6">
        <div class="form-floating">
            <input type="date" class="form-control" id="fechavencimiento" placeholder="fechavencimiento" name="fechavencimiento">
            <label for="fechavencimientoldr">Vencimiento</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="PERMANENTE" id="licenciaPermanente" name="licenciaPermanente">
            <label class="form-check-label" for="licenciaPermanente">
              Licencia permanente
            </label>
        </div>
        
    </div>
</div>
<div class="row">
<h5><b>Archivo </b></h5>
    <div class="col-md-10">
        <div class="form-floating">
            <input type="file" class="form-control" id="archivolicenciaconducir" placeholder="archivolicenciaconducir" name="archivolicenciaconducir" accept=".pdf">
            <label for="archivolicenciaconducirldr">Archivo</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>

    </div>