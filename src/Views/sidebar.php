<?php
$user = Auth::getCurrentUser();
?>

<!-- Sidebar -->
<nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
    <div class="position-sticky pt-3">
        <div class="text-center mb-4">
            <h5 class="text-white">Sistema de Construcción</h5>
            <small class="text-white-50">Análisis de Precios y Programa de Obra</small>
        </div>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : '' ?>" href="index.php">
                    <i class="bi bi-house-door"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'obras.php') ? 'active' : '' ?>" href="obras.php">
                    <i class="bi bi-building"></i> Obras
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'conceptos.php') ? 'active' : '' ?>" href="conceptos.php">
                    <i class="bi bi-list-task"></i> Conceptos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'precios_unitarios.php') ? 'active' : '' ?>" href="precios_unitarios.php">
                    <i class="bi bi-calculator"></i> Precios Unitarios
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'materiales.php') ? 'active' : '' ?>" href="materiales.php">
                    <i class="bi bi-boxes"></i> Materiales
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'mano_obra.php') ? 'active' : '' ?>" href="mano_obra.php">
                    <i class="bi bi-people"></i> Mano de Obra
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'avance.php') ? 'active' : '' ?>" href="avance.php">
                    <i class="bi bi-graph-up"></i> Avance de Obra
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'programa.php') ? 'active' : '' ?>" href="programa.php">
                    <i class="bi bi-calendar-event"></i> Programa de Obra
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'reportes.php') ? 'active' : '' ?>" href="reportes.php">
                    <i class="bi bi-file-earmark-text"></i> Reportes
                </a>
            </li>
            
            <?php if (Auth::hasPermission('read', 'usuarios')): ?>
            <li class="nav-item">
                <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'usuarios.php') ? 'active' : '' ?>" href="usuarios.php">
                    <i class="bi bi-person-gear"></i> Usuarios
                </a>
            </li>
            <?php endif; ?>
        </ul>
        
        <hr class="text-white-50">
        
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" 
               data-bs-toggle="dropdown">
                <i class="bi bi-person-circle me-2"></i>
                <span><?= htmlspecialchars($user['name']) ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="perfil.php">Mi Perfil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </div>
    </div>
</nav>