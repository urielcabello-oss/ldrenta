<div class="row">
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
            <input type="text" class="form-control colaboradordomicilio" id="colaboradordomicilio" placeholder="colaboradordomicilio" name="colaboradordomicilio" list="datalistcolaborador">
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
    <h3>Domicilio</h3>
    <!-- domicilio -->
    <div class="col-md-8">
        <div class="form-floating">
            <input type="text" class="form-control domicilio" id="domicilio" placeholder="domicilio" name="domicilio">
            <label for="domicilioldr">Domicilio</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
    <!--archivo comprobande de domicilio-->
    <h5><b>Archivo comprobande de domicilio</b></h5>
    <div class="col-md-10">
        <div class="form-floating">
            <input type="file" class="form-control archivodomicilio" id="archivodomicilio" placeholder="archivodomicilio" name="archivodomicilio" accept=".pdf">
            <label for="archivodomicilioldr">Archivo domicilio</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
</div>
