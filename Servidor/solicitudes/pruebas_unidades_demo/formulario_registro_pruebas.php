<div class="row">
    <div class="col-md-12">
        <h2>Registrar Pruebas Unidades Demo</h2>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" class="form-control" id="nombre_conductor" placeholder="nombre_conductor" name="nombre_conductor">
            <label for="nombre_conductor">Nombre conductor</label>
        </div>
        <label id="costoNetoLabel" style="color: black;"></label>
    </div>

    <?php
    include("../../conexion.php");
    $querytipoprueba = "SELECT id_tipo_prueba_demo, prueba_demo FROM tipos_pruebas_demo";
    $result = $conectar->query($querytipoprueba);
    // Verificar si hay resultados
    if ($result->num_rows > 0) {
        // Recorrer los resultados y mostrar las opciones
        echo '<div class="col-md-6">
        <div class="form-floating">
            <select class="form-control tipo_prueba" id="tipo_prueba" placeholder="tipo_prueba" name="tipo_prueba">
                <option value="">Seleccione un tipo de prueba</option>'; // Opción predeterminada

        while ($row = $result->fetch_assoc()) {
            // Mostrar cada marca como una opcion
            $selected = ($row['id_tipo_prueba_demo']);
            echo '<option value="' . $row['id_tipo_prueba_demo'] . '" ' . $selected . '>' . $row['prueba_demo'] . '</option>';
        }
        echo '</select>
        <label for="colaboradorldr">Tipo de prueba</label>
    </div>
    <label class="" style="color: white;"></label>
</div>'; 
    }
    ?>


    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" class="form-control" id="origen_inicial" placeholder="origen_inicial" name="origen_inicial">
            <label for="origen_inicial">Origen inicial</label>
        </div>
        <label id="costoNetoLabel" style="color: black;"></label>
    </div>

    <div class="col-md-6">
        <div class="form-floating">
            <input type="text" class="form-control" id="origen_destino" placeholder="origen_destino" name="origen_destino">
            <label for="origen_destino">Origen destino</label>
        </div>
        <label id="costoNetoLabel" style="color: black;"></label>
    </div>

    <div class="col-md-3">
        <div class="form-floating">
            <input type="number" class="form-control" id="temperatura" placeholder="temperatura" name="temperatura">
            <label for="temperatura">Temperatura</label>
        </div>
        <label id="costoNetoLabel" style="color: black;"></label>
    </div>

    <div class="col-md-3">
        <div class="form-floating">
            <input type="number" class="form-control" id="revoluciones" placeholder="revoluciones" name="revoluciones">
            <label for="revoluciones">Revoluciones</label>
        </div>
        <label id="costoNetoLabel" style="color: black;"></label>
    </div>
    <div class="col-md-3">
        <div class="form-floating">
            <input type="number" class="form-control" id="velocidad" placeholder="velocidad" name="velocidad">
            <label for="velocidad">Velocidad</label>
        </div>
        <label id="costoNetoLabel" style="color: black;"></label>
    </div>
    <div class="col-md-3">
        <div class="form-floating">
            <input type="number" class="form-control" id="kilometraje" placeholder="kilometraje" name="kilometraje">
            <label for="kilometraje">Kilometraje inicial</label>
        </div>
        <label id="costoNetoLabel" style="color: black;"></label>
    </div>

    <div class="col-md-6">
        <div class="form-floating">
            <div class="form-label">
                <label for="foto_cluster" class="form-label">Foto clúster</label>
                <input class="form-control" type="file" id="foto_cluster" name="foto_cluster" accept="image/*">
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-floating">
            <div class="form-label">
                <label for="foto_unidad_exterior" class="form-label">Foto unidad exterior</label>
                <input class="form-control" type="file" id="foto_unidad_exterior" name="foto_unidad_exterior" accept="image/*">
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <p class="textmotivodenegacioncartaresponsiva">Comentarios</p>
            <textarea class="form-control textareamotivodenegacioncartaresponsiva comentarios_pruebas_demo" id="comentarios_pruebas_demo" name="comentarios_pruebas_demo"></textarea>
        </div>
    </div>


</div>