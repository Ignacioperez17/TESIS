<?php
require "conexion.php";

$id = $_POST["id"] ?? null;
$nombre = $_POST["nombre"] ?? null;
$id_categoria = $_POST["id_categoria"] ?? null;
$id_proveedor = $_POST["id_proveedor"] ?? null;
$precio_compra = $_POST["precio_compra"] ?? null;
$precio_venta = $_POST["precio_venta"] ?? null;
$stock = $_POST["stock"] ?? null;

if (!$id || !$nombre || !$id_categoria || !$id_proveedor || !$precio_compra || !$precio_venta || !$stock) {
    echo json_encode(["ok" => false, "msg" => "Faltan datos para actualizar."]);
    exit;
}

$stmt = $conn->prepare("UPDATE productos SET nombre=?, id_categoria=?, id_proveedor=?, precio_compra=?, precio_venta=?, stock=? WHERE id=?");
$stmt->bind_param("siiddii", $nombre, $id_categoria, $id_proveedor, $precio_compra, $precio_venta, $stock, $id);

if ($stmt->execute()) {
    echo json_encode(["ok" => true, "msg" => "Producto actualizado correctamente."]);
} else {
    echo json_encode(["ok" => false, "msg" => "Error al actualizar."]);
}
?>
