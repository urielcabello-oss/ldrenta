<?php

class RolesModel {

    private $conexion;

    public function __construct($conexion) {

        $this->conexion = $conexion;
    }

    // ==========================================
    // INSERTAR
    // ==========================================

    public function insertarRol($nombrerol, $descripcion) {

        $sqlValidar = "
            SELECT idrol
            FROM roles
            WHERE nombrerol = '$nombrerol'
            LIMIT 1
        ";

        $queryValidar = $this->conexion->query($sqlValidar);

        if($queryValidar->num_rows > 0){

            return [
                'status' => false,
                'msg' => 'El rol ya existe'
            ];
        }

        $sql = "
            INSERT INTO roles(
                nombrerol,
                descripcion,
                status
            ) VALUES (
                '$nombrerol',
                '$descripcion',
                1
            )
        ";

        $query = $this->conexion->query($sql);

        if($query){

            return [
                'status' => true,
                'msg' => 'Rol registrado correctamente'
            ];
        }

        return [
            'status' => false,
            'msg' => 'Error al registrar rol'
        ];
    }

    // ==========================================
    // ACTUALIZAR
    // ==========================================

    public function actualizarRol($idrol, $nombrerol, $descripcion){

        $sql = "
            UPDATE roles
            SET
                nombrerol = '$nombrerol',
                descripcion = '$descripcion'
            WHERE idrol = '$idrol'
        ";

        $query = $this->conexion->query($sql);

        if($query){

            return [
                'status' => true,
                'msg' => 'Rol actualizado'
            ];
        }

        return [
            'status' => false,
            'msg' => 'Error al actualizar'
        ];
    }
}