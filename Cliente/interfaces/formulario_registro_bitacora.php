<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Supón que recibes $id_prueba desde la vista anterior o la URL
$id_prueba = isset($_GET['id_prueba']) ? (int)$_GET['id_prueba'] : 0;
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bitácora diaria – Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="../img/LDR_LOGO.png" href="../img/LDR_LOGO.png">
    <!--estilos de boostrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CDN para poder utilizar los toastify -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <!--estilos de FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!--estIlos de interfaz-->
    <link rel="stylesheet" href="../css/estilos.css?v=1">
    <!--cdn para icons-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css"
        integrity="sha512-9xKTRVabjVeZmc+GUW8GgSmcREDunMM+Dt/GrzchfN8tkwHizc5RP4Ok/MXFFy5rIjJjzhndFScTceq5e6GvVQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!---estilos de los botones para descragar archhivos csv pdf excel--->
    <link rel="stylesheet" href="../datatable/buttons.dataTables.css">
    <link rel="stylesheet" href="../datatable/dataTables.dataTables.css">
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body class="bg-light">
    <?php
    include("../include/menu.php");

    //obtenemos el id del colaborador para saber quien es el que esta logeado
if (!isset($_SESSION)) {
    session_start();
}

// Verificar que la sesión tenga los datos necesarios
if (!isset($_SESSION['id_colaborador']) || !isset($_SESSION['id_tipo_usuario'])) {
    echo "Sesión inválida";
    exit;
}

$colaborador = $_SESSION['id_colaborador'];
$id_tipo_usuario = $_SESSION['id_tipo_usuario'];

    ?>
<!--------------------------------------mostramos el formulario del registro de la bitacora diaria solo a los master drivers------------------------------->
    <?php if ($id_tipo_usuario == 9 || $id_tipo_usuario == 11): ?>
    <div class="container py-4">
        <div class="row mb-3">
            <div class="col">
                <h1 class="titulosletrasunidadescliente">Registro de Bitácora diaria</h1>
                <p class="text-muted mb-0">Checklist de inicio/fin y muestreos durante la jornada.</p>
            </div>
        </div>

        <form id="formBitacora" class="cardontainer shadow-sm" method="POST" action="../../Servidor/solicitudes/pruebas_unidades_demo/guardar_bitacora.php" enctype="multipart/form-data">
            <input type="hidden" name="id_prueba" value="<?= htmlspecialchars($id_prueba) ?>">

            <div class="card-body">
                <!-- Datos generales -->
                <h5 class="mb-3">Datos generales</h5>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" class="form-control" name="fecha" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Objetivo de prueba</label>
                        <select class="form-select-prueba" name="objetivo_prueba" required>
                            <option value="">— Selecciona —</option>
                            <option>Rendimiento</option>
                            <option>Desempeño</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Origen</label>
                        <input type="text" class="form-control" name="origen" maxlength="100">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Destino</label>
                        <input type="text" class="form-control" name="destino" maxlength="100">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Peso de carga (toneladas)</label>
                        <input type="number" class="form-control" name="peso_carga" step="0.01" min="0">
                    </div>
                </div>

                <hr class="my-4">

                <!-- Inicio de jornada -->
                <h5 class="mb-3">Inicio de jornada</h5>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Kilometraje inicial</label>
                        <input type="number" class="form-control" name="kilometraje_inicial" min="0" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Hora de inicio</label>
                        <input type="time" class="form-control" name="hora_inicio" required>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="row w-100">
                            <div class="col-6 col-md-4 form-check">
                                <input class="form-check-input" type="checkbox" name="combustible_inicio" value="1" id="combI">
                                <label class="form-check-label" for="combI">Combustible lleno</label>
                            </div>
                            <div class="col-6 col-md-4 form-check">
                                <input class="form-check-input" type="checkbox" name="urea_inicio" value="1" id="ureaI">
                                <label class="form-check-label" for="ureaI">Urea llena</label>
                            </div>
                            <div class="col-6 col-md-4 form-check">
                                <input class="form-check-input" type="checkbox" name="llantas_inicio" value="1" id="llantI">
                                <label class="form-check-label" for="llantI">Presión llantas ok</label>
                            </div>
                            <div class="col-6 col-md-4 form-check">
                                <input class="form-check-input" type="checkbox" name="niveles_inicio" value="1" id="nivI">
                                <label class="form-check-label" for="nivI">Niveles ok</label>
                            </div>
                            <div class="col-6 col-md-4 form-check">
                                <input class="form-check-input" type="checkbox" name="fallas_inicio" value="1" id="fallI">
                                <label class="form-check-label" for="fallI">Códigos falla</label>
                            </div>
                            <div class="col-6 col-md-4 form-check">
                                <input class="form-check-input" type="checkbox" name="fugas_inicio" value="1" id="fugI">
                                <label class="form-check-label" for="fugI">Fugas</label>
                            </div>
                            <div class="col-6 col-md-4 form-check">
                                <input class="form-check-input" type="checkbox" name="danos_inicio" value="1" id="danI">
                                <label class="form-check-label" for="danI">Golpes/daños</label>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Fin de jornada -->
                <h5 class="mb-3">Fin de jornada</h5>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Kilometraje final</label>
                        <input type="number" class="form-control" name="kilometraje_final" min="0" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Hora de fin</label>
                        <input type="time" class="form-control" name="hora_fin" required>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="row w-100">
                            <div class="col-6 col-md-4 form-check">
                                <input class="form-check-input" type="checkbox" name="combustible_fin" value="1" id="combF">
                                <label class="form-check-label" for="combF">Combustible lleno</label>
                            </div>
                            <div class="col-6 col-md-4 form-check">
                                <input class="form-check-input" type="checkbox" name="urea_fin" value="1" id="ureaF">
                                <label class="form-check-label" for="ureaF">Urea llena</label>
                            </div>
                            <div class="col-6 col-md-4 form-check">
                                <input class="form-check-input" type="checkbox" name="fallas_fin" value="1" id="fallF">
                                <label class="form-check-label" for="fallF">Códigos falla</label>
                            </div>
                            <div class="col-6 col-md-4 form-check">
                                <input class="form-check-input" type="checkbox" name="fugas_fin" value="1" id="fugF">
                                <label class="form-check-label" for="fugF">Fugas</label>
                            </div>
                            <div class="col-6 col-md-4 form-check">
                                <input class="form-check-input" type="checkbox" name="danos_fin" value="1" id="danF">
                                <label class="form-check-label" for="danF">Golpes/daños</label>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4"> 



                <!-- Muestreos -->
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="mb-0">Muestreos durante la jornada</h5>
                    <button type="button" id="btnAddMuestreo" class="btn btn-outline-primary btn-sm">+ Agregar muestreo</button>
                </div>

                <div id="muestreos" class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Hora</th>
                                <th>RPM/Relación de marcha</th>
                                <th>Velocidad (Km/h)</th>
                                <th>Temperatura (°C)</th>
                                <th>Presión (Aceite)</th>
                                <th>Presión (Aire)</th>
                                <th>Odómetro (Km)</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="tbodyMuestreos">
                            <tr>
                                <td class="idx">1</td>
                                <td><input type="time" class="form-control" name="muestreos[0][hora]"></td>
                                <td><input type="text" class="form-control" name="muestreos[0][rpm_relacion]" maxlength="50"></td>
                                <td><input type="number" class="form-control" name="muestreos[0][velocidad]" step="0.01" min="0"></td>
                                <td><input type="number" class="form-control" name="muestreos[0][temperatura]" step="0.01"></td>
                                <td><input type="number" class="form-control" name="muestreos[0][presion_aceite]" step="0.01" min="0"></td>
                                <td><input type="number" class="form-control" name="muestreos[0][presion_aire]" step="0.01" min="0"></td>
                                <td><input type="number" class="form-control" name="muestreos[0][odometro]" min="0"></td>
                                <td><button type="button" class="btn btn-sm btn-outline-danger btnDel">Eliminar</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <hr class="my-4">

                <!-- Eventos importantes -->
                <h5 class="mb-3">Eventos importantes</h5>
                <div class="mb-3">
                    <textarea class="form-control" name="eventos_importantes" rows="3" placeholder="¿Ocurrió algún evento relevante de seguridad/consumo?"></textarea>
                </div>

            </div>
            

            <div class="card-footer d-flex gap-2">
                <button type="submit" class="btn btn-primary">Guardar bitácora</button>
                <a href="javascript:history.back()" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
    </div>
    <?php endif; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function() {
            const tbody = document.getElementById('tbodyMuestreos');
            const btnAdd = document.getElementById('btnAddMuestreo');

            function renumerar() {
                [...tbody.querySelectorAll('tr')].forEach((tr, idx) => {
                    tr.querySelector('.idx').textContent = idx + 1;
                    // Reasignar los name="muestreos[i][campo]"
                    ['hora', 'rpm_relacion', 'velocidad', 'temperatura', 'presion_aceite', 'presion_aire', 'odometro'].forEach(campo => {
                        const input = tr.querySelector(`[name^=muestreos][name$='[` + campo + `]']`);
                        if (input) input.name = `muestreos[${idx}][${campo}]`;
                    });
                });
            }

            btnAdd.addEventListener('click', () => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
      <td class="idx"></td>
      <td><input type="time" class="form-control" name="muestreos[][hora]"></td>
      <td><input type="text" class="form-control" name="muestreos[][rpm_relacion]" maxlength="50"></td>
      <td><input type="number" class="form-control" name="muestreos[][velocidad]" step="0.01" min="0"></td>
      <td><input type="number" class="form-control" name="muestreos[][temperatura]" step="0.01"></td>
      <td><input type="number" class="form-control" name="muestreos[][presion_aceite]" step="0.01" min="0"></td>
      <td><input type="number" class="form-control" name="muestreos[][presion_aire]" step="0.01" min="0"></td>
      <td><input type="number" class="form-control" name="muestreos[][odometro]" min="0"></td>
      <td><button type="button" class="btn btn-sm btn-outline-danger btnDel">Eliminar</button></td>`;
                tbody.appendChild(tr);
                renumerar();
            });

            tbody.addEventListener('click', (e) => {
                if (e.target.classList.contains('btnDel')) {
                    const tr = e.target.closest('tr');
                    tr.remove();
                    renumerar();
                }
            });
        })();
    </script>

    <?php
include("../../Servidor/conexion.php"); 

// Traemos todo de las dos tablas
$query = "SELECT d.*, 
                 m.id_muestreo, m.hora, m.rpm_relacion, m.velocidad, m.temperatura,
                 m.presion_aceite, m.presion_aire, m.odometro,
                 c.nombre_1, c.nombre_2, c.apellido_paterno, c.apellido_materno
          FROM bitacora_diaria d
          LEFT JOIN bitacora_muestreos m ON d.id_bitacora = m.id_bitacora
          LEFT JOIN colaboradores c ON d.id_master_driver = c.id_colaborador
          ORDER BY d.fecha DESC, m.hora ASC";
$result = mysqli_query($conexion, $query);

$bitacoras = [];
while ($row = mysqli_fetch_assoc($result)) {
    $id = $row["id_bitacora"];
    if (!isset($bitacoras[$id])) {
        $bitacoras[$id] = [
            "datos" => $row,
            "muestreos" => []
        ];
    }
    if ($row["id_muestreo"]) {
        $bitacoras[$id]["muestreos"][] = [
            "id_muestreo" => $row["id_muestreo"],
            "hora" => $row["hora"],
            "rpm_relacion" => $row["rpm_relacion"],
            "velocidad" => $row["velocidad"],
            "temperatura" => $row["temperatura"],
            "presion_aceite" => $row["presion_aceite"],
            "presion_aire" => $row["presion_aire"],
            "odometro" => $row["odometro"]
        ];
    }
}
?>


<div class="d-flex justify-content-between align-items-center">
    <h2 class="titulosletrasunidadescliente">Registros de Bitácora</h2>
    <button class="btn btn-registrar m-2" onclick="window.history.back()"><i class="fa-solid fa-arrow-left"></i> Regresar </button>
</div>
<?php foreach ($bitacoras as $b): 
    $d = $b["datos"]; ?>
    <div style="border:1px solid #b1aeaeff; padding:12px; margin-bottom:20px; border-radius:8px;">
        <p><strong>Fecha:</strong> <?= $d["fecha"] ?> | <strong>Origen:</strong> <?= $d["origen"] ?> → <strong>Destino:</strong> <?= $d["destino"] ?></p>
        <p><strong>Master Driver:</strong> <?= $d["nombre_1"] . " " . $d["nombre_2"] . " " . $d["apellido_paterno"] . " " . $d["apellido_materno"] ?> | <strong>Objetivo:</strong> <?= $d["objetivo_prueba"] ?></p>
        <p><strong>Inicio:</strong> Km <?= $d["kilometraje_inicial"] ?> | Hora <?= $d["hora_inicio"] ?></p>
        <p><strong>Fin:</strong> Km <?= $d["kilometraje_final"] ?> | Hora <?= $d["hora_fin"] ?></p>
        <p><strong>Eventos Importantes:</strong> <?= $d["eventos_importantes"] ?></p>

        <h4 class="titulosletrasunidadescliente">Muestreos</h4>
        <?php if (count($b["muestreos"]) > 0): ?>
        <table class="table table-striped" cellpadding="6" cellspacing="0" style="border-collapse: collapse; width:100%">
            <thead style="background:#f9f9f9">
                <tr>
                    <th>Hora</th>
                    <th>RPM Relación</th>
                    <th>Velocidad</th>
                    <th>Temperatura</th>
                    <th>Presión Aceite</th>
                    <th>Presión Aire</th>
                    <th>Odómetro</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($b["muestreos"] as $m): ?>
                <tr>
                    <td><?= $m["hora"] ?></td>
                    <td><?= $m["rpm_relacion"] ?></td>
                    <td><?= $m["velocidad"] ?></td>
                    <td><?= $m["temperatura"] ?></td>
                    <td><?= $m["presion_aceite"] ?></td>
                    <td><?= $m["presion_aire"] ?></td>
                    <td><?= $m["odometro"] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <em>No hay muestreos registrados</em>
        <?php endif; ?>

        <br>
        <a href="../../Servidor/solicitudes/pruebas_unidades_demo/generar_bitacora.php?id_bitacora=<?= $d["id_bitacora"] ?>" target="_blank">📄 Generar PDF</a>
    </div>
<?php endforeach; ?>

</body>

</html>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById("formBitacora").addEventListener("submit", function(e){
    e.preventDefault();

    let form = e.target;
    let formData = new FormData(form);

    fetch("../../Servidor/solicitudes/pruebas_unidades_demo/guardar_bitacora.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === "success"){
            Swal.fire({
                icon: "success",
                title: "Éxito",
                text: data.message,
                confirmButtonText: "OK"
            }).then(() => {
                // 👇 Redirige de nuevo a tu interfaz inicial
                window.location.href = "../interfaces/formulario_registro_bitacora.php?id_prueba=" + formData.get("id_prueba");
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: data.message
            });
        }
    })
    .catch(err => {
        Swal.fire({
            icon: "error",
            title: "Error inesperado",
            text: err
        });
    });
});
</script>
