<?php
require __DIR__ . '/includes/config.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: auth/login.php');
    exit;
}

if (empty($_SESSION['carrito'])) {
    header('Location: carrito.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $metodo_pago = $_POST['metodo_pago'] ?? '';
    $tarjeta = $_POST['tarjeta'] ?? '';
    
    if (empty($metodo_pago)) {
        $error = 'Selecciona un método de pago';
    } elseif ($metodo_pago === 'tarjeta' && !preg_match('/^\d{16}$/', str_replace(' ', '', $tarjeta))) {
        $error = 'Número de tarjeta inválido';
    } else {
        // Cargar stock ACTUAL (no los productos originales)
        if (file_exists(__DIR__ . '/stock-temporal.php')) {
            $productos = require __DIR__ . '/stock-temporal.php';
        } else {
            $productos = require __DIR__ . '/includes/productos.php';
        }

        // Actualizar stock solo para productos comprados
        foreach ($_SESSION['carrito'] as $id => $item) {
            if (isset($productos[$id])) {
                $productos[$id]['stock'] -= $item['cantidad'];
            }
        }

        // Guardar stock actualizado
        file_put_contents(__DIR__ . '/stock-temporal.php', '<?php return ' . var_export($productos, true) . ';');
        $_SESSION['stock-temporal'] = $productos;

        // Generar número de orden
        $orden_id = 'ORD-' . time();
        
        date_default_timezone_set('America/Mexico_City');
        $_SESSION['ultima_orden'] = [
            'id' => $orden_id,
            'fecha' => date('d/m/Y H:i'),
            'productos' => $_SESSION['carrito'],
            'total' => array_sum(array_map(fn($item) => $item['precio'] * $item['cantidad'], $_SESSION['carrito'])),
            'metodo_pago' => $metodo_pago
        ];
        
        if (!isset($_SESSION['historial'])) {
            $_SESSION['historial'] = [];
        }
        array_unshift($_SESSION['historial'], $_SESSION['ultima_orden']);
        
        $_SESSION['carrito'] = [];
        header("Location: ticket.php?orden=$orden_id");
        exit;
    }
}

$total = array_sum(array_map(fn($item) => $item['precio'] * $item['cantidad'], $_SESSION['carrito']));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra | <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="assets/css/core.css">
    <style>
        .checkout-container {
            max-width: 1000px;
            margin: 2rem auto;
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 2rem;
        }
        .payment-section, .summary-section {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .section-title {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: var(--primary);
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--primary);
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark);
        }
        .form-control {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            transition: border 0.3s;
        }
        .form-control:focus {
            border-color: var(--primary);
            outline: none;
        }
        .payment-methods {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .payment-method {
            flex: 1;
            text-align: center;
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .payment-method.selected {
            border-color: var(--primary);
            background: #f0f7ff;
        }
        .payment-method input {
            display: none;
        }
        .card-icons {
            display: flex;
            gap: 10px;
            margin: 1rem 0;
        }
        .card-icons img {
            height: 30px;
        }
        .btn-pagar {
            background: var(--success);
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 4px;
            font-size: 1.1rem;
            cursor: pointer;
            width: 100%;
            margin-top: 1rem;
            transition: background 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .btn-pagar:hover {
            background: #3aa76d;
        }
        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 0.8rem 0;
            border-bottom: 1px solid #eee;
        }
        .order-total {
            font-weight: bold;
            font-size: 1.2rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 2px solid #eee;
        }
        .error-message {
            color: var(--danger);
            margin-bottom: 1rem;
            padding: 0.8rem;
            background: #fee2e2;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <?php include 'vistas/header.php'; ?>
    
    <main class="container">
        <h1 class="section-title">Finalizar Compra</h1>
        
        <?php if (isset($error)): ?>
            <div class="error-message"><?= $error ?></div>
        <?php endif; ?>
        
        <div class="checkout-container">
            <!-- Sección de Pago -->
            <div class="payment-section">
                <h2 class="section-title">Método de Pago</h2>
                
                <form method="POST" id="payment-form">
                    <div class="payment-methods">
                        <label class="payment-method" onclick="selectPayment('tarjeta')">
                            <input type="radio" name="metodo_pago" value="tarjeta" checked>
                            <i class="fas fa-credit-card" style="font-size: 1.5rem; margin-bottom: 0.5rem;"></i>
                            <div>Tarjeta débito</div>
                        </label>
                        
                        <label class="payment-method" onclick="selectPayment('tarjeta')">
                            <input type="radio" name="metodo_pago" value="tarjeta" checked>
                            <i class="fas fa-credit-card" style="font-size: 1.5rem; margin-bottom: 0.5rem;"></i>
                            <div>Tarjeta crédito</div>
                        </label>
                    </div>
                    
                    <div id="tarjeta-fields">
                        <div class="card-icons">
                            <img src="https://cdn-icons-png.flaticon.com/512/196/196578.png" alt="Visa">
                            <img src="https://cdn-icons-png.flaticon.com/512/196/196561.png" alt="Mastercard">
                            <img src="https://cdn-icons-png.flaticon.com/512/888/888870.png" alt="American Express">
                        </div>
                        
                        <div class="form-group">
                            <label for="tarjeta">Número de Tarjeta</label>
                            <input type="text" id="tarjeta" name="tarjeta" class="form-control" placeholder="1234 5678 9012 3456" maxlength="19">
                        </div>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label for="expiracion">Fecha de Expiración</label>
                                <input type="text" id="expiracion" name="expiracion" class="form-control" placeholder="MM/AA" maxlength="5">
                            </div>
                            
                            <div class="form-group">
                                <label for="cvv">CVV</label>
                                <input type="text" id="cvv" name="cvv" class="form-control" placeholder="123" maxlength="3">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="nombre-tarjeta">Nombre en la Tarjeta</label>
                            <input type="text" id="nombre-tarjeta" name="nombre-tarjeta" class="form-control" placeholder="JUAN PEREZ">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-pagar">
                        <i class="fas fa-lock"></i> Confirmar Pago - $<?= number_format($total, 2) ?>
                    </button>
                </form>
            </div>
            
            <!-- Resumen del Pedido -->
            <div class="summary-section">
                <h2 class="section-title">Resumen del Pedido</h2>
                
                <?php foreach ($_SESSION['carrito'] as $item): ?>
                    <div class="order-item">
                        <span><?= $item['nombre'] ?> x<?= $item['cantidad'] ?></span>
                        <span>$<?= number_format($item['precio'] * $item['cantidad'], 2) ?></span>
                    </div>
                <?php endforeach; ?>
                
                <div class="order-item">
                    <span>Envío</span>
                    <span>Gratis</span>
                </div>
                
                <div class="order-item order-total">
                    <span>Total</span>
                    <span>$<?= number_format($total, 2) ?></span>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Selección de método de pago
        function selectPayment(method) {
            document.querySelectorAll('.payment-method').forEach(el => {
                el.classList.remove('selected');
            });
            event.currentTarget.classList.add('selected');
            
            if (method === 'paypal') {
                document.getElementById('tarjeta-fields').style.display = 'none';
            } else {
                document.getElementById('tarjeta-fields').style.display = 'block';
            }
        }

        // Formatear número de tarjeta
        document.getElementById('tarjeta').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s+/g, '');
            if (value.length > 0) {
                value = value.match(new RegExp('.{1,4}', 'g')).join(' ');
            }
            e.target.value = value;
        });

        // Formatear fecha de expiración
        document.getElementById('expiracion').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            e.target.value = value;
        });
    </script>
</body>
</html>