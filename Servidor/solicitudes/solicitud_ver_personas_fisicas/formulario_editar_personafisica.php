<?php
include "../../conexion.php";
if (isset($_POST['id_persona_editar'])) {
    $id_persona_fisica = $_POST['id_persona_editar'];

    $sqlobtenerpersonafisica = "SELECT id_persona_fisica,
                                        nombre_1,
                                        nombre_2,
                                        apellido_paterno,
                                        apellido_materno,
                                        genero,
                                        seccion,
                                        vigencia,
                                        curp,
                                        rfc,
                                        domicilio,
                                        archivo_ine,
                                        archivo_curp,
                                        archivo_rfc,
                                        archivo_domicilio
                                FROM personas_fisicas 
                                WHERE id_persona_fisica = '$id_persona_fisica'";

    $result = $conectar->query($sqlobtenerpersonafisica);
    $data = $result->fetch_assoc();

    echo '
<div class="row">
    <h3>Datos personales</h3>
    <!-- Nombre -->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text"  class="form-control editarnombrepersonafisica1" id="editarnombrepersonafisica1" value="' . $data['nombre_1'] . '" placeholder="editarnombrepersonafisica1" name="editarnombrepersonafisica1">
            <label for="nombre1unidadldr">Nombre</label>
        </div>
        <label class="" style="color: white;"> </label>
    </div>
    <!-- Nombre 2 -->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" class="form-control editarnombrepersonafisica2" id="editarnombrepersonafisica2" value="' . $data['nombre_2'] . '" placeholder="editarnombrepersonafisica2" name="editarnombrepersonafisica2">
            <label for="nombre2unidadldr">Segundo nombre</label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>
    <!-- apellido paterno -->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" class="form-control editarapaternopersonafisica" id="editarapaternopersonafisica" value="' . $data['apellido_paterno'] . '" placeholder="editarapaternopersonafisica" name="editarapaternopersonafisica">
            <label for="apaternounidadldr">Apellido paterno</label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>
    <!-- apellido materno -->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" class="form-control editaramaternopersonafisica" id="editaramaternopersonafisica" value="' . $data['apellido_materno'] . '" placeholder="amaterno" name="amaterno">
            <label for="amaternounidadldr">Apellido materno</label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>
    <!-- genero -->
    <div class="col-md-4">
        <div class="form-floating">
            <select class="form-control editargeneropersonafisica" id="editargeneropersonafisica" name="editargeneropersonafisica">
                <option value="">Selecciona Género</option>
                <option value="M" ' . ($data['genero'] == 'M' ? 'selected' : '') . '>Masculino</option>
                <option value="F" ' . ($data['genero'] == 'F' ? 'selected' : '') . '>Femenino</option>
            </select>
            <label for="generounidadldr">Género</label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>
</div>

<div class="row">
    <!---------------------------------identificacion oficial----------------------->
    <h3>Identificacion oficial (INE)</h3>
    <!-- identificacion oficial -->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="number" class="form-control editarinepersonafisica" id="editarinepersonafisica" value="' . $data['seccion'] . '" placeholder="editarinepersonafisica" name="editarinepersonafisica" min="0" max="4">
            <label for="domicilioldr">Sección</label>
        </div>
        <label class="float-end" style="color: black;">Ejemplo: 1727</label>
    </div>
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" class="form-control editarvigenciainepersonafisica" id="editarvigenciainepersonafisica" value="' . $data['vigencia'] . '" placeholder="editarvigenciainepersonafisica" name="editarvigenciainepersonafisica">
            <label for="domicilioldr">Vigencia</label>
        </div>
        <label class="float-end" style="color: black;">Ejemplo: 2020-2030</label>
    </div>
</div>

<div class="row">
    <h3>CURP y RFC</h3>
    <!--curp-->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" class="form-control editarcurppersonafisica" id="editarcurppersonafisica" value="' . $data['curp'] . '" placeholder="editarcurppersonafisica" name="editarcurppersonafisica">
            <label for="curpunidadldr">CURP</label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>
    <!--rfc-->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" class="form-control editarrfcpersonafisica" id="editarrfcpersonafisica" value="' . $data['rfc'] . '" placeholder="editarrfcpersonafisica" name="editarrfcpersonafisica">
            <label for="curpunidadldr">RFC</label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>
</div>

<div class="row">
    <h3>Domicilio</h3>
    <!-- domicilio -->
    <div class="col-md-8">
        <div class="form-floating">
            <input type="text" class="form-control editardomiciliopersonafisica" id="editardomiciliopersonafisica" value="' . $data['domicilio'] . '" placeholder="editardomiciliodomiciliopersonafisica" name="editardomiciliodomiciliopersonafisica">
            <label for="domiciliounidadldr">Domicilio</label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>
    <!--archivo comprobande de domicilio-->
    <h5><b>Archivo comprobande de domicilio</b></h5>
    <div class="col-md-8">
        <div class="form-floating">
            <input type="file" class="form-control editararchivodomicilio" id="editararchivodomicilio" placeholder="editararchivodomicilio" name="editararchivodomicilio" accept=".pdf" value="' . $data['archivo_domicilio'] . '">
            <label for="archivodomicilioldr">Archivo domicilio</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
    <!--archivo INE-->
    <h5><b>Archivo INE</b></h5>
    <div class="col-md-8">
        <div class="form-floating">
            <input type="file" class="form-control editararchivoINEpersonafisica" id="editararchivoINEpersonafisica" placeholder="editararchivoINEpersonafisica" name="editararchivoINEpersonafisica" accept=".pdf" value="' . $data['archivo_ine'] . '">
            <label for="archivoINEldr">Archivo INE</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>

    <!--archivo comprobande curp-->
    <h5><b>Archivo CURP</b></h5>
    <div class="col-md-8">
        <div class="form-floating">
            <input type="file" class="form-control editararchivoCURPpersonafisica" id="editararchivoCURPpersonafisica" placeholder="editararchivoCURPpersonafisica" name="editararchivoCURPpersonafisica" accept=".pdf" value="' . $data['archivo_curp'] . '">
            <label for="archivodomicilioldr">Archivo CURP</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
    
    <!--archivo comprobande rfc-->
    <h5><b>Archivo RFC</b></h5>
    <div class="col-md-8">
        <div class="form-floating">
            <input type="file" class="form-control editararchivoRFCpersonafisica" id="editararchivoRFCpersonafisica" placeholder="editararchivoRFCpersonafisica" name="editararchivoRFCpersonafisica" accept=".pdf" value="' . $data['archivo_rfc'] . '">
            <label for="archivodomicilioldr">Archivo RFC</label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
</div>';
}
?>
