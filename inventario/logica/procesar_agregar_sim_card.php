<?php
session_start();
require '../db.php'; // Conectar a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $cedula = $_POST['cedula'];
    $dispositivo = $_POST['dispositivo'];
    $linea_celular = $_POST['linea_celular'];
    $fecha_compra = $_POST['fecha_compra'];
    $fecha_entrega = $_POST['fecha_entrega']; // Asegúrate de capturar este campo

    // Validar los datos
    if (empty($cedula) || empty($dispositivo) || empty($linea_celular) || empty($fecha_compra) || empty($fecha_entrega)) {
        $_SESSION['error'] = 'Por favor, completa todos los campos requeridos.';
        header('Location: agregar_sim_card.php');
        exit();
    }

    // Verificar si la SIM card ya existe
    $stmt = $pdo->prepare("SELECT * FROM sim_cards WHERE cedula = ? AND linea_celular = ?");
    $stmt->execute([$cedula, $linea_celular]);
    $simCardExistente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($simCardExistente) {
        $_SESSION['error'] = 'Esta SIM Card ya está registrada.';
        header('Location: agregar_sim_card.php');
        exit();
    }

    // Preparar la consulta SQL para insertar la nueva SIM card
    $query = "
        INSERT INTO sim_cards (cedula, dispositivo, linea_celular, fecha_compra, fecha_entrega) 
        VALUES (:cedula, :dispositivo, :linea_celular, :fecha_compra, :fecha_entrega)
    ";

    $stmt = $pdo->prepare($query);
    
    // Ejecutar la consulta
    try {
        $stmt->execute([
            ':cedula' => $cedula,
            ':dispositivo' => $dispositivo,
            ':linea_celular' => $linea_celular,
            ':fecha_compra' => $fecha_compra,
            ':fecha_entrega' => $fecha_entrega,
        ]);

        $_SESSION['success'] = 'SIM Card agregada exitosamente.';
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Error al agregar la SIM Card: ' . $e->getMessage();
    }

    // Redirigir a la página de inventario
    header('Location: ../vistas/inventario_sim_cards.php');
    exit();
} else {
    // Si no es una petición POST, redirigir
    header('Location: agregar_sim_card.php');
    exit();
}
?>
