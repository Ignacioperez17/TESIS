<?php
header("Content-Type: application/json; charset=UTF-8");
require "conexion.php"; // debe contener $conexion (no $conn)

$response = ["ok" => false, "msg" => ""];

// Validar que existan los datos enviados
if (
    !isset($_POST["nombre"]) ||
    !isset($_POST["id_categoria"]) ||
    !isset($_POST["id_proveedor"]) ||
    !isset($_POST["precio_compra"]) ||
    !isset($_POST["precio_venta"]) ||
    !isset($_POST["stock"])
) {
    $response["msg"] = "No llegaron todos los datos.";
    echo json_encode($response);
    exit;
}

// Capturar datos
$nombre = $_POST["nombre"];
$id_categoria = $_POST["id_categoria"];
$id_proveedor = $_POST["id_proveedor"];
$precio_compra = $_POST["precio_compra"];
$precio_venta = $_POST["precio_venta"];
$stock = $_POST["stock"];

// Insertar producto
$sql = "INSERT INTO productos (nombre, id_categoria, id_proveedor, precio_compra, precio_venta, stock)
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    $response["msg"] = "Error al preparar la consulta: " . $conn->error;
    echo json_encode($response);
    exit;
}

$stmt->bind_param("siiddi", $nombre, $id_categoria, $id_proveedor, $precio_compra, $precio_venta, $stock);

if ($stmt->execute()) {
    $response["ok"] = true;
    $response["msg"] = "Producto guardado correctamente.";
} else {
    $response["msg"] = "Error al guardar: " . $stmt->error;
}

echo json_encode($response);
?>




