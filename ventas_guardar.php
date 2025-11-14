<?php
require "conexion.php";

$data = json_decode(file_get_contents("php://input"), true);

$id_cliente = $data['id_cliente'];
$id_usuario = $data['id_usuario'];
$carrito    = $data['carrito'];
$total      = $data['total'];

$conn->begin_transaction();

try {

    // Registrar venta
    $stmt = $conn->prepare("INSERT INTO ventas (id_cliente, id_usuario, total)
    VALUES (?, ?, ?)");

    $stmt->bind_param("iid", $id_cliente, $id_usuario, $total);
    $stmt->execute();
    $id_venta = $stmt->insert_id;

    // Registrar detalle
    $stmt_det = $conn->prepare("
        INSERT INTO detalle_ventas (id_venta, id_producto, cantidad, precio_unitario, subtotal)
        VALUES (?, ?, ?, ?, ?)
    ");

    foreach ($carrito as $item) {

        $id_producto     = $item['id'];
        $cantidad        = $item['cantidad'];
        $precio_unitario = $item['precio'];   // tu JSON debe enviarlo así
        $subtotal        = $item['subtotal'];

        $stmt_det->bind_param("iiidd", $id_venta, $id_producto, $cantidad, $precio_unitario, $subtotal);
        $stmt_det->execute();

        // Actualizar stock
        $conn->query("UPDATE productos SET stock = stock - $cantidad WHERE id = $id_producto");
    }

    $conn->commit();

    echo json_encode(["ok" => true, "msg" => "Venta registrada correctamente"]);

} catch (Exception $e) {

    $conn->rollback();
    echo json_encode(["ok" => false, "msg" => "Error: " . $e->getMessage()]);
}
