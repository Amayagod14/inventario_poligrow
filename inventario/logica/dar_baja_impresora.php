<?php
require '../db.php'; // Conexión a la base de datos

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Obtener los datos de la impresora
    $query_select = "SELECT * FROM impresoras WHERE id = :id";
    $stmt_select = $pdo->prepare($query_select);
    $stmt_select->execute([':id' => $id]);
    $impresora = $stmt_select->fetch(PDO::FETCH_ASSOC);

    if ($impresora) {
        // 2. Insertar los datos en la tabla dispositivos_dados_de_baja
        $query_insert = "
            INSERT INTO dispositivos_dados_de_baja (
                tipo_dispositivo, id_dispositivo, cedula, marca, modelo, 
                serial, placa_activos, fecha_compra, fecha_baja, estado
            ) VALUES (
                'impresora', :id_dispositivo, :cedula, :marca, :modelo, 
                :serial, :placa_activos, :fecha_compra, CURDATE(), :estado
            )
        ";
        $stmt_insert = $pdo->prepare($query_insert);
        $stmt_insert->execute([
            ':id_dispositivo' => $impresora['id'],
            ':cedula' => $impresora['cedula'],
            ':marca' => $impresora['marca'],
            ':modelo' => $impresora['modelo'],
            ':serial' => $impresora['serial'],
            ':placa_activos' => $impresora['placa_activos'],
            ':fecha_compra' => $impresora['fecha_compra'],
            ':estado' => $impresora['estado']
        ]);

        // 3. Eliminar el registro de la tabla impresoras
        $query_delete = "DELETE FROM impresoras WHERE id = :id";
        $stmt_delete = $pdo->prepare($query_delete);
        $stmt_delete->execute([':id' => $id]);

        // Redireccionar o mostrar un mensaje de éxito
        header("Location: ../vistas/inventario_impresoras.php?mensaje=Impresora dada de baja correctamente");
        exit;
    } else {
        echo "Error: Impresora no encontrada.";
    }
} else {
    echo "Error: ID de la impresora no proporcionado.";
}
?>