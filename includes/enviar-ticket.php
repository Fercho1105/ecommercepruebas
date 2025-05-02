<?php
require 'config.php';
require __DIR__ . '/../vendor/autoload.php';


// Solo ejecutar si hay una orden reciente
if (empty($_SESSION['ultima_orden'])) {
    die('No hay orden para enviar');
}

$orden = $_SESSION['ultima_orden'];
$usuario = $_SESSION['usuario'];

// Configuración de PHPMailer (usa Mailtrap para pruebas)
$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->isSMTP();
$mail->Host = 'sandbox.smtp.mailtrap.io';
$mail->SMTPAuth = true;
$mail->Username = '70dcb67cada34c'; // Regístrate en mailtrap.io para obtener credenciales
$mail->Password = '48649fc6a5a7e8';
$mail->Port = 2525;

// Contenido del correo
$mail->setFrom('no-reply@' . strtolower(SITE_NAME) . '.com', SITE_NAME);
$mail->addAddress($usuario['email'], $usuario['nombre']);
$mail->Subject = 'Tu ticket de compra #' . $orden['id'];

// Generar HTML del ticket
ob_start();
include __DIR__ . '/../mail/ticket-template.php';

$html = ob_get_clean();

$mail->msgHTML($html);

if ($mail->send()) {
    unset($_SESSION['carrito']);
    $_SESSION['email_enviado'] = true;

    // Mostrar mensaje y redirigir con delay
    echo '
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Enviando ticket...</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                text-align: center;
                padding: 50px;
            }
            .alert {
                display: inline-block;
                padding: 20px;
                background-color: #d4edda;
                color: #155724;
                border: 1px solid #c3e6cb;
                border-radius: 5px;
                font-size: 1.2em;
            }
        </style>
        <script>
            setTimeout(function() {
                window.location.href = "../index.php?reload=" + new Date().getTime();
            }, 3000); // 3000 ms = 3 segundos
        </script>
    </head>
    <body>
        <div class="alert">
            ✅ Ticket enviado exitosamente. Redirigiendo al menú...
        </div>
    </body>
    </html>';
    exit;
} else {
    echo 'Error al enviar: ' . $mail->ErrorInfo;
}