<div class="contenedorvalidacionunidades">
    <h5 class="titulosletrasunidades text-nowrap">
        <a class="navbar-brand" href="#"><i class="bi bi-tools"></i> Flotilla - Mantenimientos realizados (Demo)</a>
    </h5>
    <h4 class="letravalidacionunidadresponsiva text-nowrap"></h4>
</div>

<div class="container my-4">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">VIN</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Taller</th>
                    <th scope="col">Fecha de salida</th>
                </tr>
            </thead>
            <tbody id="finalizedUnitsContainer">
                <!-- Aquí se generarán las filas -->
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById("finalizedUnitsContainer");

    fetch("../../Servidor/solicitudes/unidades/mantenimientos_unidades_demo/obtener_mantenimientos.php")
        .then(res => res.json())
        .then(data => {
            // Filtrar solo los finalizados
            const finalized = data.filter(m => m.estatus.toLowerCase() === "finalizado");

            if(finalized.length === 0){
                container.innerHTML = `<tr><td class="text-muted" colspan="5">No hay unidades finalizadas.</td></tr>`;
                return;
            }

            finalized.forEach(m => {
                const row = document.createElement("tr");

                row.innerHTML = `
                    <td>${m.vin}</td>
                    <td>${m.modelo}</td>
                    <td>${m.tipo}</td>
                    <td>${m.taller || "-"}</td>
                    <td>${m.fecha_salida || "-"}</td>
                    
                `;
                container.appendChild(row);
            });
        })
        .catch(err => {
            container.innerHTML = `<tr><td class="text-danger" colspan="5">Error al cargar unidades finalizadas.</td></tr>`;
            console.error(err);
        });
});
</script>

