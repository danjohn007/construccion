-- Construction Management System Database Schema
-- Created: 2024

-- Create database
CREATE DATABASE IF NOT EXISTS construccion_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE construccion_db;

-- Users table
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'analista', 'visitante') DEFAULT 'visitante',
    activo BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Projects table
CREATE TABLE obras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(200) NOT NULL,
    clave VARCHAR(50) UNIQUE NOT NULL,
    direccion TEXT,
    municipio VARCHAR(100),
    fecha_inicio DATE,
    fecha_termino DATE,
    presupuesto_total DECIMAL(15,2) DEFAULT 0,
    avance_fisico DECIMAL(5,2) DEFAULT 0,
    avance_financiero DECIMAL(5,2) DEFAULT 0,
    estado ENUM('planeacion', 'en_proceso', 'terminada', 'cancelada') DEFAULT 'planeacion',
    usuario_id INT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Suppliers table
CREATE TABLE proveedores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    contacto VARCHAR(100),
    telefono VARCHAR(20),
    email VARCHAR(100),
    direccion TEXT,
    activo BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Materials table
CREATE TABLE materiales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    unidad VARCHAR(20) NOT NULL,
    precio_unitario DECIMAL(10,4) NOT NULL,
    proveedor_id INT,
    categoria VARCHAR(50),
    activo BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (proveedor_id) REFERENCES proveedores(id)
);

-- Work concepts table
CREATE TABLE conceptos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    obra_id INT NOT NULL,
    clave VARCHAR(50) NOT NULL,
    descripcion TEXT NOT NULL,
    unidad VARCHAR(20) NOT NULL,
    cantidad DECIMAL(12,4) DEFAULT 0,
    precio_unitario DECIMAL(12,4) DEFAULT 0,
    importe DECIMAL(15,2) GENERATED ALWAYS AS (cantidad * precio_unitario) STORED,
    costo_real DECIMAL(15,2) DEFAULT 0,
    diferencia DECIMAL(15,2) GENERATED ALWAYS AS (importe - costo_real) STORED,
    etapa VARCHAR(50),
    avance_fisico DECIMAL(5,2) DEFAULT 0,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (obra_id) REFERENCES obras(id) ON DELETE CASCADE,
    UNIQUE KEY unique_concepto_obra (obra_id, clave)
);

-- Volumes table
CREATE TABLE volumenes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    concepto_id INT NOT NULL,
    descripcion VARCHAR(200),
    cantidad DECIMAL(12,4) NOT NULL,
    unidad VARCHAR(20) NOT NULL,
    observaciones TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (concepto_id) REFERENCES conceptos(id) ON DELETE CASCADE
);

-- Unit prices table
CREATE TABLE precios_unitarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    concepto_id INT NOT NULL,
    tipo ENUM('material', 'mano_obra', 'herramienta', 'indirecto') NOT NULL,
    item_id INT,
    descripcion VARCHAR(200) NOT NULL,
    unidad VARCHAR(20) NOT NULL,
    cantidad DECIMAL(12,6) NOT NULL,
    precio_unitario DECIMAL(12,4) NOT NULL,
    importe DECIMAL(15,2) GENERATED ALWAYS AS (cantidad * precio_unitario) STORED,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (concepto_id) REFERENCES conceptos(id) ON DELETE CASCADE
);

-- Labor table
CREATE TABLE mano_obra (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    salario_diario DECIMAL(10,2) NOT NULL,
    factor_salario_real DECIMAL(6,4) DEFAULT 1.0000,
    costo_hora DECIMAL(10,4) GENERATED ALWAYS AS (salario_diario * factor_salario_real / 8) STORED,
    activo BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Work progress table
CREATE TABLE avance_obra (
    id INT AUTO_INCREMENT PRIMARY KEY,
    concepto_id INT NOT NULL,
    fecha DATE NOT NULL,
    cantidad_ejecutada DECIMAL(12,4) NOT NULL,
    porcentaje_avance DECIMAL(5,2) NOT NULL,
    importe_ejecutado DECIMAL(15,2) NOT NULL,
    observaciones TEXT,
    usuario_id INT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (concepto_id) REFERENCES conceptos(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    UNIQUE KEY unique_concepto_fecha (concepto_id, fecha)
);

-- Work schedule table
CREATE TABLE programa_obra (
    id INT AUTO_INCREMENT PRIMARY KEY,
    concepto_id INT NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    duracion_dias INT GENERATED ALWAYS AS (DATEDIFF(fecha_fin, fecha_inicio) + 1) STORED,
    secuencia INT DEFAULT 1,
    dependencia_id INT NULL,
    estado ENUM('programado', 'en_proceso', 'terminado', 'retrasado') DEFAULT 'programado',
    observaciones TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (concepto_id) REFERENCES conceptos(id) ON DELETE CASCADE,
    FOREIGN KEY (dependencia_id) REFERENCES programa_obra(id)
);

-- Reports table
CREATE TABLE reportes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    obra_id INT NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    nombre VARCHAR(200) NOT NULL,
    archivo VARCHAR(255) NOT NULL,
    parametros JSON,
    usuario_id INT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (obra_id) REFERENCES obras(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Create indexes for better performance
CREATE INDEX idx_obras_estado ON obras(estado);
CREATE INDEX idx_conceptos_obra ON conceptos(obra_id);
CREATE INDEX idx_conceptos_etapa ON conceptos(etapa);
CREATE INDEX idx_precios_concepto ON precios_unitarios(concepto_id);
CREATE INDEX idx_precios_tipo ON precios_unitarios(tipo);
CREATE INDEX idx_avance_concepto ON avance_obra(concepto_id);
CREATE INDEX idx_avance_fecha ON avance_obra(fecha);
CREATE INDEX idx_programa_concepto ON programa_obra(concepto_id);
CREATE INDEX idx_programa_fechas ON programa_obra(fecha_inicio, fecha_fin);