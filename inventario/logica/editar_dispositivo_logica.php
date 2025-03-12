<?php
session_start();
require '../db.php'; // Conectar a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    
    // Aquí puedes agregar lógica para obtener los datos del dispositivo y mostrar un formulario de edición
    // Por ejemplo, redirigir a un formulario de edición
    header("Location: ../vistas/editar_dispositivo.php?id=" . urlencode($id));
    exit();
}
?>
