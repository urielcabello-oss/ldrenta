<?php

if (session_status() === PHP_SESSION_NONE) {

    session_start();
}

function tienePermiso($modulo, $accion)
{
    $modulo = strtoupper(trim($modulo));

    if (!isset($_SESSION['permisos'][$modulo])) {

        return false;
    }

    return $_SESSION['permisos'][$modulo][$accion] == 1;
}