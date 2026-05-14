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
        <div class="col-md-10">
        <div class="form-floating">
            <input type="text" class="form-control colaboradorine" id="colaboradorine" placeholder="colaboradorine" name="colaboradorine" list="datalistcolaborador">
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
        <div class="col-md-6">
            <h3>Sección</h3>
            <div class="form-floating">
                <input type="number" class="form-control seccionine" id="seccionine" placeholder="seccionine" name="seccionine" min="0" max="4">
                <label for="domicilioldr">Sección</label>
            </div>
            <label class="float-end" style="color: black;">Ejemplo: 1727</label>
        </div>
        <div class="col-md-6">
            <h3>Vigencia</h3>
            <div class="form-floating">
                <input type="text" class="form-control vigenciaine" id="vigenciaine" placeholder="vigenciaine" name="vigenciaine">
                <label for="domicilioldr">Vigencia</label>
            </div>
            <label class="float-end" style="color: black;">Ejemplo: 2020-2030</label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <h5><b>Archivo INE</b></h5>
            <div class="form-floating">
                <input type="file" class="form-control archivoine" id="archivoine" placeholder="archivoine" name="archivoine" accept=".pdf">
                <label for="archivoineldr">Archivo ine</label>
            </div>
            <label class="" style="color: white;">*Campo obligatorio</label>
        </div>
    </div>
    
