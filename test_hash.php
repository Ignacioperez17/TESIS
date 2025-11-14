<?php
$password_ingresada = "admin123";
// usa comillas simples para que PHP no intente interpolar $2y...
$hash_guardado = '$2y$10$hHYvWJ0K/dBaOCmEhCZP2uLkguCYoYfJeqSmN0Z1Gu5c3Y7vht94a';

if (password_verify($password_ingresada, $hash_guardado)) {
    echo "✅ La contraseña coincide";
} else {
    echo "❌ Contraseña incorrecta";
}
?>

