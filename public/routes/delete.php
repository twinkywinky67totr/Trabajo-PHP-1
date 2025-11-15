<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre_ruta'])) {
    $nombreRuta = $_POST['nombre_ruta'];

    foreach ($_SESSION['rutas'] as $index => $ruta) {
        if ($ruta['nombre'] === $nombreRuta) {
            unset($_SESSION['rutas'][$index]);
            $_SESSION['rutas'] = array_values($_SESSION['rutas']);
        }
    }
}

header("Location: ../profile.php");
?>