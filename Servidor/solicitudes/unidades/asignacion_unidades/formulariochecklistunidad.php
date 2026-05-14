<?php
include("../../../conexion.php");

if (isset($_POST['idunidadasignar']) && isset($_POST['colaboradorasignacion'])) {
    $idUnidad = $_POST['idunidadasignar'];
    $idColaborador = $_POST['colaboradorasignacion'];

    // Simulación de datos en caso de que no se hayan definido
    $checkdocumentosunidad = ['Factura', 'Tarjeta de circulación', 'Verificación'];
    $cheklistgeneralesdelautomovil = ['Gato', 'Llave de cruz', 'Refacción'];

    // Obtener checklist ANVERSO
    $queryChecklistAnverso = "SELECT DISTINCT 
            rev.nombre_revision,
            rev.id_revision,
            arc.id_revisiones_catalogos,
            arc.id_catalogo_revision 
        FROM revisiones AS rev
        INNER JOIN asignacion_revisiones_catalogos AS arc ON rev.id_revision = arc.id_revision
        INNER JOIN asignacion_catalogos_modelos AS acm ON arc.id_catalogo_revision = acm.id_catalogo_revision
        INNER JOIN unidades AS unid ON unid.id_unidad = $idUnidad
        INNER JOIN modelos AS model ON unid.id_modelo = model.id_modelo
        INNER JOIN catalogos_revisiones AS catrev ON catrev.id_catalogo_revision = acm.id_catalogo_revision
        WHERE rev.id_tipo_revision = 1
    ";

    $resultChecklistAnverso = $conexion->query($queryChecklistAnverso);
    ?>

    <!-- Formulario Principal -->
    <form id="formChecklistUnidadCompleto">
        <input type="hidden" name="idunidad" value="<?= $idUnidad ?>">
        <input type="hidden" name="idcolaborador" value="<?= $idColaborador ?>">

        <!-- ANVERSO -->
        <strong>
            <h4 class="text-center" style="padding: 10px; background-color:rgba(121, 119, 119, 0.87); color: white;">
                ASIGNACIÓN ANVERSO
            </h4>
        </strong>
        <h5 style="padding: 10px;"><strong>DA CLICK EN EL CHECK SI CONTIENE EL ACCESORIO</strong></h5>

        <div class="row">
            <?php if ($resultChecklistAnverso && $resultChecklistAnverso->num_rows > 0): ?>
                <?php while ($data = $resultChecklistAnverso->fetch_assoc()): ?>
                    <div class="col-md-6 mb-2">
                        <div class="form-check">
                            <input class="form-check-input resgitrarchecklist" type="checkbox">
                            <label class="form-check-label">
                                <?= $data['nombre_revision'] ?>
                            </label>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-danger">No hay datos del checklist anverso.</p>
            <?php endif; ?>
        </div>

        <div class="col-md-10 mb-2">
            <h6 style="font-weight: bold;">OTROS</h6>
            <textarea class="form-control" name="otros_anverso" style="height: 100px;"></textarea>
        </div>

        <!-- DOCUMENTOS -->
        <h5 style="padding: 10px;"><strong>DOCUMENTOS DE LA UNIDAD</strong></h5>
        <div class="row">
            <?php foreach ($checkdocumentosunidad as $documento): ?>
                <div class="col-md-6 mb-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                               name="documentos_unidad[]" value="<?= $documento ?>" id="doc_<?= $documento ?>">
                        <label class="form-check-label" for="doc_<?= $documento ?>">
                            <?= $documento ?>
                        </label>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="col-md-10 mb-2">
            <h6 style="font-weight: bold;">OTROS</h6>
            <textarea class="form-control" name="otros_documentos" style="height: 100px;"></textarea>
        </div>

        <!-- OBSERVACIONES -->
        <div class="col-md-10 mb-2">
            <h5><strong>OBSERVACIONES</strong></h5>
            <textarea class="form-control" name="observaciones_general" style="height: 100px;"></textarea>
        </div>

        <!-- REVERSO -->
        <strong>
            <h4 class="text-center" style="padding: 10px; background-color:rgba(121, 119, 119, 0.87); color: white;">
                ASIGNACIÓN REVERSO
            </h4>
        </strong>
        <h5 style="padding: 10px;"><strong>CONDICIONES GENERALES DEL AUTOMÓVIL</strong></h5>

        <div class="row">
            <?php foreach ($cheklistgeneralesdelautomovil as $accesorio): ?>
                <div class="col-md-6 mb-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                               name="condiciones_generales[]" value="<?= $accesorio ?>" id="acc_<?= $accesorio ?>">
                        <label class="form-check-label" for="acc_<?= $accesorio ?>">
                            <?= $accesorio ?>
                        </label>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="col-md-10 mb-2">
            <h6 style="font-weight: bold;">OTROS</h6>
            <textarea class="form-control" name="otros_reverso" style="height: 100px;"></textarea>
        </div>

        <!-- EVIDENCIAS -->
        <strong>
            <h4 class="text-center" style="padding: 10px; background-color:rgba(121, 119, 119, 0.87); color: white;">
                EVIDENCIAS Y COMENTARIOS
            </h4>
        </strong>
        <h5>Imágenes de salida de la unidad</h5>
        <div class="col-md-6 mb-2">
            <input type="file" class="form-control" name="imagen_unidad" accept="image/*">
        </div>

        <div class="col-md-10 mb-2">
            <p>Comentarios de salida</p>
            <textarea class="form-control" name="comentarios_salida" style="height: 100px;"></textarea>
        </div>

    </form>
    <?php
}
?>
