<div class="row">
    <!-- ------------------------------------------------------------------------Verificaciones ------------------------------------------------------------------->
    <h3>Registro de verificaciones</h3>
</div>
<div class="row">
    <!---------------------------------------------------------------- folio verificacion ---------------------------------------->
    <div class="col-md-4">
        <div class="form-floating">
            <input type="text" class="form-control" id="folioverificacion" value="" placeholder="folioverificacion" name="folioverificacion">
            <label for="folioverificacionldr">Folio</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
    <!---------------------------------------------------------------- monto verificacion ---------------------------------------->
    <div class="col-md-4">
        <div class="form-floating">
            <input type="number" class="form-control" id="montoverificacion" value="" placeholder="montoverificacion" name="montoverificacion"oninput="document.getElementById('MontoVerificacion').innerText = this.value ? parseFloat(this.value).toLocaleString('es-MX', { style: 'currency', currency: 'MXN' }) + ' MXN' : '';">
            <label for="montoverificacionldr">Monto</label>
        </div>
        <label id="MontoVerificacion" style="color: black;"></label>
    </div>
</div>
<div class="row">
    <h3>Año y semestre</h3>
    <!---------------------------------------------------------------- año verificacion ---------------------------------------->
    <div class="col-md-4">
        <div class="form-floating">
            <input type="number" class="form-control" id="añoverificacion" value="" placeholder="añoverificacion" name="añoverificacion">
            <label for="añoverificacionldr">Año</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
    <!---------------------------------------------------------------- semestre ---------------------------------------->
    <?php
    include("../../Servidor/conexion.php");
    $sql = "SELECT id_semestre, nombre_semestre FROM verificacion_semestre";
    $result = $conectar->query($sql);
    echo '
    <div class="col-md-4">
        <div class="form-floating">
            <select class="form-select" id="semestreverificacion" name="semestreverificacion">
                <option selected>Selecciona un semestre</option>';

    while ($row = $result->fetch_assoc()) {
        // Mostrar cada marca como una opcion
        $selected = ($data['id_semestre'] == $row['id_semestre']) ? 'selected' : '';
        echo '<option value="' . $row['id_semestre'] . '"' . $selected . '>' . $row['nombre_semestre'] . '</option>';
    }

    echo '</select>
            <label for="id_semestreldr">Semestre</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
    ';
    ?>
</div>
<div class="row">
    <h3>Fecha de verificación y proxima</h3>
    <!---------------------------------------------------------------- Fecha verificacion ---------------------------------------->
    <div class="col-md-4">
        <div class="form-floating">
            <input type="date" class="form-control" id="fechaverificacion" value="" placeholder="fechaverificacion" name="fechaverificacion">
            <label for="fechaverificacionldr">Verificación</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
    <!---------------------------------------------------------------- Fecha siguiente verificacion ---------------------------------------->
    <div class="col-md-4">
        <div class="form-floating">
            <input type="date" class="form-control" id="fechaproximaverificacion" value="" placeholder="fechaproximaverificacion" name="fechaproximaverificacion">
            <label for="fechaproximaverificacionldr">Proxima verificación</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
</div>
<div class="row">
    <h3>Estatus</h3>
    <!---------------------------------------------------------------- estatus verificacion ---------------------------------------->
    <?php
    include("../../Servidor/conexion.php");
    $sql = "SELECT id_estatus_verificacion, estatus FROM estatus_verificacion";
    $result = $conectar->query($sql);
    echo '
    <div class="col-md-4">
        <div class="form-floating">
            <select class="form-select" id="estatusverificacion" name="estatusverificacion">
                <option selected>Seleccionar estatus de verificación</option>';

    while ($row = $result->fetch_assoc()) {
        // Mostrar cada marca como una opcion
        $selected = ($data['id_estatus_verificacion'] == $row['id_estatus_verificacion']) ? 'selected' : '';
        echo '<option value="' . $row['id_estatus_verificacion'] . '"' . $selected . '>' . $row['estatus'] . '</option>';
    }

    echo '</select>
            <label for="id_estatus_verificacionldr">Estatus</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
    ';
    ?>
</div>