<?php

require '../db.php';

$cedula = $_GET['cedula'] ?? '';
$response = ['existe' => false];

if ($cedula) {
    $stmt = $pdo->prepare("SELECT * FROM empleados WHERE cedula = ?");
    $stmt->execute([$cedula]);
    $empleado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($empleado) {
        $response['existe'] = true;
        $response['nombre'] = $empleado['nombre'];
        $response['cargo'] = $empleado['cargo'];
        $response['area'] = $empleado['area'];
        $response['sub_area'] = $empleado['sub_area'];
    }
}

echo json_encode($response);
