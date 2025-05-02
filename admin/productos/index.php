<?php
require '../../includes/config.php';

// Solo admin puede acceder
if ($_SESSION['usuario']['rol'] !== 'admin') {
    header('Location: ../../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Productos | <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="../../assets/css/core.css">
</head>
<body>
    <?php include '../../vistas/header-admin.php'; ?>
    
    <div class="admin-container">
        <h1>Gestión de Productos</h1>
        <a href="editar.php" class="btn">Nuevo Producto</a>
        
        <table class="product-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($GLOBALS['config']['productos'] as $producto): ?>
                <tr>
                    <td><?= $producto['id'] ?></td>
                    <td><img src="../../assets/img/productos/<?= $producto['imagen'] ?>" width="50"></td>
                    <td><?= $producto['nombre'] ?></td>
                    <td>$<?= $producto['precio'] ?></td>
                    <td>
                        <a href="editar.php?id=<?= $producto['id'] ?>">Editar</a>
                        <a href="eliminar.php?id=<?= $producto['id'] ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>