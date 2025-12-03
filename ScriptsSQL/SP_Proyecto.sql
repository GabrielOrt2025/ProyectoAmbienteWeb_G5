USE lavaca_shop;

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







