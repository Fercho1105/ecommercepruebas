<?php
require 'includes/config.php';

// Inicializar variable de sesión para controlar resets
if (!isset($_SESSION['pagina_cargada'])) {
    $_SESSION['reset_stock'] = true;
    $_SESSION['pagina_cargada'] = true;
}

if (!isset($_SESSION['carrito']) || !is_array($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}
$cuantos = count($_SESSION['carrito']);

// Cargar productos (se maneja automáticamente en productos.php)
$productosMostrar = $GLOBALS['config']['productos'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?> - Tienda de Moda</title>
    <link rel="stylesheet" href="assets/css/core.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .header .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            padding: 1rem 2;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 2rem; /* Espacio entre logo y navegación */
            flex-wrap: wrap;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--primary);
            text-decoration: none;
        }

        .navbar {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .auth-links {
            margin-left: 2rem;
        }

        .search-container {
            margin-left: auto;
        }

        .search-form {
            display: flex;
            align-items: center;
        }

        .search-form input {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            border-radius: 20px 0 0 20px;
            min-width: 200px;
        }

        .search-form button {
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 0 20px 20px 0;
            padding: 0.5rem 1rem;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .header .container {
                flex-direction: column;
                align-items: flex-start;
            }

            .search-container {
                width: 100%;
                margin-top: 1rem;
            }

            .search-form input {
                width: 100%;
            }

            .navbar, .auth-links {
                flex-direction: column;
                gap: 0.5rem;
                margin-top: 0.5rem;
            }
        }
    </style>

</head>
<body>
    <!-- Header con buscador a la derecha -->
    <header class="header">
        <div class="container">
            <div class="header-left">
                <a href="index.php" class="logo"><?= SITE_NAME ?></a>
                <nav class="navbar">
                    <a href="index.php"><i class="fas fa-home"></i> Inicio</a>
                    <a href="carrito.php"><i class="fas fa-shopping-cart"></i> Carrito (<span id="cart-count"><?= $cuantos ?></span>)</a>

                </nav>
            </div>
            
            
            
            <nav class="navbar auth-links">
            <?php if (isset($_SESSION['usuario'])) : ?>
                <a href="historial.php"><i class="fas fa-history"></i> Historial</a>
                <a href="includes/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
                <span style="margin-left: 10px; font-weight: bold; color: var(--primary);">
                    Bienvenido <?= htmlspecialchars($_SESSION['usuario']['nombre']) ?>
                </span>
            <?php else : ?>
                <a href="auth/login.php"><i class="fas fa-user"></i> Ingresar</a>
            <?php endif; ?>

            </nav>


            <!-- Buscador a la derecha -->
            <div class="search-container">
                <form action="index.php" method="get" class="search-form">
                    <input 
                        type="text" 
                        name="q" 
                        placeholder="Buscar productos..." 
                        value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
                    >
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
    </header>

    <!-- Hero Banner -->
    <section class="hero">
        <div class="container">
            <h1>Nueva Colección Primavera/Verano</h1>
            <p>Envíos gratis en compras mayores a $20</p>
        </div>
    </section>

    <!-- Productos con filtro -->
    <main class="container">
        <h2 class="section-title">Nuestros Productos</h2>
        
        <?php 
        $searchTerm = $_GET['q'] ?? '';
        
        // Filtrar los productos mostrados (usando $productosMostrar)
        if (!empty($searchTerm)) {
            $productosFiltrados = array_filter($productosMostrar, function($producto) use ($searchTerm) {
                $enNombre = stripos($producto['nombre'], $searchTerm) !== false;
                $enCategorias = stripos(implode(' ', $producto['categorias']), $searchTerm) !== false;
                return $enNombre || $enCategorias;
            });
            
            echo '<p class="search-results">Mostrando resultados para: <strong>"' . htmlspecialchars($searchTerm) . '"</strong></p>';
        } else {
            $productosFiltrados = $productosMostrar;
        }
        ?>
        
        <div class="product-grid">
            <?php if (empty($productosFiltrados)): ?>
                <p class="no-results">No se encontraron productos. <a href="index.php">Ver todos</a></p>
            <?php else: ?>
                <?php foreach ($productosFiltrados as $producto): ?>
                    <div class="product-card" data-categorias="<?= implode(' ', $producto['categorias']) ?>">
                        <div class="product-img">
                            <img src="assets/img/productos/<?= $producto['imagen'] ?>" alt="<?= $producto['nombre'] ?>">
                            <?php if ($producto['destacado']): ?>
                                <div class="product-badge">Destacado</div>
                            <?php endif; ?>
                        </div>
                        <div class="product-info">
                            <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
                            <p class="product-description"><?= htmlspecialchars($producto['descripcion']) ?></p>
                            <div class="product-price">$<?= number_format($producto['precio'], 2) ?></div>
                            <div class="product-stock <?= $producto['stock'] <= 0 ? 'out-of-stock' : '' ?>">
                                <?= $producto['stock'] <= 0 ? 'AGOTADO' : $producto['stock'] . ' disponibles' ?>
                            </div>
                            <button class="btn-add-to-cart" data-id="<?= $producto['id'] ?>" <?= $producto['stock'] <= 0 ? 'disabled' : '' ?>>
                                <i class="fas fa-cart-plus"></i> Añadir al carrito
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-section">
                <h3>Contacto</h3>
                <p>contacto@<?= strtolower(SITE_NAME) ?>.com</p>
            </div>
            <div class="footer-section">
                <h3>Síguenos</h3>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-facebook"></i></a>
                </div>
            </div>
        </div>
        <p class="copyright">&copy; <?= date('Y') ?> <?= SITE_NAME ?>. Todos los derechos reservados.</p>
    </footer>

    
    <script src="assets/js/carrito.js"></script>
    <script>
    // Detectar cierre de pestaña/ventana
    window.addEventListener('beforeunload', function() {
        // Enviar petición para marcar reset (no esperar respuesta)
        navigator.sendBeacon('includes/session-reset.php');
    });
    </script>

    
</body>
</html>