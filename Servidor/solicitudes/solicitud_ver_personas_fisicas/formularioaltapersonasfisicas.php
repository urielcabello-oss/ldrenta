
<div class="row">
    <p class="letrasaltapersonasfisicas">Datos personales</p>
    <!-- Nombre -->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" class="form-control nombrepersonafisica1" id="nombrepersonafisica1" placeholder="nombrepersonafisica1" name="nombrepersonafisica1" required>
            <label for="nombre1unidadldr">Nombre<span class="text-danger">*</span></label>
        </div>
        <label class="" style="color: white;"> </label>
    </div>
    <!-- Nombre 2 -->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" class="form-control nombrepersonafisica2" id="nombrepersonafisica2" placeholder="nombrepersonafisica2" name="nombrepersonafisica2">
            <label for="nombre2unidadldr">Segundo nombre</label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>
    <!-- apellido paterno -->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" class="form-control apaternopersonafisica" id="apaternopersonafisica" placeholder="apaternopersonafisica" name="apaternopersonafisica">
            <label for="apaternounidadldr">Apellido paterno<span class="text-danger">*</span></label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>
    <!-- apellido materno -->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" class="form-control amaternopersonafisica" id="amaternopersonafisica" placeholder="amaterno" name="amaterno">
            <label for="amaternounidadldr">Apellido materno<span class="text-danger">*</span></label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>
    <!-- genero -->
    <div class="col-md-4">
        <div class="form-floating">
            <select class="form-control generopersonafisica" id="generopersonafisica" placeholder="generopersonafisica" name="generopersonafisica">
                <option value="">Selecciona un género</option>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
            </select>
            <label for="generounidadldr">Género<span class="text-danger">*</span></label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>
</div>

<div class="row">
    <!---------------------------------identificacion oficial----------------------->
    <p class="letrasaltapersonasfisicas">Identificación oficial y vigente</p>
    <!-- identificacion oficial -->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="number" class="form-control inepersonafisica" id="inepersonafisica" placeholder="inepersonafisica" name="inepersonafisica" min="0" max="4">
            <label for="domicilioldr">Sección o pasaporte<span class="text-danger">*</span></label>
        </div>
        <label class="float-end letrasaltapersonasfisicas">Ejemplo: 1727</label>
    </div>
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" class="form-control vigenciainepersonafisica" id="vigenciainepersonafisica" placeholder="vigenciainepersonafisica" name="vigenciainepersonafisica">
            <label for="domicilioldr">Vigencia<span class="text-danger">*</span></label>
        </div>
        <label class="float-end letrasaltapersonasfisicas">Ejemplo: 2020-2030</label>
    </div>
    <!--archivo INE-->
    <div class="col-md-12">
        <p class="letrasaltapersonasfisicas">•	Archivo identificación oficial</p>
        <div class="form-floating">
            <input type="file" class="form-control archivoINEpersonafisica" id="archivoINEpersonafisica" placeholder="archivoINEpersonafisica" name="archivoINEpersonafisica" accept=".pdf">
            <label for="archivoINEldr">Archivo identificación oficial (INE o Pasaporte)<span class="text-danger">*</span></label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>

</div>

<div class="row">
    <p class="letrasaltapersonasfisicas">•	CURP</p>
    <!--curp-->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" class="form-control curppersonafisica" id="curppersonafisica" placeholder="curppersonafisica" name="curppersonafisica">
            <label for="curpunidadldr">CURP<span class="text-danger">*</span></label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>
    <!--archivo comprobande curp-->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="file" class="form-control archivoCURPpersonafisica" id="archivoCURPpersonafisica" placeholder="archivoCURPpersonafisica" name="archivoCURPpersonafisica" accept=".pdf">
            <label for="archivodomicilioldr">Archivo CURP<span class="text-danger">*</span></label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
</div>
<div class="row">
    <p class="letrasaltapersonasfisicas">•	RFC y Constancia de Situación Fiscal (con vigencia no mayor a 2 meses).</p>
    <!--curp-->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" class="form-control rfcpersonafisica" id="rfcpersonafisica" placeholder="rfcpersonafisica" name="rfcpersonafisica">
            <label for="curpunidadldr">RFC<span class="text-danger">*</span></label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>
    <!--archivo comprobande curp-->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="file" class="form-control archivoRFCpersonafisica" id="archivoRFCpersonafisica" placeholder="archivoRFCpersonafisica" name="archivoRFCpersonafisica" accept=".pdf">
            <label for="archivodomicilioldr">Archivo Constancia de situación fiscal<span class="text-danger">*</span></label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
</div>

<div class="row">
    <p class="letrasaltapersonasfisicas">Domicilio de la persona física</p>
    <!-- domicilio -->
    <div class="col-md-12">
        <div class="form-floating">
            <input type="text" class="form-control domiciliodomiciliopersonafisica" id="domiciliodomiciliopersonafisica" placeholder="domiciliodomiciliopersonafisica" name="domiciliodomiciliopersonafisica">
            <label for="domiciliounidadldr">Domicilio<span class="text-danger">*</span></label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>
    <!--archivo comprobande de domicilio-->
    <h5 class="letrasaltapersonasfisicas">•	Archivo comprobande de domicilio</h5>
    <div class="col-md-12">
        <div class="form-floating">
            <input type="file" class="form-control archivodomicilio" id="archivodomicilio" placeholder="archivodomicilio" name="archivodomicilio" accept=".pdf">
            <label for="archivodomicilioldr">Archivo domicilio<span class="text-danger">*</span></label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
</div>

<div class="row">
    <!-- domicilio resguardo de la unidad-->
    <div class="col-md-12">
        <p class="letrasaltapersonasfisicas">Domicilio resguardo de la unidad</p>
        <div class="form-floating">
            <input type="text" class="form-control domiciliodomicilioresguardounidad" id="domiciliodomicilioresguardounidad" placeholder="domiciliodomicilioresguardounidad" name="domiciliodomicilioresguardounidad">
            <label for="domiciliounidadldr">Domicilio resguardo<span class="text-danger">*</span></label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>
    <!--archivo comprobande de domicilio resguardo de la unidad-->
    <h5 class="letrasaltapersonasfisicas">•	Archivo comprobande de domicilio resguardo de la unidad</h5>
    <div class="col-md-12">
        <div class="form-floating">
            <input type="file" class="form-control archivodomicilioresguardounidad" id="archivodomicilioresguardounidad" placeholder="archivodomicilioresguardounidad" name="archivodomicilioresguardounidad" accept=".pdf">
            <label for="archivodomicilioldr">Archivo domicilio resguardo de la unidad<span class="text-danger">*</span></label>
        </div>
        <label class="" style="color: white;">*Campo obligatorio</label>
    </div>
<!-- Contacto de la persona-->
    <div class="col-md-6">
        <p class="letrasaltapersonasfisicas">Contacto de la persona</p>
        <div class="form-floating">
            <textarea class="form-control" id="contactopersonafisica" placeholder="contactopersonafisica" name="contactopersonafisica" rows="5"></textarea>
            <label for="domiciliounidadldr">Número telefónico o correo electrónico<span class="text-danger">*</span></label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>
</div>