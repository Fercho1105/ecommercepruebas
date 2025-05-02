<?php
require 'includes/config.php';

// Validar acceso solo si hay una orden reciente
if (!isset($_GET['orden']) || empty($_SESSION['ultima_orden'])) {
    header('Location: index.php');
    exit;
}

$orden = $_SESSION['ultima_orden'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ticket de Compra | <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="assets/css/core.css">
    <style>
        .ticket-container {
            max-width: 600px;
            margin: 2rem auto;
            background: white;
            padding: 2rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .ticket-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .ticket-details {
            margin: 1.5rem 0;
        }
        .ticket-items {
            width: 100%;
            border-collapse: collapse;
        }
        .ticket-items th, .ticket-items td {
            padding: 0.8rem;
            border-bottom: 1px solid #eee;
            text-align: left;
        }
        .ticket-total {
            font-weight: bold;
            font-size: 1.2rem;
            margin-top: 1rem;
            text-align: right;
        }
        .ticket-actions {
            margin-top: 2rem;
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <?php include 'vistas/header.php'; ?>
    
    <main class="container">
        <div class="ticket-container">
            <div class="ticket-header">
                <h1>¡Compra Exitosa!</h1>
                <h3>¡Pedidio en camino!</h3>
                <p>Orden #<?= $orden['id'] ?></p>
            </div>
            
            <div class="ticket-details">
                <p><strong>Fecha:</strong> <?= $orden['fecha'] ?></p>
                <p><strong>Cliente:</strong> <?= $_SESSION['usuario']['nombre'] ?></p>
            </div>
            
            <table class="ticket-items">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orden['productos'] as $item): ?>
                    <tr>
                        <td><?= $item['nombre'] ?></td>
                        <td><?= $item['cantidad'] ?></td>
                        <td>$<?= number_format($item['precio'], 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div class="ticket-total">
                Total: $<?= number_format($orden['total'], 2) ?>
            </div>
            
            <!-- Modifica la sección de acciones del ticket -->
            <div class="ticket-actions">
                <a href="index.php" class="btn">
                    <i class="fas fa-home"></i> Volver al Inicio
                </a>
                <a href="historial.php" class="btn">
                    <i class="fas fa-history"></i> Ver Historial
                </a>
                <!-- Agrega esto en la sección de acciones -->
                <a href="includes/enviar-ticket.php" class="btn">
                    <i class="fas fa-envelope"></i> Enviar por correo
                </a>
                <button onclick="window.print()" class="btn">
                    <i class="fas fa-print"></i> Imprimir
                </button>
            </div>
        </div>
    </main>
</body>
</html>