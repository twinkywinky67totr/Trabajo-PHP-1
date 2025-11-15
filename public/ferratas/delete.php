<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre_ferra'])) {
    $nombreFerra = $_POST['nombre_ferra'];

    foreach ($_SESSION['ferra'] as $index => $ferra) {
        if ($ferra['nombre'] === $nombreFerra) {
            unset($_SESSION['ferra'][$index]);
            $_SESSION['ferra'] = array_values($_SESSION['ferra']);
        }
    }
}

header("Location: ../profile.php");
?>