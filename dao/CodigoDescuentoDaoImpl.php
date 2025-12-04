<?php
require_once 'CodigoDescuentoDao.php';
require_once '../Entidades/codigo_descuento.php';

class CodigoDescuentoDaoImpl implements CodigoDescuentoDAO {

    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerTodos() {
        $codigos = [];
        $sql = "CALL leer_codigos_descuento()";
        $result = $this->conexion->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $codigos[] = new codigo_descuento(
                    $row['id_codigo'],
                    $row['codigo'],
                    $row['descuento'],
                    $row['fecha_expiracion'],
                    $row['activo']
                );
            }
        }

        while ($this->conexion->more_results() && $this->conexion->next_result()) {}

        return $codigos;
    }

    public function obtenerPorCodigo($codigoBuscado) {
        $sql = "CALL leer_codigos_descuento()";
        $result = $this->conexion->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['codigo'] === $codigoBuscado) {
                    return new codigo_descuento(
                        $row['id_codigo'],
                        $row['codigo'],
                        $row['descuento'],
                        $row['fecha_expiracion'],
                        $row['activo']
                    );
                }
            }
        }

        while ($this->conexion->more_results() && $this->conexion->next_result()) {}

        return null;
    }

    public function obtenerPorId($id_codigo) {
        $sql = "CALL leer_codigos_descuento()";
        $result = $this->conexion->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['id_codigo'] == $id_codigo) {
                    return new codigo_descuento(
                        $row['id_codigo'],
                        $row['codigo'],
                        $row['descuento'],
                        $row['fecha_expiracion'],
                        $row['activo']
                    );
                }
            }
        }

        while ($this->conexion->more_results() && $this->conexion->next_result()) {}

        return null;
    }

    public function insertar(codigo_descuento $codigo) {
        $stmt = $this->conexion->prepare("CALL crear_codigo_descuento(?, ?, ?, ?)");

        $stmt->bind_param(
            "sdss",
            $codigo->codigo,
            $codigo->descuento,
            $codigo->fecha_expiracion,
            $codigo->activo
        );

        $resultado = $stmt->execute();
        $stmt->close();

        return $resultado;
    }

    public function actualizar(codigo_descuento $codigo) {
        $stmt = $this->conexion->prepare("CALL actualizar_codigo_descuento(?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "isdss",
            $codigo->id_codigo,
            $codigo->codigo,
            $codigo->descuento,
            $codigo->fecha_expiracion,
            $codigo->activo
        );

        $resultado = $stmt->execute();
        $stmt->close();

        return $resultado;
    }

    public function eliminar($id_codigo) {
        $stmt = $this->conexion->prepare("CALL eliminar_codigo_descuento(?)");
        $stmt->bind_param("i", $id_codigo);

        $resultado = $stmt->execute();
        $stmt->close();

        return $resultado;
    }
}
?>
