<?php
require '../db.php'; // Conectar a la base de datos

// Obtener todas las impresoras junto con los datos del empleado asignado
$query = "
    SELECT 
        impresoras.*, 
        empleados.nombre, 
        empleados.cargo, 
        empleados.area, 
        empleados.sub_area 
    FROM 
        impresoras 
    LEFT JOIN 
        empleados ON impresoras.cedula = empleados.cedula
";

$impresoras = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'header.php'; ?> <!-- Incluir el header -->

<div class="container mt-4">
    <h2 class="text-center mb-4">🖨️ Inventario de Impresoras</h2>

    <!-- Botón para agregar Impresora -->
    <div class="d-flex justify-content-end mb-3">
        <a href="agregar_impresoras.php" class="btn btn-success">➕ Agregar Impresora</a>
    </div>

    <!-- Input de búsqueda -->
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="🔍 Buscar por cédula, nombre, cargo...">
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
                    <th>Serial</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Placa de Activos</th>
                    <th>Estado</th>
                    <th>Fecha de Compra</th>
                </tr>
            </thead>
            <tbody id="impresorasTable">
                <?php foreach ($impresoras as $impresora): ?>
                <tr>
                    <td><?= htmlspecialchars($impresora['cedula']) ?></td>
                    <td><?= htmlspecialchars($impresora['nombre']) ?></td>
                    <td><?= htmlspecialchars($impresora['cargo']) ?></td>
                    <td><?= htmlspecialchars($impresora['area']) ?></td>
                    <td><?= htmlspecialchars($impresora['sub_area']) ?></td>
                    <td><?= htmlspecialchars($impresora['serial']) ?></td>
                    <td><?= htmlspecialchars($impresora['marca']) ?></td>
                    <td><?= htmlspecialchars($impresora['modelo']) ?></td>
                    <td><?= htmlspecialchars($impresora['placa_activos']) ?></td>
                    <td><?= htmlspecialchars($impresora['estado']) ?></td>
                    <td><?= htmlspecialchars($impresora['fecha_compra']) ?></td>
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
        let rows = document.querySelectorAll("#impresorasTable tr");

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
</script>
