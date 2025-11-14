<?php
header("Content-Type: application/json; charset=UTF-8");
require "conexion.php";

$response = ["ok" => false, "msg" => ""];

if (!isset($_POST["id"])) {
    $response["msg"] = "Falta el ID del producto.";
    echo json_encode($response);
    exit;
}

$id = intval($_POST["id"]);

$stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
if ($stmt === false) {
    $response["msg"] = "Error al preparar: " . $conn->error;
    echo json_encode($response);
    exit;
}

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $response["ok"] = true;
    $response["msg"] = "Producto eliminado correctamente.";
} else {
    $response["msg"] = "Error al eliminar: " . $stmt->error;
}

echo json_encode($response);
?>

