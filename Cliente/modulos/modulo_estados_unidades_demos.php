<div class="contenedor_grafica">
<?php
include("../../Servidor/conexion.php");

$sql = "SELECT id_estado_prueba_demo, COUNT(*) AS total FROM asignacion_unidad_demo GROUP BY id_estado_prueba_demo";
$resultado = mysqli_query($conexion, $sql);

$pruebas = [];
while ($fila = mysqli_fetch_assoc($resultado)) {
    $pruebas[$fila['id_estado_prueba_demo']] = $fila['total'];
}

$sinPrueba = $pruebas[null] ?? 0;
$primera = $pruebas[1] ?? 0;
$segunda = $pruebas[2] ?? 0;
$finalizada = $pruebas[3] ?? 0;

$datos = [$sinPrueba, $primera, $segunda, $finalizada];
$etiquetas = ['Sin prueba', 'Primera prueba', 'Segunda prueba', 'Finalizada'];
$colores = ['#dc3545', '#ffc107', '#fd7e14', '#28a745'];
?>

<style>
#graficaPruebas {
    max-width: 100%;
    max-height: 300px;
    margin: auto;
}
</style>

<div class="container my-5">
        <h2 class="text-center mb-4">Gráfica de pruebas unidades demo</h2>

        <div class="estado-prueba mb-5">
            <?php foreach ($etiquetas as $i => $etiqueta) : ?>
                <div class="item">
                    <h5 style="color: <?= $colores[$i] ?>;"><?= $etiqueta ?></h5>
                    <p><?= $datos[$i] ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="chart-container">
            <canvas id="graficaPruebas"></canvas>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('graficaPruebas').getContext('2d');
        const graficaPruebas = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?= json_encode($etiquetas) ?>,
                datasets: [{
                    data: <?= json_encode($datos) ?>,
                    backgroundColor: <?= json_encode($colores) ?>,
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'Estado de pruebas de unidades demo'
                    }
                }
            }
        });
    </script>
</div>