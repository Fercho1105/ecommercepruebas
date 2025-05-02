<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .ticket { max-width: 600px; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        .total { font-weight: bold; font-size: 1.2em; }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <h1><?= SITE_NAME ?></h1>
            <h2>Ticket de Compra #<?= $orden['id'] ?></h2>
            <p>Fecha: <?= $orden['fecha'] ?></p>
        </div>
        
        <table>
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
        
        <p class="total">Total: $<?= number_format($orden['total'], 2) ?></p>
        <p>Método de pago: <?= $orden['metodo_pago'] ?? 'Tarjeta' ?></p>
    </div>
</body>
</html>