<?php
$password = "admin123";
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Hash generado para admin123:<br>";
echo "<b>$hash</b>";
?>
