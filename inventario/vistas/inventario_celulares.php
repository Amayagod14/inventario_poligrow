<?php
require '../db.php';
require '../clases/DispositivoManager.php';

$dispositivoManager = new DispositivoManager($pdo);

try {
    $query = "SELECT c.*, e.nombre, e.cargo, e.area, e.sub_area 
              FROM celulares c 
              LEFT JOIN empleados e ON c.cedula = e.cedula";
    $celulares = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error al obtener datos de celulares: " . $e->getMessage());
    die("Error al obtener los datos. Por favor, contacte al administrador.");
}
?>

<?php include 'header.php'; ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">📱 Inventario de Celulares</h2>

    <div class="d-flex justify-content-end mb-3">
        <a href="agregar_celular.php" class="btn btn-success">➕ Agregar Celular</a>
    </div>

    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="🔍 Buscar...">
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover text-center">
            <thead class="table-dark" style="position: sticky; top: 0;">
                <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Cargo</th>
                    <th>Área</th>
                    <th>Sub Área</th>
                    <th>Serial</th>
                    <th>IMEI</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Fecha Entrega</th>
                    <th>Fecha Compra</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="celularesTable">
                <?php if (!empty($celulares)): ?>
                    <?php foreach ($celulares as $celular): ?>
                        <tr>
                            <td style="text-align: right;"><?= htmlspecialchars($celular['cedula']) ?></td>
                            <td><?= htmlspecialchars($celular['nombre'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($celular['cargo'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($celular['area'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($celular['sub_area'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($celular['serial']) ?></td>
                            <td><?= htmlspecialchars($celular['imei']) ?></td>
                            <td><?= htmlspecialchars($celular['marca']) ?></td>
                            <td><?= htmlspecialchars($celular['modelo']) ?></td>
                            <td><?= htmlspecialchars(date('d/m/Y', strtotime($celular['fecha_entrega']))) ?></td>
                            <td><?= htmlspecialchars($celular['fecha_compra'] ? date('d/m/Y', strtotime($celular['fecha_compra'])) : 'No registrado') ?></td>
                            <td>
                                <a href="entregar_celular.php?serial=<?= $celular['serial'] ?>" class="btn btn-info btn-sm">📦 Entrega</a>
                                <a href="devolver_celular.php?serial=<?= $celular['serial'] ?>" class="btn btn-warning btn-sm">🔄 Devolución</a>
                                <a href="../logica/dar_baja_celular.php?id=<?php echo $celular['id']; ?>" onclick="return confirm('¿Estás seguro de dar de baja?')" class="btn btn-danger btn-sm">❌ Baja</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="12">⚠️ No hay datos disponibles.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.getElementById("searchInput").addEventListener("input", function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#celularesTable tr");

        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
</script>