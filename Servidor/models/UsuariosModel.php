<?php

class UsuariosModel
{

    private $conexion;

    public function __construct($conexion)
    {

        $this->conexion = $conexion;
    }

    // ==========================================
    // INSERTAR
    // ==========================================

    public function insertarUsuario($id_colaborador, $idrol)
    {

        // VALIDAR SI YA EXISTE
        $sqlValidar = "
            SELECT id_usuario
            FROM usuarios
            WHERE id_colaborador = '$id_colaborador'
            LIMIT 1
        ";

        $queryValidar = $this->conexion->query($sqlValidar);

        if ($queryValidar->num_rows > 0) {

            return [
                'status' => false,
                'msg' => 'El colaborador ya tiene usuario'
            ];
        }

        // INSERTAR USUARIO
        $sqlUsuario = "
            INSERT INTO usuarios (
                id_colaborador,
                status
            ) VALUES (
                '$id_colaborador',
                1
            )
        ";

        $queryUsuario = $this->conexion->query($sqlUsuario);

        if (!$queryUsuario) {

            return [
                'status' => false,
                'msg' => 'Error al crear usuario'
            ];
        }

        $id_usuario = $this->conexion->insert_id;

        // INSERTAR ROL
        $sqlRol = "
            INSERT INTO usuario_rol (
                id_usuario,
                idrol
            ) VALUES (
                '$id_usuario',
                '$idrol'
            )
        ";

        $queryRol = $this->conexion->query($sqlRol);

        if (!$queryRol) {

            return [
                'status' => false,
                'msg' => 'Error al asignar rol'
            ];
        }

        return [
            'status' => true,
            'msg' => 'Usuario registrado correctamente'
        ];
    }

    // ==========================================
    // ACTUALIZAR
    // ==========================================

    public function actualizarUsuario($idusuario, $idrol)
    {

        $sqlExiste = "
        SELECT id
        FROM usuario_rol
        WHERE id_usuario = '$idusuario'
        LIMIT 1
    ";

        $queryExiste = $this->conexion->query($sqlExiste);

        if ($queryExiste->num_rows > 0) {

            $sql = "
            UPDATE usuario_rol
            SET idrol = '$idrol'
            WHERE id_usuario = '$idusuario'
        ";
        } else {

            $sql = "
            INSERT INTO usuario_rol(
                id_usuario,
                idrol
            ) VALUES (
                '$idusuario',
                '$idrol'
            )
        ";
        }

        $query = $this->conexion->query($sql);

        if ($query) {

            return [
                'status' => true,
                'msg' => 'Usuario actualizado'
            ];
        }

        return [
            'status' => false,
            'msg' => 'Error al actualizar'
        ];
    }
}
