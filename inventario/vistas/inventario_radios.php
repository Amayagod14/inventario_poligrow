<?php
require '../db.php'; // Conectar a la base de datos
require '../clases/DispositivoManager.php'; // Incluir la clase

$dispositivoManager = new DispositivoManager($pdo);

// Consulta para obtener información de radios junto con los datos del empleado
$query = "
    SELECT r.*, e.nombre 
    FROM radios r 
    JOIN empleados e ON r.cedula = e.cedula
";
$radios = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'header.php'; ?> <!-- Incluir el header -->

<div class="container mt-4">
    <h2 class="text-center mb-4">📻 Inventario de Radios</h2>

    <!-- Botón para agregar radio -->
    <div class="d-flex justify-content-end mb-3">
        <a href="agregar_radio.php" class="btn btn-success">➕ Agregar Radio</a>
    </div>

    <!-- Input de búsqueda -->
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="🔍 Buscar por cédula, empleado, marca...">
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover text-center">
            <thead class="table-dark">
                <tr>
                    <th>Cédula</th>
                    <th>Empleado</th>
                    <th>Serial</th>
                    <th>Marca</th>
                    <th>Placa Activos Fijos</th>
                    <th>Dispositivo</th>
                    <th>Referencia</th>
                    <th>Estado de Entrega</th>
                    <th>Observaciones</th>
                    <th>Fecha de Entrega</th>
                    <th>Fecha de Compra</th> <!-- Nuevo campo -->
                    <th>Acciones</th> <!-- Columna para los botones -->
                </tr>
            </thead>
            <tbody id="radiosTable">
                <?php foreach ($radios as $radio): ?>
                <tr>
                    <td><?= htmlspecialchars($radio['cedula']) ?></td>
                    <td><?= htmlspecialchars($radio['nombre']) ?></td>
                    <td><?= htmlspecialchars($radio['serial']) ?></td>
                    <td><?= htmlspecialchars($radio['marca']) ?></td>
                    <td><?= htmlspecialchars($radio['placa_activos_fijos']) ?></td>
                    <td><?= htmlspecialchars($radio['dispositivo']) ?></td>
                    <td><?= htmlspecialchars($radio['referencia']) ?></td>
                    <td><?= htmlspecialchars($radio['estado_entrega']) ?></td>
                    <td><?= htmlspecialchars($radio['observaciones']) ?></td>
                    <td><?= htmlspecialchars($radio['fecha_entrega']) ?></td>
                    <td><?= htmlspecialchars($radio['fecha_compra']) ?></td> <!-- Nuevo campo -->
                    <td>
                        <a href="entregar_radio.php?serial=<?= htmlspecialchars($radio['serial']) ?>" class="btn btn-info btn-sm">📦 Entrega</a>
                        <a href="devolver_radio.php?serial=<?= htmlspecialchars($radio['serial']) ?>" class="btn btn-warning btn-sm">🔄 Devolución</a>
                        <a href="dar_baja_radio.php?id=<?= htmlspecialchars($radio['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas dar de baja este radio?');">❌ Dar de Baja</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Filtrar la tabla en tiempo real
    document.getElementById("searchInput").addEventListener("keyup", function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#radiosTable tr");

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
</script>
