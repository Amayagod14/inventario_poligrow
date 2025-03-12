<?php
session_start();
require '../db.php'; // Conectar a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Consulta para verificar las credenciales
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
    $stmt->bindParam(':usuario', $usuario);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si el usuario existe y la contraseña es correcta
    if ($user && password_verify($contrasena, $user['contrasena'])) {
        $_SESSION['usuario'] = $usuario;
        header("Location: ../vistas/inventario.php"); // Redirigir a la página del inventario
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos.";
        header("Location: ../vistas/login.php?error=" . urlencode($error)); // Redirigir con mensaje de error
        exit();
    }
}
?>
