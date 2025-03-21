<?php
session_start();
require '../db.php'; // Conectar a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $serial = $_POST['serial'] ?? null; // Serial del dispositivo
    $linea_celular = $_POST['linea_celular'] ?? null; // Línea celular (si aplica)
    $cedula_nueva = $_POST['cedula_nueva']; // Cédula del nuevo empleado
    $nombre_nuevo = $_POST['nombre_nuevo']; // Nombre del nuevo empleado
    $cargo_nuevo = $_POST['cargo_nuevo']; // Cargo del nuevo empleado
    $area_nueva = $_POST['area_nueva']; // Área del nuevo empleado
    $sub_area_nueva = $_POST['sub_area_nueva']; // Sub área del nuevo empleado
    $tipo_dispositivo = $_POST['tipo']; // Tipo de dispositivo
    $fecha_entrega = $_POST['fecha_entrega']; // Fecha de entrega

    // Validar los datos
    if (empty($cedula_nueva) || empty($tipo_dispositivo) || empty($fecha_entrega) || empty($nombre_nuevo) || empty($cargo_nuevo) || empty($area_nueva) || empty($sub_area_nueva)) {
        $_SESSION['error'] = 'Por favor, completa todos los campos requeridos.';
        header('Location: ../vistas/reasignar_dispositivo.php');
        exit();
    }

    // Preparar la consulta SQL para verificar la existencia del empleado
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM empleados WHERE cedula = :cedula_nueva");
    $stmt->execute([':cedula_nueva' => $cedula_nueva]);
    $existe_empleado = $stmt->fetchColumn();

    try {
        // Si el empleado no existe, insertarlo
        if (!$existe_empleado) {
            $insertEmpleadoQuery = "INSERT INTO empleados (cedula, nombre, cargo, area, sub_area) VALUES (:cedula, :nombre, :cargo, :area, :sub_area)";
            $stmt = $pdo->prepare($insertEmpleadoQuery);
            $stmt->execute([
                ':cedula' => $cedula_nueva,
                ':nombre' => $nombre_nuevo,
                ':cargo' => $cargo_nuevo,
                ':area' => $area_nueva,
                ':sub_area' => $sub_area_nueva
            ]);
        }

        // Ahora proceder a reasignar el dispositivo
        switch ($tipo_dispositivo) {
            case 'celular':
                $query = "UPDATE celulares SET cedula = :cedula_nueva, fecha_entrega = :fecha_entrega WHERE serial = :serial";
                break;
            case 'computador':
                $query = "UPDATE computadores SET cedula = :cedula_nueva, fecha_entrega = :fecha_entrega WHERE serial = :serial";
                break;
            case 'impresora':
                $query = "UPDATE impresoras SET cedula = :cedula_nueva, fecha_entrega = :fecha_entrega WHERE serial = :serial";
                break;
            case 'radio':
                $query = "UPDATE radios SET cedula = :cedula_nueva, fecha_entrega = :fecha_entrega WHERE serial = :serial";
                break;
            case 'sim_card':
                $query = "UPDATE sim_cards SET cedula = :cedula_nueva, fecha_entrega = :fecha_entrega WHERE linea_celular = :linea_celular";
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
                ':fecha_entrega' => $fecha_entrega,
            ]);
        } else {
            $stmt->execute([
                ':cedula_nueva' => $cedula_nueva,
                ':serial' => $serial,
                ':fecha_entrega' => $fecha_entrega,
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
