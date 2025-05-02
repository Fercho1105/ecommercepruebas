<header class="header">
    <div class="container">
        <a href="../index.php" class="logo"><?= SITE_NAME ?></a>
        <nav class="navbar">
            <a href="../index.php"><i class="fas fa-home"></i> Inicio</a>
            <a href="../carrito.php"><i class="fas fa-shopping-cart"></i> Carrito (<span id="cart-count"><?= isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0 ?></span>)</a>
            
            <?php if (isset($_SESSION['usuario'])) : ?>
                <a href="historial.php"><i class="fas fa-history"></i> Historial</a>
                <a href="includes/logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
            <?php else : ?>
                <a href="../auth/login.php"><i class="fas fa-user"></i> Ingresar</a>
            <?php endif; ?>
        </nav>
    </div>
    
</header>