<?php
require "conexion.php";

$id_venta = $_GET['id'] ?? 0;

// OBTENER DATOS GENERALES DE LA VENTA
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
$venta = $resVenta->fetch_assoc();

// OBTENER DETALLE
$sqlDetalle = "
    SELECT d.cantidad, d.precio_unitario, d.subtotal,
           p.nombre AS producto
    FROM detalle_ventas d
    INNER JOIN productos p ON d.id_producto = p.id
    WHERE d.id_venta = $id_venta
";

$resDetalle = $conn->query($sqlDetalle);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Ticket <?= $venta['id'] ?></title>

<style>
body {
    font-family: monospace;
    width: 260px; /* Para impresora térmica de 80mm */
    margin: 0 auto;
    font-size: 13px;
}

.ticket {
    text-align: center;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

td {
    padding: 2px 0;
}

.total {
    border-top: 1px dashed black;
    border-bottom: 1px dashed black;
    font-weight: bold;
    margin-top: 10px;
    padding: 5px 0;
}

.btnPrint {
    margin-top: 15px;
    width: 100%;
    padding: 8px;
    background: steelblue;
    color: white;
    border: none;
    border-radius: 5px;
}
</style>

</head>
<body>

<div class="ticket">

    <h3>SISTEMA SFI V2</h3>
    <p><strong>Ticket #<?= $venta['id'] ?></strong></p>

    <p>
        Fecha: <?= $venta['fecha_venta'] ?><br>
        Cliente: <?= $venta['cliente'] ?><br>
        Documento: <?= $venta['documento'] ?><br>
        Atendido por: <?= $venta['usuario'] ?>
    </p>

    <table>
        <tbody>
            <?php while ($d = $resDetalle->fetch_assoc()) { ?>
                <tr>
                    <td colspan="2">
                        <?= $d['producto'] ?>
                    </td>
                </tr>
                <tr>
                    <td><?= $d['cantidad'] ?> x S/. <?= number_format($d['precio_unitario'],2) ?></td>
                    <td style="text-align:right">S/. <?= number_format($d['subtotal'],2) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <p class="total">TOTAL: S/. <?= number_format($venta['total'],2) ?></p>

    <p>¡Gracias por su compra!</p>

    <button onclick="imprimir()" class="btnPrint">Imprimir Ticket</button>

</div>

<script>
function imprimir() {
    window.print();
}
</script>

</body>
</html>
