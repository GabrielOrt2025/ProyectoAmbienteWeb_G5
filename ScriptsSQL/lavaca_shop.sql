-- ============================================
-- BASE DE DATOS: LA VACA E-COMMERCE
-- Estructura básica siguiendo el enfoque de las clases
-- ============================================

-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS lavaca_shop;
USE lavaca_shop;

-- ============================================
-- TABLA: usuarios
-- ============================================
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    rol VARCHAR(20) DEFAULT 'cliente'
);

-- ============================================
-- TABLA: categorias
-- ============================================
CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    imagen VARCHAR(255)
);

-- ============================================
-- TABLA: productos
-- ============================================
CREATE TABLE productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(200) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    precio_descuento DECIMAL(10, 2),
    id_categoria INT,
    stock INT DEFAULT 0,
    imagen VARCHAR(255),
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
);

-- ============================================
-- TABLA: carrito
-- ============================================
CREATE TABLE carrito (
    id_carrito INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_producto INT,
    cantidad INT DEFAULT 1,
    precio_unitario DECIMAL(10, 2),
    fecha_agregado DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);

-- ============================================
-- TABLA: direcciones
-- ============================================
CREATE TABLE direcciones (
    id_direccion INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    calle VARCHAR(200) NOT NULL,
    ciudad VARCHAR(100) NOT NULL,
    codigo_postal VARCHAR(20) NOT NULL,
    pais VARCHAR(100) DEFAULT 'España',
    telefono VARCHAR(20),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

-- ============================================
-- TABLA: pedidos
-- ============================================
CREATE TABLE pedidos (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    numero_pedido VARCHAR(50) NOT NULL,
    id_usuario INT,
    id_direccion INT,
    subtotal DECIMAL(10, 2) NOT NULL,
    descuento DECIMAL(10, 2) DEFAULT 0,
    costo_envio DECIMAL(10, 2) DEFAULT 0,
    total DECIMAL(10, 2) NOT NULL,
    metodo_pago VARCHAR(50),
    estado VARCHAR(50) DEFAULT 'pendiente',
    fecha_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_direccion) REFERENCES direcciones(id_direccion)
);

-- ============================================
-- TABLA: detalle_pedido
-- ============================================
CREATE TABLE detalle_pedido (
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT,
    id_producto INT,
    nombre_producto VARCHAR(200),
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);

-- ============================================
-- TABLA: codigos_descuento
-- ============================================
CREATE TABLE codigos_descuento (
    id_codigo INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(50) NOT NULL UNIQUE,
    descuento DECIMAL(10, 2) NOT NULL,
    fecha_expiracion DATE,
    activo VARCHAR(10) DEFAULT 'si'
);

-- ============================================
-- INSERTAR DATOS DE EJEMPLO
-- ============================================

-- Insertar categorías
INSERT INTO categorias (nombre, descripcion) VALUES
('Clothes', 'Ropa de temporada'),
('Shoes', 'Calzado'),
('Bags', 'Bolsos y mochilas'),
('Accessories', 'Accesorios');

-- Insertar productos
INSERT INTO productos (nombre, descripcion, precio, id_categoria, stock, imagen) VALUES
('Leather Belt', 'Cinturón de cuero genuino', 95.00, 4, 50, 'img/imagen.png'),
('Smartphone Case', 'Funda protectora', 55.00, 4, 100, 'img/imagen1.png'),
('Leather Gloves', 'Guantes de cuero', 120.00, 4, 30, 'img/imagen2.png'),
('Black Duffel', 'Bolsa deportiva', 420.00, 3, 20, 'img/imagen3.png'),
('Chaqueta de cuero napa', 'Chaqueta de cuero', 20.00, 1, 15, 'img/imagen.png'),
('Cardigan roja', 'Cardigan de lana', 30.00, 1, 40, 'img/imagen1.png'),
('Velcro black pants', 'Pantalones negros', 25.00, 1, 60, 'img/imagen2.png'),
('Pantalon de lana', 'Pantalón cómodo', 15.00, 1, 80, 'img/imagen3.png'),
('Cotton T-shirt', 'Camiseta de algodón', 44.00, 1, 100, 'img/shirt.png');

-- Insertar códigos de descuento
INSERT INTO codigos_descuento (codigo, descuento, fecha_expiracion) VALUES
('SAVE10', 10.00, '2025-12-31'),
('SAVE20', 20.00, '2025-12-31'),
('WELCOME15', 15.00, '2025-12-31');

-- Insertar usuario administrador
-- Contraseña: admin123
INSERT INTO usuarios (nombre, apellido, email, password, telefono, rol) VALUES
('Admin', 'Sistema', 'admin@lavaca.com', 'admin123', '+506 8888-8888', 'admin');

-- Insertar usuario cliente de ejemplo
INSERT INTO usuarios (nombre, apellido, email, password, telefono, rol) VALUES
('Eduard', 'Franz', 'eduard@gmail.com', 'pass123', '+380 555-0115', 'cliente');

-- ============================================
-- CONSULTAS ÚTILES PARA EL PROYECTO
-- ============================================

-- Obtener todos los productos con su categoría
-- SELECT p.*, c.nombre AS categoria 
-- FROM productos p 
-- LEFT JOIN categorias c ON p.id_categoria = c.id_categoria;

-- Obtener productos de una categoría específica
-- SELECT * FROM productos WHERE id_categoria = 1;

-- Obtener el carrito de un usuario
-- SELECT c.*, p.nombre, p.imagen 
-- FROM carrito c 
-- JOIN productos p ON c.id_producto = p.id_producto 
-- WHERE c.id_usuario = 1;

-- Obtener pedidos de un usuario
-- SELECT * FROM pedidos WHERE id_usuario = 1 ORDER BY fecha_pedido DESC;

-- Obtener detalles de un pedido específico
-- SELECT dp.*, p.imagen 
-- FROM detalle_pedido dp 
-- LEFT JOIN productos p ON dp.id_producto = p.id_producto 
-- WHERE dp.id_pedido = 1;