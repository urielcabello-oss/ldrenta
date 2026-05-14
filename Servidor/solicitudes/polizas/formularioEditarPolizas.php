<div class="row">
    <!-- ------------------------------------------------------------------------polizas de aseguradora ------------------------------------------------------------------->
    <h3>Edición de información</h3>
</div>
<div class="row">
    <!---------------------------------------------------------------------------edicion de polizas ------------------------------------------------------------------->
    <?php
    include("../../conexion.php");

    if (isset($_POST['idpoliza'])) {
        $idpoliza = $_POST['idpoliza'];

        //vamos a obtener los valores de la poliza de aeguradoras por unidad
        $queryobtenerpoliza = "SELECT * FROM asignacion_aseguradora_unidad WHERE id_asignacion_aseguradora = $idpoliza";

        $ejecutarobtenervalorpoliza = $conectar->query($queryobtenerpoliza);
        if (mysqli_num_rows($ejecutarobtenervalorpoliza) > 0) {
            $data = mysqli_fetch_array($ejecutarobtenervalorpoliza);
        }


        $sql = "SELECT id_aseguradora, aseguradora FROM aseguradoras";
        $result = $conectar->query($sql);
        if ($result->num_rows > 0) {
            // Recorrer los resultados y mostrar las opciones
            echo '<div class="col-md-6">
            <div class="form-floating">
                <select class="form-select" id="nombreaseguradoraeditar" name="nombreaseguradoraeditar">
                    <option selected>Seleccionar aseguradora</option>';

            while ($row = $result->fetch_assoc()) {
                // Mostrar cada marca como una opción
                if ($data['id_aseguradora'] == $row['id_aseguradora']) {
                    echo '<option value="' . $row['id_aseguradora'] . '" selected>' . $row['aseguradora'] . '</option>';
                } else {
                    echo '<option value="' . $row['id_aseguradora'] . '">' . $row['aseguradora'] . '</option>';
                }
            }

            echo '</select>
                <label for="editarpolizasunidadldr">Aseguradora</label>
            </div>
            <label class="" style="color: white;">*Campo obligatorio</label>
        </div>';
        } else {
            echo "No hay tipopolizas disponibles.";
        }


    ?>
        <!---------------------------------------------------------------- edicion Identificador poliza de seguro ---------------------------------------->
        <div class="col-md-6">
            <div class="form-floating">
                <input type="text" class="form-control" id="identificadopolizaseguroeditar" value="<?php echo $data['numero_poliza_aseguradora']; ?>" placeholder="identificadopolizaseguroeditar" name="identificadopolizaseguroeditar">
                <label for="identificadopolizaseguroeditarldr">Folio</label>
            </div>
            <label class="" style="color: white;">*Campo obligatorio</label>
        </div>
</div>


<div class="row">
    <h3>Fechas de registro y vencimiento</h3>
    <!---------------------------------------------------------------- edicion Fecha de alta de poliza ---------------------------------------->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="date" class="form-control" id="fechaaltaseguroeditar" value="<?php echo $data['fecha_alta']; ?>" placeholder="fechaaltaseguroeditar" name="fechaaltaseguroeditar">
            <label for="fechaaltaseguroeditarldr">Alta</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
    <!---------------------------------------------------------------- edicion Fecha de vencimiento de poliza ---------------------------------------->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="date" class="form-control" id="fechavencimientoaseguradoraeditar" value="<?php echo $data['fecha_vencimiento']; ?>" placeholder="fechavencimientoaseguradoraeditar" name="fechavencimientoaseguradoraeditar">
            <label for="fechavencimientoaseguradoraeditarldr">Vencimiento</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
</div>
<div class="row">
<h3>Estado y estatus</h3>
    <!---------------------------------------------------------------- editar Estado aseguradora ---------------------------------------->
    <?php
        $sql = "SELECT id_estado_aseguradora, estado_aseguradora FROM estado_aseguradora";
        $result = $conectar->query($sql);
        if ($result->num_rows > 0) {
            // Recorrer los resultados y mostrar las opciones
            echo '<div class="col-md-6">
         <div class="form-floating">
             <select class="form-select" id="estadoaseguradoraeditar" name="estadoaseguradoraeditar">
                 <option selected>Seleccionar aseguradora</option>';

            while ($row = $result->fetch_assoc()) {
                // Mostrar cada marca como una opción
                if ($data['id_estado_aseguradora'] == $row['id_estado_aseguradora']) {
                    echo '<option value="' . $row['id_estado_aseguradora'] . '" selected>' . $row['estado_aseguradora'] . '</option>';
                } else {
                    echo '<option value="' . $row['id_estado_aseguradora'] . '">' . $row['estado_aseguradora'] . '</option>';
                }
            }

            echo '</select>
             <label for="editarpolizasunidadldr">Estado</label>
         </div>
         <label class="" style="color: white;">*Campo obligatorio</label>
     </div>';
        } else {
            echo "No hay tipopolizas disponibles.";
        }
    ?>
    <!---------------------------------------------------------------- editar Estatus aseguradora ---------------------------------------->
    <?php
        $sql = "SELECT id_estatus_aseguradora, estatus FROM estatus_aseguradora";
        $result = $conectar->query($sql);
        if ($result->num_rows > 0) {
            // Recorrer los resultados y mostrar las opciones
            echo '<div class="col-md-6">
         <div class="form-floating">
             <select class="form-select" id="estatusaseguradoraeditar" name="estatusaseguradoraeditar">
                 <option selected>Seleccionar aseguradora</option>';

            while ($row = $result->fetch_assoc()) {
                // Mostrar cada marca como una opción
                if ($data['id_estatus_aseguradora'] == $row['id_estatus_aseguradora']) {
                    echo '<option value="' . $row['id_estatus_aseguradora'] . '" selected>' . $row['estatus'] . '</option>';
                } else {
                    echo '<option value="' . $row['id_estatus_aseguradora'] . '">' . $row['estatus'] . '</option>';
                }
            }

            echo '</select>
             <label for="editarpolizasunidadldr">Estatus</label>
         </div>
         <label class="" style="color: white;">*Campo obligatorio</label>
     </div>';
        } else {
            echo "No hay tipopolizas disponibles.";
        }
    ?>
</div>
<div class="row">
<h3>Documento</h3>
    <!-----------------------------------------------------------------------Documento edicion de polizas de unidades -------------------------------------------------------------------->
    <div class="col-md-8">
        <div class="form-floating">
            <div class="form-label">
                <input type="file" class="form-control" id="editar_documento_poliza" name="editar_documento_poliza" accept=".pdf" value="<?php echo $data['documento_aseguradora']; ?>">
                
            </div>
        </div>
    </div>
</div>
<?php
    }
?>