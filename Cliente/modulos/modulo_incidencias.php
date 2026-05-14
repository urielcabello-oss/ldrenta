<!-------------------------------------------aqui comienza el contenedor Validacion de los comodatos ----------------------------------------------------------->
<div class="contenedorvalidacionunidades">
    <h5 class="titulosletrasunidades text-nowrap">
        <a class="navbar-brand" href="#"><i class="bi bi-tools"></i> Flotilla - Incidencias (Demo)</a>
    </h5>
    <h4 class="letravalidacionunidadresponsiva text-nowrap"></h4>
</div>

<!-- ========================= -->
<!-- MÓDULO: Registro Incidencias -->
<!-- ========================= -->
<div class="container py-4">
  <h4 class="mb-4">
    <i class="bi bi-exclamation-triangle"></i> Realizar reporte
  </h4>

  <form id="formIncidencia" enctype="multipart/form-data" class="p-3 border rounded bg-light shadow-sm">
    <div class="row mb-3">
      <div class="col-md-6">
        <label for="unidadInput" class="form-label">Unidad</label>
        <select class="form-select" id="unidadInput" name="id_unidad" required>
          <option value="">-- Selecciona una unidad --</option>
          <?php
          include("../../Servidor/conexion.php");
          $res = $conexion->query("SELECT id_unidad, vin, placa FROM unidades WHERE id_tipo_unidad = 3");
          while ($r = $res->fetch_assoc()) {
            echo "<option value='{$r['id_unidad']}'>{$r['vin']} - {$r['placa']}</option>";
          }
          ?>
        </select>
      </div>

      <div class="col-md-6">
        <label for="tipoInput" class="form-label">Tipo de incidencia</label>
        <select class="form-select" id="tipoInput" name="tipo_incidencia" required>
          <option value="">-- Selecciona tipo --</option>
          <option value="Daño menor">Daño menor</option>
          <option value="Accidente">Accidente</option>
          <option value="Robo de autopartes">Robo de autopartes</option>
          <option value="Robo total">Robo total de la unidad</option>
        </select>
      </div>
    </div>

    <div class="mb-3">
      <label for="descInput" class="form-label">Descripción</label>
      <textarea class="form-control" id="descInput" name="descripcion" rows="3" placeholder="Describe la incidencia..." required></textarea>
    </div>

    <div class="mb-3">
      <label for="fileInput" class="form-label">Evidencia (foto o PDF)</label>
      <input type="file" class="form-control" id="fileInput" name="evidencia" accept=".jpg,.jpeg,.png,.pdf">
    </div>

    <div class="text-end">
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Registrar incidencia
      </button>
    </div>
  </form>

  <div id="alertContainer" class="mt-3"></div>
</div>

<!-- JS -->
<script src="js/modulo_incidencias_registro.js"></script>