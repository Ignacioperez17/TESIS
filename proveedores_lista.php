<?php
require "conexion.php";
header('Content-Type: application/json; charset=utf-8');

$res = $conn->query("SELECT id, nombre_empresa FROM proveedores ORDER BY nombre_empresa ASC");
$data = [];

while ($fila = $res->fetch_assoc()) {
    $data[] = $fila;
}

echo json_encode($data);
?>
