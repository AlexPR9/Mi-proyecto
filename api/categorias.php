<?php
// Encabezados para permitir peticiones desde cualquier origen
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Incluir archivos requeridos
include_once '../config/Database.php';
include_once '../models/Categoria.php';

// Conectar con la base de datos
$database = new Database();
$db = $database->getConnection();
$categoria = new Categoria($db);


// Instanciar el objeto Categoria
$categoria = new Categoria($db);

// Obtener el método HTTP
$metodo = $_SERVER['REQUEST_METHOD'];

// Obtener datos de entrada si es POST o PUT
$data = json_decode(file_get_contents("php://input"));

// Rutas para la API
switch ($metodo) {
    case 'GET':
        if (!empty($_GET['id'])) {
            $categoria->id = $_GET['id'];
            $categoria->obtenerCategoriaPorId();

            if ($categoria->nombre != null) {
                $categoria_arr = array(
                    "id" => $categoria->id,
                    "nombre" => $categoria->nombre,
                    "descripcion" => $categoria->descripcion
                );

                http_response_code(200);
                echo json_encode($categoria_arr);
            } else {
                http_response_code(404);
                echo json_encode(array("mensaje" => "Categoría no encontrada."));
            }
        } else {
            try {
                $stmt = $categoria->obtenerCategorias();
                $num = $stmt->rowCount();

                if ($num > 0) {
                    $categorias_arr = array();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        $item = array(
                            "id" => $id,
                            "nombre" => $nombre,
                            "descripcion" => $descripcion
                        );
                        array_push($categorias_arr, $item);
                    }

                    http_response_code(200);
                    echo json_encode($categorias_arr);
                } else {
                    http_response_code(404);
                    echo json_encode(array("mensaje" => "No hay categorías encontradas."));
                }
            } catch (PDOException $e) {
                http_response_code(500); // Error interno del servidor
                echo json_encode(array("mensaje" => "Error al obtener las categorías: " . $e->getMessage()));
            }
        }
        break;

    case 'POST':
        // Obtener datos de la nueva categoría
        $nombre = isset($data->nombre) ? $data->nombre : "";
        $descripcion = isset($data->descripcion) ? $data->descripcion : "";

        // Validar datos
        if (empty($nombre)) {
            http_response_code(400);
            echo json_encode(array("mensaje" => "El nombre de la categoría es obligatorio."));
            break;
        }

        // Crear categoría
        $categoria->nombre = $nombre;
        $categoria->descripcion = $descripcion;

        if ($categoria->crearCategoria()) {
            http_response_code(201);
            echo json_encode(array("mensaje" => "Categoría creada con éxito."));
        } else {
            http_response_code(500);
            echo json_encode(array("mensaje" => "Error al crear la categoría."));
        }
        break;
        case 'PUT':
            // Obtener datos de la categoría actualizada
            $id = isset($_GET['id']) ? $_GET['id'] : "";
            $nombre = isset($data->nombre) ? $data->nombre : "";
            $descripcion = isset($data->descripcion) ? $data->descripcion : "";
    
            // Validar datos
            if (empty($id) || empty($nombre)) {
                http_response_code(400);
                echo json_encode(array("mensaje" => "ID y nombre son obligatorios."));
                break;
            }
    
            // Actualizar categoría
            $categoria->id = $id;
            $categoria->nombre = $nombre;
            $categoria->descripcion = $descripcion;
    
            if ($categoria->actualizarCategoria()) {
                http_response_code(200);
                echo json_encode(array("mensaje" => "Categoría actualizada con éxito."));
            } else {
                http_response_code(500);
                echo json_encode(array("mensaje" => "Error al actualizar la categoría."));
            }
            break;

            case 'DELETE':
                // Obtener ID de la categoría a eliminar
                $id = isset($_GET['id']) ? $_GET['id'] : "";
        
                if (empty($id)) {
                    http_response_code(400);
                    echo json_encode(array("mensaje" => "ID de la categoría es obligatorio."));
                    break;
                }
        
                // Eliminar categoría
                $categoria->id = $id;
        
                if ($categoria->eliminarCategoria()) {
                    http_response_code(200);
                    echo json_encode(array("mensaje" => "Categoría eliminada con éxito."));
                } else {
                    http_response_code(500);
                    echo json_encode(array("mensaje" => "Error al eliminar la categoría."));
                }
                break;
    



// Método no permitido

    default:
        http_response_code(405);
        echo json_encode(array("mensaje" => "Método no permitido."));
        break;
}
?>