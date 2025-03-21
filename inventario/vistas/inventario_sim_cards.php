<?php
require '../db.php'; // Conectar a la base de datos
require '../clases/DispositivoManager.php'; // Incluir la clase

$dispositivoManager = new DispositivoManager($pdo);

// Actualizar la consulta para incluir el nombre del empleado
$query = "
    SELECT s.*, e.nombre 
    FROM sim_cards s
    LEFT JOIN empleados e ON s.cedula = e.cedula
";
$simCards = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'header.php'; ?> <!-- Incluir el header -->

<div class="container mt-4">
    <h2 class="text-center mb-4">📶 Inventario de SIM Cards</h2>

    <!-- Botón para agregar SIM Card -->
    <div class="d-flex justify-content-end mb-3">
        <a href="agregar_sim_card.php" class="btn btn-success">➕ Agregar SIM Card</a>
    </div>

    <!-- Input de búsqueda -->
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="🔍 Buscar por cédula, dispositivo, línea celular...">
    </div>

    <div class="table-responsive">
        <!-- Contenedor para el scroll superior -->
        <div style="overflow-x: auto; margin-bottom: -1px;">
            <table class="table table-striped table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Cédula</th>
                        <th>Nombre del Empleado</th> <!-- Nueva columna para el nombre del empleado -->
                        <th>Dispositivo</th>
                        <th>Línea Celular</th>
                        <th>Fecha de Compra</th> <!-- Campo existente -->
                        <th>Fecha de Entrega</th> <!-- Nuevo campo agregado -->
                        <th>Acciones</th> <!-- Columna para los botones -->
                    </tr>
                </thead>
            </table>
        </div>
        <!-- Contenedor para la tabla -->
        <div style="overflow-x: auto;">
            <table class="table table-striped table-hover text-center">
                <tbody id="simCardsTable">
                    <?php foreach ($simCards as $simCard): ?>
                    <tr>
                        <td><?= htmlspecialchars($simCard['cedula']) ?></td>
                        <td><?= htmlspecialchars($simCard['nombre']) ?></td> <!-- Mostrar nombre del empleado -->
                        <td><?= htmlspecialchars($simCard['dispositivo']) ?></td>
                        <td><?= htmlspecialchars($simCard['linea_celular']) ?></td>
                        <td><?= htmlspecialchars($simCard['fecha_compra']) ?></td> <!-- Campo existente -->
                        <td><?= htmlspecialchars($simCard['fecha_entrega']) ?></td> <!-- Nuevo campo agregado -->
                        <td>
                            <div class="d-flex flex-column align-items-center">
                                <a href="entregar_sim_card.php?id=<?= htmlspecialchars($simCard['id']) ?>" class="btn btn-info btn-sm mb-1">📦 Entrega</a>
                                <a href="devolver_sim_card.php?id=<?= htmlspecialchars($simCard['id']) ?>" class="btn btn-warning btn-sm mb-1">🔄 Devolución</a>
                                <a href="../logica/dar_baja_sim_card.php?id=<?= htmlspecialchars($simCard['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas dar de baja esta SIM Card?');">🗑️ Dar de Baja</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Filtrar la tabla en tiempo real
    document.getElementById("searchInput").addEventListener("keyup", function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#simCardsTable tr");

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
</script>
