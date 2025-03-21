<?php
session_start();
require '../db.php'; // Conectar a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $cargo = $_POST['cargo'];
    $area = $_POST['area'];
    $sub_area = $_POST['sub_area'];
    $serial = $_POST['serial'];
    $imei = $_POST['imei'];
    $placa_activos = $_POST['placa_activos'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $fecha_compra = $_POST['fecha_compra']; // Asegúrate de que este campo esté en tu formulario
    $fecha_entrega = $_POST['fecha_entrega']; // Nuevo campo para la fecha de entrega
    $observaciones = $_POST['observaciones']; // Captura el nuevo campo

    // Validar los datos
    if (empty($cedula) || empty($nombre) || empty($cargo) || empty($area) || empty($sub_area) || empty($serial) || empty($imei) || empty($placa_activos) || empty($marca) || empty($modelo) || empty($fecha_compra) || empty($fecha_entrega)) {
        $_SESSION['error'] = 'Por favor, completa todos los campos requeridos.';
        header('Location: ../vistas/agregar_celular.php');
        exit();
    }

    // Verificar si el empleado ya existe
    $stmt = $pdo->prepare("SELECT * FROM empleados WHERE cedula = ?");
    $stmt->execute([$cedula]);
    $empleado = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$empleado) {
        // Agregar nuevo empleado
        $stmt = $pdo->prepare("INSERT INTO empleados (cedula, nombre, cargo, area, sub_area) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$cedula, $nombre, $cargo, $area, $sub_area]);
    }

    // Agregar celular
    $stmt = $pdo->prepare("INSERT INTO celulares (cedula, serial, imei, placa_activos, marca, modelo, fecha_entrega, fecha_compra, observaciones) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$cedula, $serial, $imei, $placa_activos, $marca, $modelo, $fecha_entrega, $fecha_compra, $observaciones]); // Agregando el campo fecha_entrega

    // Mensaje de éxito
    $_SESSION['success'] = 'Celular agregado exitosamente.';
    
    // Redirigir al inventario de celulares
    header("Location: ../vistas/inventario_celulares.php");
    exit();
} else {
    // Si no es una petición POST, redirigir
    header('Location: ../vistas/agregar_celular.php');
    exit();
}
?>
