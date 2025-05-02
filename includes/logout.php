<?php
session_start(); // Inicia la sesión (por si no se ha iniciado)

// Destruye todas las variables de sesión
$_SESSION = [];
session_unset();
session_destroy();

// Redirecciona al inicio
header("Location: ../index.php");
exit;
