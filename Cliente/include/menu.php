<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../../Servidor/helpers/permisos.php';

$avatar = $_SESSION['avatar'] ?? null;

$avatarFinal = empty($avatar)
    ? '../img/iconos/default_avatar.png'
    : 'https://ldrhsys.ldrhumanresources.com/Cliente/img/avatars/' . $avatar . '.png';
?>

<button class="menu-toggle">
    ☰
</button>

<div class="sidebar-overlay"></div>

<nav class="sidebar">

    <div class="sidebar-header">

    <div class="sidebar-logo">
        <img src="../img/Logo_LDRenta_OG.png">
    </div>
</div>

    <!-- USER -->
    <div class="sidebar-user">

        <img src="<?= $avatarFinal ?>">

        <div class="sidebar-user-info">

            <h4>
                <?php include("../include/nombre_icono.php"); ?>
            </h4>

            <span>
                <?= $_SESSION['rol'] ?? 'Usuario'; ?>
            </span>

        </div>

    </div>

    <!-- MENU -->
    <div class="sidebar-menu">

        <!-- GENERAL -->
        <div class="menu-section">

            <div class="menu-section-title">
                GENERAL
            </div>

            <ul>

                <?php if (tienePermiso('INICIO', 'r')): ?>
                    <li>
                        <a href="inicio_demos.php">
                            <i class="fas fa-home"></i>
                            Inicio
                        </a>
                    </li>
                <?php endif; ?>

            </ul>

        </div>

        <!-- OPERACIONES -->
        <div class="menu-section">

            <div class="menu-section-title">
                OPERACIONES
            </div>

            <ul>

                <?php if (tienePermiso('UNIDADES', 'r')): ?>
                    <li>
                        <a href="unidades_demo.php">
                            <i class="fas fa-truck"></i>
                            Unidades
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (tienePermiso('RENTUNID', 'r')): ?>
                    <li>
                        <a href="solicitar_unidades_demo.php">
                            <i class="fas fa-key"></i>
                            Rentar unidad
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (tienePermiso('ASIGNACIONES', 'r')): ?>
                    <li>
                        <a href="unidades_autorizadas.php">
                            <i class="fas fa-clipboard-check"></i>
                            Unidades rentadas
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (tienePermiso('DOCUMENTOS', 'r')): ?>
                    <li>
                        <a href="asignaciones_unidades_demo.php">
                            <i class="fas fa-file-alt"></i>
                            Documentación
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (tienePermiso('MENTENIMIENTO', 'r')): ?>
                    <li>
                        <a href="unidades_mantenimiento_flotilla.php">
                            <i class="fas fa-tools"></i>
                            Mantenimientos
                        </a>
                    </li>
                <?php endif; ?>

            </ul>

        </div>

        <?php if (tienePermiso('CONTRATO', 'r') || tienePermiso('CONTRATOS', 'r')): ?>
            <!-- ADMIN -->
            <div class="menu-section">

                <div class="menu-section-title">
                    JURIDICO
                </div>

                <ul>

                    <?php if (tienePermiso('CONTRATO', 'r')): ?>
                        <li>
                            <a href="comodatos.php">
                                <i class="fas fa-file-contract"></i>
                                Usuarios
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (tienePermiso('CONTRATOS', 'r')): ?>
                        <li>
                            <a href="historial_comodatos.php">
                                <i class="fas fa-user-shield"></i>
                                Roles y permisos
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        <?php endif; ?>

        <?php if (tienePermiso('USUARIOS', 'r') || tienePermiso('ROLES', 'r')): ?>
            <!-- ADMIN -->
            <div class="menu-section">

                <div class="menu-section-title">
                    ADMINISTRACIÓN
                </div>

                <ul>

                    <?php if (tienePermiso('USUARIOS', 'r')): ?>
                        <li>
                            <a href="usuarios.php">
                                <i class="fas fa-users"></i>
                                Usuarios
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (tienePermiso('ROLES', 'r')): ?>
                        <li>
                            <a href="roles.php">
                                <i class="fas fa-user-shield"></i>
                                Roles y permisos
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        <?php endif; ?>

        <!-- ADMIN -->
        <div class="menu-section">

            <div class="menu-section-title">
                Intranet
            </div>

            <ul>

                <a href="http://localhost/intranet/LDRHSystem/Cliente/interfaces/Inicio.php">
                    <i class="fas fa-building"></i>
                    <span>Intranet</span>
                </a>

            </ul>
        </div>

    </div>

</nav>