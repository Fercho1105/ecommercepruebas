<?php
session_start();
require 'config.php';
require __DIR__ . '/includes/productos.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$productId = intval($data['id']);
$action = $data['action'];

$productos = require __DIR__ . '/includes/productos.php';

if (!isset($_SESSION['carrito'][$productId])) {
    echo json_encode(['success' => false, 'message' => 'Producto no está en el carrito']);
    exit;
}

$producto = $productos[$productId];
$cantidad = $_SESSION['carrito'][$productId]['cantidad'];

if ($action === 'increase') {
    // Verificar stock antes de aumentar
    if ($cantidad < $producto['stock']) {
        $_SESSION['carrito'][$productId]['cantidad']++;
    } else {
        echo json_encode(['success' => false, 'message' => 'No hay suficiente stock']);
        exit;
    }
} elseif ($action === 'decrease') {
    $_SESSION['carrito'][$productId]['cantidad']--;
    if ($_SESSION['carrito'][$productId]['cantidad'] <= 0) {
        unset($_SESSION['carrito'][$productId]);
        $subtotal = calcularSubtotal();
        echo json_encode([
            'success' => true,
            'removed' => true,
            'subtotal' => number_format($subtotal, 2),
            'cart_count' => count($_SESSION['carrito'])
        ]);
        exit;
    }
}

// Recalcular totales
$nuevaCantidad = $_SESSION['carrito'][$productId]['cantidad'];
$itemTotal = $nuevaCantidad * $producto['precio'];
$subtotal = calcularSubtotal();

echo json_encode([
    'success' => true,
    'new_quantity' => $nuevaCantidad,
    'item_total' => number_format($itemTotal, 2),
    'subtotal' => number_format($subtotal, 2),
    'cart_count' => array_sum(array_column($_SESSION['carrito'], 'cantidad'))
]);

function calcularSubtotal() {
    $total = 0;
    foreach ($_SESSION['carrito'] as $id => $item) {
        $total += $item['precio'] * $item['cantidad'];
    }
    return $total;
}
?>