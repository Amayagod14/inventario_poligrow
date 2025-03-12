<?php
require '../db.php'; // Conectar a la base de datos

// Obtener empleados para el dropdown
$empleados = $pdo->query("SELECT cedula, nombre FROM empleados")->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include 'header.php'; ?> <!-- Incluir el header -->

<h2>Agregar Impresora</h2>
<form method="POST" action="../logica/procesar_agregar_impresoras.php">
    <label>Cédula:</label>
    <input type="text" name="cedula" id="cedula" required onblur="checkEmpleado()"><br>

    <div id="empleado-info" style="display:none;">
        <label>Nombre:</label>
        <input type="text" name="nombre" id="nombre" readonly><br>
        
        <label>Cargo:</label>
        <input type="text" name="cargo" id="cargo" required><br>

        <label>Área:</label>
        <input type="text" name="area" id="area" required><br>

        <label>Sub Área:</label>
        <input type="text" name="sub_area" id="sub_area" required><br>
    </div>

    <label>Marca:</label>
    <input type="text" name="marca" required><br>

    <label>Modelo:</label>
    <input type="text" name="modelo" required><br>

    <label>Serial:</label>
    <input type="text" name="serial" required><br>

    <label>Placa de Activos:</label>
    <input type="text" name="placa_activos" required><br>

    <label>Estado:</label>
    <input type="text" name="estado" required><br>

    <label>Fecha de Asignación:</label>
    <input type="date" name="fecha_asignacion" required><br>

    <label>Fecha de Compra:</label>
    <input type="date" name="fecha_compra" required><br>

    <label>Observaciones:</label> <!-- Nuevo campo -->
    <textarea name="observaciones" rows="4" cols="50"></textarea><br>

    <button type="submit">Agregar Impresora</button>
</form>

<script>
function checkEmpleado() {
    const cedula = document.getElementById('cedula').value;
    if (cedula) {
        fetch(`check_empleado.php?cedula=${cedula}`)
            .then(response => response.json())
            .then(data => {
                // Mostrar los campos de información del empleado
                document.getElementById('empleado-info').style.display = 'block';
                
                if (data.existe) {
                    // Si el empleado existe, llenar los campos y hacerlos de solo lectura
                    document.getElementById('nombre').value = data.nombre;
                    document.getElementById('nombre').readOnly = true; // Solo lectura
                    document.getElementById('cargo').value = data.cargo;
                    document.getElementById('area').value = data.area;
                    document.getElementById('sub_area').value = data.sub_area;
                } else {
                    // Si el empleado no existe, limpiar los campos y permitir edición
                    document.getElementById('nombre').value = '';
                    document.getElementById('nombre').readOnly = false; // Editable
                    document.getElementById('cargo').value = '';
                    document.getElementById('area').value = '';
                    document.getElementById('sub_area').value = '';
                }
            });
    } else {
        document.getElementById('empleado-info').style.display = 'none';
    }
}
</script>
