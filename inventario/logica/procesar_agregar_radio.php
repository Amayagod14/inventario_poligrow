<?php
session_start();
require '../db.php'; // Conectar a la base de datos
require '../clases/DispositivoManager.php'; // Incluir la clase

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $cedula = htmlspecialchars($_POST['cedula']);
    $serial = htmlspecialchars($_POST['serial']);
    $marca = htmlspecialchars($_POST['marca']);
    $placa_activos_fijos = htmlspecialchars($_POST['placa_activos_fijos']);
    $dispositivo = htmlspecialchars($_POST['dispositivo']);
    $referencia = htmlspecialchars($_POST['referencia']);
    $estado_entrega = htmlspecialchars($_POST['estado_entrega']);
    $observaciones = htmlspecialchars($_POST['observaciones']);
    $fecha = htmlspecialchars($_POST['fecha']); // Fecha
    $fecha_compra = htmlspecialchars($_POST['fecha_compra']); // Fecha de compra

    // Validar los datos
    if (empty($cedula) || empty($serial) || empty($marca) || empty($placa_activos_fijos) || empty($dispositivo) || empty($referencia) || empty($estado_entrega) || empty($observaciones) || empty($fecha) || empty($fecha_compra)) {
        $_SESSION['error'] = 'Por favor, completa todos los campos requeridos.';
        header('Location: ../vistas/agregar_radio.php');
        exit();
    }

    try {
        // Preparar la consulta SQL
        $stmt = $pdo->prepare("INSERT INTO radios (cedula, serial, marca, placa_activos_fijos, dispositivo, referencia, estado_entrega, observaciones, fecha, fecha_compra) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        // Ejecutar la consulta
        $stmt->execute([$cedula, $serial, $marca, $placa_activos_fijos, $dispositivo, $referencia, $estado_entrega, $observaciones, $fecha, $fecha_compra]);

        // Redirigir a la página de inventario o mostrar un mensaje de éxito
        $_SESSION['mensaje'] = 'Radio agregado exitosamente.';
        header('Location: ../vistas/inventario_radios.php'); // Cambia a la página de inventario correspondiente
        exit();
    } catch (PDOException $e) {
        // Manejo de errores
        $_SESSION['error'] = 'Error al agregar el radio: ' . $e->getMessage();
        header('Location: ../vistas/agregar_radio.php'); // Regresar al formulario en caso de error
        exit();
    }
} else {
    // Redirigir si no es una solicitud POST
    header('Location: ../vistas/agregar_radio.php');
    exit();
}
?>
