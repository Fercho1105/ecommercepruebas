<?php
session_start();
require 'includes/config.php';

// Marcar para resetear stock
$_SESSION['reset_stock'] = true;

// Eliminar archivo temporal si existe
if (file_exists(__DIR__ . '/stock-temporal.php')) {
    unlink(__DIR__ . '/stock-temporal.php');
}

// Redirigir al index con mensaje
$_SESSION['mensaje'] = 'Stock restablecido correctamente';
header('Location: index.php');
exit;
?>