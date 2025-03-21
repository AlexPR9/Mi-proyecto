<?php
// Encabezados para permitir peticiones desde cualquier origen
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Incluir archivos requeridos
include_once 'config/Database.php';
include_once 'models/Producto.php';

// Conectar con la base de datos
$database = new Database();
$db = $database->getConnection();

// Instanciar el objeto Producto
$producto = new Producto($db);

// Obtener el método HTTP
$metodo = $_SERVER['REQUEST_METHOD'];

// Obtener datos de entrada si es POST o PUT
$data = json_decode(file_get_contents("php://input"));

// Rutas para la API
switch ($metodo) {
    case 'GET':
        if (!empty($_GET['id'])) {
            $producto->id = $_GET['id'];
            $producto->obtenerProductoPorId();

            if ($producto->nombre != null) {
                $producto_arr = array(
                    "id" => $producto->id,
                    "nombre" => $producto->nombre,
                    "descripcion" => $producto->descripcion,
                    "precio" => $producto->precio,
                    "categoria_id" => $producto->categoria_id
                );

                http_response_code(200);
                echo json_encode($producto_arr);
            } else {
                http_response_code(404);
                echo json_encode(array("mensaje" => "Producto no encontrado."));
            }
        } else {
            $stmt = $producto->obtenerProductos();
            $num = $stmt->rowCount();

            if ($num > 0) {
                $productos_arr = array();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $item = array(
                        "id" => $id,
                        "nombre" => $nombre,
                        "descripcion" => $descripcion,
                        "precio" => $precio,
                        "categoria_id" => $categoria_id
                    );
                    array_push($productos_arr, $item);
                }

                http_response_code(200);
                echo json_encode($productos_arr);
            } else {
                http_response_code(404);
                echo json_encode(array("mensaje" => "No hay productos encontrados."));
            }
        }
        break;

    case 'POST':
        // Obtener datos del nuevo producto
        $nombre = isset($data->nombre) ? $data->nombre : "";
        $descripcion = isset($data->descripcion) ? $data->descripcion : "";
        $precio = isset($data->precio) ? $data->precio : 0;
        $categoria_id = isset($data->categoria_id) ? $data->categoria_id : 0;

        // Validar datos
        if (empty($nombre) || empty($precio) || empty($categoria_id)) {
            http_response_code(400);
            echo json_encode(array("mensaje" => "Nombre, precio y categoria_id son obligatorios."));
            break;
        }

        // Crear producto
        $producto->nombre = $nombre;
        $producto->descripcion = $descripcion;
        $producto->precio = $precio;
        $producto->categoria_id = $categoria_id;

        if ($producto->crearProducto()) {
            http_response_code(201);
            echo json_encode(array("mensaje" => "Producto creado con éxito."));
        } else {
            http_response_code(500);
            echo json_encode(array("mensaje" => "Error al crear el producto."));
        }
        break;

    case 'PUT':
        // Obtener datos del producto actualizado
        $id = isset($_GET['id']) ? $_GET['id'] : "";
        $nombre = isset($data->nombre) ? $data->nombre : "";
        $descripcion = isset($data->descripcion) ? $data->descripcion : "";
        $precio = isset($data->precio) ? $data->precio : 0;
        $categoria_id = isset($data->categoria_id) ? $data->categoria_id : 0;

        // Validar datos
        if (empty($id) || empty($nombre) || empty($precio) || empty($categoria_id)) {
            http_response_code(400);
            echo json_encode(array("mensaje" => "ID, nombre, precio y categoria_id son obligatorios."));
            break;
        }

        // Actualizar producto
        $producto->id = $id;
        $producto->nombre = $nombre;
        $producto->descripcion = $descripcion;
        $producto->precio = $precio;
        $producto->categoria_id = $categoria_id;

        if ($producto->actualizarProducto()) {
            http_response_code(200);
            echo json_encode(array("mensaje" => "Producto actualizado con éxito."));
        } else {
            http_response_code(500);
            echo json_encode(array("mensaje" => "Error al actualizar el producto."));
        }
        break;

    case 'DELETE':
        // Obtener ID del producto a eliminar
        $id = isset($_GET['id']) ? $_GET['id'] : "";

        if (empty($id)) {
            http_response_code(400);
            echo json_encode(array("mensaje" => "ID del producto es obligatorio."));
            break;
        }

        // Eliminar producto
        $producto->id = $id;

        if ($producto->eliminarProducto()) {
            http_response_code(200);
            echo json_encode(array("mensaje" => "Producto eliminado con éxito."));
        } else {
            http_response_code(500);
            echo json_encode(array("mensaje" => "Error al eliminar el producto."));
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(array("mensaje" => "Método no permitido."));
        break;
}
?>