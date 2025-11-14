<?php
require "conexion.php";

$texto = $_POST['texto'] ?? '';
$texto = $conn->real_escape_string($texto);

$sql = "
    SELECT 
        id, 
        nombre, 
        precio_venta AS precio, 
        stock 
    FROM productos 
    WHERE nombre LIKE '%$texto%' 
    ORDER BY nombre ASC
";

$res = $conn->query($sql);

$data = [];

while ($row = $res->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
