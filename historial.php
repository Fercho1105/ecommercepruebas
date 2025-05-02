<?php
require 'includes/config.php';
requiereAutenticacion();

$pedidos = $_SESSION['historial'] ?? [];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Historial | <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="assets/css/core.css">
    <style>
        .historial-container {
            max-width: 800px;
            margin: 2rem auto;
        }
        .pedido-card {
            background: white;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .pedido-id {
            font-weight: bold;
            color: var(--primary);
        }
        .empty-history {
            text-align: center;
            padding: 2rem;
            color: #666;
        }
    </style>
</head>
<body>
    <?php include 'vistas/header.php'; ?>
    
    <main class="container">
        <h1 class="section-title">Tus Pedidos Anteriores</h1>
        
        <div class="historial-container">
            <?php if (empty($pedidos)): ?>
                <div class="empty-history">
                    <i class="fas fa-box-open" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                    <p>No hay pedidos registrados</p>
                    <a href="index.php" class="btn">Ir a Comprar</a>
                </div>
            <?php else: ?>
                <?php foreach ($pedidos as $pedido): ?>
                <div class="pedido-card">
                    <p class="pedido-id">Orden #<?= $pedido['id'] ?></p>
                    <p>Fecha: <?= $pedido['fecha'] ?></p>
                    <p>Total: $<?= number_format($pedido['total'], 2) ?></p>
                    <a href="ticket.php?orden=<?= $pedido['id'] ?>" class="btn">
                        <i class="fas fa-receipt"></i> Ver Ticket
                    </a>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>