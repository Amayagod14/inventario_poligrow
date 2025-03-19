<?php
require '../db.php'; // Conexión a la base de datos

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Obtener los datos del computador
    $query_select = "SELECT * FROM computadores WHERE id = :id";
    $stmt_select = $pdo->prepare($query_select);
    $stmt_select->execute([':id' => $id]);
    $computador = $stmt_select->fetch(PDO::FETCH_ASSOC);

    if ($computador) {
        // 2. Insertar los datos en la tabla dispositivos_dados_de_baja
        $query_insert = "
            INSERT INTO dispositivos_dados_de_baja (
                tipo_dispositivo, id_dispositivo, cedula, marca, dispositivo, 
                serial, ram, mac, referencia, fecha_compra, fecha_baja
            ) VALUES (
                'computador', :id_dispositivo, :cedula, :marca, :dispositivo, 
                :serial, :ram, :mac, :referencia, :fecha_compra, CURDATE()
            )
        ";
        $stmt_insert = $pdo->prepare($query_insert);
        $stmt_insert->execute([
            ':id_dispositivo' => $computador['id'],
            ':cedula' => $computador['cedula'],
            ':marca' => $computador['marca'],
            ':dispositivo' => $computador['dispositivo'],
            ':serial' => $computador['serial'],
            ':ram' => $computador['ram'],
            ':mac' => $computador['mac'],
            ':referencia' => $computador['referencia'],
            ':fecha_compra' => $computador['fecha_compra']
        ]);

        // 3. Eliminar el registro de la tabla computadores
        $query_delete = "DELETE FROM computadores WHERE id = :id";
        $stmt_delete = $pdo->prepare($query_delete);
        $stmt_delete->execute([':id' => $id]);

        // Redireccionar o mostrar un mensaje de éxito
        header("Location: ../vistas/inventario_computadores.php?mensaje=Computador dado de baja correctamente");
        exit;
    } else {
        echo "Error: Computador no encontrado.";
    }
} else {
    echo "Error: ID del computador no proporcionado.";
}
?>
