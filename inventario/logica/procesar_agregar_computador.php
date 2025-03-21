<?php
session_start();
require '../db.php'; // Conectar a la base de datos
require '../clases/DispositivoManager.php'; // Incluir la clase

$dispositivoManager = new DispositivoManager($pdo);

// Recibir datos del formulario
$cedula = $_POST['cedula'];
$dispositivo = $_POST['dispositivo'];
$marca = $_POST['marca'];
$referencia = $_POST['referencia'];
$mac = $_POST['mac'];
$placa_activos = $_POST['placa_activos'];
$serial = $_POST['serial'];
$ram = $_POST['ram'];
$estado_entrega = $_POST['estado_entrega'];
$disco_duro = $_POST['disco_duro'];
$cuenta_email = $_POST['cuenta_email'];
$fecha_compra = $_POST['fecha_compra']; // Asegúrate de que este campo esté en tu formulario
$fecha_entrega = $_POST['fecha_entrega']; // Captura la fecha actual
$observaciones = $_POST['observaciones']; // Captura el nuevo campo

// Validar los datos (puedes agregar más validaciones según sea necesario)
if (empty($cedula) || empty($dispositivo) || empty($marca) || empty($referencia) || empty($mac) || empty($placa_activos) || empty($serial) || empty($ram) || empty($estado_entrega) || empty($disco_duro) || empty($cuenta_email) || empty($fecha_compra) || empty($fecha_entrega)) {
    $_SESSION['error'] = 'Por favor, completa todos los campos requeridos.';
    header('Location: ../vistas/agregar_computador.php');
    exit();
}

// Verificar si el empleado existe
$stmt = $pdo->prepare("SELECT * FROM empleados WHERE cedula = ?");
$stmt->execute([$cedula]);
$empleado = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$empleado) {
    // Si el empleado no existe, agregarlo
    $nombre = $_POST['nombre']; // Se asume que el nombre se envía desde el formulario
    $cargo = $_POST['cargo'];
    $area = $_POST['area'];
    $sub_area = $_POST['sub_area'];

    $stmt = $pdo->prepare("INSERT INTO empleados (cedula, nombre, cargo, area, sub_area) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$cedula, $nombre, $cargo, $area, $sub_area]);
}

// Agregar el computador
$stmt = $pdo->prepare("INSERT INTO computadores (cedula, dispositivo, marca, referencia, mac, placa_activos, serial, ram, estado_entrega, disco_duro, cuenta_email, fecha_compra, fecha_entrega, observaciones) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([$cedula, $dispositivo, $marca, $referencia, $mac, $placa_activos, $serial, $ram, $estado_entrega, $disco_duro, $cuenta_email, $fecha_compra, $fecha_entrega, $observaciones]); // Agregando el campo observaciones

// Redirigir o mostrar un mensaje de éxito
$_SESSION['mensaje'] = "Computador agregado exitosamente.";
header('Location: ../vistas/inventario_computadores.php'); // Cambia esto por la página de éxito que desees
exit();
?>
