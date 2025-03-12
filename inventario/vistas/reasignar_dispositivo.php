<?php
require '../db.php'; // Conectar a la base de datos
?>

<?php include 'header.php'; ?> <!-- Incluir el header -->

<h2>Reasignar Dispositivo</h2>
<form method="POST" action="../logica/procesar_reasignar_dispositivo.php">
    <label>Serial del Dispositivo:</label>
    <input type="text" name="serial" id="serial" required onblur="buscarDispositivo()"><br>

    <div id="dispositivo-info" style="display:none;">
        <h3>Información del Dispositivo</h3>
        <label>Tipo:</label>
        <input type="text" name="tipo" id="tipo" readonly><br>

        <label>Marca:</label>
        <input type="text" name="marca" id="marca" readonly><br>

        <label>Modelo:</label>
        <input type="text" name="modelo" id="modelo" readonly><br>

        <label>Placa de Activos:</label>
        <input type="text" name="placa_activos" id="placa_activos" readonly><br>

        <label>Fecha de Compra:</label>
        <input type="date" name="fecha_compra" id="fecha_compra" ><br>

        <label>Linea Celular (solo para SIM):</label>
        <input type="text" name="linea_celular" id="linea_celular" onblur="buscarSimCard()" style="display:none;"><br>
    </div>

    <div id="empleado-info" style="display:none;">
        <h3>Información del Empleado Asignado</h3>
        <label>Cédula:</label>
        <input type="text" name="cedula" id="cedula" readonly><br>

        <label>Nombre:</label>
        <input type="text" name="nombre" id="nombre" readonly><br>
        
        <label>Cargo:</label>
        <input type="text" name="cargo" id="cargo" required><br>

        <label>Área:</label>
        <input type="text" name="area" id="area" required><br>

        <label>Sub Área:</label>
        <input type="text" name="sub_area" id="sub_area" required><br>
    </div>

    <h3>Nueva Asignación</h3>
    <label>Cédula Nuevo Empleado:</label>
    <input type="text" name="cedula_nueva" id="cedula_nueva" onblur="checkNuevoEmpleado()"><br>

    <div id="nuevo-empleado-info" style="display:none;">
        <label>Nombre:</label>
        <input type="text" name="nombre_nuevo" id="nombre_nuevo" readonly><br>

        <label>Cargo:</label>
        <input type="text" name="cargo_nuevo" id="cargo_nuevo" required><br>

        <label>Área:</label>
        <input type="text" name="area_nueva" id="area_nueva" required><br>

        <label>Sub Área:</label>
        <input type="text" name="sub_area_nueva" id="sub_area_nueva" required><br>
    </div>

    <button type="submit">Reasignar Dispositivo</button>
</form>

<script>
function buscarDispositivo() {
    const serial = document.getElementById('serial').value;
    if (serial) {
        fetch(`buscar_dispositivo.php?serial=${serial}`)
            .then(response => response.json())
            .then(data => {
                if (data.existe) {
                    // Mostrar información del dispositivo
                    document.getElementById('dispositivo-info').style.display = 'block';
                    document.getElementById('tipo').value = data.tipo;
                    document.getElementById('marca').value = data.marca;
                    document.getElementById('modelo').value = data.modelo;
                    document.getElementById('placa_activos').value = data.placa_activos;
                    document.getElementById('fecha_compra').value = data.fecha_compra;

                    // Mostrar línea celular si es una tarjeta SIM
                    if (data.tipo === 'sim_card') {
                        document.getElementById('linea_celular').style.display = 'block';
                        document.getElementById('linea_celular').value = data.linea_celular;
                    } else {
                        document.getElementById('linea_celular').style.display = 'none';
                    }

                    // Mostrar información del empleado asignado
                    document.getElementById('empleado-info').style.display = 'block';
                    document.getElementById('cedula').value = data.cedula_asignado;
                    document.getElementById('nombre').value = data.nombre_asignado;
                    document.getElementById('cargo').value = data.cargo_asignado;
                    document.getElementById('area').value = data.area_asignado;
                    document.getElementById('sub_area').value = data.sub_area_asignado;
                } else {
                    alert('Dispositivo no encontrado');
                    document.getElementById('dispositivo-info').style.display = 'none';
                    document.getElementById('empleado-info').style.display = 'none';
                }
            });
    } else {
        document.getElementById('dispositivo-info').style.display = 'none';
        document.getElementById('empleado-info').style.display = 'none';
    }
}

function checkNuevoEmpleado() {
    const cedula = document.getElementById('cedula_nueva').value;
    if (cedula) {
        fetch(`check_empleado.php?cedula=${cedula}`)
            .then(response => response.json())
            .then(data => {
                // Mostrar información del nuevo empleado
                document.getElementById('nuevo-empleado-info').style.display = 'block';
                
                if (data.existe) {
                    document.getElementById('nombre_nuevo').value = data.nombre;
                    document.getElementById('cargo_nuevo').value = data.cargo;
                    document.getElementById('area_nueva').value = data.area;
                    document.getElementById('sub_area_nueva').value = data.sub_area;
                } else {
                    // Limpiar campos si el empleado no existe
                    document.getElementById('nombre_nuevo').value = '';
                    document.getElementById('cargo_nuevo').value = '';
                    document.getElementById('area_nueva').value = '';
                    document.getElementById('sub_area_nueva').value = '';
                }
            });
    } else {
        document.getElementById('nuevo-empleado-info').style.display = 'none';
    }
}
</script>
