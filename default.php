<?php

include("./Servidor/conexion.php");

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// ============================================
// VALIDAR PARÁMETRO
// ============================================

if (!isset($_GET['idcolaborador'])) {

    die("Parámetros inválidos");
}

$idcolaborador = base64_decode($_GET['idcolaborador']);

if (!$idcolaborador) {

    die("Colaborador inválido");
}

// ============================================
// OBTENER USUARIO + ROL
// ============================================

$queryUsuario = "
    SELECT

        u.id_usuario,
        u.correo,
        u.avatar,

        r.idrol,
        r.nombrerol

    FROM usuarios u

    LEFT JOIN usuario_rol ur
        ON ur.id_usuario = u.id_usuario

    LEFT JOIN roles r
        ON r.idrol = ur.idrol

    WHERE u.id_colaborador = '$idcolaborador'

    AND u.status = 1
    LIMIT 1
";

$resultUsuario = $conectar->query($queryUsuario);

if (!$resultUsuario || mysqli_num_rows($resultUsuario) == 0) {

    die("Sin acceso a la plataforma");
}

$usuario = mysqli_fetch_assoc($resultUsuario);

// ============================================
// OBTENER PERMISOS
// ============================================

$queryPermisos = "
    SELECT

        m.idmodulo,
        m.titulo,
        m.identificador,

        p.r,
        p.w,
        p.u,
        p.d

    FROM permisos p

    INNER JOIN modulo m
        ON m.idmodulo = p.moduloid

    WHERE p.rolid = '{$usuario['idrol']}'
    AND m.status = 1
";

$resultPermisos = $conectar->query($queryPermisos);

$permisos = [];

if ($resultPermisos) {

    while ($permiso = mysqli_fetch_assoc($resultPermisos)) {

        $modulo = trim($permiso['identificador']);

        $permisos[$modulo] = [

            'idmodulo' => $permiso['idmodulo'],
            'titulo' => $permiso['titulo'],

            'r' => intval($permiso['r']),
            'w' => intval($permiso['w']),
            'u' => intval($permiso['u']),
            'd' => intval($permiso['d'])
        ];
    }
}

// ============================================
// SESIONES
// ============================================

$_SESSION['id_colaborador'] = $idcolaborador;

$_SESSION['id_usuario'] = $usuario['id_usuario'];

$_SESSION['correo'] = $usuario['correo'];

$_SESSION['avatar'] = $usuario['avatar'];

$_SESSION['idrol'] = $usuario['idrol'];

$_SESSION['rol'] = $usuario['nombrerol'];

$_SESSION['permisos'] = $permisos;

// ============================================
// REDIRECCIÓN
// ============================================

header("Location: ./Cliente/interfaces/inicio_demos.php");
exit;
