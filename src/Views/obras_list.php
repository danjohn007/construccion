<?php
// This file is included by obras.php for list action
$pageTitle = 'Gestión de Obras';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> - Sistema de Construcción</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/public/assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Include sidebar -->
            <?php include '../src/Views/sidebar.php'; ?>
            
            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <div class="pt-3 pb-2 mb-3 border-bottom">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                        <h1 class="h2"><?= $pageTitle ?></h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <?php if (Auth::hasPermission('create', 'obras')): ?>
                                <a href="obras.php?action=create" class="btn btn-primary">
                                    <i class="bi bi-plus-circle"></i> Nueva Obra
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Flash messages -->
                <?php displayFlashMessages(); ?>
                
                <!-- Obras table -->
                <div class="card">
                    <div class="card-body">
                        <?php if (empty($obras)): ?>
                            <div class="text-center py-5">
                                <i class="bi bi-building fs-1 text-muted"></i>
                                <h4 class="text-muted mt-3">No hay obras registradas</h4>
                                <p class="text-muted">Comience creando su primera obra.</p>
                                <?php if (Auth::hasPermission('create', 'obras')): ?>
                                    <a href="obras.php?action=create" class="btn btn-primary">
                                        <i class="bi bi-plus-circle"></i> Crear Primera Obra
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Clave</th>
                                            <th>Nombre</th>
                                            <th>Municipio</th>
                                            <th>Estado</th>
                                            <th>Avance</th>
                                            <th>Presupuesto</th>
                                            <th>Responsable</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($obras as $obra): ?>
                                            <tr>
                                                <td><code><?= htmlspecialchars($obra['clave']) ?></code></td>
                                                <td>
                                                    <strong><?= htmlspecialchars($obra['nombre']) ?></strong><br>
                                                    <small class="text-muted"><?= htmlspecialchars($obra['direccion']) ?></small>
                                                </td>
                                                <td><?= htmlspecialchars($obra['municipio']) ?></td>
                                                <td>
                                                    <span class="badge bg-<?= getStatusBadgeClass($obra['estado']) ?>">
                                                        <?= ucfirst(str_replace('_', ' ', $obra['estado'])) ?>
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
                                                <td><?= htmlspecialchars($obra['usuario_nombre'] ?? 'Sin asignar') ?></td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="obras.php?action=view&id=<?= $obra['id'] ?>" 
                                                           class="btn btn-outline-primary" title="Ver">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <?php if (Auth::hasPermission('update', 'obras')): ?>
                                                            <a href="obras.php?action=edit&id=<?= $obra['id'] ?>" 
                                                               class="btn btn-outline-secondary" title="Editar">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                        <?php if (Auth::hasPermission('delete', 'obras')): ?>
                                                            <a href="obras.php?action=delete&id=<?= $obra['id'] ?>" 
                                                               class="btn btn-outline-danger btn-delete" title="Eliminar">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/dashboard.js"></script>
</body>
</html>