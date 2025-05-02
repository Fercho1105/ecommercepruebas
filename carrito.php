<?php
require 'includes/config.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: auth/login.php');
    exit;
}

$carrito = $_SESSION['carrito'] ?? [];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Carrito | <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="assets/css/core.css">
</head>
<body>
    <?php include 'vistas/header.php'; ?>
    
    <main class="container">
        <h1>Tu Carrito</h1>
        
        <?php if (empty($carrito)): ?>
            <p class="empty-cart">Tu carrito está vacío</p>
        <?php else: ?>
            <div class="cart-items">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>Eliminar</th>
                            <th>Precio Unitario</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($carrito as $id => $item): 
                            $totalItem = $item['precio'] * $item['cantidad'];
                        ?>
                            <tr class="cart-item" data-id="<?= $id ?>">
                                <td><img src="assets/img/productos/<?= $item['imagen'] ?>" alt="<?= $item['nombre'] ?>" class="cart-item-img" style="width: 80px;"></td>
                                <td><?= $item['nombre'] ?></td>
                                <td>
                                    <div class="item-quantity">
                                        <button class="quantity-btn minus">-</button>
                                        <span><?= $item['cantidad'] ?></span>
                                        <button class="quantity-btn plus">+</button>
                                    </div>
                                </td>
                                <td><button class="remove-item">Eliminar</button></td>
                                <td class="item-price">$<?= number_format($item['precio'], 2) ?></td>
                                <td class="item-total">$<?= number_format($totalItem, 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="cart-summary" style="margin-top: 20px;">
                <div class="cart-total">
                    Subtotal: <span>$<?= number_format(array_sum(array_map(fn($item) => $item['precio'] * $item['cantidad'], $carrito)), 2) ?></span>
                </div>
                <a href="checkout.php" class="checkout-btn">Proceder al Pago</a>
            </div>
        <?php endif; ?>
    </main>

    <script src="assets/js/carrito.js"></script>
</body>
</html>