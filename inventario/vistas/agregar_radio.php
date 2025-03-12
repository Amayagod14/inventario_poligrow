<?php

require '../db.php'; // Conectar a la base de datos
require '../clases/DispositivoManager.php'; // Incluir la clase

$dispositivoManager = new DispositivoManager($pdo);
?>

<?php include 'header.php'; ?> <!-- Incluir el header -->

<h2>Agregar Nuevo Radio</h2>
<form method="POST" action="../logica/procesar_agregar_radio.php">
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

    <label>Serial:</label>
    <input type="text" name="serial" required><br>

    <label>Marca:</label>
    <input type="text" name="marca" required><br>

    <label>Placa Activos Fijos:</label>
    <input type="text" name="placa_activos_fijos" required><br>

    <label>Dispositivo:</label>
    <input type="text" name="dispositivo" required><br>

    <label>Referencia:</label>
    <input type="text" name="referencia" required><br>

    <label>Estado de Entrega:</label>
    <input type="text" name="estado_entrega" required><br>

    <label>Observaciones:</label>
    <textarea name="observaciones"></textarea><br>

    <label>Fecha:</label>
    <input type="date" name="fecha" required><br>

    <label>Fecha de Compra:</label>
    <input type="date" name="fecha_compra" required><br>

    <button type="submit">Agregar Radio</button>
</form>

<script>
function checkEmpleado() {
    const cedula = document.getElementById('cedula').value;
    if (cedula) {
        fetch(`check_empleado.php?cedula=${cedula}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('empleado-info').style.display = 'block';
                
                if (data.existe) {
                    document.getElementById('nombre').value = data.nombre;
                    document.getElementById('nombre').readOnly = true; // Solo lectura
                    document.getElementById('cargo').value = data.cargo;
                    document.getElementById('area').value = data.area;
                    document.getElementById('sub_area').value = data.sub_area;
                } else {
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
