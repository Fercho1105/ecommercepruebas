<?php
require '../includes/config.php';

if (isset($_SESSION['usuario'])) {
    header('Location: ../index.php');
    exit;
}

$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login | <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="../assets/css/core.css">
    <style>
        .auth-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 70vh;
        }

        .login-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .login-card h2 {
            margin-bottom: 1rem;
            color: var(--primary);
        }

        .login-card form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .login-card input {
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        .login-card button {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.9rem;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }

        .login-card button:hover {
            background: var(--secondary);
        }

        .login-card p {
            margin-top: 1rem;
            font-size: 0.95rem;
        }

        .login-card a {
            color: var(--primary);
            text-decoration: none;
        }

        .alert.error {
            background: var(--danger);
            color: white;
            padding: 0.7rem;
            margin-bottom: 1rem;
            border-radius: 5px;
            font-weight: bold;
        }

        @media (max-width: 500px) {
            .login-card {
                margin: 1rem;
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <?php include '../vistas/header.php'; ?>

    <main class="auth-container">
        <div class="login-card">
            <h2>Iniciar Sesión</h2>
            <?php if ($error): ?>
                <div class="alert error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form action="../includes/auth/login.php" method="POST">
                <input type="email" name="email" placeholder="Correo electrónico" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <button type="submit">Ingresar</button>
            </form>

            <p>¿No tienes cuenta? <a href="#">Regístrate</a></p>
        </div>
    </main>
</body>
</html>
