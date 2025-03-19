<?php
require '../db.php'; // Incluye el archivo de conexión a la base de datos

// Consulta para obtener los dispositivos dados de baja
$query = "SELECT * FROM dispositivos_dados_de_baja";
$stmt = $pdo->query($query);
$dispositivos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dispositivos Dados de Baja</title>
</head>
<body>

<div class="container mt-5">
    <h2>Dispositivos Dados de Baja</h2>

    <div class="table-responsive"> <!-- Contenedor para scroll horizontal -->
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo de Dispositivo</th>
                    <th>ID Dispositivo</th>
                    <th>Cédula</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Serial</th>
                    <th>IMEI</th>
                    <th>Placa Activos</th>
                    <th>MAC</th>
                    <th>RAM</th>
                    <th>Estado Entrega</th>
                    <th>Disco Duro</th>
                    <th>Cuenta Email</th>
                    <th>Referencia</th>
                    <th>Placa Activos Fijos</th>
                    <th>Dispositivo</th>
                    <th>Observaciones</th>
                    <th>Línea Celular</th>
                    <th>Fecha Compra</th>
                    <th>Fecha Baja</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dispositivos as $dispositivo): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($dispositivo['id']); ?></td>
                        <td><?php echo htmlspecialchars($dispositivo['tipo_dispositivo']); ?></td>
                        <td><?php echo htmlspecialchars($dispositivo['id_dispositivo']); ?></td>
                        <td><?php echo htmlspecialchars($dispositivo['cedula']); ?></td>
                        <td><?php echo htmlspecialchars($dispositivo['marca']); ?></td>
                        <td><?php echo htmlspecialchars($dispositivo['modelo']); ?></td>
                        <td><?php echo htmlspecialchars($dispositivo['serial']); ?></td>
                        <td><?php echo htmlspecialchars($dispositivo['imei']); ?></td>
                        <td><?php echo htmlspecialchars($dispositivo['placa_activos']); ?></td>
                        <td><?php echo htmlspecialchars($dispositivo['mac']); ?></td>
                        <td><?php echo htmlspecialchars($dispositivo['ram']); ?></td>
                        <td><?php echo htmlspecialchars($dispositivo['estado_entrega']); ?></td>
                        <td><?php echo htmlspecialchars($dispositivo['disco_duro']); ?></td>
                        <td><?php echo htmlspecialchars($dispositivo['cuenta_email']); ?></td>
                        <td><?php echo htmlspecialchars($dispositivo['referencia']); ?></td>
                        <td><?php echo htmlspecialchars($dispositivo['placa_activos_fijos']); ?></td>
                        <td><?php echo htmlspecialchars($dispositivo['dispositivo']); ?></td>
                        <td><?php echo htmlspecialchars($dispositivo['observaciones']); ?></td>
                        <td><?php echo htmlspecialchars($dispositivo['linea_celular']); ?></td>
                        <td><?php echo htmlspecialchars($dispositivo['fecha_compra']); ?></td>
                        <td><?php echo htmlspecialchars($dispositivo['fecha_baja']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
