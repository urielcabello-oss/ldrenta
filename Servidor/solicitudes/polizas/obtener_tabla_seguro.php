<?php
include("../../conexion.php");

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['id_tipo_usuario'])) {
    echo '
    <div class="alert alert-danger">
        Sesión inválida
    </div>';
    exit;
}

if (!isset($_POST['id_unidad'])) {
    echo '
    <div class="alert alert-warning">
        No se recibió la unidad
    </div>';
    exit;
}

$id_unidad = $_POST['id_unidad'];

$query = "SELECT 
            aseg.numero_poliza_aseguradora,
            aseg.id_asignacion_aseguradora,
            aseg.fecha_alta,
            aseg.fecha_vencimiento,
            aseg.documento_aseguradora,
            unid.id_unidad,
            catlogo.aseguradora,
            estat_aseg.estatus,
            estad_aseg.estado_aseguradora
          FROM asignacion_aseguradora_unidad AS aseg
          INNER JOIN unidades AS unid 
                ON aseg.id_unidad = unid.id_unidad
          INNER JOIN aseguradoras AS catlogo 
                ON aseg.id_aseguradora = catlogo.id_aseguradora
          INNER JOIN estatus_aseguradora AS estat_aseg 
                ON aseg.id_estatus_aseguradora = estat_aseg.id_estatus_aseguradora
          INNER JOIN estado_aseguradora AS estad_aseg 
                ON aseg.id_estado_aseguradora = estad_aseg.id_estado_aseguradora
          WHERE unid.id_unidad = '$id_unidad'
          ORDER BY aseg.fecha_vencimiento DESC";

$resultado = $conexion->query($query);
?>

<div class="ldr-table-wrapper">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>

            <h5 class="fw-bold mb-1">
                Historial de pólizas
            </h5>

            <small class="text-muted">
                Registro histórico de seguros asignados
            </small>

        </div>

    </div>

    <div class="table-responsive">

        <table class="table ldr-table align-middle">

            <thead>

                <tr>

                    <th>Acciones</th>
                    <th>Unidad</th>
                    <th>Folio</th>
                    <th>Alta</th>
                    <th>Vencimiento</th>
                    <th>Aseguradora</th>
                    <th>Estatus</th>
                    <th>Estado</th>
                    <th>Documento</th>

                </tr>

            </thead>

            <tbody>

                <?php

                if ($resultado && $resultado->num_rows > 0):

                    while ($data = $resultado->fetch_assoc()):

                ?>

                        <tr>

                            <!-- ACCIONES -->
                            <td>

                                <button class="btn-table-action btn-edit btneditarpolizas"
                                    data-id="<?php echo $data['id_asignacion_aseguradora']; ?>">

                                    <i class="fas fa-pen"></i>

                                </button>

                            </td>

                            <!-- UNIDAD -->
                            <td>

                                <span class="fw-semibold">
                                    #<?php echo $data['id_unidad']; ?>
                                </span>

                            </td>

                            <!-- FOLIO -->
                            <td>

                                <span class="badge-folio">
                                    <?php echo $data['numero_poliza_aseguradora']; ?>
                                </span>

                            </td>

                            <!-- ALTA -->
                            <td>

                                <?php echo date("d/m/Y", strtotime($data['fecha_alta'])); ?>

                            </td>

                            <!-- VENCIMIENTO -->
                            <td>

                                <?php echo date("d/m/Y", strtotime($data['fecha_vencimiento'])); ?>

                            </td>

                            <!-- ASEGURADORA -->
                            <td>

                                <span class="fw-semibold">
                                    <?php echo $data['aseguradora']; ?>
                                </span>

                            </td>

                            <!-- ESTATUS -->
                            <td>

                                <span class="badge bg-success">
                                    <?php echo $data['estatus']; ?>
                                </span>

                            </td>

                            <!-- ESTADO -->
                            <td>

                                <span class="badge bg-primary">
                                    <?php echo $data['estado_aseguradora']; ?>
                                </span>

                            </td>

                            <!-- DOCUMENTO -->
                            <td>

                                <?php
                                if (
                                    !empty($data['documento_aseguradora']) &&
                                    $data['documento_aseguradora'] != "SIN ASIGNAR"
                                ):
                                ?>

                                    <a href="../../Servidor/archivos/files/files_unidades/polizas_seguros/<?php echo $data['documento_aseguradora']; ?>"
                                        target="_blank"
                                        class="btn-table-action btn-pdf">

                                        <i class="fas fa-file-pdf"></i>

                                    </a>

                                <?php else: ?>

                                    <span class="text-muted small">
                                        Sin documento
                                    </span>

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="9">

                            <div class="ldr-empty-state">

                                <i class="fas fa-shield-halved"></i>

                                <h6>
                                    No hay pólizas registradas
                                </h6>

                                <small>
                                    Esta unidad todavía no tiene seguros asignados
                                </small>

                            </div>

                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>