<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "conexion.php";


$res = $conn->query("SELECT * FROM clientes ORDER BY id DESC");
$data = [];

while ($fila = $res->fetch_assoc()) {
    $data[] = $fila;
}

echo json_encode($data);
