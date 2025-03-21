<?php
require '../db.php'; // Conectar a la base de datos
require '../clases/DispositivoManager.php'; // Incluir la clase

$dispositivoManager = new DispositivoManager($pdo);

// Obtener la información de los computadores junto con la información del empleado
$query = "
    SELECT c.*, e.nombre, e.cargo, e.area, e.sub_area 
    FROM computadores c
    LEFT JOIN empleados e ON c.cedula = e.cedula
";
$computadores = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'header.php'; ?> <!-- Incluir el header -->

<div class="container mt-4">
    <h2 class="text-center mb-4">🖥️ Inventario de Computadores</h2>

    <!-- Botón para agregar computador -->
    <div class="d-flex justify-content-end mb-3">
        <a href="agregar_computador.php" class="btn btn-success">➕ Agregar Computador</a>
    </div>

    <!-- Input de búsqueda -->
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="🔍 Buscar por cédula, nombre, marca...">
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover text-center">
            <thead class="table-dark">
                <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Cargo</th>
                    <th>Área</th>
                    <th>Sub Área</th>
                    <th>Dispositivo</th>
                    <th>Marca</th>
                    <th>Referencia</th>
                    <th>MAC</th>
                    <th>Serial</th>
                    <th>RAM</th>
                    <th>Estado de Entrega</th>
                    <th>Fecha de Entrega</th>
                    <th>Fecha de Compra</th> <!-- Nuevo campo -->
                    <th>Acciones</th> <!-- Nueva columna para acciones -->
                </tr>
            </thead>
            <tbody id="computadoresTable">
                <?php foreach ($computadores as $computador): ?>
                <tr>
                    <td><?= htmlspecialchars($computador['cedula']) ?></td>
                    <td><?= htmlspecialchars($computador['nombre']) ?></td>
                    <td><?= htmlspecialchars($computador['cargo']) ?></td>
                    <td><?= htmlspecialchars($computador['area']) ?></td>
                    <td><?= htmlspecialchars($computador['sub_area']) ?></td>
                    <td><?= htmlspecialchars($computador['dispositivo']) ?></td>
                    <td><?= htmlspecialchars($computador['marca']) ?></td>
                    <td><?= htmlspecialchars($computador['referencia']) ?></td>
                    <td><?= htmlspecialchars($computador['mac']) ?></td>
                    <td><?= htmlspecialchars($computador['serial']) ?></td>
                    <td><?= htmlspecialchars($computador['ram']) ?></td>
                    <td><?= htmlspecialchars($computador['estado_entrega']) ?></td>
                    <td><?= htmlspecialchars($computador['fecha_entrega']) ?></td>
                    <td><?= htmlspecialchars($computador['fecha_compra']) ?></td> <!-- Nuevo campo -->
                    <td>
                        <a href="entregar_computador.php?serial=<?= urlencode($computador['serial']) ?>" class="btn btn-info btn-sm">📦 Entrega</a>
                        <a href="devolver_computador.php?serial=<?= urlencode($computador['serial']) ?>" class="btn btn-warning btn-sm">🔄 Devolución</a>
                        <a href="../logica/dar_baja_computador.php?id=<?= urlencode($computador['id']) ?>" onclick="return confirm('¿Estás seguro de que quieres dar de baja este computador?')" class="btn btn-danger btn-sm">❌ Dar de Baja</a>
                    </td> <!-- Botones de acción -->
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
        let rows = document.querySelectorAll("#computadoresTable tr");

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
</script>
