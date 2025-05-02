// Añadir al carrito
document.querySelectorAll('.btn-add-to-cart').forEach(button => {
    button.addEventListener('click', async (e) => {
        const productId = e.target.dataset.id;
        const button = e.target;
        
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Agregando...';
        
        try {
            const response = await fetch('includes/agregar-carrito.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: productId })
            });
            
            const result = await response.json();
            
            if (result.success) {
                document.getElementById('cart-count').textContent = result.cart_count;
                button.innerHTML = '<i class="fas fa-check"></i> Añadido';
                
                // Mostrar notificación
                showNotification(`${result.product_name} añadido al carrito`);
                
                setTimeout(() => {
                    button.innerHTML = '<i class="fas fa-cart-plus"></i> Añadir al carrito';
                    button.disabled = false;
                }, 2000);
            } else {
                showNotification(result.error || 'Error al agregar al carrito', 'error');
                button.innerHTML = '<i class="fas fa-cart-plus"></i> Añadir al carrito';
                button.disabled = false;
            }
        } catch (error) {
            console.error('Error:', error);
            showNotification('Error de conexión. Intenta nuevamente.', 'error');
            button.innerHTML = '<i class="fas fa-cart-plus"></i> Añadir al carrito';
            button.disabled = false;
        }
    });
});

// Función para mostrar notificaciones
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('fade-out');
        setTimeout(() => notification.remove(), 500);
    }, 3000);
}

// Actualizar cantidades en el carrito
document.querySelectorAll('.quantity-btn').forEach(button => {
    button.addEventListener('click', async function() {
        const item = this.closest('.cart-item');
        const productId = item.dataset.id;
        const action = this.classList.contains('plus') ? 'increase' : 'decrease';
        
        this.disabled = true;
        
        try {
            const response = await fetch('includes/actualizar-carrito.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: productId, action })
            });
            
            const result = await response.json();
            
            if (result.success) {
                if (result.removed) {
                    item.remove();
                    document.getElementById('cart-count').textContent = result.cart_count;
                } else {
                    item.querySelector('.item-quantity span').textContent = result.new_quantity;
                    item.querySelector('.item-total').textContent = '$' + result.item_total;
                }
                
                document.querySelector('.cart-total span').textContent = '$' + result.subtotal;
                document.getElementById('cart-count').textContent = result.cart_count;
                
                if (result.cart_count === 0) {
                    document.querySelector('.cart-items').innerHTML = 
                        '<p class="empty-cart">Tu carrito está vacío</p>';
                }
            } else {
                showNotification(result.message || 'Error al actualizar', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showNotification('Error de conexión', 'error');
        } finally {
            this.disabled = false;
        }
    });
});

// Eliminar items del carrito
document.querySelectorAll('.remove-item').forEach(button => {
    button.addEventListener('click', async function() {
        const item = this.closest('.cart-item');
        const productId = item.dataset.id;
        
        if (confirm('¿Eliminar este producto del carrito?')) {
            try {
                const response = await fetch('includes/eliminar-carrito.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: productId })
                });
                
                const result = await response.json();
                if (result.success) {
                    item.remove();
                    document.querySelector('.cart-total span').textContent = '$' + result.new_total;
                    document.getElementById('cart-count').textContent = result.cart_count;
                    
                    if (result.cart_count === 0) {
                        document.querySelector('.cart-items').innerHTML = 
                            '<p class="empty-cart">Tu carrito está vacío</p>';
                    }
                    
                    showNotification('Producto eliminado del carrito');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Error al eliminar', 'error');
            }
        }
    });
});