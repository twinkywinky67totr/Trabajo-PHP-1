<?php
    include('../includes/header.php');
    if (isset($_SESSION['usuario_actual'])){
        $loginCorrecto = true;
        $nombreUsuario = $_SESSION['usuario_actual']['user'];
    }else {
        $loginCorrecto= false;
    }
?>
<link rel="stylesheet" href="/pinga/assets/css/register.css">
        <div class="containerR">
            <h2>Escalada</h2>
            <img src="../assets/images/escalada.png" alt="Escalada">
            <button onclick="window.location.href='../public/climbing/list.php'">Explora más</button>
        </div>
        <div class="containerR">
            <h2>Rutas</h2>
            <img src="../assets/images/ruta.png" alt="Rutas">
            <button onclick="window.location.href='../public/routes/list.php'">Explora más</button>
        </div>
        <div class="containerR">
            <h2>Ferratas</h2>
            <img src="../assets/images/ferrata.png" alt="Ferratas">
            <button onclick="window.location.href='../public/ferratas/list.php'">Explora más</button>
        </div>
<?php include('../includes/footer.php'); ?>