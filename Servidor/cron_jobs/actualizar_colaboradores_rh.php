<?php

// Conexión a la base de datos local
include("../../Servidor/conexion.php");

// Conexión a la base de datos de RH
include("../../Servidor/conexionbdrh.php");

// Función para validar claves foráneas
function existeEnTabla($conexion, $tabla, $campo, $valor) {
    $valor = $conexion->real_escape_string($valor);
    $check = $conexion->query("SELECT 1 FROM $tabla WHERE $campo = '$valor'");
    return ($check && $check->num_rows > 0);
}

// Obtener todos los colaboradores desde RH
$resultado = $conexion_rh->query("SELECT * FROM colaboradores");

if ($resultado) {
    while ($col = $resultado->fetch_assoc()) {
        // Escapar y limpiar valores null
        foreach ($col as $key => $value) {
            $col[$key] = ($value !== null) ? $conexion->real_escape_string($value) : null;
        }

        $id = $col['id_colaborador'];

        // Validar claves foráneas críticas
        $claves_foraneas = [
            ['tabla' => 'empresas', 'campo' => 'id_empresa', 'valor' => $col['id_empresa']],
            ['tabla' => 'direcciones', 'campo' => 'id_direccion', 'valor' => $col['id_direccion']],
            ['tabla' => 'areas', 'campo' => 'id_area', 'valor' => $col['id_area']],
            ['tabla' => 'puestos', 'campo' => 'id_puesto', 'valor' => $col['id_puesto']]
        ];

        $foranea_faltante = false;
        foreach ($claves_foraneas as $fk) {
            if (!existeEnTabla($conexion, $fk['tabla'], $fk['campo'], $fk['valor'])) {
                echo "Omitido: {$fk['campo']} '{$fk['valor']}' no existe para colaborador $id\n";
                $foranea_faltante = true;
                break;
            }
        }

        if ($foranea_faltante) {
            continue; // Evita error por restricción de integridad
        }

        // Verificar si ya existe
        $existe = $conexion->query("SELECT id_colaborador FROM colaboradores WHERE id_colaborador = '$id'");

        if ($existe && $existe->num_rows > 0) {
            // UPDATE
            $sql = "UPDATE colaboradores SET 
                numero_colaborador = '{$col['numero_colaborador']}',
                nombre_1 = '{$col['nombre_1']}',
                nombre_2 = '{$col['nombre_2']}',
                nombre_fav = '{$col['nombre_fav']}',
                apellido_paterno = '{$col['apellido_paterno']}',
                apellido_materno = '{$col['apellido_materno']}',
                fecha_nacimiento = '{$col['fecha_nacimiento']}',
                genero = '{$col['genero']}',
                curp = '{$col['curp']}',
                nss = '{$col['nss']}',
                rfc = '{$col['rfc']}',
                id_tipo_estado_civil = '{$col['id_tipo_estado_civil']}',
                numero_hijos = '{$col['numero_hijos']}',
                telefono_personal = '{$col['telefono_personal']}',
                domicilio = '{$col['domicilio']}',
                id_tipo_sangre = '{$col['id_tipo_sangre']}',
                operaciones_previas = '{$col['operaciones_previas']}',
                enfermedades_cronicas = '{$col['enfermedades_cronicas']}',
                email_personal = '{$col['email_personal']}',
                id_contacto = '{$col['id_contacto']}',
                email_corporativo = '{$col['email_corporativo']}',
                email_corporativo_2 = '{$col['email_corporativo_2']}',
                telefono_corporativo = '{$col['telefono_corporativo']}',
                fecha_ingreso = '{$col['fecha_ingreso']}',
                fecha_salida = '{$col['fecha_salida']}',
                id_empresa = '{$col['id_empresa']}',
                id_direccion = '{$col['id_direccion']}',
                id_sede = '{$col['id_sede']}',
                id_area = '{$col['id_area']}',
                id_puesto = '{$col['id_puesto']}',
                id_turno_trabajo = '{$col['id_turno_trabajo']}',
                id_kit_bienvenida = '{$col['id_kit_bienvenida']}',
                id_jefe_directo = '{$col['id_jefe_directo']}',
                fecha_alta_imss = '{$col['fecha_alta_imss']}',
                id_tipo_contrato = '{$col['id_tipo_contrato']}',
                sueldo_neto = '{$col['sueldo_neto']}',
                sueldo_bruto = '{$col['sueldo_bruto']}',
                id_tipo_pago = '{$col['id_tipo_pago']}',
                id_banco = '{$col['id_banco']}',
                cuenta_bancaria = '{$col['cuenta_bancaria']}',
                clabe_interbancaria = '{$col['clabe_interbancaria']}',
                id_estado_colaborador = '{$col['id_estado_colaborador']}',
                id_estatus_colaborador = '{$col['id_estatus_colaborador']}',
                fecha_guardado = '{$col['fecha_guardado']}',
                fecha_actualizacion = '{$col['fecha_actualizacion']}',
                id_colaborador_creacion = '{$col['id_colaborador_creacion']}',
                id_colaborador_ultima_actualizacion = '{$col['id_colaborador_ultima_actualizacion']}'
                WHERE id_colaborador = '$id'";
        } else {
            // INSERT
            $sql = "INSERT INTO colaboradores (
                id_colaborador, numero_colaborador, nombre_1, nombre_2, nombre_fav,
                apellido_paterno, apellido_materno, fecha_nacimiento, genero, curp,
                nss, rfc, id_tipo_estado_civil, numero_hijos, telefono_personal,
                domicilio, id_tipo_sangre, operaciones_previas, enfermedades_cronicas,
                email_personal, id_contacto, email_corporativo, email_corporativo_2,
                telefono_corporativo, fecha_ingreso, fecha_salida, id_empresa,
                id_direccion, id_sede, id_area, id_puesto, id_turno_trabajo,
                id_kit_bienvenida, id_jefe_directo, fecha_alta_imss, id_tipo_contrato,
                sueldo_neto, sueldo_bruto, id_tipo_pago, id_banco, cuenta_bancaria,
                clabe_interbancaria, id_estado_colaborador, id_estatus_colaborador,
                fecha_guardado, fecha_actualizacion, id_colaborador_creacion,
                id_colaborador_ultima_actualizacion
            ) VALUES (
                '{$col['id_colaborador']}', '{$col['numero_colaborador']}', '{$col['nombre_1']}',
                '{$col['nombre_2']}', '{$col['nombre_fav']}', '{$col['apellido_paterno']}',
                '{$col['apellido_materno']}', '{$col['fecha_nacimiento']}', '{$col['genero']}',
                '{$col['curp']}', '{$col['nss']}', '{$col['rfc']}', '{$col['id_tipo_estado_civil']}',
                '{$col['numero_hijos']}', '{$col['telefono_personal']}', '{$col['domicilio']}',
                '{$col['id_tipo_sangre']}', '{$col['operaciones_previas']}', '{$col['enfermedades_cronicas']}',
                '{$col['email_personal']}', '{$col['id_contacto']}', '{$col['email_corporativo']}',
                '{$col['email_corporativo_2']}', '{$col['telefono_corporativo']}', '{$col['fecha_ingreso']}',
                '{$col['fecha_salida']}', '{$col['id_empresa']}', '{$col['id_direccion']}',
                '{$col['id_sede']}', '{$col['id_area']}', '{$col['id_puesto']}', '{$col['id_turno_trabajo']}',
                '{$col['id_kit_bienvenida']}', '{$col['id_jefe_directo']}', '{$col['fecha_alta_imss']}',
                '{$col['id_tipo_contrato']}', '{$col['sueldo_neto']}', '{$col['sueldo_bruto']}',
                '{$col['id_tipo_pago']}', '{$col['id_banco']}', '{$col['cuenta_bancaria']}',
                '{$col['clabe_interbancaria']}', '{$col['id_estado_colaborador']}',
                '{$col['id_estatus_colaborador']}', '{$col['fecha_guardado']}',
                '{$col['fecha_actualizacion']}', '{$col['id_colaborador_creacion']}',
                '{$col['id_colaborador_ultima_actualizacion']}'
            )";
        }

        // Ejecutar consulta
        if (!$conexion->query($sql)) {
            echo "Error al sincronizar colaborador $id: " . $conexion->error . "\n";
        }
    }

    echo "Sincronización completada correctamente.";
} else {
    echo "Error al consultar la base de datos de RH.";
}

$conexion->close();
$conexion_rh->close();
?>
