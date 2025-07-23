<?php
$pageTitle = isset($obra) ? 'Editar Obra' : 'Nueva Obra';
$isEditing = isset($obra);
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
                        <h1 class="h2"><?= $pageTitle ?></h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <a href="obras.php" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Flash messages -->
                <?php displayFlashMessages(); ?>
                
                <!-- Form errors -->
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <!-- Obra form -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><?= $pageTitle ?></h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" class="needs-validation" novalidate>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="nombre" class="form-label">Nombre de la Obra *</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" 
                                                   value="<?= htmlspecialchars($obra['nombre'] ?? $_POST['nombre'] ?? '') ?>" 
                                                   required>
                                            <div class="invalid-feedback">
                                                El nombre de la obra es requerido.
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="clave" class="form-label">Clave *</label>
                                            <input type="text" class="form-control" id="clave" name="clave" 
                                                   value="<?= htmlspecialchars($obra['clave'] ?? $_POST['clave'] ?? '') ?>" 
                                                   required>
                                            <div class="invalid-feedback">
                                                La clave de la obra es requerida.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="direccion" class="form-label">Dirección</label>
                                        <textarea class="form-control" id="direccion" name="direccion" rows="2"><?= htmlspecialchars($obra['direccion'] ?? $_POST['direccion'] ?? '') ?></textarea>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="municipio" class="form-label">Municipio</label>
                                            <input type="text" class="form-control" id="municipio" name="municipio" 
                                                   value="<?= htmlspecialchars($obra['municipio'] ?? $_POST['municipio'] ?? '') ?>">
                                        </div>
                                        
                                        <?php if ($isEditing): ?>
                                        <div class="col-md-6 mb-3">
                                            <label for="estado" class="form-label">Estado</label>
                                            <select class="form-select" id="estado" name="estado">
                                                <option value="planeacion" <?= ($obra['estado'] ?? '') == 'planeacion' ? 'selected' : '' ?>>Planeación</option>
                                                <option value="en_proceso" <?= ($obra['estado'] ?? '') == 'en_proceso' ? 'selected' : '' ?>>En Proceso</option>
                                                <option value="terminada" <?= ($obra['estado'] ?? '') == 'terminada' ? 'selected' : '' ?>>Terminada</option>
                                                <option value="cancelada" <?= ($obra['estado'] ?? '') == 'cancelada' ? 'selected' : '' ?>>Cancelada</option>
                                            </select>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" 
                                                   value="<?= $obra['fecha_inicio'] ?? $_POST['fecha_inicio'] ?? '' ?>">
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label for="fecha_termino" class="form-label">Fecha de Término</label>
                                            <input type="date" class="form-control" id="fecha_termino" name="fecha_termino" 
                                                   value="<?= $obra['fecha_termino'] ?? $_POST['fecha_termino'] ?? '' ?>">
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label for="presupuesto_total" class="form-label">Presupuesto Total</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" step="0.01" class="form-control currency-input" 
                                                       id="presupuesto_total" name="presupuesto_total" 
                                                       value="<?= $obra['presupuesto_total'] ?? $_POST['presupuesto_total'] ?? '0' ?>">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between">
                                        <a href="obras.php" class="btn btn-secondary">Cancelar</a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-circle"></i>
                                            <?= $isEditing ? 'Actualizar' : 'Crear' ?> Obra
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Ayuda</h6>
                            </div>
                            <div class="card-body">
                                <p class="small text-muted">
                                    <strong>Campos requeridos:</strong> Los campos marcados con * son obligatorios.
                                </p>
                                <p class="small text-muted">
                                    <strong>Clave:</strong> Identificador único de la obra (ej: OBRA-001).
                                </p>
                                <p class="small text-muted">
                                    <strong>Presupuesto:</strong> Monto estimado total de la obra.
                                </p>
                                <?php if ($isEditing): ?>
                                <p class="small text-muted">
                                    <strong>Estado:</strong> Cambie el estado según el progreso de la obra.
                                </p>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <?php if ($isEditing): ?>
                        <div class="card mt-3">
                            <div class="card-header">
                                <h6 class="mb-0">Estadísticas</h6>
                            </div>
                            <div class="card-body">
                                <p class="small mb-1">
                                    <strong>Creada:</strong> <?= formatDate($obra['fecha_creacion']) ?>
                                </p>
                                <p class="small mb-1">
                                    <strong>Última actualización:</strong> <?= formatDate($obra['fecha_actualizacion']) ?>
                                </p>
                                <p class="small mb-0">
                                    <strong>ID:</strong> <?= $obra['id'] ?>
                                </p>
                            </div>
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