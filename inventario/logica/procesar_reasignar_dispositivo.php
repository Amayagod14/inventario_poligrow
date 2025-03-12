<?php
session_start();
require '../db.php'; // Conectar a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $serial = $_POST['serial'] ?? null; // Serial del dispositivo
    $linea_celular = $_POST['linea_celular'] ?? null; // Línea celular (si aplica)
    $cedula_nueva = $_POST['cedula_nueva']; // Cédula del nuevo empleado
    $tipo_dispositivo = $_POST['tipo']; // Tipo de dispositivo

    // Validar los datos
    if (empty($cedula_nueva) || empty($tipo_dispositivo)) {
        $_SESSION['error'] = 'Por favor, completa todos los campos requeridos.';
        header('Location: ../vistas/reasignar_dispositivo.php');
        exit();
    }

    // Preparar la consulta SQL para actualizar el dispositivo según su tipo
    try {
        switch ($tipo_dispositivo) {
            case 'celular':
                $query = "UPDATE celulares SET cedula = :cedula_nueva WHERE serial = :serial";
                break;
            case 'computador':
                $query = "UPDATE computadores SET cedula = :cedula_nueva WHERE serial = :serial";
                break;
            case 'impresora':
                $query = "UPDATE impresoras SET cedula = :cedula_nueva WHERE serial = :serial";
                break;
            case 'radio':
                $query = "UPDATE radios SET cedula = :cedula_nueva WHERE serial = :serial";
                break;
            case 'sim_card':
                $query = "UPDATE sim_cards SET cedula = :cedula_nueva WHERE linea_celular = :linea_celular";
                break;
            default:
                throw new Exception('Tipo de dispositivo no válido.');
        }

        $stmt = $pdo->prepare($query);
        
        // Ejecutar la consulta
        if ($tipo_dispositivo === 'sim_card') {
            $stmt->execute([
                ':cedula_nueva' => $cedula_nueva,
                ':linea_celular' => $linea_celular,
            ]);
        } else {
            $stmt->execute([
                ':cedula_nueva' => $cedula_nueva,
                ':serial' => $serial,
            ]);
        }

        $_SESSION['success'] = 'Dispositivo reasignado exitosamente.';
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Error al reasignar el dispositivo: ' . $e->getMessage();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }

    // Redirigir a la página de inventario o donde desees
    header('Location: ../vistas/inventario.php'); // Cambia esto a la página que desees
    exit();
} else {
    // Si no es una petición POST, redirigir
    header('Location: ../vistas/reasignar_dispositivo.php');
    exit();
}
?>
