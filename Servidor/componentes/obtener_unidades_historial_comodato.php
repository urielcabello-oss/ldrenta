<?php

include("../../Servidor/conexion.php");

$queryobtenercomodatosusuarios = '  SELECT auc.id_asignaciones,
                                            colab.nombre_1 AS nombre1colaborador,
                                            colab.nombre_2 AS nombre2colaborador,
                                            colab.apellido_paterno AS apellidopaterno_colaborador,
                                            colab.apellido_materno AS apellidomaterno_colaborador,
                                            colabcomodato.nombre_1 AS nombre_creador_comodato,
                                            colabcomodato.nombre_2 AS nombre_creador_comodato_2,
                                            colabcomodato.apellido_paterno AS apaterno_creador_comodato,
                                            colabcomodato.apellido_materno AS amaterno_creador_comodato,
                                            usuexterno.nombre_1 AS nombre1usuario,
                                            usuexterno.nombre_2 AS nombre2usuario,
                                            usuexterno.apellido_paterno AS apellidopaterno_usuario,
                                            usuexterno.apellido_materno AS apellidomaterno_usuario,
                                            model.nombre_modelo,
                                            unid.placa,
                                            unid.img_unidad,
                                            estcomodato.estatus_comodato,
                                            auc.id_creador_comodato,
                                            auc.id_estatus_comodato,
                                            auc.archivo_comodato_firmado,
                                            auc.fecha_creacion_comodato,
                                            auc.id_usuario_externo
                                    FROM asignacion_unidad_colaborador AS auc
                                    LEFT JOIN colaboradores AS colab
                                    ON auc.id_colaborador = colab.id_colaborador
                                    LEFT JOIN unidades AS unid
                                    ON auc.id_unidad = unid.id_unidad
                                    LEFT JOIN modelos AS model
                                    ON unid.id_modelo = model.id_modelo
                                    LEFT JOIN estatus_comodato AS estcomodato
                                    ON auc.id_estatus_comodato = estcomodato.id_estatus_comodato
                                    LEFT JOIN colaboradores AS colabcomodato
                                    ON auc.id_creador_comodato = colabcomodato.id_colaborador
                                    LEFT JOIN usuarios_externos AS usuexterno
                                    ON auc.id_usuario_externo = usuexterno.id_usuario_externo';

$resultado = $conexion->query($queryobtenercomodatosusuarios);
//Hacemos el titulo de la tabla
echo '<table class="table table-hover tablaunidades" id="tablaUnidades">
    <thead style="background-color:rgba(119, 120, 121, 0.68); color: white;">
      <tr class="titulostablaunidades">
        <th class="titulostablaunidades">ID</th>
        <th class="titulostablaunidades">Colaborador de la unidad</th>
        <th class="titulostablaunidades">Modelo</th>
        <th class="titulostablaunidades">Placa</th>
        <th class="titulostablaunidades">Creador del comodato</th>
        <th class="titulostablaunidades">Creación del comodato</th>
        <th class="titulostablaunidades">Estatus</th>
        <th class="titulostablaunidades">Achivo</th>
      </tr>
    </thead>
<tbody>';

if ($resultado->num_rows > 0) {
    $contador = 1;

    while ($fila = $resultado->fetch_assoc()) {
        if ($fila['id_estatus_comodato'] == 3 || $fila['id_estatus_comodato'] == 4 || $fila['id_estatus_comodato'] == 5 || $fila['id_estatus_comodato'] == 6) {
            echo "<tr>
            
            <td>".$contador."</td>
            <td class='titulostablaunidades'>".$fila['nombre1colaborador'] . ' ' . $fila['nombre2colaborador'] . ' ' . $fila['apellidopaterno_colaborador'] . ' ' . $fila['apellidomaterno_colaborador'] . ' ' . $fila['nombre1usuario'] . ' ' . $fila['nombre2usuario'] . ' ' . $fila['apellidopaterno_usuario'] . ' ' . $fila['apellidomaterno_usuario']."</td>
            <td class='titulostablaunidades'>".$fila['nombre_modelo']."</td>
            <td class='titulostablaunidades'>".$fila['placa']."</td>
            <td class='titulostablaunidades'>".$fila['nombre_creador_comodato']." ".$fila['nombre_creador_comodato_2']." ".$fila['apaterno_creador_comodato']." ".$fila['amaterno_creador_comodato']."</td>
            <td class='titulostablaunidades'>".date('d-m-Y', strtotime($fila['fecha_creacion_comodato']))."</td>
            <td class='titulostablaunidades'>".$fila['estatus_comodato']."</td>
            <td class='titulostablaunidades'>";
            
            if ($fila['archivo_comodato_firmado'] != "") {
                echo '<a href="../../Servidor/archivos/files/files_unidades/comodato_firmado_por_usuario/' . $fila['archivo_comodato_firmado'] . '" target="_blank" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>';
            }
            echo "</td>
        </tr>";
        }
$contador++;
}
}
?>