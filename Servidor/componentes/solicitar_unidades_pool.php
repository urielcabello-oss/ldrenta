<div class="contenedorsolicitudunidadpool p-4 shadow-sm mb-4">

    <h5 class="mb-3">Datos de la solicitud</h5>

    <hr>

    <!-- ================= RECOLECCIÓN ================= -->
    <h6 class="text-primary mb-2">Recolección</h6>

    <div class="row g-3">
        <?php
        include("../../Servidor/conexion.php");
        $sql = "SELECT id_sede, ubicacion FROM sedes";
        $result = $conectar->query($sql);
        ?>

        <div class="col-md-4">
            <div class="form-floating">
                <select class="form-control" id="sederecoleccionpool">
                    <option value="">Seleccionar</option>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <option value="<?= $row['id_sede'] ?>"><?= $row['ubicacion'] ?></option>
                    <?php } ?>
                </select>
                <label>Ubicación de recolección</label>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-floating">
                <input type="date" class="form-control" id="fechasolicitudunidadpool">
                <label>Fecha de recolección</label>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-floating">
                <input type="time" class="form-control" id="horasolicitudunidadpool">
                <label>Hora</label>
            </div>
        </div>
    </div>

    <hr>

    <!-- ================= DEVOLUCIÓN ================= -->
    <h6 class="text-primary mb-2">Devolución</h6>

    <div class="row g-3">

        <div class="col-md-4">
            <div class="form-floating">
                <select class="form-control" id="sededevolucionunidadpool">
                    <option value="">Seleccionar</option>
                    <?php
                    $result->data_seek(0);
                    while ($row = $result->fetch_assoc()) { ?>
                        <option value="<?= $row['id_sede'] ?>"><?= $row['ubicacion'] ?></option>
                    <?php } ?>
                </select>
                <label>Ubicación de devolución</label>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-floating">
                <input type="date" class="form-control" id="fechadevolucionunidadpool">
                <label>Fecha de devolución</label>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-floating">
                <input type="time" class="form-control" id="horadevolucionunidadpool">
                <label>Hora</label>
            </div>
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-primary w-100" id="btnsolicitudunidadpool">
                Verificar unidades
            </button>
        </div>


    </div>

</div>