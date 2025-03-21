<?php
class Categoria {
    private $conn;
    private $table_name = "categorias";

    // Propiedades de la categoría
    public $id;
    public $nombre;
    public $descripcion;

    // Constructor para la conexión
    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener todas las categorías
    public function obtenerCategorias() {
        try {
            $query = "SELECT id, nombre, descripcion FROM " . $this->table_name;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            // Registrar el error o manejarlo apropiadamente
            error_log("Database Error: " . $e->getMessage());
            return false; // lanzar una excepción
        }
    }

    // Obtener una sola categoría por ID
    public function obtenerCategoriaPorId() {
        try {
            $query = "SELECT nombre, descripcion FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $this->nombre = $row['nombre'];
                $this->descripcion = $row['descripcion'];
            }
        } catch (PDOException $e) {
            // Registrar el error o manejarlo apropiadamente
            error_log("Database Error: " . $e->getMessage());
            return false; // lanzar una excepción
        }
    }

    // Crear una nueva categoría
    public function crearCategoria() {
        try {
            $query = "INSERT INTO " . $this->table_name . " (nombre, descripcion) VALUES (:nombre, :descripcion)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":nombre", $this->nombre);
            $stmt->bindParam(":descripcion", $this->descripcion);

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
    
    // Actualizar una categoría
    public function actualizarCategoria() {
        try {
            $query = "UPDATE " . $this->table_name . " SET nombre = :nombre, descripcion = :descripcion WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":nombre", $this->nombre);
            $stmt->bindParam(":descripcion", $this->descripcion);

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

    // Eliminar una categoría
    public function eliminarCategoria() {
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