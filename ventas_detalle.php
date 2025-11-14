<?php require "layout/header.php"; ?>
<?php require "conexion.php"; ?>

<?php
$id_venta = $_GET['id'] ?? 0;

// OBTENER DATOS DE LA VENTA
$sqlVenta = "
    SELECT v.id, v.total, v.fecha_venta,
           c.nombre AS cliente, c.documento,
           u.username AS usuario
    FROM ventas v
    INNER JOIN clientes c ON v.id_cliente = c.id
    INNER JOIN usuarios u ON v.id_usuario = u.id
    WHERE v.id = $id_venta
    LIMIT 1
";

$resVenta = $conn->query($sqlVenta);

if ($resVenta->num_rows == 0) {
    echo "<div class='container mt-4'><h3>Venta no encontrada</h3></div>";
    require "layout/footer.php";
    exit;
}

$venta = $resVenta->fetch_assoc();

// OBTENER DETALLE DE PRODUCTOS
$sqlDetalle = "
    SELECT d.cantidad, d.precio_unitario, d.subtotal,
           p.nombre AS producto
    FROM detalle_ventas d
    INNER JOIN productos p ON d.id_producto = p.id
    WHERE d.id_venta = $id_venta
";

$resDetalle = $conn->query($sqlDetalle);
?>

<div class="container mt-4">

    <h3>Detalle de Venta #<?= $venta['id'] ?></h3>
    <hr>

    <!-- INFO GENERAL -->
    <div class="card mb-3">
        <div class="card-header">Información de la Venta</div>
        <div class="card-body">

            <p><strong>Cliente:</strong> <?= $venta['cliente'] ?> (<?= $venta['documento'] ?>)</p>
            <p><strong>Usuario:</strong> <?= $venta['usuario'] ?></p>
            <p><strong>Fecha:</strong> <?= $venta['fecha_venta'] ?></p>
            <p><strong>Total:</strong> S/. <?= number_format($venta['total'], 2) ?></p>

        </div>
    </div>

    <!-- DETALLE -->
    <div class="card">
        <div class="card-header">Productos Vendidos</div>

        <div class="card-body">
            <a href="ticket.php?id=<?= $venta['id'] ?>" 
   target="_blank" 
   class="btn btn-success mt-2">
   Imprimir Ticket
</a>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>

                    <?php while ($row = $resDetalle->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $row['producto'] ?></td>
                            <td><?= $row['cantidad'] ?></td>
                            <td>S/. <?= number_format($row['precio_unitario'], 2) ?></td>
                            <td>S/. <?= number_format($row['subtotal'], 2) ?></td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>

            <a href="listar_ventas.php" class="btn btn-secondary mt-3">Regresar</a>
        </div>
    </div>
</div>

<?php require "layout/footer.php"; ?>
