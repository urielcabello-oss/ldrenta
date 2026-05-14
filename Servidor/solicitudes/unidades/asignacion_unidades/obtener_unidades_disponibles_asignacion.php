<?php

include("../../../conexion.php");
if (isset($_POST['selectmodelosasignacion'])) {
    $id_modelo = $_POST['selectmodelosasignacion'];
    //realizar la consulta a la base de datos para obtener los modelos dependiendo del select modelo
    $sqlunidadestipomodelo = "SELECT ung.id_unidad,
                                    marc.nombre_marca,  
                                    model.nombre_modelo,
                                    ung.placa,
                                    unest.estado,
                                    tipunid.id_tipo_unidad,
                                    unestatus.id_estatus_unidad,
                                    sed.ubicacion
                                FROM unidades AS ung
                                INNER JOIN modelos AS model 
                                ON ung.id_modelo = model.id_modelo 
                                INNER JOIN marcas AS marc 
                                ON model.id_marca = marc.id_marca  
                                INNER JOIN estado_unidad AS unest 
                                ON ung.id_estado_unidad = unest.id_estado_unidad
                                INNER JOIN estatus_unidades AS unestatus
                                ON ung.id_estatus_unidad = unestatus.id_estatus_unidad
                                INNER JOIN sedes AS sed 
                                ON ung.id_sede = sed.id_sede
                                INNER JOIN tipo_unidad AS tipunid 
                                ON ung.id_tipo_unidad = tipunid.id_tipo_unidad
                                where ung.id_modelo = $id_modelo 
                                AND ung.id_estado_unidad = 1
                                AND ung.id_estatus_unidad = 1
                                AND ung.id_tipo_unidad = 1";
    $result = $conectar->query($sqlunidadestipomodelo);
    echo '<thead style="background-color:rgba(119, 120, 121, 0.68); color: white;">
    <tr class="titulostablaunidades">
        <th>N o</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Placa</th>
        <th>Estado</th>
        <th>Ubicación</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody>';
    if ($result->num_rows > 0) {
        $contador = 1;
        while ($fila = $result->fetch_assoc()) {
            echo "<tr>
                
                <td>" . $contador . "</td>
                <td>" . $fila['nombre_marca'] . "</td>
                <td>" . $fila['nombre_modelo'] . "</td>
                <td>" . $fila['placa'] . "</td>
                <td>" . $fila['estado'] . "</td>
                <td>" . $fila['ubicacion'] . "</td>
                <td>
                    <button class='btn btn-warning btn-sm btninfounidadasignacion' data-id='" . $fila['id_unidad'] . "'>
                        <i class='fa-solid fa-eye'></i> Ver
                    </button>

                </td>
            </tr>";
            $contador++;
        }
    } else {
        echo "<tr><td colspan='7'>No hay unidades disponibles.</td></tr>";
    }
}
