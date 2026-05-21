<?php
include("../../conexion.php");

if (!isset($_SESSION)) session_start();


if (!isset($_POST['id_unidad'])) {
    echo '
    <div class="alert alert-warning">
        No se recibió el ID de la unidad
    </div>';
    exit;
}

$id_unidad = $_POST['id_unidad'];

// =====================================================
// QUERY TENENCIAS
// =====================================================

$query = "SELECT 
            ten.id_tenencias,
            ten.id_unidad,
            ten.folio,
            ten.año_semestre,
            ten.id_estatus_tenencias,
            ten.monto_pago,
            ten.fecha_pago,
            ten.fecha_vencimiento,
            ten.documento_tenencia,
            estatenencia.estatus
          FROM tenencias AS ten
          INNER JOIN estatus_tenencias AS estatenencia
            ON ten.id_estatus_tenencias = estatenencia.id_estatus_tenencias
          WHERE ten.id_unidad = '$id_unidad'
          ORDER BY ten.fecha_vencimiento DESC";

$ejecutar = $conexion->query($query);

?>

<div class="row g-4">

    <!-- ===================================================== -->
    <!-- HEADER -->
    <!-- ===================================================== -->

    <div class="col-12">

        <div class="titulo-seccion-orange">

            <div class="icono-seccion">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>

            <div>
                <h5 class="mb-1 fw-bold">
                    Historial de tenencias
                </h5>

                <small>
                    Consulta y administración de pagos de tenencias
                </small>
            </div>

        </div>

    </div>

    <!-- ===================================================== -->
    <!-- TABLA -->
    <!-- ===================================================== -->

    <div class="col-12">

        <div class="ldr-form-section">

            <div class="ldr-section-title">
                <i class="fas fa-table-list"></i>
                Registros encontrados
            </div>

            <div class="table-responsive">

                <table class="table table-hover align-middle ldr-table">

                    <thead>

                        <tr>

                            <th width="120">
                                Acción
                            </th>

                            <th>
                                Unidad
                            </th>

                            <th>
                                Folio
                            </th>

                            <th>
                                Año / semestre
                            </th>

                            <th>
                                Estatus
                            </th>

                            <th>
                                Monto
                            </th>

                            <th>
                                Fecha pago
                            </th>

                            <th>
                                Vencimiento
                            </th>

                            <th class="text-center">
                                Documento
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        if ($ejecutar && $ejecutar->num_rows > 0) {

                            while ($data = $ejecutar->fetch_assoc()) {

                                ?>

                                <tr>

                                    <!-- ACCIONES -->
                                    <td>

                                        <button class="btn btn-warning btn-sm btn-modern btneditartenencias"
                                            data-id="<?php echo $data['id_tenencias']; ?>">

                                            <i class="fas fa-edit"></i>

                                        </button>

                                    </td>

                                    <!-- UNIDAD -->
                                    <td>

                                        <span class="badge bg-dark">
                                            #<?php echo $data['id_unidad']; ?>
                                        </span>

                                    </td>

                                    <!-- FOLIO -->
                                    <td>

                                        <strong>
                                            <?php echo htmlspecialchars($data['folio']); ?>
                                        </strong>

                                    </td>

                                    <!-- AÑO -->
                                    <td>

                                        <?php echo htmlspecialchars($data['año_semestre']); ?>

                                    </td>

                                    <!-- ESTATUS -->
                                    <td>

                                        <?php

                                        $estatus = strtolower($data['estatus']);

                                        $badge = "bg-secondary";

                                        if ($estatus == "pagada") {
                                            $badge = "bg-success";
                                        } elseif ($estatus == "pendiente") {
                                            $badge = "bg-warning text-dark";
                                        } elseif ($estatus == "vencida") {
                                            $badge = "bg-danger";
                                        }

                                        ?>

                                        <span class="badge <?php echo $badge; ?>">
                                            <?php echo $data['estatus']; ?>
                                        </span>

                                    </td>

                                    <!-- MONTO -->
                                    <td>

                                        <strong>
                                            $<?php echo number_format($data['monto_pago'], 2); ?>
                                        </strong>

                                        <small class="text-muted">
                                            MXN
                                        </small>

                                    </td>

                                    <!-- FECHA PAGO -->
                                    <td>

                                        <?php
                                        echo (!empty($data['fecha_pago']))
                                            ? date("d/m/Y", strtotime($data['fecha_pago']))
                                            : 'N/D';
                                        ?>

                                    </td>

                                    <!-- FECHA VENCIMIENTO -->
                                    <td>

                                        <?php
                                        echo (!empty($data['fecha_vencimiento']))
                                            ? date("d/m/Y", strtotime($data['fecha_vencimiento']))
                                            : 'N/D';
                                        ?>

                                    </td>

                                    <!-- DOCUMENTO -->
                                    <td class="text-center">

                                        <?php

                                        if (!empty($data['documento_tenencia'])) {

                                        ?>

                                            <a href="../../Servidor/archivos/files/files_unidades/polizas_tenencias/<?php echo $data['documento_tenencia']; ?>"
                                                target="_blank"
                                                class="btn btn-success btn-sm btn-modern">

                                                <i class="fas fa-eye"></i>

                                            </a>

                                        <?php

                                        } else {

                                            echo '
                                            <span class="text-muted">
                                                Sin archivo
                                            </span>';
                                        }

                                        ?>

                                    </td>

                                </tr>

                        <?php

                            }
                        } else {

                            echo '
                            <tr>
                                <td colspan="9">

                                    <div class="text-center py-5">

                                        <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>

                                        <h5 class="text-muted">
                                            No se encontraron registros
                                        </h5>

                                        <small class="text-muted">
                                            Esta unidad aún no tiene tenencias registradas
                                        </small>

                                    </div>

                                </td>
                            </tr>';
                        }

                        ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>