<?php
header('Content-Type: application/json');
include 'conexion.php'; // asegúrate de que este archivo exista y tenga la conexión $conn

// Verificar si llegan los datos del formulario
if (!isset($_POST['usuario']) || !isset($_POST['password'])) {
    echo json_encode(['ok' => false, 'error' => 'Faltan datos.']);
    exit;
}

$usuario = trim($_POST['usuario']);
$password = trim($_POST['password']);

// Verificar si el usuario existe en la base de datos
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['ok' => false, 'error' => 'Usuario no encontrado.']);
    exit;
}

$user = $result->fetch_assoc();

// Verificar contraseña
if (password_verify($password, $user['password'])) {
    // Iniciar sesión
    session_start();
    $_SESSION['usuario'] = $user['usuario'];
    $_SESSION['rol'] = $user['rol'];

    echo json_encode(['ok' => true]);
} else {
    echo json_encode(['ok' => false, 'error' => 'Contraseña incorrecta.']);
}

$stmt->close();
$conn->close();
?>

