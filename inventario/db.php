<?php
$host = 'localhost'; // Cambia esto si tu host es diferente
$db = 'inventario_sistemas'; // Nombre de tu base de datos
$user = 'root'; // Cambia esto al usuario de MySQL
$pass = ''; // Cambia esto a tu contraseña de MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
