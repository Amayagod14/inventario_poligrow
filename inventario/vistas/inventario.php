<?php
require '../db.php'; // Conectar a la base de datos
require '../clases/DispositivoManager.php'; // Incluir la clase

$dispositivoManager = new DispositivoManager($pdo);

// Obtener empleados y sus dispositivos asignados
$query = "
    SELECT e.cedula, e.nombre, 
           GROUP_CONCAT(DISTINCT c.serial SEPARATOR ', ') AS celulares,
           GROUP_CONCAT(DISTINCT co.serial SEPARATOR ', ') AS computadores,
           GROUP_CONCAT(DISTINCT r.serial SEPARATOR ', ') AS radios,
           GROUP_CONCAT(DISTINCT s.linea_celular SEPARATOR ', ') AS sim_cards
    FROM empleados e
    LEFT JOIN celulares c ON e.cedula = c.cedula
    LEFT JOIN computadores co ON e.cedula = co.cedula
    LEFT JOIN radios r ON e.cedula = r.cedula
    LEFT JOIN sim_cards s ON e.cedula = s.cedula
    GROUP BY e.cedula
";
$empleados = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'header.php'; ?> <!-- Incluir el header -->

<div class="container mt-4">
    <h2 class="text-center mb-4">Inventario de Empleados y Dispositivos Asignados</h2>

    <!-- Mensajes de éxito o error -->
    <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['mensaje']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Input de búsqueda -->
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="🔍 Buscar por cédula o nombre...">
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered shadow-sm text-center">
            <thead class="table-dark">
                <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Celulares Asignados</th>
                    <th>Computadores Asignados</th>
                    <th>Radios Asignados</th>
                    <th>SIM Cards Asignadas</th>
                </tr>
            </thead>
            <tbody id="empleadosTable">
                <?php foreach ($empleados as $empleado): ?>
                <tr>
                    <td><?= htmlspecialchars($empleado['cedula']) ?></td>
                    <td><?= htmlspecialchars($empleado['nombre']) ?></td>
                    <td><?= htmlspecialchars($empleado['celulares'] ?: 'Ninguno') ?></td>
                    <td><?= htmlspecialchars($empleado['computadores'] ?: 'Ninguno') ?></td>
                    <td><?= htmlspecialchars($empleado['radios'] ?: 'Ninguno') ?></td>
                    <td><?= htmlspecialchars($empleado['sim_cards'] ?: 'Ninguno') ?></td>
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
        let rows = document.querySelectorAll("#empleadosTable tr");

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
</script>
