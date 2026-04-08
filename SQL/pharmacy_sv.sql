-- Base de datos Farmacia SV
CREATE DATABASE IF NOT EXISTS pharmacy_sv;
USE pharmacy_sv;

-- Tabla de usuarios del sistema (login + roles)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    rol ENUM('usuario', 'admin') DEFAULT 'usuario',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla principal del CRUD
CREATE TABLE IF NOT EXISTS registros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    correo VARCHAR(150) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Usuario admin de prueba (contraseña: admin123)
INSERT INTO usuarios (nombre_usuario, contrasena, rol) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Registros de ejemplo
INSERT INTO registros (nombre, apellido, correo, telefono) VALUES
('María', 'González', 'maria@correo.com', '7777-1234'),
('Carlos', 'Martínez', 'carlos@correo.com', '7888-5678'),
('Ana', 'López', 'ana@correo.com', '7999-9012');
