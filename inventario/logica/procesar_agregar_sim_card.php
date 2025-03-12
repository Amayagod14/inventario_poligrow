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
    $dispositivo = $_POST['dispositivo'];
    $linea_celular = $_POST['linea_celular'];
    $fecha_compra = $_POST['fecha_compra']; // Asegúrate de que este campo esté en tu formulario

    // Validar los datos (puedes agregar más validaciones según sea necesario)
    if (empty($cedula) || empty($nombre) || empty($cargo) || empty($area) || empty($sub_area) || empty($dispositivo) || empty($linea_celular) || empty($fecha_compra)) {
        $_SESSION['error'] = 'Por favor, completa todos los campos requeridos.';
        header('Location: agregar_sim_card.php');
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

    // Preparar la consulta SQL para insertar la nueva SIM card
    $query = "
        INSERT INTO sim_cards (cedula, dispositivo, linea_celular, fecha_compra) 
        VALUES (:cedula, :dispositivo, :linea_celular, :fecha_compra)
    ";

    $stmt = $pdo->prepare($query);
    
    // Ejecutar la consulta
    try {
        $stmt->execute([
            ':cedula' => $cedula,
            ':dispositivo' => $dispositivo,
            ':linea_celular' => $linea_celular,
            ':fecha_compra' => $fecha_compra,
        ]);

        $_SESSION['success'] = 'SIM Card agregada exitosamente.';
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Error al agregar la SIM Card: ' . $e->getMessage();
    }

    // Redirigir a la página de inventario o donde desees
    header('Location: ../vistas/inventario_sim_cards.php'); // Cambia esto a la página que desees
    exit();
} else {
    // Si no es una petición POST, redirigir
    header('Location: agregar_sim_card.php');
    exit();
}
?>
