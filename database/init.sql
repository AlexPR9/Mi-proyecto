-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS examen CHARACTER SET utf8 COLLATE utf8_general_ci;
USE examen;

-- Crear tabla de categorías
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear tabla de productos
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    categoria_id INT,
    stock INT DEFAULT 0, -- Añadida la columna stock con valor por defecto 0
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE CASCADE
);

-- Insertar datos de prueba en categorias
INSERT INTO categorias (nombre, descripcion) VALUES
('Electrónica', 'Productos electrónicos como teléfonos y laptops'),
('Ropa', 'Prendas de vestir para todas las edades');

-- Insertar datos de prueba en productos
INSERT INTO productos (nombre, descripcion, precio, categoria_id, stock) VALUES
('Teléfono móvil', 'Smartphone de última generación', 350.00, 1, 10), 
('Laptop', 'Portátil con procesador Intel', 800.00, 1, 5),  
('Camiseta', 'Camiseta de algodón para hombre', 15.00, 2, 20); 