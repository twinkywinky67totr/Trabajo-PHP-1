<?php
include('../includes/header.php');
if (!isset($_SESSION['rutas'])) {
    $_SESSION['rutas'] = [];
}
if (!isset($_SESSION['ferra'])) {
    $_SESSION['ferra'] = [];
}
if (!isset($_SESSION['climb'])) {
    $_SESSION['climb'] = [];
}

?>
<link rel="stylesheet" href="../assets/css/register.css">
    <div class="perfil">
        <h2><?php echo $nombreUsuario; ?></h2>
        <label class="title">Correo electrónico:</label>
        <label class="txt"><?php echo $emailSUsuario?></label>
        <label class="title">Especialidad:</label>
        <label class="txt"><?php echo $espUsuario?></label>
        <label class="title">Provincia:</label>
        <label class="txt"><?php echo $provUsuario?></label>
        <label class="title">Nivel:</label>
        <label class="txt"><?php echo $nivelUsuario?></label>
        
        <label class="title">Tus rutas:</label>
        <?php foreach($_SESSION['rutas'] as $ruta): ?>
            <?php if ($ruta['creador'] == $nombreUsuario): ?>
                <div class="container">
                <label><?php echo htmlspecialchars($ruta['nombre']); ?></label>
                <form action="routes/delete.php" method="post" style="display:inline;">
                    <input type="hidden" name="nombre_ruta" value="<?php echo htmlspecialchars($ruta['nombre']); ?>">
                    <button>Borrar Ruta</button>
                </form>
                <form action="routes/edit.php" method="get" style="display:inline;">
                    <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($ruta['nombre']); ?>">
                    <button type="submit">Editar</button>
                </form>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
        
        <label class="title">Tus escaladas:</label>
        <?php foreach($_SESSION['climb'] as $climb): ?>
            <?php if ($climb['creador'] == $nombreUsuario): ?>
                <div class="container">
                <label><?php echo htmlspecialchars($climb['nombre']); ?></label>
                <form action="climbing/delete.php" method="post" style="display:inline;">
                <input type="hidden" name="nombre_climb" value="<?php echo htmlspecialchars($climb['nombre']); ?>">
                <button>Borrar Escalada</button>
            </form>
            <form action="climbing/edit.php" method="get" style="display:inline;">
                    <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($climb['nombre']); ?>">
                    <button type="submit">Editar</button>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
        
        <label class="title">Tus ferratas:</label>
        <?php foreach($_SESSION['ferra'] as $ferra): ?>
            <?php if ($ferra['creador'] == $nombreUsuario): ?>
                <div class="container">
                <label><?php echo htmlspecialchars($ferra['nombre']); ?></label>
                <form action="ferratas/delete.php" method="post" style="display:inline;">
                <input type="hidden" name="nombre_ferra" value="<?php echo htmlspecialchars($ferra['nombre']); ?>">
                <button>Borrar Ferrata</button>
                </form>
                <form action="ferratas/edit.php" method="get" style="display:inline;">
                    <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($ferra['nombre']); ?>">
                    <button type="submit">Editar</button>
                </form>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>

<?php include('../includes/footer.php'); ?>