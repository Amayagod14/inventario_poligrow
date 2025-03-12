<?php
session_start();
require '../db.php'; // Conectar a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    // Actualizar el estado del dispositivo a "baja"
    $stmt = $pdo->prepare("UPDATE celulares SET estado = 'baja' WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Redirigir a la vista de inventario
    header("Location: ../vistas/inventario.php");
    exit();
}
?>
