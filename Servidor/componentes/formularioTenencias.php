<div class="row">
    <!-- ------------------------------------------------------------------------Tenencias ------------------------------------------------------------------->
    <h3>Registro de tenencias</h3>
</div>
<div class="row">
    <!---------------------------------------------------------------- folio tenencia ---------------------------------------->
    <div class="col-md-4">
        <div class="form-floating">
            <input type="text" class="form-control" id="foliotenencia" value="" placeholder="foliotenencia" name="foliotenencia">
            <label for="foliotenencialdr">Folio</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
    <!---------------------------------------------------------------- Año semestre tenencia ---------------------------------------->
    <div class="col-md-4">
        <div class="form-floating">
            <input type="text" class="form-control" id="añotenencia" value="" placeholder="añotenencia" name="añotenencia">
            <label for="añotenencialdr">Año semestre</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
</div>
<div class="row">
    <h3>Estatus y monto de pago</h3>
    <!---------------------------------------------------------------- estatus tenencias ---------------------------------------->
    <?php
    include("../../Servidor/conexion.php");
    $sql = "SELECT id_estatus_tenencias, estatus FROM estatus_tenencias";
    $result = $conectar->query($sql);
    echo '
    <div class="col-md-4">
        <div class="form-floating">
            <select class="form-select" id="estatustenencias" name="estatustenencias">
                <option selected>Seleccionar estatus de tenecia</option>';

    while ($row = $result->fetch_assoc()) {
        // Mostrar cada marca como una opcion
        $selected = ($data['id_estatus_tenencias'] == $row['id_estatus_tenencias']) ? 'selected' : '';
        echo '<option value="' . $row['id_estatus_tenencias'] . '"' . $selected . '>' . $row['estatus'] . '</option>';
    }

    echo '</select>
            <label for="id_estatus_tenenciasldr">Estatus</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
    ';
    ?>
    <!---------------------------------------------------------------- Monto pago ---------------------------------------->
    <div class="col-md-4">
        <div class="form-floating">
            <input type="number" class="form-control" id="montopago" value="" placeholder="montopago" name="montopago" oninput="document.getElementById('MontoPago').innerText = this.value ? parseFloat(this.value).toLocaleString('es-MX', { style: 'currency', currency: 'MXN' }) + ' MXN' : '';">
            <label for="montopagoldr">Monto de pago</label>
        </div>
        <label id="MontoPago" style="color: black;"></label>
    </div>
</div>
<div class="row">
<h3>Fecha de pago y vencimiento</h3>
    <!---------------------------------------------------------------- Fecha pago ---------------------------------------->
    <div class="col-md-4">
        <div class="form-floating">
            <input type="date" class="form-control" id="fechapago" value="" placeholder="fechapago" name="fechapago">
            <label for="fechapagoldr">Pago</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
    <!---------------------------------------------------------------- Fecha vencimiento ---------------------------------------->
    <div class="col-md-4">
        <div class="form-floating">
            <input type="date" class="form-control" id="fechavencimiento" value="" placeholder="fechavencimiento" name="fechavencimiento">
            <label for="fechavencimientoldr">Vencimiento</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
</div>
<div class="row">
    <!---------------------------------------------------------------- Documento poliza tenencia ---------------------------------------->
    <h3>Documento</h3>
    <div class="col-md-6">
        <div class="form-floating">
            <div class="form-label">
                <input type="file" class="form-control" id="documento_poliza_tenencia" name="documento_poliza_tenencia" accept=".pdf" value="">
            </div>
        </div>
    </div>
</div>