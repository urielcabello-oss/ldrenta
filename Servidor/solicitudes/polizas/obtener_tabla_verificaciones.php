<?php
include("../../conexion.php");

if (!isset($_SESSION)) session_start();

// =====================================================
// VALIDAR SESIÓN
// =====================================================

if (!isset($_SESSION['id_colaborador']) || !isset($_SESSION['id_tipo_usuario'])) {

    echo '
    <div class="alert alert-danger">
        Sesión inválida
    </div>';

    exit;
}

if (!isset($_POST['id_unidad'])) {

    echo '
    <div class="alert alert-warning">
        No se recibió el ID de la unidad
    </div>';

    exit;
}

$id_unidad = $_POST['id_unidad'];

// =====================================================
// QUERY VERIFICACIONES
// =====================================================

$query = "SELECT 
            veri.id_verificaciones,
            veri.id_unidad,
            veri.folio,
            veri.monto,
            veri.año,
            veri.fecha_verificacion,
            veri.fecha_siguiente_verificacion,
            verisemestre.nombre_semestre,
            estatusveri.estatus
          FROM verificaciones AS veri
          INNER JOIN estatus_verificacion AS estatusveri
            ON veri.id_estatus_verificacion = estatusveri.id_estatus_verificacion
          INNER JOIN verificacion_semestre AS verisemestre
            ON veri.id_semestre = verisemestre.id_semestre
          WHERE veri.id_unidad = '$id_unidad'
          ORDER BY veri.fecha_siguiente_verificacion DESC";

$ejecutar = $conexion->query($query);

?>

<div class="row g-4">

    <!-- ===================================================== -->
    <!-- HEADER -->
    <!-- ===================================================== -->

    <div class="col-12">

        <div class="titulo-seccion-orange">

            <div class="icono-seccion">
                <i class="fas fa-clipboard-check"></i>
            </div>

            <div>
                <h5 class="mb-1 fw-bold">
                    Historial de verificaciones
                </h5>

                <small>
                    Consulta y administración de verificaciones vehiculares
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
                                Monto
                            </th>

                            <th>
                                Año
                            </th>

                            <th>
                                Semestre
                            </th>

                            <th>
                                Fecha verificación
                            </th>

                            <th>
                                Próxima verificación
                            </th>

                            <th>
                                Estatus
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

                                        <button class="btn btn-warning btn-sm btn-modern btneditarverificaciones"
                                            data-id="<?php echo $data['id_verificaciones']; ?>">

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

                                    <!-- MONTO -->
                                    <td>

                                        <strong>
                                            $<?php echo number_format($data['monto'], 2); ?>
                                        </strong>

                                        <small class="text-muted">
                                            MXN
                                        </small>

                                    </td>

                                    <!-- AÑO -->
                                    <td>

                                        <?php echo htmlspecialchars($data['año']); ?>

                                    </td>

                                    <!-- SEMESTRE -->
                                    <td>

                                        <span class="badge bg-primary">

                                            <?php echo htmlspecialchars($data['nombre_semestre']); ?>

                                        </span>

                                    </td>

                                    <!-- FECHA VERIFICACION -->
                                    <td>

                                        <?php

                                        echo (!empty($data['fecha_verificacion']))
                                            ? date("d/m/Y", strtotime($data['fecha_verificacion']))
                                            : 'N/D';

                                        ?>

                                    </td>

                                    <!-- FECHA SIGUIENTE -->
                                    <td>

                                        <?php

                                        echo (!empty($data['fecha_siguiente_verificacion']))
                                            ? date("d/m/Y", strtotime($data['fecha_siguiente_verificacion']))
                                            : 'N/D';

                                        ?>

                                    </td>

                                    <!-- ESTATUS -->
                                    <td>

                                        <?php

                                        $estatus = strtolower($data['estatus']);

                                        $badge = "bg-secondary";

                                        if (
                                            $estatus == "vigente" ||
                                            $estatus == "aprobada"
                                        ) {

                                            $badge = "bg-success";

                                        } elseif (
                                            $estatus == "pendiente"
                                        ) {

                                            $badge = "bg-warning text-dark";

                                        } elseif (
                                            $estatus == "vencida" ||
                                            $estatus == "rechazada"
                                        ) {

                                            $badge = "bg-danger";
                                        }

                                        ?>

                                        <span class="badge <?php echo $badge; ?>">

                                            <?php echo $data['estatus']; ?>

                                        </span>

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
                                            No se encontraron verificaciones
                                        </h5>

                                        <small class="text-muted">
                                            Esta unidad aún no tiene verificaciones registradas
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