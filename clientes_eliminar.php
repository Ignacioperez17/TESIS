<?php
require "conexion.php";

$id = $_GET['id'] ?? 0;

if ($id == 0) {
    echo json_encode(["ok" => false, "msg" => "ID no válido"]);
    exit;
}

$stmt = $conn->prepare("DELETE FROM clientes WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["ok" => true, "msg" => "Cliente eliminado correctamente"]);
} else {
    echo json_encode(["ok" => false, "msg" => "Error al eliminar cliente"]);
}
