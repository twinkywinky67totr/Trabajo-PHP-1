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
if (!isset($_SESSION['climb'])) {
    $_SESSION['climb'] = [];
}
?>
<link rel="stylesheet" href="/pinga/assets/css/register.css">

    <div class="containerDef">
    <h2>Bienvenido, <?php echo htmlspecialchars($nombreUsuario); ?>! Estas son las rutas escaladas:</h2>
    

    <?php if (count($_SESSION['climb']) === 0): ?>
        <label>No hay rutas registradas.</label>
    <?php else: ?>
        <?php foreach($_SESSION['climb'] as $climb): ?>
            <div class="container">
                <h2><?php echo htmlspecialchars($climb['nombre']); ?></h2>
                <label>Dificultad: <?php echo $climb['dificultad']; ?></label>
                <label>Distancia: <?php echo $climb['distancia']; ?> km</label>
                <label>Desnivel positivo: <?php echo $climb['desnivel']; ?> m</label>
                <label>Duración: <?php echo $climb['duracion']; ?> h</label>
                <label>Provincia: <?php echo $climb['provincia']; ?></label>
                <label>Época: <?php echo implode(', ', $climb['epoca']); ?></label>
                <label>Nivel técnico: <?php echo $climb['nivel_tecnico']; ?></label>
                <label>Nivel físico: <?php echo $climb['nivel_fisico']; ?></label>
                <label>Descripción: <?php echo nl2br(htmlspecialchars($climb['descripcion'])); ?></label>
                <div>
                    <?php foreach($climb['fotos'] as $foto): ?>
                        <img src="../../uploads/photos/<?php echo $foto; ?>" class="miniatura">
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <a href="create.php"><button>Crear nueva escalada</button></a>
    </div>
<?php include('../../includes/footer.php'); ?>
