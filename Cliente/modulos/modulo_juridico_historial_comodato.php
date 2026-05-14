<!-------------------------------------------aqui comienza el contenedor Validacion de carta responsiva ----------------------------------------------------------->
<div class="contenedorvalidacionunidades">
    <h5 class="letrahistorialcomodato text-nowrap">
        Historial de comodatos asignados a usuarios.
    </h5>
    <br>
    <div class="contendortablahistorialcomodato" id="contendortablahistorialcomodato">
        <!-- Campo de búsqueda para filtrar la tabla -->
        <div class="buscadorhistorialcomodato">
            <input type="text" id="filtroBusqueda" class="form-control" placeholder="Buscar unidades..." onkeyup="filtrarTabla()">
        </div>
        <!--contenedor de las cards de las unidades por asignar-->
        <?php include("../../Servidor/componentes/obtener_unidades_historial_comodato.php"); ?>

    </div>
</div>