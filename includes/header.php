<?php
session_start();
if (isset($_SESSION['usuario_actual'])){
$loginCorrecto = true;
$nombreUsuario = $_SESSION['usuario_actual']['user'];
$emailSUsuario = $_SESSION['usuario_actual']['gmail'];
$provUsuario = $_SESSION['usuario_actual']['prov'];
$espUsuario = $_SESSION['usuario_actual']['esp'];
$nivelUsuario = $_SESSION['usuario_actual']['nivel'];
}else {
    $loginCorrecto= false;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registro de Usuario</title>


</head>
<body>
    <header>
        <h1> </h1>
        <nav>
            <?php if ($loginCorrecto == true): ?>
            
            <a href="/pinga/public/index.php">Inicio</a></li>
            <a href="/pinga/public/logout.php">Cerrar Sesion</a></li>
            <a href="/pinga/public/profile.php"><?php echo $nombreUsuario; ?></a></li>
            <?php else: ?>
            <a href="/pinga/public/login.php">Iniciar sesión</a></li>
            <a href="/pinga/public/register.php">Registrarse</a></li>
            <a href="/pinga/public/index.php">Inicio</a></li>
            <?php endif; ?>
        </nav>
    </header>
    <main>