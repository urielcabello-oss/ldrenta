<div class="row">
    <!-- ------------------------------------------------------------------------polizas de aseguradora ------------------------------------------------------------------->
    <h3>Registro de aseguradoras</h3>
</div>
<div class="row">
    <!-----------------------------------------------------------------------Nombre de la aseguradora -------------------------------------------------------------------->

    <?php
    include("../../Servidor/conexion.php");
    $sql = "SELECT id_aseguradora, aseguradora FROM aseguradoras";
    $result = $conectar->query($sql);
    echo '
    <div class="col-md-6">
        <div class="form-floating">
            <select class="form-select" id="nombreaseguradora" name="nombreaseguradora">
                <option selected>Seleccionar aseguradora</option>';

    while ($row = $result->fetch_assoc()) {
        // Mostrar cada marca como una opcion
        $selected = ($data['id_aseguradora'] == $row['id_aseguradora']) ? 'selected' : '';
        echo '<option value="' . $row['id_aseguradora'] . '"' . $selected . '>' . $row['aseguradora'] . '</option>';
    }

    echo '</select>
            <label for="id_aseguradorasldr">Aseguradora</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
    ';
    ?>

    <!---------------------------------------------------------------- Identificador poliza de seguro ---------------------------------------->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" class="form-control" id="identificadopolizaseguro" value="" placeholder="identificadopolizaseguro" name="identificadopolizaseguro">
            <label for="identificadopolizaseguroldr">Identificador</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
</div>
<div class="row">
    <h3>Fechas de alta y vencimiento</h3>
    <!---------------------------------------------------------------- Fecha de alta de poliza ---------------------------------------->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="date" class="form-control" id="fechaaltaseguro" value="" placeholder="fechaaltaseguro" name="fechaaltaseguro">
            <label for="fechaaltaseguroldr">Alta</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
    <!---------------------------------------------------------------- Fecha de vencimiento de poliza ---------------------------------------->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="date" class="form-control" id="fechavencimientoaseguradora" value="" placeholder="fechavencimientoaseguradora" name="fechavencimientoaseguradora">
            <label for="fechavencimientoaseguradoraldr">Vencimiento</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
</div>
<div class="row">
    <h3>Estado y estatus</h3>
    <!---------------------------------------------------------estado de la aseguradora------------------------------------------------>
    <?php
    include("../../Servidor/conexion.php");
    $sql = "SELECT id_estado_aseguradora, estado_aseguradora FROM estado_aseguradora";
    $result = $conectar->query($sql);
    echo '
    <div class="col-md-6">
        <div class="form-floating">
            <select class="form-select" id="estadoaseguradora" name="estadoaseguradora">
                <option selected>Seleccionar estado</option>';

    while ($row = $result->fetch_assoc()) {
        // Mostrar cada marca como una opcion
        $selected = ($data['id_estado_aseguradora'] == $row['id_estado_aseguradora']) ? 'selected' : '';
        echo '<option value="' . $row['id_estado_aseguradora'] . '"' . $selected . '>' . $row['estado_aseguradora'] . '</option>';
    }

    echo '</select>
            <label for="id_estatus_aseguradoraldr">Estado</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
    ';
    ?>
    <!---------------------------------------------------------estatus de la aseguradora------------------------------------------------>
    <?php
    include("../../Servidor/conexion.php");
    $sql = "SELECT id_estatus_aseguradora, estatus FROM estatus_aseguradora";
    $result = $conectar->query($sql);
    echo '
    <div class="col-md-6">
        <div class="form-floating">
            <select class="form-select" id="estatusaseguradora" name="estatusaseguradora">
                <option selected>Seleccionar estatus</option>';

    while ($row = $result->fetch_assoc()) {
        // Mostrar cada marca como una opcion
        $selected = ($data['id_estatus_aseguradora'] == $row['id_estatus_aseguradora']) ? 'selected' : '';
        echo '<option value="' . $row['id_estatus_aseguradora'] . '"' . $selected . '>' . $row['estatus'] . '</option>';
    }

    echo '</select>
            <label for="id_estatus_aseguradoraldr">Estatus</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
    ';
    ?>
    <!-----------------------------------------------------------------------Documento de polizas de unidades -------------------------------------------------------------------->
</div>
<div class="row">
    <h3>Documento</h3>
    <div class="col-md-6">
        <div class="form-floating">
            <div class="form-label">
                <input type="file" class="form-control" id="documento_poliza" name="documento_poliza" accept=".pdf" value="">
            </div>
        </div>
    </div>
</div>