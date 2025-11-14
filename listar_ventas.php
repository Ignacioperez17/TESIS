<?php require "layout/header.php"; ?>
<?php require "conexion.php"; ?>

<div class="container mt-4">

    <h3 class="mb-4">Listado de Ventas</h3>

    <table class="table table-bordered table-striped" id="tablaVentas">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Usuario</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Detalle</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "
                SELECT v.id, c.nombre AS cliente, u.username AS usuario, 
                       v.total, v.fecha_venta
                FROM ventas v
                INNER JOIN clientes c ON v.id_cliente = c.id
                INNER JOIN usuarios u ON v.id_usuario = u.id
                ORDER BY v.id DESC
            ";

            $res = $conn->query($sql);

            while ($row = $res->fetch_assoc()) {
                echo "
                <tr>
                    <td>{$row['id']}</td>
                    <td>{$row['cliente']}</td>
                    <td>{$row['usuario']}</td>
                    <td>S/. {$row['total']}</td>
                    <td>{$row['fecha_venta']}</td>
                    <td>
                        <a href='ventas_detalle.php?id={$row['id']}' class='btn btn-info btn-sm'>
                            Ver
                        </a>
                    </td>
                </tr>
                ";
            }
            ?>
        </tbody>
    </table>

</div>

<?php require "layout/footer.php"; ?>
