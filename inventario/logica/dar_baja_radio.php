<?php
require '../db.php'; // Conexión a la base de datos

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Obtener los datos del radio
    $query_select = "SELECT * FROM radios WHERE id = :id";
    $stmt_select = $pdo->prepare($query_select);
    $stmt_select->execute([':id' => $id]);
    $radio = $stmt_select->fetch(PDO::FETCH_ASSOC);

    if ($radio) {
        // 2. Insertar los datos en la tabla dispositivos_dados_de_baja
        $query_insert = "
            INSERT INTO dispositivos_dados_de_baja (
                tipo_dispositivo, id_dispositivo, cedula, marca, modelo, 
                serial, imei, placa_activos, fecha_compra, fecha_baja
            ) VALUES (
                'radio', :id_dispositivo, :cedula, :marca, :modelo, 
                :serial, NULL, :placa_activos, :fecha_compra, CURDATE()
            )
        ";
        $stmt_insert = $pdo->prepare($query_insert);
        $stmt_insert->execute([
            ':id_dispositivo' => $radio['id'],
            ':cedula' => $radio['cedula'],
            ':marca' => $radio['marca'],
            ':modelo' => $radio['modelo'],
            ':serial' => $radio['serial'],
            ':placa_activos' => $radio['placa_activos'],
            ':fecha_compra' => $radio['fecha_compra']
        ]);

        // 3. Eliminar el registro de la tabla radios
        $query_delete = "DELETE FROM radios WHERE id = :id";
        $stmt_delete = $pdo->prepare($query_delete);
        $stmt_delete->execute([':id' => $id]);

        // Redireccionar o mostrar un mensaje de éxito
        header("Location: ../vistas/inventario_radios.php?mensaje=Radio dado de baja correctamente");
        exit;
    } else {
        echo "Error: Radio no encontrado.";
    }
} else {
    echo "Error: ID del radio no proporcionado.";
}
?>
