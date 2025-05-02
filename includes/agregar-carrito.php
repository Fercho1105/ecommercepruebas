<?php
session_start();
require 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'error' => 'Debes iniciar sesión']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$productId = intval($data['id']);

// Cargar productos desde productos.php
$productos = require __DIR__ . '/productos.php';

// Verificar si el producto existe
if (!isset($productos[$productId])) {
    echo json_encode(['success' => false, 'error' => 'Producto no encontrado']);
    exit;
}

$producto = $productos[$productId];

// Verificar stock
if ($producto['stock'] <= 0) {
    echo json_encode(['success' => false, 'error' => 'Producto agotado']);
    exit;
}

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Agregar o actualizar producto en el carrito
if (isset($_SESSION['carrito'][$productId])) {
    $_SESSION['carrito'][$productId]['cantidad'] += 1;
} else {
    $_SESSION['carrito'][$productId] = [
        'id' => $producto['id'],
        'nombre' => $producto['nombre'],
        'precio' => $producto['precio'],
        'imagen' => $producto['imagen'],
        'cantidad' => 1
    ];
}

// Calcular total de items en el carrito
$cartCount = array_sum(array_column($_SESSION['carrito'], 'cantidad'));

echo json_encode([
    'success' => true,
    'cart_count' => $cartCount,
    'product_name' => $producto['nombre']
]);
?>