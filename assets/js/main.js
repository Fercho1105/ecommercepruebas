// Filtros de categoría
document.querySelectorAll('.filtro-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        // Remover clase active de todos los botones
        document.querySelectorAll('.filtro-btn').forEach(b => {
            b.classList.remove('active');
        });
        
        // Añadir clase active al botón clickeado
        btn.classList.add('active');
        
        const categoria = btn.dataset.categoria;
        filterProducts(categoria);
    });
});

function filterProducts(categoria) {
    const productos = document.querySelectorAll('.product-card');
    
    productos.forEach(producto => {
        if (categoria === 'todos') {
            producto.style.display = 'block';
        } else {
            producto.style.display = producto.dataset.categorias.includes(categoria) 
                ? 'block' 
                : 'none';
        }
    });
}

