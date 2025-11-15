<?php
    include('../../includes/header.php');
    if (isset($_SESSION['usuario_actual'])){
        $loginCorrecto = true;
        $nombreUsuario = $_SESSION['usuario_actual']['user'];
    }else {
        $loginCorrecto= false;
    }
    if ($loginCorrecto==false) {
        header("Location: ../login.php");
}
if (!isset($_SESSION['rutas'])) {
    $_SESSION['rutas'] = [];
}
?>
<link rel="stylesheet" href="/pinga/assets/css/register.css">

    <div class="containerDef">
    <h2>Bienvenido, <?php echo htmlspecialchars($nombreUsuario); ?>! Estas son las rutas:</h2>
    

    <?php if (count($_SESSION['rutas']) === 0): ?>
        <label>No hay rutas registradas.</label>
    <?php else: ?>
        <?php foreach($_SESSION['rutas'] as $ruta): ?>
            <div class="container">
                <h2><?php echo htmlspecialchars($ruta['nombre']); ?></h2>
                <label>Dificultad: <?php echo $ruta['dificultad']; ?></label>
                <label>Distancia: <?php echo $ruta['distancia']; ?> km</label>
                <label>Desnivel positivo: <?php echo $ruta['desnivel']; ?> m</label>
                <label>Duración: <?php echo $ruta['duracion']; ?> h</label>
                <label>Provincia: <?php echo $ruta['provincia']; ?></label>
                <label>Época: <?php echo implode(', ', $ruta['epoca']); ?></label>
                <label>Nivel técnico: <?php echo $ruta['nivel_tecnico']; ?></label>
                <label>Nivel físico: <?php echo $ruta['nivel_fisico']; ?></label>
                <label>Descripción: <?php echo nl2br(htmlspecialchars($ruta['descripcion'])); ?></label>
                <div>
                    <?php foreach($ruta['fotos'] as $foto): ?>
                        <img src="../../uploads/photos/<?php echo $foto; ?>" class="miniatura">
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <a href="create.php"><button>Crear nueva ruta</button></a>
    </div>
<?php include('../../includes/footer.php'); ?>
