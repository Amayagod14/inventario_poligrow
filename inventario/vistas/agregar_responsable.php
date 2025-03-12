<?php
require '../db.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $cedula = $_POST['cedula'];
    $cargo = $_POST['cargo'];
    $area = $_POST['area'];
    $sub_area = $_POST['sub_area'];

    $query = "
        INSERT INTO responsables_inventario (nombre, cedula, cargo, area, sub_area)
        VALUES (:nombre, :cedula, :cargo, :area, :sub_area)
    ";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':nombre' => $nombre,
        ':cedula' => $cedula,
        ':cargo' => $cargo,
        ':area' => $area,
        ':sub_area' => $sub_area
    ]);

    header("Location: usuarios.php");
    exit;
}
?>
