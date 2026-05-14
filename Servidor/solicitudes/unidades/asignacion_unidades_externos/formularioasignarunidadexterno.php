<?php
include("../../../conexion.php");

// Consulta para obtener los tipos de usuario externos
$querytipousuarioexterno = "SELECT id_tipo_usuario_externo, tipo_externo FROM tipo_usuarios_externos";
$result = $conectar->query($querytipousuarioexterno);
?>

<div>
    <h5>Selecciona el tipo: <strong>Nacional / Extranjero</strong></h5>
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="form-floating">
                <select class="form-select tipousuarioexterno" id="tipousuarioexterno" name="tipousuarioexterno">
                    <option value="">Seleccione el tipo</option>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <option value="<?= $row['id_tipo_usuario_externo'] ?>"><?= $row['tipo_externo'] ?></option>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <option value="">No hay tipos disponibles</option>
                    <?php endif; ?>
                </select>
                <label for="tipousuarioexterno">Tipo de usuario</label>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <!-- Nombre -->
    <div class="col-md-4">
        <div class="form-floating">
            <input type="text" class="form-control nombre1" id="nombre1" placeholder="nombre1" name="nombre1">
            <label for="nombre1unidadldr">Nombre</label>
        </div>
        <label class="" style="color: white;"> </label>
    </div>
    <!-- Nombre 2 -->
    <div class="col-md-4">
        <div class="form-floating">
            <input type="text" class="form-control nombre2" id="nombre2" placeholder="nombre2" name="nombre2">
            <label for="nombre2unidadldr">Segundo nombre</label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>
    <!-- apellido paterno -->
    <div class="col-md-4">
        <div class="form-floating">
            <input type="text" class="form-control apaterno" id="apaterno" placeholder="apaterno" name="apaterno">
            <label for="apaternounidadldr">Apellido paterno</label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>
    <!-- apellido materno -->
    <div class="col-md-4">
        <div class="form-floating">
            <input type="text" class="form-control amaterno" id="amaterno" placeholder="amaterno" name="amaterno">
            <label for="amaternounidadldr">Apellido materno</label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>
    <!-- genero -->
    <div class="col-md-4">
        <div class="form-floating">
            <select class="form-control genero" id="genero" placeholder="genero" name="genero">
                <option value="">Selecciona Género</option>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
            </select>
            <label for="generounidadldr">Género</label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>
</div>
<div class="row">
    <h3>Licencia de conducir</h3>
    <!-- licencia conducir -->
    <div class="col-md-4">
        <div class="form-floating">
            <input type="number" class="form-control licenciaconducir" id="licenciaconducir" placeholder="licenciaconducir" name="licenciaconducir">
            <label for="licenciaconducirunidadldr">Licencia de conducir</label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>
    <!-- fecha emision -->
    <div class="col-md-4">
        <div class="form-floating">
            <input type="date" class="form-control fechaemision" id="fechaemision" placeholder="fechaemision" name="fechaemision">
            <label for="fechaemisionunidadldr">Emisión</label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>
    <!-- fecha vencimiento -->
    <div class="col-md-4">
        <div class="form-floating">
            <input type="date" class="form-control fechavenci" id="fechavenci" placeholder="fechavenci" name="fechavenci">
            <label for="fechavenciunidadldr">Vencimiento</label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>
</div>

<?php
$queryobtenerestadolicencia = "SELECT id_estado_licencia, estado_licencia_conducir FROM estado_licencia_conducir";
$result = $conectar->query($queryobtenerestadolicencia);
// Verificar si hay resultados
if ($result->num_rows > 0) {
    // Recorrer los resultados y mostrar las opciones
    echo '<div class="col-md-4">
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
';
}
?>
<!--archivo licencia de conducir-->
<h5><b>Archivo licencia</b></h5>
<div class="col-md-8">
    <div class="form-floating">
        <input type="file" class="form-control archivolicenciaconducir" id="archivolicenciaconducir" placeholder="archivolicenciaconducir" name="archivolicenciaconducir" accept=".pdf">
        <label for="archivolicenciaconducirldr">Archivo</label>
    </div>
    <label class="" style="color: white;">*Campo obligatorio</label>
</div>
</div>
<div class="row">
    <h3>Domicilio</h3>
    <!-- domicilio -->
    <div class="col-md-8">
        <div class="form-floating">
            <input type="text" class="form-control domicilio" id="domicilio" placeholder="domicilio" name="domicilio">
            <label for="domiciliounidadldr">Domicilio</label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>
    <!--archivo comprobande de domicilio-->
    <h5><b>Archivo comprobande de domicilio</b></h5>
    <div class="col-md-8">
        <div class="form-floating">
            <input type="file" class="form-control archivodomicilio" id="archivodomicilio" placeholder="archivodomicilio" name="archivodomicilio" accept=".pdf">
            <label for="archivodomicilioldr">Archivo domicilio</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
    <!-- Campos Nacional -->
    <div id="campos_nacional" style="display: none;">
        <!--archivo INE-->
        <h5><b>Archivo INE</b></h5>
        <div class="col-md-8">
            <div class="form-floating">
                <input type="file" class="form-control archivoINE" id="archivoINE" placeholder="archivoINE" name="archivoINE" accept=".pdf">
                <label for="archivoINEldr">Archivo INE</label>
            </div>
            <label class="" style="color: white;">*Campo obligatorio</label>
        </div>
        <!--archivo INE-->
        <h5><b>Archivo constancia de situación fiscal</b></h5>
        <div class="col-md-8">
            <div class="form-floating">
                <input type="file" class="form-control archivoconsfiscal" id="archivoconsfiscal" placeholder="archivoconsfiscal" name="archivoconsfiscal" accept=".pdf">
                <label for="archivoconsfiscalldr">Archivo constancia de situación fiscal</label>
            </div>
            <label class="" style="color: white;">*Campo obligatorio</label>
        </div>
    </div>
</div>

</div>

<!-- Campos Extranjero -->
<div id="campos_extranjero" style="display: none;">
    <div class="row">
        <h3>Residencia</h3>
        <?php
        $queryobteneresidencia = "SELECT id_tipo_recidencia, tipo_residencia FROM tipos_recidencias_externos";
        $result = $conectar->query($queryobteneresidencia);
        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            // Recorrer los resultados y mostrar las opciones
            echo '<div class="col-md-4">
        <div class="form-floating">
            <select class="form-control tiporesidencia" id="tiporesidencia" placeholder="tiporesidencia" name="tiporesidencia">
                <option value="">Seleccione un estado</option>'; // Opción predeterminada

            while ($row = $result->fetch_assoc()) {
                // Mostrar cada marca como una opcion
                $selected = ($row['id_tipo_recidencia']);
                echo '<option value="' . $row['id_tipo_recidencia'] . '" ' . $selected . '>' . $row['tipo_residencia'] . '</option>';
            }
            echo '</select>
        <label for="colaboradorldr">Estado</label>
    </div>
    <label class="" style="color: white;">*Campo obligatorio</label>
</div>';
        }
        ?>
    </div>
    <!--archivo credencial residencia-->
    <h5><b>Archivo credencial residencia</b></h5>
    <div class="col-md-8">
            <div class="form-floating">
                <input type="file" class="form-control archivocredencialresidencia" id="archivocredencialresidencia" placeholder="archivocredencialresidencia" name="archivocredencialresidencia" accept=".pdf">
                <label for="archivocredencialresidencialdr">Archivo credencial residencia</label>
            </div>
            <label class="" style="color: white;">*Campo obligatorio</label>
        </div>
    <div class="row">
        <h3>Pasaporte</h3>
        <!-- licencia conducir -->
        <div class="col-md-4">
            <div class="form-floating">
                <input type="text" class="form-control pasaporte" id="pasaporte" placeholder="pasaporte" name="pasaporte">
                <label for="pasaporteunidadldr">Pasaporte</label>
            </div>
            <label class="" style="color: black;"> </label>
        </div>
        <!--archivo pasaporte-->
        <h5><b>Archivo pasaporte</b></h5>
        <div class="col-md-8">
            <div class="form-floating">
                <input type="file" class="form-control archivopasaporte" id="archivopasaporte" placeholder="archivopasaporte" name="archivopasaporte" accept=".pdf">
                <label for="archivopasaporteldr">Archivo pasaporte</label>
            </div>
            <label class="" style="color: white;">*Campo obligatorio</label>
        </div>
    </div>
    <div class="row">
        <h3>Forma migratoria</h3>
        <!-- licencia conducir -->
        <div class="col-md-4">
            <div class="form-floating">
                <input type="text" class="form-control formamigratoria" id="formamigratoria" placeholder="formamigratoria" name="formamigratoria">
                <label for="formamigratoriaunidadldr">Forma migratoria</label>
            </div>
        </div>
    </div>
</div>
