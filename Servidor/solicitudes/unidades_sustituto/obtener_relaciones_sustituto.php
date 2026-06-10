<?php

include("../../conexion.php");

$sql = "

SELECT

    u.id_unidad,
    u.placa,
    u.vin,

    ma.nombre_marca,
    mo.nombre_modelo,

    COUNT(us.id_unidad_sustituto) AS total_sustitutas

FROM unidades_sustituto us

INNER JOIN unidades u
    ON us.id_unidad = u.id_unidad

INNER JOIN modelos mo
    ON u.id_modelo = mo.id_modelo

INNER JOIN marcas ma
    ON mo.id_marca = ma.id_marca

WHERE us.estado = 1

GROUP BY
    u.id_unidad,
    u.placa,
    ma.nombre_marca,
    mo.nombre_modelo

ORDER BY
    ma.nombre_marca,
    mo.nombre_modelo

";

$resultado = mysqli_query($conexion, $sql);

$html = '';

while ($principal = mysqli_fetch_assoc($resultado)) {

    $idUnidad = $principal['id_unidad'];

    $html .= '

    <div class="accordion-item">

        <h2 class="accordion-header" id="heading_'.$idUnidad.'">

            <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapse_'.$idUnidad.'"
                aria-expanded="false">

                <div class="w-100 d-flex justify-content-between align-items-center">

                    <div>

                        <strong>
                            '.$principal['nombre_marca'].' '.$principal['nombre_modelo'].'
                        </strong>

                        <span class="ms-2 text-muted">
                            '.$principal['placa'].' | '.$principal['vin'].'
                        </span>

                    </div>

                    <span class="badge bg-success me-3">

                        '.$principal['total_sustitutas'].' sustitutas

                    </span>

                </div>

            </button>

        </h2>

        <div
            id="collapse_'.$idUnidad.'"
            class="accordion-collapse collapse"
            data-bs-parent="#accordionRelaciones">

            <div class="accordion-body">

    ';

    $sqlSustitutas = "

    SELECT

        us.id_unidad_sustituto,

        u.placa,
        u.vin,

        ma.nombre_marca,
        mo.nombre_modelo

    FROM unidades_sustituto us

    INNER JOIN unidades u
        ON us.id_unidad_sustituta = u.id_unidad

    INNER JOIN modelos mo
        ON u.id_modelo = mo.id_modelo

    INNER JOIN marcas ma
        ON mo.id_marca = ma.id_marca

    WHERE us.id_unidad = '$idUnidad'
    AND us.estado = 1

    ORDER BY
        ma.nombre_marca,
        mo.nombre_modelo

    ";

    $sustitutas = mysqli_query($conexion, $sqlSustitutas);

    if (mysqli_num_rows($sustitutas) > 0) {

        while ($s = mysqli_fetch_assoc($sustitutas)) {

            $html .= '

            <div class="card mb-2 border">

                <div class="card-body py-2">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <strong>

                                '.$s['nombre_marca'].' '.$s['nombre_modelo'].'

                            </strong>

                            <br>

                            <small class="text-muted">

                                '.$s['placa'].' | '.$s['vin'].'

                            </small>

                        </div>

                        <button
                            type="button"
                            class="btn btn-danger btn-sm eliminarRelacion"
                            data-id="'.$s['id_unidad_sustituto'].'">

                            <i class="fa-solid fa-trash"></i>

                        </button>

                    </div>

                </div>

            </div>

            ';
        }

    } else {

        $html .= '

        <div class="alert alert-warning mb-0">

            Esta unidad no tiene sustitutas asignadas.

        </div>

        ';
    }

    $html .= '

            </div>

        </div>

    </div>

    ';
}

echo $html;