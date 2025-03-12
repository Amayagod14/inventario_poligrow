<?php
require '../db.php'; // Conectar a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    // Preparar la consulta para insertar el nuevo usuario
    $stmt = $pdo->prepare("INSERT INTO usuarios (usuario, contrasena) VALUES (:usuario, :contrasena)");

    // Vincular parámetros
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':contrasena', $contrasena);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        header("Location: ../vistas/login.php");
    } else {
        echo "Error al agregar el usuario.";
    }
}
?>
