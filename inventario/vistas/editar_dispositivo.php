<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Dispositivo</title>
</head>
<body>
    <h2>Editar Dispositivo</h2>
    <?php
    require '../db.php'; // Conectar a la base de datos

    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM celulares WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $dispositivo = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>

    <form action="logica/editar_dispositivo_logica.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($dispositivo['id']); ?>">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($dispositivo['nombre']); ?>" required>
        <br>
        <label for="estado">Estado:</label>
        <select id="estado" name="estado" required>
            <option value="activo" <?php echo $dispositivo['estado'] == 'activo' ? 'selected' : ''; ?>>Activo</option>
            <option value="baja" <?php echo $dispositivo['estado'] == 'baja' ? 'selected' : ''; ?>>Baja</option>
        </select>
        <br>
        <input type="submit" value="Guardar Cambios">
    </form>
</body>
</html>
