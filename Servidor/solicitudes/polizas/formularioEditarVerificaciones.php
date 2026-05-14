<div class="row">
    <!-- ------------------------------------------------------------------------editar Tenencias ------------------------------------------------------------------->
    <h3>Edición de información</h3>
</div>
<div class="row">
    <?php
    include("../../conexion.php");

    if (isset($_POST['idverificacion'])) {
        $idverificacion = $_POST['idverificacion'];

        //vamos a obtener los valores de la poliza de aeguradoras por unidad
        $queryobtenerverificaciones = "SELECT * FROM verificaciones WHERE id_verificaciones = $idverificacion";

        $ejecutarobtenerverificacion = $conectar->query($queryobtenerverificaciones);
        if (mysqli_num_rows($ejecutarobtenerverificacion) > 0) {
            $data = mysqli_fetch_array($ejecutarobtenerverificacion);
        }
    ?>
        <!---------------------------------------------------------------- editar folio verificacion ---------------------------------------->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" class="form-control" id="folioverificacioneditar" value="<?php echo $data['folio']; ?>" placeholder="folioverificacioneditar" name="folioverificacioneditar">
            <label for="folioverificacioneditarldr">Folio</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
        <!---------------------------------------------------------------- editar monto verificacion ---------------------------------------->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="number" class="form-control" id="montoverificacioneditar" value="<?php echo $data['monto']; ?>" placeholder="montoverificacioneditar" name="montoverificacioneditar" oninput="document.getElementById('MontoVerificacionEditar').innerText = this.value ? parseFloat(this.value).toLocaleString('es-MX', { style: 'currency', currency: 'MXN' }) + ' MXN' : '';">
            <label for="montoverificacioneditarldr">Monto</label>
        </div>
        <label id="MontoVerificacionEditar" style="color: black;"><?php echo $data['monto'] ? number_format($data['monto'], 2, '.', ',') . ' MXN' : ''; ?></label>
    </div>
</div>
<div class="row">
    <h3>Año y semestre</h3>
    <!---------------------------------------------------------------- editar año verificacion ---------------------------------------->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="number" class="form-control" id="añoverificacioneditar" value="<?php echo $data['año']; ?>" placeholder="añoverificacioneditar" name="añoverificacioneditar">
            <label for="añoverificacioneditarldr">Año</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
    <!---------------------------------------------------------------- editar semestre ---------------------------------------->
    <?php
        $sql = "SELECT id_semestre, nombre_semestre FROM verificacion_semestre";
        $result = $conectar->query($sql);
        if ($result->num_rows > 0) {
            // Recorrer los resultados y mostrar las opciones
            echo '<div class="col-md-6">
         <div class="form-floating">
             <select class="form-select" id="verificacionsemestreeditar" name="verificacionsemestreeditar">
                 <option selected>Seleccionar aseguradora</option>';

            while ($row = $result->fetch_assoc()) {
                // Mostrar cada marca como una opción
                if ($data['id_semestre'] == $row['id_semestre']) {
                    echo '<option value="' . $row['id_semestre'] . '" selected>' . $row['nombre_semestre'] . '</option>';
                } else {
                    echo '<option value="' . $row['id_semestre'] . '">' . $row['nombre_semestre'] . '</option>';
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
</div>
<div class="row">
    <h3>Fecha de verificación y proxima verificación</h3>
    <!---------------------------------------------------------------- editar Fecha verificacion ---------------------------------------->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="date" class="form-control" id="fechaverificacioneditar" value="<?php echo $data['fecha_verificacion']; ?>" placeholder="fechaverificacioneditar" name="fechaverificacioneditar">
            <label for="fechaverificacioneditarldr">Fecha de verificación</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
    <!---------------------------------------------------------------- editar Fecha siguiente verificacion ---------------------------------------->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="date" class="form-control" id="fechaproximaverificacioneditar" value="<?php echo $data['fecha_siguiente_verificacion']; ?>" placeholder="fechaproximaverificacioneditar" name="fechaproximaverificacioneditar">
            <label for="fechaproximaverificacioneditarldr">Proxima verificación</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
</div>
<div class="row">
    <h3>Estatus</h3>
    <!----------------------------------------------------------------editar estatus verificacion ---------------------------------------->
    <?php
        $sql = "SELECT id_estatus_verificacion, estatus FROM estatus_verificacion";
        $result = $conectar->query($sql);
        if ($result->num_rows > 0) {
            // Recorrer los resultados y mostrar las opciones
            echo '<div class="col-md-6">
         <div class="form-floating">
             <select class="form-select" id="estatusverificacioneditar" name="estatusverificacioneditar">
                 <option selected>Seleccionar aseguradora</option>';

            while ($row = $result->fetch_assoc()) {
                // Mostrar cada marca como una opción
                if ($data['id_estatus_verificacion'] == $row['id_estatus_verificacion']) {
                    echo '<option value="' . $row['id_estatus_verificacion'] . '" selected>' . $row['estatus'] . '</option>';
                } else {
                    echo '<option value="' . $row['id_estatus_verificacion'] . '">' . $row['estatus'] . '</option>';
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
</div>


<?php
    }
?>