<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Inventario</title>
    <link rel="stylesheet" href="../css/style.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Personalización del menú desplegable */
        .dropdown-menu {
            background-color: #343a40; /* Fondo oscuro */
        }
        .dropdown-item {
            color: white !important; /* Texto blanco */
        }
        .dropdown-item:hover {
            background-color: #495057; /* Color al pasar el mouse */
        }
    </style>
</head>
<body>

<header class="bg-dark text-white py-3">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Botón de Inicio -->
        <a href="inventario.php" class="btn btn-light">🏠 Inicio</a>

        <!-- Título -->
        <h1 class="h3">📋 Gestión de Inventario</h1>

        <!-- Menú desplegable -->
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                📌 Opciones de Inventario
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="inventario_sim_cards.php">📶 SIM Cards</a></li>
                <li><a class="dropdown-item" href="inventario_celulares.php">📱 Celulares</a></li>
                <li><a class="dropdown-item" href="inventario_radios.php">📡 Radios</a></li>
                <li><a class="dropdown-item" href="inventario_computadores.php">💻 Computadores</a></li>
                <li><a class="dropdown-item" href="inventario_impresoras.php">🖨️ Impresoras</a></li>
                <li><a class="dropdown-item" href="reasignar_dispositivo.php">🔄 Reasignar</a></li>
                <li><a class="dropdown-item" href="usuarios.php">👤 Gestión de Responsables</a></li> <!-- Nuevo enlace -->
            </ul>
        </div>
    </div>
</header>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
