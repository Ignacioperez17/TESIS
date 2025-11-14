<?php
session_start();
require_once("conexion.php");

// Verificar sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Venta - SFI</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            background-color: #343a40;
            height: 100vh;
            color: white;
            position: fixed;
            width: 240px;
            top: 0;
            left: 0;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .main-content {
            margin-left: 255px;
            padding: 20px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>


<!-- =============== CONTENIDO PRINCIPAL =============== -->
<div class="main-content">

    <h2 class="mb-3">💰 Registrar Venta</h2>
    <p class="text-muted">Complete los datos para registrar una nueva venta.</p>

    <!-- CARD DE CLIENTE -->
    <div class="card p-4 mb-4">
        <h4 class="mb-3">🧍 Datos del Cliente</h4>

        <div class="row">
            <div class="col-md-6">
                <label>Seleccione un cliente</label>
                <select id="cliente" class="form-control">
                    <option value="">-- Seleccione --</option>

                    <?php
                    $clientes = $conn->query("SELECT * FROM clientes ORDER BY nombre ASC");
                    while ($c = $clientes->fetch_assoc()) {
                        echo "<option value='{$c['id']}'>{$c['nombre']} - {$c['documento']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-6">
                <label class="d-block">Nuevo Cliente</label>
                <a href="clientes.php" class="btn btn-success">Registrar Cliente</a>
            </div>
        </div>
    </div>

    <!-- CARD DE PRODUCTOS -->
    <div class="card p-4 mb-4">
        <h4>📦 Productos</h4>

        <div class="input-group mb-3">
            <input type="text" id="buscar_producto" class="form-control" placeholder="Buscar producto por nombre...">
            <button class="btn btn-primary" id="btnBuscar">Buscar</button>
        </div>

        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Agregar</th>
                </tr>
            </thead>
            <tbody id="tablaProductos"></tbody>
        </table>
    </div>

    <!-- CARRITO -->
    <div class="card p-4">
        <h4>🛒 Carrito de Venta</h4>

        <table class="table table-bordered text-center">
            <thead class="table-secondary">
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                    <th>Quitar</th>
                </tr>
            </thead>
            <tbody id="tablaCarrito"></tbody>
        </table>

        <h3 class="text-end">Total: S/. <span id="total">0.00</span></h3>

        <button class="btn btn-success w-100 mt-3" id="btnRegistrarVenta">Registrar Venta</button>
    </div>

</div>

<script src="ventas.js"></script>
</body>
</html>


