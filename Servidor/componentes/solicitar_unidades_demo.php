<div class="ldr-solicitud-wrapper">

    <!-- FILTROS -->
    <div class="ldr-filtros-card">

        <div class="row g-4">

            <!-- Fecha solicitud -->
            <div class="col-md-6">

                <label class="label-form">
                    Fecha de solicitud
                </label>

                <input type="date"
                    class="form-control input-moderno"
                    id="fechasolicitudunidademo"
                    name="fechasolicitudunidademo">

            </div>

            <!-- Fecha devolución -->
            <div class="col-md-6">

                <label class="label-form">
                    Fecha devolución
                </label>

                <input type="date"
                    class="form-control input-moderno"
                    id="fechadevolucionunidademo"
                    name="fechadevolucionunidademo">

            </div>
        </div>

        <!-- FILTROS AVANZADOS -->
        <div class="row g-4 mt-1">
            

            <!-- Buscar -->
            <div class="col-md-8">

                <label class="label-form">
                    Buscar unidad
                </label>

                <input type="text"
                    class="form-control input-moderno"
                    id="busqueda_global"
                    name="busqueda_global"
                    placeholder="Modelo, placa, VIN...">

            </div>

            <!-- Modelo -->
            <?php
            include("../../Servidor/conexion.php");

            $sql = "SELECT id_modelo, nombre_modelo 
                    FROM modelos 
                    LEFT JOIN marcas 
                    ON modelos.id_marca = marcas.id_marca 
                    WHERE marcas.id_marca = 1";

            $result = $conexion->query($sql);

            if ($result->num_rows > 0) {

                echo '
                <div class="col-md-4">
                    <label class="label-form">Modelo</label>
                    <select class="form-select input-moderno" id="nombre_modelo" name="nombre_modelo">
                        <option value="">Todos</option>';

                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['id_modelo'] . '">' . $row['nombre_modelo'] . '</option>';
                }

                echo '
                    </select>
                </div>';
            }

            $conexion->close();
            ?>


        </div>

        <!-- BOTONES -->
        <div class="d-flex flex-wrap gap-3 mt-4">

            <button class="btn-orange"
                id="btnsolicitudunidademo">

                <i class="fas fa-search me-2"></i>
                Verificar unidades

            </button>

            <button class="btn btn-light btn-modern"
                type="button"
                onclick="limpiarCamposPrincipales()">

                <i class="fas fa-trash-alt me-2"></i>
                Limpiar

            </button>

        </div>

    </div>

</div>

<script>

    function limpiarCamposPrincipales() {

        const ids = [
            'fechasolicitudunidademo',
            'fechadevolucionunidademo',
            'busqueda_global',
            'nombre_modelo'
        ];

        ids.forEach(id => {
            const el = document.getElementById(id);

            if (el) {
                el.value = '';
            }
        });
    }

    const fechaInputSolicitud = document.getElementById('fechasolicitudunidademo');
    const fechaInputDevolucion = document.getElementById('fechadevolucionunidademo');

    const hoy = new Date();

    const yyyy = hoy.getFullYear();
    const mm = String(hoy.getMonth() + 1).padStart(2, '0');
    const dd = String(hoy.getDate()).padStart(2, '0');

    fechaInputSolicitud.min = `${yyyy}-${mm}-${dd}`;
    fechaInputDevolucion.min = `${yyyy}-${mm}-${dd}`;

    fechaInputSolicitud.addEventListener('change', function () {
        fechaInputDevolucion.min = this.value;
    });

</script>