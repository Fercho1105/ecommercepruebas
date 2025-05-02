<?php
// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_lifetime' => 86400,      // 1 día
        'cookie_httponly' => true,       // Seguridad
        'cookie_samesite' => 'Strict'    // Prevenir CSRF
    ]);
}

// Configuración global
define('SITE_NAME', 'ModaStyle');
define('BASE_URL', 'http://localhost/ecomsinmysql');
define('DEBUG_MODE', true);

// Simulación de datos (sin DB)
$GLOBALS['config'] = [
    'usuarios' => [
        'usuario@modastyle.com' => [
            'nombre' => 'Usuario Ejemplo',
            'password' => 'moda123',  
            'rol' => 'admin'
        ],
        'ejemplo2@modastyle.com' => [
            'nombre' => 'Cliente Ejemplo',
            'password' => 'cliente123',
            'rol' => 'user'
        ]
    ],
    'productos' => require __DIR__ . '/productos.php' 
    ,
    'carrito' => [
        'max_items' => 100,
        'iva' => 0.19 
    ]
];

// Función para proteger rutas
function requiereAutenticacion($rol = 'user') {
    if (!isset($_SESSION['usuario']) || 
        ($rol === 'admin' && $_SESSION['usuario']['rol'] !== 'admin')) {
        header('Location: ' . BASE_URL . '/auth/login.php');
        exit;
    }
}

// Autocargador de clases (si usas POO)
spl_autoload_register(function($clase) {
    $archivo = __DIR__ . '/clases/' . $clase . '.php';
    if (file_exists($archivo)) {
        require $archivo;
    }
});

// Helper para redirecciones
function redirect($url, $statusCode = 303) {
    header('Location: ' . BASE_URL . '/' . ltrim($url, '/'), true, $statusCode);
    exit;
}

// Mostrar errores en desarrollo
if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
?>