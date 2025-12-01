<?php require_once '../app/views/layouts/header.php'; ?>
<?php require_once '../app/views/layouts/sidebar.php'; ?>

<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Punto de Venta</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="/GestionInventario/public/">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="/GestionInventario/public/sale">Ventas</a></li>
                    <li class="breadcrumb-item active">Nueva Venta</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="app-content">
    <div class="container-fluid">
        
        <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <div class="row">
            <!-- Columna izquierda: Búsqueda y productos -->
            <div class="col-md-7">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-search"></i> Buscar Productos
                        </h3>
                    </div>
                    <div class="card-body">
                        <!-- Buscador -->
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                            <input type="text" 
                                   class="form-control form-control-lg" 
                                   id="productSearch" 
                                   placeholder="Buscar por código o nombre..."
                                   autocomplete="off">
                        </div>

                        <!-- Resultados de búsqueda -->
                        <div id="searchResults" class="list-group"></div>
                    </div>
                </div>
            </div>

            <!-- Columna derecha: Carrito -->
            <div class="col-md-5">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-cart"></i> Carrito de Venta
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-sm btn-danger" id="clearCart">
                                <i class="bi bi-trash"></i> Vaciar
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cant.</th>
                                    <th>Precio</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="cartItems">
                                <tr id="emptyCart">
                                    <td colspan="5" class="text-center text-muted">
                                        <i class="bi bi-cart-x fs-3"></i>
                                        <p>Carrito vacío</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">TOTAL:</h5>
                            <h3 class="mb-0 text-success">$<span id="totalAmount">0.00</span></h3>
                        </div>
                        <button type="button" class="btn btn-success btn-lg w-100" id="processButton" disabled>
                            <i class="bi bi-check-circle"></i> Procesar Venta
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulario oculto para enviar -->
        <form id="saleForm" action="/GestionInventario/public/sale/store" method="POST" style="display: none;">
            <input type="hidden" name="items" id="itemsInput">
        </form>

    </div>
</div>

<?php
ob_start();
?>
<script>
$(document).ready(function() {
    let cart = [];
    let searchTimeout;

    // Búsqueda de productos
    $('#productSearch').on('input', function() {
        clearTimeout(searchTimeout);
        const search = $(this).val().trim();

        if (search.length < 2) {
            $('#searchResults').html('');
            return;
        }

        searchTimeout = setTimeout(function() {
            $.ajax({
                url: '/GestionInventario/public/sale/searchProducts',
                method: 'GET',
                data: { q: search },
                dataType: 'json',
                success: function(products) {
                    displaySearchResults(products);
                },
                error: function() {
                    $('#searchResults').html('<div class="alert alert-danger">Error al buscar productos</div>');
                }
            });
        }, 300);
    });

    // Mostrar resultados de búsqueda
    function displaySearchResults(products) {
        if (products.length === 0) {
            $('#searchResults').html('<div class="list-group-item text-muted">No se encontraron productos</div>');
            return;
        }

        let html = '';
        products.forEach(function(product) {
            html += `
                <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center add-product" 
                        data-id="${product.id}"
                        data-code="${product.code}"
                        data-name="${product.name}"
                        data-price="${product.price}"
                        data-stock="${product.stock}">
                    <div>
                        <strong>${product.name}</strong><br>
                        <small class="text-muted">Código: ${product.code} | Stock: ${product.stock}</small>
                    </div>
                    <div>
                        <span class="badge text-bg-success">$${parseFloat(product.price).toFixed(2)}</span>
                    </div>
                </button>
            `;
        });

        $('#searchResults').html(html);
    }

    // Agregar producto al carrito
    $(document).on('click', '.add-product', function() {
        const product = {
            id: $(this).data('id'),
            code: $(this).data('code'),
            name: $(this).data('name'),
            price: parseFloat($(this).data('price')),
            stock: parseInt($(this).data('stock')),
            quantity: 1
        };

        // Verificar si ya está en el carrito
        const existingIndex = cart.findIndex(item => item.id === product.id);
        
        if (existingIndex >= 0) {
            // Si ya existe, aumentar cantidad (si hay stock)
            if (cart[existingIndex].quantity < product.stock) {
                cart[existingIndex].quantity++;
            } else {
                alert('Stock insuficiente');
                return;
            }
        } else {
            cart.push(product);
        }

        updateCart();
        $('#productSearch').val('');
        $('#searchResults').html('');
    });

    // Actualizar carrito
    function updateCart() {
        const cartBody = $('#cartItems');
        
        if (cart.length === 0) {
            cartBody.html(`
                <tr id="emptyCart">
                    <td colspan="5" class="text-center text-muted">
                        <i class="bi bi-cart-x fs-3"></i>
                        <p>Carrito vacío</p>
                    </td>
                </tr>
            `);
            $('#totalAmount').text('0.00');
            $('#processButton').prop('disabled', true);
            return;
        }

        let html = '';
        let total = 0;

        cart.forEach(function(item, index) {
            const subtotal = item.price * item.quantity;
            total += subtotal;

            html += `
                <tr>
                    <td>
                        <small><strong>${item.name}</strong></small><br>
                        <small class="text-muted">${item.code}</small>
                    </td>
                    <td>
                        <div class="input-group input-group-sm" style="width: 90px;">
                            <button class="btn btn-outline-secondary decrease-qty" data-index="${index}" type="button">-</button>
                            <input type="text" class="form-control text-center" value="${item.quantity}" readonly style="max-width: 40px;">
                            <button class="btn btn-outline-secondary increase-qty" data-index="${index}" type="button">+</button>
                        </div>
                    </td>
                    <td><small>$${item.price.toFixed(2)}</small></td>
                    <td><strong>$${subtotal.toFixed(2)}</strong></td>
                    <td>
                        <button class="btn btn-sm btn-danger remove-item" data-index="${index}">
                            <i class="bi bi-x"></i>
                        </button>
                    </td>
                </tr>
            `;
        });

        cartBody.html(html);
        $('#totalAmount').text(total.toFixed(2));
        $('#processButton').prop('disabled', false);
    }

    // Aumentar cantidad
    $(document).on('click', '.increase-qty', function() {
        const index = $(this).data('index');
        if (cart[index].quantity < cart[index].stock) {
            cart[index].quantity++;
            updateCart();
        } else {
            alert('Stock insuficiente');
        }
    });

    // Disminuir cantidad
    $(document).on('click', '.decrease-qty', function() {
        const index = $(this).data('index');
        if (cart[index].quantity > 1) {
            cart[index].quantity--;
            updateCart();
        }
    });

    // Eliminar item
    $(document).on('click', '.remove-item', function() {
        const index = $(this).data('index');
        cart.splice(index, 1);
        updateCart();
    });

    // Vaciar carrito
    $('#clearCart').on('click', function() {
        if (confirm('¿Vaciar todo el carrito?')) {
            cart = [];
            updateCart();
        }
    });

    // Procesar venta
    $('#processButton').on('click', function() {
        if (cart.length === 0) {
            alert('El carrito está vacío');
            return;
        }

        if (confirm('¿Confirmar venta por $' + $('#totalAmount').text() + '?')) {
            // Preparar items para enviar
            const items = cart.map(item => ({
                product_id: item.id,
                quantity: item.quantity,
                price: item.price
            }));

            $('#itemsInput').val(JSON.stringify(items));
            $('#saleForm').submit();
        }
    });

    // Atajo: Enter en búsqueda selecciona primer resultado
    $('#productSearch').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('.add-product').first().click();
        }
    });
});
</script>
<?php
$pageScripts = ob_get_clean();
?>

<?php require_once '../app/views/layouts/footer.php'; ?>

