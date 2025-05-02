<?php
require '../../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../auth/login.php');
    exit;
}

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = $_POST['password'];

// Validar credenciales (simulado)
$usuarioValido = false;
foreach ($GLOBALS['config']['usuarios'] as $userEmail => $userData) {
    if ($email === $userEmail && $password === $userData['password']) {
        $_SESSION['usuario'] = [
            'email' => $email,
            'nombre' => $userData['nombre'],
            'rol' => $userData['rol']
        ];
        $usuarioValido = true;
        break;
    }
}

if (!$usuarioValido) {
    header('Location: ../../auth/login.php?error=Credenciales incorrectas');
    exit;
}

header('Location: ../../index.php');