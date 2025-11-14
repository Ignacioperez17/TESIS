<?php
require "conexion.php";

$nombre    = $_POST['nombre'] ?? '';
$documento = $_POST['documento'] ?? ''; 
$telefono  = $_POST['telefono'] ?? '';
$direccion = $_POST['direccion'] ?? '';
$correo    = $_POST['correo'] ?? '';

if ($nombre == '' || $documento == '') {
    echo json_encode(["ok" => false, "msg" => "Complete los campos obligatorios"]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO clientes 
(nombre, documento, telefono, direccion, correo, fecha_registro)
VALUES (?, ?, ?, ?, ?, NOW())");

$stmt->bind_param("sssss", $nombre, $documento, $telefono, $direccion, $correo);

if ($stmt->execute()) {
    echo json_encode(["ok" => true, "msg" => "Cliente registrado correctamente"]);
} else {
    echo json_encode(["ok" => false, "msg" => "Error al registrar cliente: " . $stmt->error]);
}
