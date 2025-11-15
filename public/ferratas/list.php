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
if (!isset($_SESSION['ferra'])) {
    $_SESSION['ferra'] = [];
}
?>
<link rel="stylesheet" href="/pinga/assets/css/register.css">

    <div class="containerDef">
    <h2>Bienvenido, <?php echo htmlspecialchars($nombreUsuario); ?>! Estas son las ferratas:</h2>
    

    <?php if (count($_SESSION['ferra']) === 0): ?>
        <label>No hay rutas registradas.</label>
    <?php else: ?>
        <?php foreach($_SESSION['ferra'] as $ferra): ?>
            <div class="container">
                <h2><?php echo htmlspecialchars($ferra['nombre']); ?></h2>
                <label>Dificultad: <?php echo $ferra['dificultad']; ?></label>
                <label>Distancia: <?php echo $ferra['distancia']; ?> km</label>
                <label>Desnivel positivo: <?php echo $ferra['desnivel']; ?> m</label>
                <label>Duración: <?php echo $ferra['duracion']; ?> h</label>
                <label>Provincia: <?php echo $ferra['provincia']; ?></label>
                <label>Época: <?php echo implode(', ', $ferra['epoca']); ?></label>
                <label>Nivel técnico: <?php echo $ferra['nivel_tecnico']; ?></label>
                <label>Nivel físico: <?php echo $ferra['nivel_fisico']; ?></label>
                <label>Descripción: <?php echo nl2br(htmlspecialchars($ferra['descripcion'])); ?></label>
                <div>
                    <?php foreach($ferra['fotos'] as $foto): ?>
                        <img src="../../uploads/photos/<?php echo $foto; ?>" class="miniatura">
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <a href="create.php"><button>Crear nueva ferrata</button></a>
    </div>
<?php include('../../includes/footer.php'); ?>
