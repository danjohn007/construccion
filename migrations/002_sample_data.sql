-- Sample Data for Testing
-- Insert after creating tables

-- Insert sample users
INSERT INTO usuarios (nombre, email, password, rol) VALUES
('Administrador', 'admin@construccion.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'), -- password: password
('Juan Analista', 'analista@construccion.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'analista'),
('Visitante Demo', 'visitante@construccion.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'visitante');

-- Insert sample suppliers
INSERT INTO proveedores (nombre, contacto, telefono, email) VALUES
('CEMEX México', 'Carlos Rodríguez', '555-0101', 'ventas@cemex.com'),
('Aceros del Norte', 'María González', '555-0102', 'ventas@aceronorte.com'),
('Maderas del Sur', 'José Martínez', '555-0103', 'info@maderassur.com'),
('Herramientas y Equipos SA', 'Ana López', '555-0104', 'ventas@herramientas.com');

-- Insert sample materials
INSERT INTO materiales (nombre, unidad, precio_unitario, proveedor_id, categoria) VALUES
('Cemento Portland CPC 30R', 'ton', 2800.00, 1, 'Cemento'),
('Arena de río', 'm3', 350.00, 1, 'Agregados'),
('Grava 3/4"', 'm3', 380.00, 1, 'Agregados'),
('Varilla #3 (3/8")', 'ton', 18500.00, 2, 'Acero'),
('Varilla #4 (1/2")', 'ton', 18300.00, 2, 'Acero'),
('Alambrón #2', 'kg', 22.50, 2, 'Acero'),
('Tabique rojo común', 'millar', 4200.00, NULL, 'Mampostería'),
('Madera de pino 2"x4"x3m', 'pza', 185.00, 3, 'Madera'),
('Clavos 2.5"', 'kg', 28.00, 4, 'Ferretería'),
('Alambre recocido', 'kg', 24.50, 4, 'Ferretería');

-- Insert sample labor categories
INSERT INTO mano_obra (nombre, categoria, salario_diario, factor_salario_real) VALUES
('Peón', 'Auxiliar', 280.00, 1.5400),
('Oficial albañil', 'Especializado', 420.00, 1.5400),
('Fierrero', 'Especializado', 450.00, 1.5400),
('Operador de máquina', 'Especializado', 480.00, 1.5400),
('Cabo', 'Supervisor', 520.00, 1.5400),
('Maestro albañil', 'Maestro', 600.00, 1.5400);

-- Insert sample project
INSERT INTO obras (nombre, clave, direccion, municipio, fecha_inicio, fecha_termino, presupuesto_total, usuario_id) VALUES
('Casa Habitación Tipo Medio', 'OBRA-001', 'Av. Revolución #123, Col. Centro', 'Guadalajara, Jalisco', '2024-01-15', '2024-06-15', 850000.00, 1);

-- Insert sample concepts for the project
INSERT INTO conceptos (obra_id, clave, descripcion, unidad, cantidad, precio_unitario, etapa) VALUES
(1, 'C-001', 'Excavación para cimentación', 'm3', 45.00, 120.00, 'Cimentación'),
(1, 'C-002', 'Concreto para zapatas f\'c=200 kg/cm2', 'm3', 12.50, 2850.00, 'Cimentación'),
(1, 'C-003', 'Acero de refuerzo fy=4200 kg/cm2', 'ton', 1.80, 28500.00, 'Cimentación'),
(1, 'C-004', 'Muro de tabique rojo común', 'm2', 180.00, 285.00, 'Estructura'),
(1, 'C-005', 'Losa de concreto armado e=12cm', 'm2', 120.00, 620.00, 'Estructura'),
(1, 'C-006', 'Repello y afinado de muros', 'm2', 360.00, 95.00, 'Acabados'),
(1, 'C-007', 'Pintura vinílica en muros', 'm2', 360.00, 45.00, 'Acabados');

-- Insert sample volumes
INSERT INTO volumenes (concepto_id, descripcion, cantidad, unidad) VALUES
(1, 'Excavación manual para zapatas', 45.00, 'm3'),
(2, 'Concreto premezclado f\'c=200', 12.50, 'm3'),
(3, 'Varilla #3 y #4 para refuerzo', 1.80, 'ton');

-- Insert sample unit prices (materials for concrete concept)
INSERT INTO precios_unitarios (concepto_id, tipo, descripcion, unidad, cantidad, precio_unitario) VALUES
(2, 'material', 'Cemento Portland CPC 30R', 'ton', 0.350, 2800.00),
(2, 'material', 'Arena de río', 'm3', 0.520, 350.00),
(2, 'material', 'Grava 3/4"', 'm3', 0.760, 380.00),
(2, 'mano_obra', 'Oficial albañil', 'jor', 0.180, 646.80),
(2, 'mano_obra', 'Peón', 'jor', 0.360, 431.20),
(2, 'herramienta', 'Herramienta menor', '%', 0.030, 950.00);

-- Insert sample work progress
INSERT INTO avance_obra (concepto_id, fecha, cantidad_ejecutada, porcentaje_avance, importe_ejecutado, usuario_id) VALUES
(1, '2024-01-20', 45.00, 100.00, 5400.00, 1),
(2, '2024-01-25', 6.25, 50.00, 17812.50, 1),
(3, '2024-01-30', 0.90, 50.00, 25650.00, 1),
(4, '2024-02-05', 90.00, 50.00, 25650.00, 1);

-- Insert sample work schedule
INSERT INTO programa_obra (concepto_id, fecha_inicio, fecha_fin, secuencia, estado) VALUES
(1, '2024-01-15', '2024-01-20', 1, 'terminado'),
(2, '2024-01-21', '2024-01-30', 2, 'en_proceso'),
(3, '2024-01-25', '2024-02-05', 3, 'en_proceso'),
(4, '2024-02-01', '2024-02-20', 4, 'programado'),
(5, '2024-02-15', '2024-03-10', 5, 'programado'),
(6, '2024-03-01', '2024-03-20', 6, 'programado'),
(7, '2024-03-15', '2024-03-30', 7, 'programado');