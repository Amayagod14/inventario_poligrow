<?php
require '../db.php'; // Conectar a la base de datos
require '../clases/DispositivoManager.php'; // Incluir la clase

$dispositivoManager = new DispositivoManager($pdo);
$simCards = $pdo->query("SELECT * FROM sim_cards")->fetchAll(PDO::FETCH_ASSOC);
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
        <table class="table table-striped table-hover text-center">
            <thead class="table-dark">
                <tr>
                    <th>Cédula</th>
                    <th>Dispositivo</th>
                    <th>Línea Celular</th>
                    <th>Fecha de Compra</th> <!-- Nuevo campo -->
                </tr>
            </thead>
            <tbody id="simCardsTable">
                <?php foreach ($simCards as $simCard): ?>
                <tr>
                    <td><?= htmlspecialchars($simCard['cedula']) ?></td>
                    <td><?= htmlspecialchars($simCard['dispositivo']) ?></td>
                    <td><?= htmlspecialchars($simCard['linea_celular']) ?></td>
                    <td><?= htmlspecialchars($simCard['fecha_compra']) ?></td> <!-- Nuevo campo -->
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
        let rows = document.querySelectorAll("#simCardsTable tr");

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
</script>
