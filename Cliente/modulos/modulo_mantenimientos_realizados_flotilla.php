<div class="contenedorvalidacionunidades">
    <h5 class="titulosletrasunidades text-nowrap">
        <a class="navbar-brand" href="#"><i class="bi bi-tools"></i> Flotilla - Mantenimientos realizados (Flotilla)</a>
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
                    <th scope="col">Factura</th>
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

        fetch("../../Servidor/solicitudes/unidades/mantenimientos_unidades_flotilla/obtener_mantenimientos.php")
            .then(res => res.json())
            .then(data => {
                // Filtrar solo los finalizados
                const finalized = data.filter(m => m.estatus.toLowerCase() === "finalizado");

                if (finalized.length === 0) {
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
                        <td>
                            ${
                                m.factura 
                                ? `<button class="btn btn-sm btn-primary verFacturaBtn"
                                        data-file="${m.factura}">
                                        <i class="bi bi-file-earmark-pdf"></i> Ver
                                </button>`
                                : `<span class="text-muted">Sin archivo</span>`
                            }
                        </td>
                    `;
                    container.appendChild(row);
                });
                document.addEventListener("click", function(e) {
                    if (e.target.closest(".verFacturaBtn")) {

                        const btn = e.target.closest(".verFacturaBtn");
                        const file = btn.dataset.file;

                        const ruta = `../../Servidor/archivos/files/files_mantenimientos_flotilla/facturas_mantenimientos_flotilla/${file}`;

                        window.open(ruta, "_blank");
                    }
                });
            })
            .catch(err => {
                container.innerHTML = `<tr><td class="text-danger" colspan="5">Error al cargar unidades finalizadas.</td></tr>`;
                console.error(err);
            });
    });
</script>