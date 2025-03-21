<?php
class Producto {
    private $conn;
    private $table_name = "productos";

    // Propiedades del producto
    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $categoria_id;

    // Constructor para la conexión
    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener todos los productos
    public function obtenerProductos() {
        $query = "SELECT id, nombre, descripcion, precio, categoria_id FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Obtener un solo producto por ID
    public function obtenerProductoPorId() {
        $query = "SELECT nombre, descripcion, precio, categoria_id FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->nombre = $row['nombre'];
            $this->descripcion = $row['descripcion'];
            $this->precio = $row['precio'];
            $this->categoria_id = $row['categoria_id'];
        }
    }

    // Crear un nuevo producto
    public function crearProducto() {
        try {
            $query = "INSERT INTO " . $this->table_name . " (nombre, descripcion, precio, categoria_id) VALUES (:nombre, :descripcion, :precio, :categoria_id)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":nombre", $this->nombre);
            $stmt->bindParam(":descripcion", $this->descripcion);
            $stmt->bindParam(":precio", $this->precio);
            $stmt->bindParam(":categoria_id", $this->categoria_id);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            // Registrar el error o manejarlo apropiadamente
            error_log("Database Error: " . $e->getMessage());
            return false; // lanzar una excepción
        }
    }
    
    // Actualizar un producto
    public function actualizarProducto() {
        try {
            $query = "UPDATE " . $this->table_name . " SET nombre = :nombre, descripcion = :descripcion, precio = :precio, categoria_id = :categoria_id WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":nombre", $this->nombre);
            $stmt->bindParam(":descripcion", $this->descripcion);
            $stmt->bindParam(":precio", $this->precio);
            $stmt->bindParam(":categoria_id", $this->categoria_id);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            // Registrar el error o manejarlo apropiadamente
            error_log("Database Error: " . $e->getMessage());
            return false; // lanzar una excepción
        }
    }

    // Eliminar un producto
    public function eliminarProducto() {
        try {
            $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $this->id);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            // Registrar el error o manejarlo apropiadamente
            error_log("Database Error: " . $e->getMessage());
            return false; // lanzar una excepción
        }
    }
}
?>