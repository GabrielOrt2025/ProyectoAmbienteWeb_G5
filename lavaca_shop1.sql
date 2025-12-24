-- ============================================
-- BASE DE DATOS: LA VACA E-COMMERCE
-- Estructura básica siguiendo el enfoque de las clases
-- ============================================
DROP DATABASE IF EXISTS lavaca_shop;
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
    precio DECIMAL(10, 3) NOT NULL,
    precio_descuento DECIMAL(10, 3),
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
    precio_unitario DECIMAL(10, 3),
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
    subtotal DECIMAL(10, 3) NOT NULL,
    descuento DECIMAL(10, 3) DEFAULT 0,
    costo_envio DECIMAL(10, 3) DEFAULT 0,
    total DECIMAL(10, 3) NOT NULL,
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
    precio_unitario DECIMAL(10, 3) NOT NULL,
    subtotal DECIMAL(10, 3) NOT NULL,
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedido),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
);

-- ============================================
-- TABLA: codigos_descuento
-- ============================================
CREATE TABLE codigos_descuento (
    id_codigo INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(50) NOT NULL UNIQUE,
    descuento DECIMAL(10, 3) NOT NULL,
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


SET SQL_SAFE_UPDATES = 0;

DELETE FROM productos;

-- TODOS LOS PRODUCTOS (con categoría asignada)
INSERT INTO productos (nombre, descripcion, precio, id_categoria, stock, imagen) VALUES
-- ROPA (categoria 1)
('Chaqueta marrón', 'Chaqueta de cuero', 89.000, 1, 15, 'img/imagen.png'),
('Chaqueta roja', 'Chaqueta deportiva', 75.000, 1, 20, 'img/imagen1.png'),
('Abrigo negro', 'Abrigo elegante', 120.000, 1, 10, 'img/imagen2.png'),
('Pantalones azules', 'Pantalones cómodos', 65.000, 1, 25, 'img/imagen3.png'),
('Pantalones grises', 'Pantalones casuales', 55.000, 1, 30, 'img/imagen4.jpeg'),
('Pantalones negros', 'Pantalones formales', 70.000, 1, 20, 'img/imagen5.jpeg'),
('Traje completo', 'Traje de hombre', 250.000, 1, 5, 'img/imagen6.jpeg'),
('Conjunto formal', 'Conjunto formal', 180.000, 1, 8, 'img/imagen7.jpeg'),
('Outfit casual', 'Conjunto casual', 95.000, 1, 15, 'img/imagen8.jpeg'),
-- ZAPATOS (categoria 2)
('Zapatos rojos', 'Zapatos elegantes', 120.000, 2, 12, 'img/zapatos.jpeg'),
('Zapatos blancos', 'Zapatos deportivos', 85.000, 2, 25, 'img/zapatos1.jpeg'),
('Zapatos negros', 'Zapatos formales', 110.000, 2, 15, 'img/zapatos2.jpeg'),
-- BOLSAS (categoria 3)
('Bolso marrón', 'Bolso de cuero', 95.000, 3, 18, 'img/bolsos.jpeg'),
('Bolso beige', 'Bolso elegante', 105.000, 3, 12, 'img/bolsos1.jpeg'),
('Bolso borgoña', 'Bolso deportivo', 85.000, 3, 20, 'img/bolso2.jpeg'),
-- ACCESORIOS (categoria 4)
('Aretes dorados', 'Aretes de lujo', 45.000, 4, 30, 'img/accesorios.jpeg'),
('Gafas de sol', 'Gafas protectoras', 95.000, 4, 25, 'img/accesorios1.jpeg'),
('Cinturón dorado', 'Cinturón elegante', 65.000, 4, 35, 'img/accesorios2.jpeg'),
('Collar de perlas', 'Collar clásico', 150.000, 4, 15, 'img/accesorios3.jpeg'),
('Reloj de oro', 'Reloj lujoso', 450.000, 4, 8, 'img/accesorios4.jpeg'),
('Guantes de cuero', 'Guantes premium', 120.000, 4, 20, 'img/accesorios5.jpeg');

SET SQL_SAFE_UPDATES = 1;

SELECT * FROM productos;

-- Insertar códigos de descuento
INSERT INTO codigos_descuento (codigo, descuento, fecha_expiracion) VALUES
('SAVE10', 10.000, '2025-12-31'),
('SAVE20', 20.000, '2025-12-31'),
('WELCOME15', 15.000, '2025-12-31');

-- Insertar usuario administrador
-- Contraseña: admin123
INSERT INTO usuarios (nombre, apellido, email, password, telefono, rol) VALUES
('Admin', 'Sistema', 'admin@lavaca.com', 'admin123', '+506 8888-8888', 'admin');


INSERT INTO usuarios (nombre, apellido, email, password, telefono, rol) VALUES
('Admin', 'Sistema', 'admins@lavaca.com', 'admin1234', '+506 8888-8888', 'admin');

-- Insertar usuario cliente de ejemplo
INSERT INTO usuarios (nombre, apellido, email, password, telefono, rol) VALUES
('Eduard', 'Franz', 'eduard@gmail.com', 'pass123', '+380 555-0115', 'cliente');



-- Verificar
SELECT email, password, rol FROM usuarios;

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


DELIMITER $$

CREATE PROCEDURE leer_productos()
BEGIN
    SELECT 
        id_producto,
        nombre,
        descripcion,
        precio,
        precio_descuento,
        id_categoria,
        stock,
        imagen
    FROM productos;
END$$

DELIMITER ;

DROP PROCEDURE IF EXISTS leer_productos;


-- Crear usuario
DELIMITER //
CREATE PROCEDURE crear_usuario(
    IN p_nombre VARCHAR(100),
    IN p_apellido VARCHAR(100),
    IN p_email VARCHAR(150),
    IN p_password VARCHAR(255),
    IN p_telefono VARCHAR(20),
    IN p_rol VARCHAR(20)
)
BEGIN
    INSERT INTO usuarios(nombre, apellido, email, password, telefono, rol)
    VALUES(p_nombre, p_apellido, p_email, p_password, p_telefono, p_rol);
END //
DELIMITER ;

-- Leer usuarios
DELIMITER //
CREATE PROCEDURE leer_usuarios()
BEGIN
    SELECT * FROM usuarios;
END //
DELIMITER ;

-- Actualizar usuario
DELIMITER //
CREATE PROCEDURE actualizar_usuario(
    IN p_id INT,
    IN p_nombre VARCHAR(100),
    IN p_apellido VARCHAR(100),
    IN p_email VARCHAR(150),
    IN p_password VARCHAR(255),
    IN p_telefono VARCHAR(20),
    IN p_rol VARCHAR(20)
)
BEGIN
    UPDATE usuarios
    SET nombre = p_nombre,
        apellido = p_apellido,
        email = p_email,
        password = p_password,
        telefono = p_telefono,
        rol = p_rol
    WHERE id_usuario = p_id;
END //
DELIMITER ;

-- Eliminar usuario
DELIMITER //
CREATE PROCEDURE eliminar_usuario(IN p_id INT)
BEGIN
    DELETE FROM usuarios WHERE id_usuario = p_id;
END //
DELIMITER ;

-- Categorias
DELIMITER //
CREATE PROCEDURE crear_categoria(
    IN p_nombre VARCHAR(100),
    IN p_descripcion TEXT,
    IN p_imagen VARCHAR(255)
)
BEGIN
    INSERT INTO categorias(nombre, descripcion, imagen)
    VALUES(p_nombre, p_descripcion, p_imagen);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE leer_categorias()
BEGIN
    SELECT * FROM categorias;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE actualizar_categoria(
    IN p_id INT,
    IN p_nombre VARCHAR(100),
    IN p_descripcion TEXT,
    IN p_imagen VARCHAR(255)
)
BEGIN
    UPDATE categorias
    SET nombre = p_nombre,
        descripcion = p_descripcion,
        imagen = p_imagen
    WHERE id_categoria = p_id;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE eliminar_categoria(IN p_id INT)
BEGIN
    DELETE FROM categorias WHERE id_categoria = p_id;
END //
DELIMITER ;

-- Productos
DELIMITER //
CREATE PROCEDURE crear_producto(
    IN p_nombre VARCHAR(200),
    IN p_descripcion TEXT,
    IN p_precio DECIMAL(10,2),
    IN p_precio_desc DECIMAL(10,2),
    IN p_id_categoria INT,
    IN p_stock INT,
    IN p_imagen VARCHAR(255)
)
BEGIN
    INSERT INTO productos(nombre, descripcion, precio, precio_descuento, id_categoria, stock, imagen)
    VALUES(p_nombre, p_descripcion, p_precio, p_precio_desc, p_id_categoria, p_stock, p_imagen);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE leer_productos()
BEGIN
    SELECT * FROM productos;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE actualizar_producto(
    IN p_id INT,
    IN p_nombre VARCHAR(200),
    IN p_descripcion TEXT,
    IN p_precio DECIMAL(10,2),
    IN p_precio_desc DECIMAL(10,2),
    IN p_id_categoria INT,
    IN p_stock INT,
    IN p_imagen VARCHAR(255)
)
BEGIN
    UPDATE productos
    SET nombre = p_nombre,
        descripcion = p_descripcion,
        precio = p_precio,
        precio_descuento = p_precio_desc,
        id_categoria = p_id_categoria,
        stock = p_stock,
        imagen = p_imagen
    WHERE id_producto = p_id;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE eliminar_producto(IN p_id INT)
BEGIN
    DELETE FROM productos WHERE id_producto = p_id;
END //
DELIMITER ;

-- Carrito
DELIMITER //
CREATE PROCEDURE agregar_carrito(
    IN p_id_usuario INT,
    IN p_id_producto INT,
    IN p_cantidad INT,
    IN p_precio DECIMAL(10,2)
)
BEGIN
    INSERT INTO carrito(id_usuario, id_producto, cantidad, precio_unitario)
    VALUES(p_id_usuario, p_id_producto, p_cantidad, p_precio);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE leer_carrito(IN p_id_usuario INT)
BEGIN
    SELECT * FROM carrito WHERE id_usuario = p_id_usuario;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE actualizar_carrito(
    IN p_id INT,
    IN p_cantidad INT
)
BEGIN
    UPDATE carrito
    SET cantidad = p_cantidad
    WHERE id_carrito = p_id;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE eliminar_carrito(IN p_id INT)
BEGIN
    DELETE FROM carrito WHERE id_carrito = p_id;
END //
DELIMITER ;

-- Direcciones 
DELIMITER //
CREATE PROCEDURE crear_direccion(
    IN p_id_usuario INT,
    IN p_calle VARCHAR(200),
    IN p_ciudad VARCHAR(100),
    IN p_codigo VARCHAR(20),
    IN p_pais VARCHAR(100),
    IN p_telefono VARCHAR(20)
)
BEGIN
    INSERT INTO direcciones(id_usuario, calle, ciudad, codigo_postal, pais, telefono)
    VALUES(p_id_usuario, p_calle, p_ciudad, p_codigo, p_pais, p_telefono);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE leer_direcciones()
BEGIN
    SELECT * FROM direcciones;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE actualizar_direccion(
    IN p_id INT,
    IN p_calle VARCHAR(200),
    IN p_ciudad VARCHAR(100),
    IN p_codigo VARCHAR(20),
    IN p_pais VARCHAR(100),
    IN p_telefono VARCHAR(20)
)
BEGIN
    UPDATE direcciones
    SET calle = p_calle,
        ciudad = p_ciudad,
        codigo_postal = p_codigo,
        pais = p_pais,
        telefono = p_telefono
    WHERE id_direccion = p_id;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE eliminar_direccion(IN p_id INT)
BEGIN
    DELETE FROM direcciones WHERE id_direccion = p_id;
END //
DELIMITER ;

-- Pedidos
DELIMITER //
CREATE PROCEDURE crear_pedido(
    IN p_numero VARCHAR(50),
    IN p_id_usuario INT,
    IN p_id_direccion INT,
    IN p_sub DECIMAL(10,2),
    IN p_desc DECIMAL(10,2),
    IN p_env DECIMAL(10,2),
    IN p_total DECIMAL(10,2),
    IN p_metodo VARCHAR(50),
    IN p_estado VARCHAR(50)
)
BEGIN
    INSERT INTO pedidos(numero_pedido, id_usuario, id_direccion, subtotal, descuento, costo_envio, total, metodo_pago, estado)
    VALUES(p_numero, p_id_usuario, p_id_direccion, p_sub, p_desc, p_env, p_total, p_metodo, p_estado);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE leer_pedidos()
BEGIN
    SELECT * FROM pedidos;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE actualizar_pedido(
    IN p_id INT,
    IN p_estado VARCHAR(50)
)
BEGIN
    UPDATE pedidos
    SET estado = p_estado
    WHERE id_pedido = p_id;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE eliminar_pedido(IN p_id INT)
BEGIN
    DELETE FROM pedidos WHERE id_pedido = p_id;
END //
DELIMITER ;


-- detalle_pedido
DELIMITER //
CREATE PROCEDURE crear_detalle_pedido(
    IN p_id_pedido INT,
    IN p_id_producto INT,
    IN p_nombre VARCHAR(200),
    IN p_cantidad INT,
    IN p_precio DECIMAL(10,2),
    IN p_subtotal DECIMAL(10,2)
)
BEGIN
    INSERT INTO detalle_pedido(id_pedido, id_producto, nombre_producto, cantidad, precio_unitario, subtotal)
    VALUES(p_id_pedido, p_id_producto, p_nombre, p_cantidad, p_precio, p_subtotal);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE leer_detalles_pedido(IN p_id_pedido INT)
BEGIN
    SELECT * FROM detalle_pedido WHERE id_pedido = p_id_pedido;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE eliminar_detalle_pedido(IN p_id INT)
BEGIN
    DELETE FROM detalle_pedido WHERE id_detalle = p_id;
END //
DELIMITER ;

-- codigos descuentos
DELIMITER //
CREATE PROCEDURE crear_codigo_descuento(
    IN p_codigo VARCHAR(50),
    IN p_descuento DECIMAL(10,2),
    IN p_fecha DATE,
    IN p_activo VARCHAR(10)
)
BEGIN
    INSERT INTO codigos_descuento(codigo, descuento, fecha_expiracion, activo)
    VALUES(p_codigo, p_descuento, p_fecha, p_activo);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE leer_codigos_descuento()
BEGIN
    SELECT * FROM codigos_descuento;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE actualizar_codigo_descuento(
    IN p_id INT,
    IN p_codigo VARCHAR(50),
    IN p_descuento DECIMAL(10,2),
    IN p_fecha DATE,
    IN p_activo VARCHAR(10)
)
BEGIN
    UPDATE codigos_descuento
    SET codigo = p_codigo,
        descuento = p_descuento,
        fecha_expiracion = p_fecha,
        activo = p_activo
    WHERE id_codigo = p_id;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE eliminar_codigo_descuento(IN p_id INT)
BEGIN
    DELETE FROM codigos_descuento WHERE id_codigo = p_id;
END //
DELIMITER ;


SHOW PROCEDURE STATUS WHERE Db = 'lavaca_shop';


SELECT * FROM usuarios WHERE email = 'admin@lavaca.com';

-- Eliminar admin anterior si existe
DELETE FROM usuarios WHERE email = 'admin@lavaca.com';

UPDATE usuarios 
SET password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' 
WHERE email = 'admin@lavaca.com';
-- Actualizar admin con contraseña correcta
DELETE FROM usuarios WHERE email = 'admin@lavaca.com';

INSERT INTO usuarios (nombre, apellido, email, password, telefono, rol) VALUES
('Admin', 'Sistema', 'admin@lavaca.com', 'password', '+506 8888-8888', 'admin');

SELECT * FROM usuarios;
-- Limpiar admin anterior
DELETE FROM usuarios WHERE email = 'admin@lavaca.com';

-- Insertar admin con contraseña 'password' en texto plano
INSERT INTO usuarios (nombre, apellido, email, password, telefono, rol) VALUES
('Admin', 'Sistema', 'admin@lavaca.com', 'password', '+506 8888-8888', 'admin');

SELECT * FROM usuarios WHERE email = 'admin@lavaca.com';


SHOW TABLES FROM lavaca_shop;

