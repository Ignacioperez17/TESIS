<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$usuario = "root";
$password = "";
$base_datos = "db_sfi_v2";

$conn = new mysqli($host, $usuario, $password, $base_datos);

if ($conn->connect_error) {
    die(json_encode(['ok' => false, 'error' => 'Error de conexión: ' . $conn->connect_error]));
}
?>



