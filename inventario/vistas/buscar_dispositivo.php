<?php
require '../db.php'; // Conectar a la base de datos

if (isset($_GET['serial'])) {
    $serial = $_GET['serial'];

    // Preparar la consulta para buscar en varias tablas
    $stmtCelular = $pdo->prepare("SELECT * FROM celulares WHERE serial = :serial");
    $stmtComputador = $pdo->prepare("SELECT * FROM computadores WHERE serial = :serial");
    $stmtImpresora = $pdo->prepare("SELECT * FROM impresoras WHERE serial = :serial");
    $stmtRadio = $pdo->prepare("SELECT * FROM radios WHERE serial = :serial");
    $stmtSimCard = $pdo->prepare("SELECT * FROM sim_cards WHERE linea_celular = :serial");

    // Buscar en la tabla de celulares
    $stmtCelular->execute(['serial' => $serial]);
    $celular = $stmtCelular->fetch(PDO::FETCH_ASSOC);

    // Buscar en la tabla de computadores
    $stmtComputador->execute(['serial' => $serial]);
    $computador = $stmtComputador->fetch(PDO::FETCH_ASSOC);

    // Buscar en la tabla de impresoras
    $stmtImpresora->execute(['serial' => $serial]);
    $impresora = $stmtImpresora->fetch(PDO::FETCH_ASSOC);

    // Buscar en la tabla de radios
    $stmtRadio->execute(['serial' => $serial]);
    $radio = $stmtRadio->fetch(PDO::FETCH_ASSOC);

    // Buscar en la tabla de tarjetas SIM
    $stmtSimCard->execute(['serial' => $serial]);
    $simCard = $stmtSimCard->fetch(PDO::FETCH_ASSOC);

    if ($celular) {
        // Si se encuentra un celular, buscar el empleado asignado
        $cedulaAsignado = $celular['cedula'];
        $empleadoStmt = $pdo->prepare("SELECT * FROM empleados WHERE cedula = :cedula");
        $empleadoStmt->execute(['cedula' => $cedulaAsignado]);
        $empleado = $empleadoStmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode([
            'existe' => true,
            'tipo' => 'celular',
            'marca' => $celular['marca'],
            'modelo' => $celular['modelo'],
            'placa_activos' => $celular['placa_activos'],
            'fecha_compra' => $celular['fecha_compra'],
            'cedula_asignado' => $cedulaAsignado,
            'nombre_asignado' => $empleado ? $empleado['nombre'] : '',
            'cargo_asignado' => $empleado ? $empleado['cargo'] : '',
            'area_asignado' => $empleado ? $empleado['area'] : '',
            'sub_area_asignado' => $empleado ? $empleado['sub_area'] : '',
        ]);
    } elseif ($computador) {
        // Si se encuentra un computador, buscar el empleado asignado
        $cedulaAsignado = $computador['cedula'];
        $empleadoStmt = $pdo->prepare("SELECT * FROM empleados WHERE cedula = :cedula");
        $empleadoStmt->execute(['cedula' => $cedulaAsignado]);
        $empleado = $empleadoStmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode([
            'existe' => true,
            'tipo' => 'computador',
            'marca' => $computador['marca'],
            'modelo' => $computador['referencia'], // Usando referencia como modelo
            'placa_activos' => $computador['placa_activos'],
            'fecha_compra' => $computador['fecha_compra'],
            'cedula_asignado' => $cedulaAsignado,
            'nombre_asignado' => $empleado ? $empleado['nombre'] : '',
            'cargo_asignado' => $empleado ? $empleado['cargo'] : '',
            'area_asignado' => $empleado ? $empleado['area'] : '',
            'sub_area_asignado' => $empleado ? $empleado['sub_area'] : '',
        ]);
    } elseif ($impresora) {
        // Si se encuentra una impresora, buscar el empleado asignado
        $cedulaAsignado = $impresora['cedula'];
        $empleadoStmt = $pdo->prepare("SELECT * FROM empleados WHERE cedula = :cedula");
        $empleadoStmt->execute(['cedula' => $cedulaAsignado]);
        $empleado = $empleadoStmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode([
            'existe' => true,
            'tipo' => 'impresora',
            'marca' => $impresora['marca'],
            'modelo' => $impresora['modelo'],
            'placa_activos' => $impresora['placa_activos'],
            'fecha_compra' => $impresora['fecha_compra'],
            'cedula_asignado' => $cedulaAsignado,
            'nombre_asignado' => $empleado ? $empleado['nombre'] : '',
            'cargo_asignado' => $empleado ? $empleado['cargo'] : '',
            'area_asignado' => $empleado ? $empleado['area'] : '',
            'sub_area_asignado' => $empleado ? $empleado['sub_area'] : '',
        ]);
    } elseif ($radio) {
        // Si se encuentra un radio, buscar el empleado asignado
        $cedulaAsignado = $radio['cedula'];
        $empleadoStmt = $pdo->prepare("SELECT * FROM empleados WHERE cedula = :cedula");
        $empleadoStmt->execute(['cedula' => $cedulaAsignado]);
        $empleado = $empleadoStmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode([
            'existe' => true,
            'tipo' => 'radio',
            'marca' => $radio['marca'],
            'modelo' => $radio['dispositivo'],
            'placa_activos' => $radio['placa_activos_fijos'],
            'fecha_compra' => $radio['fecha_compra'],
            'cedula_asignado' => $cedulaAsignado,
            'nombre_asignado' => $empleado ? $empleado['nombre'] : '',
            'cargo_asignado' => $empleado ? $empleado['cargo'] : '',
            'area_asignado' => $empleado ? $empleado['area'] : '',
            'sub_area_asignado' => $empleado ? $empleado['sub_area'] : '',
        ]);
    } elseif ($simCard) {
        // Si se encuentra una tarjeta SIM
        $cedulaAsignado = $simCard['cedula'];
        $empleadoStmt = $pdo->prepare("SELECT * FROM empleados WHERE cedula = :cedula");
        $empleadoStmt->execute(['cedula' => $cedulaAsignado]);
        $empleado = $empleadoStmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode([
            'existe' => true,
            'tipo' => 'sim_card',
            'linea_celular' => $simCard['linea_celular'],
            'cedula_asignado' => $cedulaAsignado,
            'nombre_asignado' => $empleado ? $empleado['nombre'] : '',
            'cargo_asignado' => $empleado ? $empleado['cargo'] : '',
            'area_asignado' => $empleado ? $empleado['area'] : '',
            'sub_area_asignado' => $empleado ? $empleado['sub_area'] : '',
        ]);
    } else {
        // Si no se encuentra el dispositivo, devolver false
        echo json_encode(['existe' => false]);
    }
} else {
    // Si no se proporciona un serial, devolver error
    echo json_encode(['error' => 'No se ha proporcionado un serial']);
}
?>
