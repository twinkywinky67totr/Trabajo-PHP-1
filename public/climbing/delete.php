<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre_climb'])) {
    $nombreClimb = $_POST['nombre_climb'];

    foreach ($_SESSION['climb'] as $index => $climb) {
        if ($climb['nombre'] === $nombreClimb) {
            unset($_SESSION['climb'][$index]);
            $_SESSION['climb'] = array_values($_SESSION['climb']);
        }
    }
}

header("Location: ../profile.php");
?>