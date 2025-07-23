<?php
$pageTitle = 'Detalle de Obra';
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
            <?php include 'sidebar.php'; ?>
            
            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <div class="pt-3 pb-2 mb-3 border-bottom">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                        <h1 class="h2"><?= htmlspecialchars($obra['nombre']) ?></h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group me-2">
                                <?php if (Auth::hasPermission('update', 'obras')): ?>
                                    <a href="obras.php?action=edit&id=<?= $obra['id'] ?>" class="btn btn-primary">
                                        <i class="bi bi-pencil"></i> Editar
                                    </a>
                                <?php endif; ?>
                                <a href="obras.php" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> Volver
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Flash messages -->
                <?php displayFlashMessages(); ?>
                
                <!-- Obra details -->
                <div class="row mb-4">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Información General</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Clave:</strong> <code><?= htmlspecialchars($obra['clave']) ?></code></p>
                                        <p><strong>Nombre:</strong> <?= htmlspecialchars($obra['nombre']) ?></p>
                                        <p><strong>Dirección:</strong> <?= htmlspecialchars($obra['direccion'] ?: 'No especificada') ?></p>
                                        <p><strong>Municipio:</strong> <?= htmlspecialchars($obra['municipio'] ?: 'No especificado') ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Estado:</strong> 
                                            <span class="badge bg-<?= getStatusBadgeClass($obra['estado']) ?>">
                                                <?= ucfirst(str_replace('_', ' ', $obra['estado'])) ?>
                                            </span>
                                        </p>
                                        <p><strong>Fecha de Inicio:</strong> <?= formatDate($obra['fecha_inicio']) ?></p>
                                        <p><strong>Fecha de Término:</strong> <?= formatDate($obra['fecha_termino']) ?></p>
                                        <p><strong>Responsable:</strong> <?= htmlspecialchars($obra['usuario_nombre'] ?: 'Sin asignar') ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Progress and financial info -->
                        <div class="card mt-3">
                            <div class="card-header">
                                <h5 class="mb-0">Avance y Finanzas</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Avance Físico</h6>
                                        <div class="progress mb-3" style="height: 25px;">
                                            <div class="progress-bar" role="progressbar" 
                                                 style="width: <?= $obra['avance_fisico'] ?>%">
                                                <?= formatPercentage($obra['avance_fisico']) ?>
                                            </div>
                                        </div>
                                        
                                        <h6>Avance Financiero</h6>
                                        <div class="progress mb-3" style="height: 25px;">
                                            <div class="progress-bar bg-success" role="progressbar" 
                                                 style="width: <?= $obra['avance_financiero'] ?>%">
                                                <?= formatPercentage($obra['avance_financiero']) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Presupuesto Total:</strong> 
                                            <span class="text-currency fs-5"><?= formatCurrency($obra['presupuesto_total']) ?></span>
                                        </p>
                                        <p><strong>Presupuesto Calculado:</strong> 
                                            <span class="text-currency"><?= formatCurrency($obra['presupuesto_calculado'] ?? 0) ?></span>
                                        </p>
                                        <p><strong>Costo Real:</strong> 
                                            <span class="text-currency"><?= formatCurrency($obra['costo_real_total'] ?? 0) ?></span>
                                        </p>
                                        <p><strong>Diferencia:</strong> 
                                            <?php 
                                            $diferencia = ($obra['presupuesto_calculado'] ?? 0) - ($obra['costo_real_total'] ?? 0);
                                            $textClass = $diferencia >= 0 ? 'text-success' : 'text-danger';
                                            ?>
                                            <span class="text-currency <?= $textClass ?>"><?= formatCurrency($diferencia) ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <!-- Quick stats -->
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Resumen</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Total Conceptos:</span>
                                    <strong><?= $obra['total_conceptos'] ?? 0 ?></strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Avance Promedio:</span>
                                    <strong><?= formatPercentage($obra['avance_promedio'] ?? 0) ?></strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Creada:</span>
                                    <strong><?= formatDate($obra['fecha_creacion']) ?></strong>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Actualizada:</span>
                                    <strong><?= formatDate($obra['fecha_actualizacion']) ?></strong>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Quick actions -->
                        <div class="card mt-3">
                            <div class="card-header">
                                <h6 class="mb-0">Acciones Rápidas</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="conceptos.php?obra_id=<?= $obra['id'] ?>" class="btn btn-outline-primary">
                                        <i class="bi bi-list-task"></i> Ver Conceptos
                                    </a>
                                    <a href="programa.php?obra_id=<?= $obra['id'] ?>" class="btn btn-outline-info">
                                        <i class="bi bi-calendar-event"></i> Programa de Obra
                                    </a>
                                    <a href="avance.php?obra_id=<?= $obra['id'] ?>" class="btn btn-outline-success">
                                        <i class="bi bi-graph-up"></i> Registrar Avance
                                    </a>
                                    <a href="reportes.php?obra_id=<?= $obra['id'] ?>" class="btn btn-outline-secondary">
                                        <i class="bi bi-file-earmark-pdf"></i> Generar Reporte
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/public/assets/js/dashboard.js"></script>
</body>
</html>