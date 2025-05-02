<?php
session_start();
require_once 'productos.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];

$productos = include 'productos.php';

if (isset($_SESSION['carrito'][$id])) {
    unset($_SESSION['carrito'][$id]);
}

$nuevoTotal = calcularSubtotal();
$cartCount = count($_SESSION['carrito']);

echo json_encode([
    'success' => true,
    'new_total' => $nuevoTotal,
    'cart_count' => $cartCount
]);

function calcularSubtotal() {
    global $productos;
    $total = 0;
    foreach ($_SESSION['carrito'] as $id => $item) {
        $total += $productos[$id]['precio'] * $item['cantidad'];
    }
    return number_format($total, 2);
}
