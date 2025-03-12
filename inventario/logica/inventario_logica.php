<?php
session_start();
require '../db.php'; // Conectar a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tabla = $_POST['tabla'];

    // Validar la tabla seleccionada
    $tablas_permitidas = ['celulares', 'computadoras', 'radios', 'sim_cards', 'empleados'];
    if (!in_array($tabla, $tablas_permitidas)) {
        die("Tabla no permitida.");
    }

    // Preparar la consulta
    $stmt = $pdo->prepare("SELECT * FROM $tabla");
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Redirigir a la vista con los resultados
    header("Location: ../vistas/inventario.php?resultado=" . urlencode(json_encode($resultados)));
    exit();
}
?>
