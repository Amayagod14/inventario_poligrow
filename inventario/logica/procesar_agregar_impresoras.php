<?php
session_start();
require '../db.php'; // Conectar a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $serial = $_POST['serial'];
    $placa_activos = $_POST['placa_activos'];
    $cedula = $_POST['cedula'];
    $estado = $_POST['estado'];
    $fecha_asignacion = $_POST['fecha_asignacion'];
    $fecha_compra = $_POST['fecha_compra']; // Asegúrate de que este campo esté en tu formulario
    $observaciones = $_POST['observaciones']; // Captura el nuevo campo

    // Validar los datos (puedes agregar más validaciones según sea necesario)
    if (empty($marca) || empty($modelo) || empty($serial) || empty($placa_activos) || empty($cedula) || empty($estado) || empty($fecha_asignacion) || empty($fecha_compra)) {
        $_SESSION['error'] = 'Por favor, completa todos los campos requeridos.';
        header('Location: ../vistas/agregar_impresora.php');
        exit();
    }

    // Insertar en la tabla impresoras
    $stmt = $pdo->prepare("INSERT INTO impresoras (marca, modelo, serial, placa_activos, cedula, estado, fecha_asignacion, fecha_compra, observaciones) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$marca, $modelo, $serial, $placa_activos, $cedula, $estado, $fecha_asignacion, $fecha_compra, $observaciones])) {
        // Mensaje de éxito
        $_SESSION['mensaje'] = "Impresora agregada exitosamente.";
        // Redirigir a la lista de impresoras
        header("Location: ../vistas/inventario_impresoras.php");
        exit;
    } else {
        echo "Error al agregar la impresora.";
    }
}
?>
