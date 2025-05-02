<?php
// Verificar si existe stock temporal y no se ha solicitado reset
$temp_file = __DIR__ . '/stock-temporal.php';
if (file_exists($temp_file) && !isset($_SESSION['reset_stock'])) {
    return require $temp_file;
}

// Si se solicita resetear o no existe temporal, devolver original
unset($_SESSION['reset_stock']);
return [
    1 => [
        'id' => 1,
        'nombre' => 'Camiseta Minimalista',
        'precio' => 24.99,
        'imagen' => 'camiseta-minimal.jpg',
        'stock' => 50,
        'categorias' => ['camisetas', 'hombre'],
        'destacado' => true,
        'descripcion' => 'Camiseta de diseño limpio y moderno, ideal para cualquier ocasión.'
    ],
    2 => [
        'id' => 2,
        'nombre' => 'Jeans Slim Fit',
        'precio' => 59.99,
        'imagen' => 'jeans-slim.jpg',
        'stock' => 30,
        'categorias' => ['pantalones', 'hombre'],
        'destacado' => true,
        'descripcion' => 'Jeans ajustados que ofrecen comodidad y estilo en cada paso.'
    ],
    3 => [
        'id' => 3,
        'nombre' => 'Vestido Floral',
        'precio' => 45.50,
        'imagen' => 'vestido-floral.jpg',
        'stock' => 25,
        'categorias' => ['vestidos', 'mujer'],
        'destacado' => true,
        'descripcion' => 'Vestido con estampado floral fresco, perfecto para primavera y verano.'
    ],
    4 => [
        'id' => 4,
        'nombre' => 'Sudadera Oversize',
        'precio' => 39.99,
        'imagen' => 'sudadera-negra.jpg',
        'stock' => 40,
        'categorias' => ['abrigos', 'unisex'],
        'destacado' => false,
        'descripcion' => 'Sudadera holgada para un look urbano y cómodo durante todo el día.'
    ],
    5 => [
        'id' => 5,
        'nombre' => 'Zapatos Urbanos',
        'precio' => 79.99,
        'imagen' => 'zapatos-urbanos.jpg',
        'stock' => 20,
        'categorias' => ['calzado', 'hombre'],
        'destacado' => true,
        'descripcion' => 'Zapatos modernos ideales para recorridos urbanos y estilo casual.'
    ],
    6 => [
        'id' => 6,
        'nombre' => 'Bolso Bandolera',
        'precio' => 35.00,
        'imagen' => 'bolso-bandolera.jpg',
        'stock' => 15,
        'categorias' => ['accesorios', 'mujer'],
        'destacado' => false,
        'descripcion' => 'Bolso práctico y elegante, perfecto para el día a día.'
    ]
];
