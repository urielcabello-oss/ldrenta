
<div class="row">
    <!-- Nombre de la institucion u organizacion -->
    <div class="col-md-12">
        <div class="form-floating">
            <input type="text" class="form-control institucionorganizacion" id="institucionorganizacion" placeholder="institucionorganizacion" name="institucionorganizacion" required>
            <label for="domiciliounidadldr">Nombre de la Persona Moral <span class="text-danger">*</span></label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>
    
    <!-- identificacion del representante legal -->
    <p class="letrasaltapersonasmorales">Identificación oficial y vigente del Representante Legal.</p>
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" class="form-control identificacionlegal" id="identificacionlegal" placeholder="identificacionlegal" name="identificacionlegal" required>
            <label for="nombre1unidadldr">Sección o pasaporte<span class="text-danger">*</span></label>
        </div>
        <label class="float-end letrasaltapersonasmorales" > Ejemplo : 1727 ó el id del pasaporte</label>
    </div>

    <!-- vigencia del representante legal -->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" class="form-control viegnciarepresentantelegal" id="viegnciarepresentantelegal" placeholder="viegnciarepresentantelegal" name="viegnciarepresentantelegal" required>
            <label for="nombre2unidadldr">Vigencia<span class="text-danger">*</span></label>
        </div>
        <label class="float-end letrasaltapersonasmorales"> Ejemplo : 2020-2030</label>
    </div>

    <!--archivo identificacion oficial del representante-->
    <div class="col-md-12">
        <p class="letrasaltapersonasmorales">•	Archivo de Identificación o Pasaporte<span class="text-danger">*</span></p>
        <div class="form-floating">
            <input type="file" class="form-control archivoidentificacionrepresentantelegal" id="archivoidentificacionrepresentantelegal" placeholder="archivoidentificacionrepresentantelegal" name="archivoidentificacionrepresentantelegal" accept=".pdf" required>
        </div>
        <label class="" style="color: white;"></label>
    </div>

    <!--archivo identificacion oficial del representante-->
    <div class="col-md-12">
        <p class="letrasaltapersonasmorales">•	Archivo Poder del Representante Legal con datos de inscripción en el Registro Público.<span class="text-danger">*</span></p>
        <div class="form-floating">
            <input type="file" class="form-control archivopoderepresentantelegal" id="archivopoderepresentantelegal" placeholder="archivopoderepresentantelegal" name="archivopoderepresentantelegal" accept=".pdf" required>
        </div>
        <label class="" style="color: white;"></label>
    </div>
    
</div>

<div class="row">
    <!--curp-->
    <p class="letrasaltapersonasmorales">Constancia de Situación Fiscal de la Moral (con vigencia no mayor a 2 meses).</p>
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" class="form-control rfcpersonamoral" id="rfcpersonamoral" placeholder="rfcpersonamoral" name="rfcpersonamoral" required>
            <label for="curpunidadldr">RFC <span class="text-danger">*</span></label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>

    <!--archivo constancia de situacion fiscal-->
    <div class="col-md-6">
        <div class="form-floating">
            <input type="file" class="form-control archivoRFCpersonamoral" id="archivoRFCpersonamoral" placeholder="archivoRFCpersonamoral" name="archivoRFCpersonamoral" accept=".pdf" required>
                    <label for="archivodomiciliopersonamoralldr">Archivo Constancia de Situación Fiscal<span class="text-danger">*</span></label>
        </div>
        <label class="" style="color: white;"></label>
    </div>
</div>

<div class="row">

    <!-- domicilio -->
    <div class="col-md-12">
        <p class="letrasaltapersonasmorales">Domicilio de la persona moral</p>
        <div class="form-floating">
            <input type="text" class="form-control domiciliodomiciliopersonamoral" id="domiciliodomiciliopersonamoral" placeholder="domiciliodomiciliopersonamoral" name="domiciliodomiciliopersonamoral" required>
            <label for="domiciliounidadldr">Domicilio <span class="text-danger">*</span></label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>

    <!--archivo comprobande de domicilio-->
    <div class="col-md-12">
        <h5 class="letrasaltapersonasmorales">•	Archivo comprobande de domicilio <span class="text-danger">*</span></h5>
        <div class="form-floating">
            <input type="file" class="form-control archivodomiciliopersonamoral" id="archivodomiciliopersonamoral" placeholder="archivodomiciliopersonamoral" name="archivodomiciliopersonamoral" accept=".pdf" required>
        </div>
        <label class="" style="color: white;"></label>
    </div>

</div>

<div class="row">

    <!-- domicilio de resguardo de unidad-->
    <div class="col-md-12">
        <p class="letrasaltapersonasmorales">Domicilio del resguardo de la unidad</p>
        <div class="form-floating">
            <input type="text" class="form-control domicilioresguardounidad" id="domicilioresguardounidad" placeholder="domicilioresguardounidad" name="domicilioresguardounidad" required>
            <label for="domiciliounidadldr">Domicilio <span class="text-danger">*</span></label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>

    <!--archivo comprobande de domicilio resguardo de -->
    <div class="col-md-12">
        <h5 class="letrasaltapersonasmorales">•	Archivo comprobande de domicilio del resguardo de la unidad<span class="text-danger">*</span></h5>
        <div class="form-floating">
            <input type="file" class="form-control archivodomicilioresguardounidad" id="archivodomicilioresguardounidad" placeholder="archivodomicilioresguardounidad" name="archivodomicilioresguardounidad" accept=".pdf" required>
        </div>
        <label class="" style="color: white;"></label>
    </div>

    <!-- Contacto de la persona-->
    <div class="col-md-6">
        <p class="letrasaltapersonasfisicas">Contacto de la persona</p>
        <div class="form-floating">
            <textarea class="form-control" id="contactopersonamoral" placeholder="contactopersonamoral" name="contactopersonamoral" rows="5"></textarea>
            <label for="domiciliounidadldr">Número telefónico o correo electrónico<span class="text-danger">*</span></label>
        </div>
        <label class="" style="color: black;"> </label>
    </div>

</div>

<div class="row">
    <!--archivo escritura constitutativa-->
    <div class="col-md-12" id="contenedor-escrituras">
    <h5 class="letrasaltapersonasmorales">
        • Archivos de Escritura Constitutiva con datos de inscripción en el Registro Público
        <span class="text-danger">*</span>
    </h5>

    <!-- primer input obligatorio -->
    <div class="form-floating mb-2">
        <input type="file" class="form-control" 
               name="archivoescrituraconstitutiva[]" 
               accept=".pdf" required>
    </div>
</div>

<div class="col-md-4">
<!-- botón modificado: sin onclick -->
<button type="button" id="btnAgregarEscritura" class="btn btn-secondary mt-2">
  ➕ Agregar otro archivo
</button>
</div>
<label class="" style="color: white;">.</label>

<div id="contenedor-escrituras"></div>


    <!--archivo escrituras de estatus sociales-->
    <div class="col-md-12" id="contenedor-estatus">
        <h5 class="letrasaltapersonasmorales">
            •	Archivo Escrituras de sus principales modificaciones a sus Estatutos Sociales. 
            <span class="text-danger">*</span>
        </h5>

        <!-- primer input obligatorio -->
        <div class="form-floating mb-2">
            <input type="file" class="form-control"
                   name="archivoestatusociales[]" 
                   accept=".pdf" required>
        </div>
    </div>

    <div class="col-md-4">
        <!-- botón modificado: sin onclick -->
        <button type="button" id="btnAgregarEstatus" class="btn btn-secondary mt-2">
            ➕ Agregar otro archivo
        </button>
    </div>
    <label class="" style="color: white;">.</label>

    <div id="contenedor-estatus"></div>

</div>
