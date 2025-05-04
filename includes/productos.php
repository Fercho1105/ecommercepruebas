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
    ],
    7 => [
        'id' => 7,
        'nombre' => 'Camisa de Lino',
        'precio' => 49.99,
        'imagen' => 'camisa-lino.jpg',
        'stock' => 22,
        'categorias' => ['camisas', 'hombre'],
        'destacado' => true,
        'descripcion' => 'Ligera y transpirable, ideal para días cálidos.'
    ],
    8 => [
        'id' => 8,
        'nombre' => 'Falda Plisada',
        'precio' => 42.00,
        'imagen' => 'falda-plisada.jpg',
        'stock' => 18,
        'categorias' => ['faldas', 'mujer'],
        'destacado' => false,
        'descripcion' => 'Estilo clásico con un toque moderno.'
    ],
    9 => [
        'id' => 9,
        'nombre' => 'Gorra Casual',
        'precio' => 15.99,
        'imagen' => 'gorra-casual.jpg',
        'stock' => 35,
        'categorias' => ['accesorios', 'unisex'],
        'destacado' => false,
        'descripcion' => 'Complemento ideal para un look relajado.'
    ],
    10 => [
        'id' => 10,
        'nombre' => 'Chaqueta Denim',
        'precio' => 64.50,
        'imagen' => 'chaqueta-denim.jpg',
        'stock' => 12,
        'categorias' => ['abrigos', 'mujer'],
        'destacado' => true,
        'descripcion' => 'Chaqueta de mezclilla resistente y con estilo.'
    ],
    11 => [
        'id' => 11,
        'nombre' => 'Pantalón Cargo',
        'precio' => 54.75,
        'imagen' => 'pantalon-cargo.jpg',
        'stock' => 28,
        'categorias' => ['pantalones', 'hombre'],
        'destacado' => false,
        'descripcion' => 'Cómodo y funcional para el día a día.'
    ],
    12 => [
        'id' => 12,
        'nombre' => 'Botines Cuero',
        'precio' => 89.99,
        'imagen' => 'botines-cuero.jpg',
        'stock' => 10,
        'categorias' => ['calzado', 'mujer'],
        'destacado' => true,
        'descripcion' => 'Elegancia y durabilidad en un solo diseño.'
    ],
    13 => [
        'id' => 13,
        'nombre' => 'Blusa Satinada',
        'precio' => 39.90,
        'imagen' => 'blusa-satinada.jpg',
        'stock' => 14,
        'categorias' => ['blusas', 'mujer'],
        'destacado' => false,
        'descripcion' => 'Suave al tacto y perfecta para ocasiones especiales.'
    ],
    14 => [
        'id' => 14,
        'nombre' => 'Short Deportivo',
        'precio' => 21.50,
        'imagen' => 'short-deportivo.jpg',
        'stock' => 27,
        'categorias' => ['pantalones', 'unisex'],
        'destacado' => false,
        'descripcion' => 'Ideal para entrenamientos o días calurosos.'
    ],
    15 => [
        'id' => 15,
        'nombre' => 'Sombrero Playa',
        'precio' => 18.00,
        'imagen' => 'sombrero-playa.jpg',
        'stock' => 19,
        'categorias' => ['accesorios', 'mujer'],
        'destacado' => false,
        'descripcion' => 'Protégete del sol con estilo.'
    ],
    16 => [
        'id' => 16,
        'nombre' => 'Sudadera con Capucha',
        'precio' => 44.99,
        'imagen' => 'sudadera-capucha.jpg',
        'stock' => 23,
        'categorias' => ['abrigos', 'unisex'],
        'destacado' => true,
        'descripcion' => 'Abrigo cómodo para cualquier clima.'
    ],
    17 => [
        'id' => 17,
        'nombre' => 'Lentes de Sol Retro',
        'precio' => 29.90,
        'imagen' => 'lentes-retro.jpg',
        'stock' => 45,
        'categorias' => ['accesorios', 'unisex'],
        'destacado' => false,
        'descripcion' => 'Estilo vintage para un look moderno.'
    ],
    18 => [
        'id' => 18,
        'nombre' => 'Polo Clásico',
        'precio' => 34.99,
        'imagen' => 'polo-clasico.jpg',
        'stock' => 32,
        'categorias' => ['camisas', 'hombre'],
        'destacado' => true,
        'descripcion' => 'Un básico elegante para tu armario.'
    ],
    19 => [
        'id' => 19,
        'nombre' => 'Mono Enterizo',
        'precio' => 59.90,
        'imagen' => 'mono-enterizo.jpg',
        'stock' => 16,
        'categorias' => ['vestidos', 'mujer'],
        'destacado' => true,
        'descripcion' => 'Ideal para eventos o salidas casuales.'
    ],
    20 => [
        'id' => 20,
        'nombre' => 'Zapatillas Running',
        'precio' => 74.95,
        'imagen' => 'zapatillas-running.jpg',
        'stock' => 20,
        'categorias' => ['calzado', 'unisex'],
        'destacado' => false,
        'descripcion' => 'Comodidad y soporte para tus entrenamientos.'
    ],
    21 => [
        'id' => 21,
        'nombre' => 'Chamarra Rompevientos',
        'precio' => 52.99,
        'imagen' => 'chamarra-rompevientos.jpg',
        'stock' => 17,
        'categorias' => ['abrigos', 'hombre'],
        'destacado' => true,
        'descripcion' => 'Ligera, resistente y perfecta para el clima impredecible.'
    ]
];
