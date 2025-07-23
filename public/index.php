<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema de Construcción</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php
    require_once '../config/database.php';
    require_once '../src/Helpers/auth.php';
    require_once '../src/Helpers/functions.php';
    require_once '../src/Models/Obra.php';
    
    // Require authentication
    Auth::requireLogin();
    
    $user = Auth::getCurrentUser();
    $obraModel = new Obra();
    $dashboardData = $obraModel->getDashboardData();
    $recentObras = $obraModel->all(5); // Get 5 most recent obras
    ?>
    
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h5 class="text-white">Sistema de Construcción</h5>
                        <small class="text-white-50">Análisis de Precios y Programa de Obra</small>
                    </div>
                    
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php">
                                <i class="bi bi-house-door"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="obras.php">
                                <i class="bi bi-building"></i> Obras
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="conceptos.php">
                                <i class="bi bi-list-task"></i> Conceptos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="precios_unitarios.php">
                                <i class="bi bi-calculator"></i> Precios Unitarios
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="materiales.php">
                                <i class="bi bi-boxes"></i> Materiales
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="mano_obra.php">
                                <i class="bi bi-people"></i> Mano de Obra
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="avance.php">
                                <i class="bi bi-graph-up"></i> Avance de Obra
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="programa.php">
                                <i class="bi bi-calendar-event"></i> Programa de Obra
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="reportes.php">
                                <i class="bi bi-file-earmark-text"></i> Reportes
                            </a>
                        </li>
                        
                        <?php if (Auth::hasPermission('read', 'usuarios')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="usuarios.php">
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
            
            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <div class="pt-3 pb-2 mb-3 border-bottom">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                        <h1 class="h2">Dashboard</h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group me-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-download"></i> Exportar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Flash messages -->
                <?php displayFlashMessages(); ?>
                
                <!-- KPI Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card kpi-card info">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="card-text text-muted mb-1">Total Obras</p>
                                        <h3 class="mb-0"><?= $dashboardData['total_obras'] ?? 0 ?></h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-building fs-2 text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <div class="card kpi-card success">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="card-text text-muted mb-1">Obras Activas</p>
                                        <h3 class="mb-0"><?= $dashboardData['obras_activas'] ?? 0 ?></h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-play-circle fs-2 text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <div class="card kpi-card warning">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="card-text text-muted mb-1">Presupuesto Total</p>
                                        <h3 class="mb-0 text-currency"><?= formatCurrency($dashboardData['presupuesto_total'] ?? 0) ?></h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-currency-dollar fs-2 text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <div class="card kpi-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="card-text text-muted mb-1">Avance Promedio</p>
                                        <h3 class="mb-0"><?= formatPercentage($dashboardData['avance_promedio'] ?? 0) ?></h3>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-graph-up fs-2 text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Works -->
                <div class="row mb-4">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Obras Recientes</h5>
                            </div>
                            <div class="card-body">
                                <?php if (empty($recentObras)): ?>
                                    <p class="text-muted text-center">No hay obras registradas</p>
                                    <div class="text-center">
                                        <a href="obras.php?action=create" class="btn btn-primary">
                                            <i class="bi bi-plus-circle"></i> Crear Primera Obra
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Obra</th>
                                                    <th>Estado</th>
                                                    <th>Avance</th>
                                                    <th>Presupuesto</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($recentObras as $obra): ?>
                                                    <tr>
                                                        <td>
                                                            <strong><?= htmlspecialchars($obra['nombre']) ?></strong><br>
                                                            <small class="text-muted"><?= htmlspecialchars($obra['clave']) ?></small>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-<?= getStatusBadgeClass($obra['estado']) ?>">
                                                                <?= ucfirst($obra['estado']) ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="progress" style="height: 20px;">
                                                                <div class="progress-bar" role="progressbar" 
                                                                     style="width: <?= $obra['avance_fisico'] ?>%">
                                                                    <?= formatPercentage($obra['avance_fisico']) ?>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-currency"><?= formatCurrency($obra['presupuesto_total']) ?></td>
                                                        <td>
                                                            <a href="obras.php?action=view&id=<?= $obra['id'] ?>" 
                                                               class="btn btn-sm btn-outline-primary">Ver</a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-center mt-3">
                                        <a href="obras.php" class="btn btn-outline-primary">Ver Todas las Obras</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Acceso Rápido</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <?php if (Auth::hasPermission('create', 'obras')): ?>
                                        <a href="obras.php?action=create" class="btn btn-primary">
                                            <i class="bi bi-plus-circle"></i> Nueva Obra
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if (Auth::hasPermission('create', 'conceptos')): ?>
                                        <a href="conceptos.php?action=create" class="btn btn-outline-primary">
                                            <i class="bi bi-plus-circle"></i> Nuevo Concepto
                                        </a>
                                    <?php endif; ?>
                                    
                                    <a href="reportes.php" class="btn btn-outline-secondary">
                                        <i class="bi bi-file-earmark-text"></i> Generar Reporte
                                    </a>
                                    
                                    <a href="avance.php" class="btn btn-outline-info">
                                        <i class="bi bi-graph-up"></i> Registrar Avance
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card mt-3">
                            <div class="card-header">
                                <h6 class="mb-0">Información del Usuario</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-1"><strong>Nombre:</strong> <?= htmlspecialchars($user['name']) ?></p>
                                <p class="mb-1"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                                <p class="mb-0"><strong>Rol:</strong> 
                                    <span class="badge bg-secondary"><?= ucfirst($user['role']) ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer -->
                <footer class="footer mt-auto py-3">
                    <div class="container-fluid">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Sistema de Análisis de Precios y Programa de Obra © 2024</span>
                            <span class="text-muted">Versión 1.0</span>
                        </div>
                    </div>
                </footer>
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/dashboard.js"></script>
</body>
</html>