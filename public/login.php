<?php
include('../includes/header.php');

if (!isset($_SESSION['usuarios']) || count($_SESSION['usuarios']) === 0) {

}

$usuarioLogin = $usuarioLogin ?? "";

$mensaje= "";
$loginCorrecto = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuarioLogin=htmlspecialchars($_POST["usuario"]);
    $pass= $_POST["password"];

    foreach ($_SESSION['usuarios'] as $usuario) {
    if ($usuario['user'] === $usuarioLogin && $usuario['pass'] === $pass) {
        $_SESSION['usuario_actual'] = $usuario;
        header("Location: index.php");
        $loginCorrecto= true;
    }else {
        $mensaje="Login Invalido, por favor revise las credenciales";
    }
}
}
?>

<link rel="stylesheet" href="../assets/css/register.css">
    <div class="container">
        <h2>Inicia Sesion</h2>

        <?php if (!empty($mensaje)): ?>
        <div class="msg <?php echo (strpos($mensaje, 'Registro completo') === 0) ? 'ok' : 'error'; ?>">
            <?php echo $mensaje; ?>
        </div>
        <?php endif; ?>

        <form action="" method="POST">
            <label>Nombre de usuario</label>
            <input type="text" name="usuario" value="<?php echo $usuarioLogin; ?>">

            <label>Contraseña</label>
            <input type="password" name="password">

            <button type="submit">Iniciar Sesion</button>
        </form>
    </div>
<?php include('../includes/footer.php'); ?>