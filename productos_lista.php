<?php
require "conexion.php";

$res = $conn->query("SELECT * FROM productos ORDER BY id DESC");
$data = [];

while ($fila = $res->fetch_assoc()) {
    $data[] = $fila;
}

echo json_encode($data);
?>
