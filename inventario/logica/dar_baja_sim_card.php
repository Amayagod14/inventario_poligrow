<?php
require '../db.php'; // Conexión a la base de datos

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Obtener los datos de la SIM card
    $query_select = "SELECT * FROM sim_cards WHERE id = :id";
    $stmt_select = $pdo->prepare($query_select);
    $stmt_select->execute([':id' => $id]);
    $simCard = $stmt_select->fetch(PDO::FETCH_ASSOC);

    if ($simCard) {
        // 2. Insertar los datos en la tabla dispositivos_dados_de_baja
        $query_insert = "
            INSERT INTO dispositivos_dados_de_baja (
                tipo_dispositivo, id_dispositivo, cedula, dispositivo, 
                linea_celular, fecha_compra, fecha_baja
            ) VALUES (
                'sim_card', :id_dispositivo, :cedula, :dispositivo, 
                :linea_celular, :fecha_compra, CURDATE()
            )
        ";
        $stmt_insert = $pdo->prepare($query_insert);
        $stmt_insert->execute([
            ':id_dispositivo' => $simCard['id'],
            ':cedula' => $simCard['cedula'],
            ':dispositivo' => $simCard['dispositivo'],
            ':linea_celular' => $simCard['linea_celular'],
            ':fecha_compra' => $simCard['fecha_compra']
        ]);

        // 3. Eliminar el registro de la tabla sim_cards
        $query_delete = "DELETE FROM sim_cards WHERE id = :id";
        $stmt_delete = $pdo->prepare($query_delete);
        $stmt_delete->execute([':id' => $id]);

        // Redireccionar o mostrar un mensaje de éxito
        header("Location: ../vistas/inventario_sim_cards.php?mensaje=SIM Card dada de baja correctamente");
        exit;
    } else {
        echo "Error: SIM Card no encontrada.";
    }
} else {
    echo "Error: ID de la SIM Card no proporcionado.";
}
?>
