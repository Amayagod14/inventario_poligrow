<?php
require '../db.php'; // Conexión a la base de datos

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Obtener los datos del celular
    $query_select = "SELECT * FROM celulares WHERE id = :id";
    $stmt_select = $pdo->prepare($query_select);
    $stmt_select->execute([':id' => $id]);
    $celular = $stmt_select->fetch(PDO::FETCH_ASSOC);

    if ($celular) {
        // 2. Insertar los datos en la tabla dispositivos_dados_de_baja
        $query_insert = "
            INSERT INTO dispositivos_dados_de_baja (
                tipo_dispositivo, id_dispositivo, cedula, marca, modelo, 
                serial, imei, placa_activos, fecha_compra, fecha_baja
            ) VALUES (
                'celular', :id_dispositivo, :cedula, :marca, :modelo, 
                :serial, :imei, :placa_activos, :fecha_compra, CURDATE()
            )
        ";
        $stmt_insert = $pdo->prepare($query_insert);
        $stmt_insert->execute([
            ':id_dispositivo' => $celular['id'],
            ':cedula' => $celular['cedula'],
            ':marca' => $celular['marca'],
            ':modelo' => $celular['modelo'],
            ':serial' => $celular['serial'],
            ':imei' => $celular['imei'],
            ':placa_activos' => $celular['placa_activos'],
            ':fecha_compra' => $celular['fecha_compra']
        ]);

        // 3. Eliminar el registro de la tabla celulares
        $query_delete = "DELETE FROM celulares WHERE id = :id";
        $stmt_delete = $pdo->prepare($query_delete);
        $stmt_delete->execute([':id' => $id]);

        // Redireccionar o mostrar un mensaje de éxito
        header("Location: ../vistas/inventario_celulares.php?mensaje=Celular dado de baja correctamente");
        exit;
    } else {
        echo "Error: Celular no encontrado.";
    }
} else {
    echo "Error: ID del celular no proporcionado.";
}
?>