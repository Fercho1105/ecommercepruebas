<?php
session_start();
require 'config.php';

// Solo permitir acceso si hay stock temporal guardado
if (!isset($_SESSION['stock-temporal'])) {
    header('Location: index.php');
    exit;
}

// Actualizar el array de productos con los valores temporales
$productos = $_SESSION['stock-temporal'];

// Guardar en un archivo temporal (para persistencia entre sesiones)
file_put_contents(__DIR__ . '/stock-temporal.php', '<?php return ' . var_export($productos, true) . ';');

// Redirigir al index con mensaje
$_SESSION['mensaje'] = 'Stock actualizado temporalmente';
header('Location: index.php');
exit;
?>