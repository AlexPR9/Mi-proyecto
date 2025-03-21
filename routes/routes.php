<?php

// Obtener la URI solicitada y el método
$request_uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Remover query string de la URL (si existe)
$request_uri = strtok($request_uri, '?');

// Rutas para categorías
if (strpos($request_uri, '/mi-proyecto/public/index.php/categorias') !== false) {
    include '../api/categorias.php';
    exit;
}

// Ruta para obtener categoría por ID
if (strpos($request_uri, '/mi-proyecto/public/index.php/categorias') !== false && isset($_GET['id'])) {
    include '../api/categorias.php';
    exit;
}

// Rutas para productos
if (strpos($request_uri, '/mi-proyecto/public/index.php/productos') !== false) {
    include '../api/productos.php';
    exit;
}

// Ruta para obtener producto por ID
if (strpos($request_uri, '/mi-proyecto/public/index.php/productos') !== false && isset($_GET['id'])) {
    include '../api/productos.php';
    exit;
}

// Ruta no encontrada
http_response_code(404);
echo json_encode(['mensaje' => 'Ruta no encontrada']);
?>
