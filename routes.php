<?php

$request_uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Rutas para categorías
if (strpos($request_uri, '/categorias') !== false) {
    if ($method === 'GET') {
        include 'api/categorias.php'; // Maneja GET /categorias y GET /categorias?id=...
    } elseif ($method === 'POST') {
        include 'api/categorias.php'; // Maneja POST /categorias
    } elseif ($method === 'PUT' && isset($_GET['id'])) {
        include 'api/categorias.php'; // Maneja PUT /categorias?id=...
    } elseif ($method === 'DELETE' && isset($_GET['id'])) {
        include 'api/categorias.php'; // Maneja DELETE /categorias?id=...
    } else {
        http_response_code(405); // Método no permitido
        echo json_encode(['mensaje' => 'Método no permitido para esta ruta.']);
    }
    exit; // Importante: Detener la ejecución después de manejar la ruta
}

// Rutas para productos
if (strpos($request_uri, '/productos') !== false) {
    if ($method === 'GET') {
        include 'api/productos.php'; // Maneja GET /productos y GET /productos?id=...
    } elseif ($method === 'POST') {
        include 'api/productos.php'; // Maneja POST /productos
    } elseif ($method === 'PUT' && isset($_GET['id'])) {
        include 'api/productos.php'; // Maneja PUT /productos?id=...
    } elseif ($method === 'DELETE' && isset($_GET['id'])) {
        include 'api/productos.php'; // Maneja DELETE /productos?id=...
    } else {
        http_response_code(405); // Método no permitido
        echo json_encode(['mensaje' => 'Método no permitido para esta ruta.']);
    }
    exit; // Importante: Detener la ejecución después de manejar la ruta
}

// Ruta no encontrada
http_response_code(404);
echo json_encode(['mensaje' => 'Ruta no encontrada.']);
?>