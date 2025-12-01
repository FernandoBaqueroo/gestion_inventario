<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket de Venta #<?= $sale['id'] ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        @media print {
            .no-print { display: none; }
            body { font-size: 12px; }
        }
        .ticket-container {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 2px solid #ddd;
            font-family: 'Courier New', monospace;
        }
        .ticket-header {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .ticket-footer {
            text-align: center;
            border-top: 2px dashed #000;
            padding-top: 10px;
            margin-top: 15px;
        }
        .ticket-table {
            width: 100%;
            font-size: 12px;
        }
        .ticket-table td {
            padding: 5px 0;
        }
        .total-row {
            font-size: 16px;
            font-weight: bold;
            border-top: 2px solid #000;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="ticket-container">
        <!-- Header del Ticket -->
        <div class="ticket-header">
            <h3>SISTEMA DE INVENTARIO</h3>
            <p class="mb-0">Ticket de Venta</p>
            <p class="mb-0">#<?= str_pad($sale['id'], 6, '0', STR_PAD_LEFT) ?></p>
        </div>

        <!-- Información de la venta -->
        <table class="ticket-table">
            <tr>
                <td><strong>Fecha:</strong></td>
                <td class="text-end"><?= date('d/m/Y H:i', strtotime($sale['sale_date'])) ?></td>
            </tr>
            <tr>
                <td><strong>Vendedor:</strong></td>
                <td class="text-end"><?= htmlspecialchars($sale['username']) ?></td>
            </tr>
        </table>

        <hr>

        <!-- Productos -->
        <table class="ticket-table">
            <thead>
                <tr style="border-bottom: 1px solid #000;">
                    <th>Producto</th>
                    <th class="text-center">Cant.</th>
                    <th class="text-end">Precio</th>
                    <th class="text-end">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sale['details'] as $detail): ?>
                <tr>
                    <td>
                        <?= htmlspecialchars($detail['product_name']) ?><br>
                        <small class="text-muted"><?= htmlspecialchars($detail['code']) ?></small>
                    </td>
                    <td class="text-center"><?= $detail['quantity'] ?></td>
                    <td class="text-end">$<?= number_format($detail['price'], 2) ?></td>
                    <td class="text-end">$<?= number_format($detail['subtotal'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Total -->
        <div class="total-row mt-3">
            <table class="ticket-table">
                <tr>
                    <td><strong>TOTAL:</strong></td>
                    <td class="text-end"><strong>$<?= number_format($sale['total'], 2) ?></strong></td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="ticket-footer">
            <p class="mb-1">¡Gracias por su compra!</p>
            <p class="mb-0"><small>www.sistemaInventario.com</small></p>
        </div>
    </div>

    <!-- Botones de acción (no se imprimen) -->
    <div class="text-center mt-4 no-print">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="bi bi-printer"></i> Imprimir
        </button>
        <a href="/GestionInventario/public/sale/show/<?= $sale['id'] ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
        <button onclick="window.close()" class="btn btn-secondary">
            <i class="bi bi-x-circle"></i> Cerrar
        </button>
    </div>

</body>
</html>

