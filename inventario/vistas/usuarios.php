<?php
require '../db.php'; // Conexión a la base de datos
include 'header.php';
// Consultar todos los responsables
$query = "SELECT * FROM responsables_inventario";
$stmt = $pdo->query($query);
$responsables = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Responsables</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Tu CSS personalizado -->
</head>
<body>

<div class="container mt-4">
    <h1 class="text-center text-primary mb-4">Gestión de Responsables de Inventario</h1>

    <!-- Tabla de Responsables -->
    <div class="card shadow">
        <div class="card-body">
            <h2 class="text-secondary text-center">Lista de Responsables</h2>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Cédula</th>
                            <th>Cargo</th>
                            <th>Área</th>
                            <th>Sub-área</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($responsables as $responsable): ?>
                        <tr class="text-center">
                            <td><?php echo $responsable['id']; ?></td>
                            <td><?php echo $responsable['nombre']; ?></td>
                            <td><?php echo $responsable['cedula']; ?></td>
                            <td><?php echo $responsable['cargo']; ?></td>
                            <td><?php echo $responsable['area']; ?></td>
                            <td><?php echo $responsable['sub_area']; ?></td>
                            <td>
                                <form action="eliminar_responsable.php" method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?php echo $responsable['id']; ?>">
                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este responsable?');">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Formulario de Agregar Responsable -->
    <div class="card mt-4 shadow">
        <div class="card-body">
            <h2 class="text-secondary text-center">Agregar Nuevo Responsable</h2>
            <form action="agregar_responsable.php" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="text" name="cedula" class="form-control" placeholder="Cédula" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="text" name="cargo" class="form-control" placeholder="Cargo" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="text" name="area" class="form-control" placeholder="Área" required>
                    </div>
                    <div class="col-12 mb-3">
                        <input type="text" name="sub_area" class="form-control" placeholder="Sub-área">
                    </div>
                </div>
                <button type="submit" class="btn btn-success w-100">Agregar Responsable</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
