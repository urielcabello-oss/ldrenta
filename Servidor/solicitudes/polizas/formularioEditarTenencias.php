<div class="row">
    <!-- ------------------------------------------------------------------------editar Tenencias ------------------------------------------------------------------->
    <h3>Edición de información</h3>
</div>
<div class="row">
<?php
    include("../../conexion.php");

    if (isset($_POST['idtenencia'])) {
        $idtenencia = $_POST['idtenencia'];

        //vamos a obtener los valores de la poliza de aeguradoras por unidad
        $queryobtenertenencia = "SELECT * FROM tenencias WHERE id_tenencias = $idtenencia";

        $ejecutarobtenertenencia = $conectar->query($queryobtenertenencia);
        if (mysqli_num_rows($ejecutarobtenertenencia) > 0) {
            $data = mysqli_fetch_array($ejecutarobtenertenencia);
        }
        ?>
        <!---------------------------------------------------------------- editar folio tenencia ----------------------------------->
<div class="col-md-6">
        <div class="form-floating">
            <input type="text" class="form-control" id="foliotenenciaeditar" value="<?php echo $data['folio']; ?>" placeholder="foliotenenciaeditar" name="foliotenenciaeditar">
            <label for="foliotenenciaeditarldr">Folio</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
    <!----------------------------------------------------------------editar Año semestre tenencia ---------------------------------------->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" class="form-control" id="añotenenciaeditar" value="<?php echo $data['año_semestre']; ?>" placeholder="añotenenciaeditar" name="añotenenciaeditar">
            <label for="añotenenciaeditarldr">Año semestre</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
</div>
<div class="row">
    <h3>Estatus y monto de pago</h3>
    <!---------------------------------------------------------------- editar estatus tenencias ---------------------------------------->
    <?php
        $sql = "SELECT id_estatus_tenencias, estatus FROM estatus_tenencias";
        $result = $conectar->query($sql);
        if ($result->num_rows > 0) {
            // Recorrer los resultados y mostrar las opciones
            echo '<div class="col-md-6">
         <div class="form-floating">
             <select class="form-select" id="estatustenenciaeditar" name="estatustenenciaeditar">
                 <option selected>Seleccionar aseguradora</option>';

            while ($row = $result->fetch_assoc()) {
                // Mostrar cada marca como una opción
                if ($data['id_estatus_tenencias'] == $row['id_estatus_tenencias']) {
                    echo '<option value="' . $row['id_estatus_tenencias'] . '" selected>' . $row['estatus'] . '</option>';
                } else {
                    echo '<option value="' . $row['id_estatus_tenencias'] . '">' . $row['estatus'] . '</option>';
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
    <!----------------------------------------------------------------editar Monto pago ---------------------------------------->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" class="form-control" id="montopagoeditar" value="<?php echo $data['monto_pago']; ?>" placeholder="montopagoeditar" name="montopagoeditar" oninput="document.getElementById('MontoPagoEditar').innerText = this.value ? parseFloat(this.value).toLocaleString('es-MX', { style: 'currency', currency: 'MXN' }) + ' MXN' : '';">
            <label for="montopagoeditarldr">Monto de pago</label>
        </div>
        <label id="MontoPagoEditar" style="color: black;"><?php echo $data['monto_pago'] ? number_format($data['monto_pago'], 2, '.', ',') . ' MXN' : ''; ?></label>
    </div>
</div>
<div class="row">
<h3>Fecha de pago y vencimiento</h3>
    <!---------------------------------------------------------------- Fecha pago ---------------------------------------->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="date" class="form-control" id="fechapagoeditar" value="<?php echo $data['fecha_pago']; ?>" placeholder="fechapagoeditar" name="fechapagoeditar">
            <label for="fechapagoeditarldr">Pago</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
    <!---------------------------------------------------------------- Fecha vencimiento ---------------------------------------->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="date" class="form-control" id="fechavencimientoeditar" value="<?php echo $data['fecha_vencimiento']; ?>" placeholder="fechavencimientoeditar" name="fechavencimientoeditar">
            <label for="fechavencimientoeditarldr">Vencimiento</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
</div>
<div class="row">
    <!---------------------------------------------------------------- Documento poliza tenencia ---------------------------------------->
    <h3>Documento</h3>
    <div class="col-md-8">
        <div class="form-floating">
            <div class="form-label">
                <input type="file" class="form-control" id="documento_poliza_tenencia_editar" name="documento_poliza_tenencia_editar" accept=".pdf" value="<?php echo $data['documento_tenencia']; ?>">
            </div>
        </div>
    </div>
</div>
<?php
    }
?>