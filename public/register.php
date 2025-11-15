<?php
include('../includes/header.php');
if (!isset($_SESSION['usuarios'])) {
    $_SESSION['usuarios'] = [];
}

$usuario = $usuario ?? "";
$email = $email ?? "";
$nivel = $nivel ?? "vacio";
$especialidad = $especialidad ?? "";
$provincia = $provincia ?? "";
$mensaje= "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario=htmlspecialchars($_POST["usuario"]);
    $email=htmlspecialchars($_POST["email"]);
    $pass1= $_POST["password"];
    $pass2= $_POST["password2"];
    $nivel= $_POST["nivel"];
    $especialidad= $_POST["especialidad"];
    $provincia= $_POST["provincia"];
    if(empty($usuario) || empty($email) || empty($pass1) ||empty($pass2)|| $nivel=="vacio" || empty($especialidad) || empty($provincia)){
        $mensaje="Registro no valido: Todos los campos han de estar rellenos";
    }elseif ($pass1!=$pass2) {
        $mensaje="Resgitro no valido: Las contraseñas no coinciden";
    }elseif (strlen($pass1)<6){
        $mensaje="Registro no valido: La contraseña debe tener minimo 6 caracteres";
    }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "Registro no valido: Formato de Email incorrecto";
    }else {
        // Verificar si el usuario ya existe
        $usuarioExistente = false;
        foreach ($_SESSION['usuarios'] as $u) {
            if ($u['user'] === $usuario) {
                $usuarioExistente = true;
                break;
            }
        }

        if ($usuarioExistente) {
            $mensaje = "Registro no valido: El usuario ya existe";
        }else{
        $mensaje = "Registro completo, bienvenido ".$usuario." !!!";
        $_SESSION['usuarios'][]=[
            "user" => $usuario,
            "gmail" => $email,
            "pass" => $pass1,
            "nivel" => $nivel,
            "esp"=> $especialidad,
            "prov" => $provincia,
        ];
        header('Location: login.php');


    }
    }
}
    ?>

<link rel="stylesheet" href="../assets/css/register.css">
    <div class="container">
        <h2>Crear cuenta</h2>

        <?php if (!empty($mensaje)): ?>
        <div class="msg <?php echo (strpos($mensaje, 'Registro completo') === 0) ? 'ok' : 'error'; ?>">
            <?php echo $mensaje; ?>
        </div>
        <?php endif; ?>

        <form action="" method="POST">
            <label>Nombre de usuario</label>
            <input type="text" name="usuario" placeholder="Ej: usuario" value="<?php echo $usuario; ?>">

            <label>Correo electrónico</label>
            <input type="text" name="email" placeholder="ejmp@correo.com" value="<?php echo $email; ?>">

            <label>Contraseña</label>
            <input type="password" name="password">

            <label>Repetir contraseña</label>
            <input type="password" name="password2">

            <label>Selecciona tu nivel</label>
            <select name="nivel">
                <option value="vacio"></option>
                <option value="Basico" <?php if ($nivel=="Basico") echo "selected"; ?>>Básico</option>
                <option value="Intermedio" <?php if ($nivel=="Intermedio") echo "selected"; ?>>Intermedio</option>
                <option value="Avanzado" <?php if ($nivel=="Avanzado") echo "selected"; ?>>Avanzado</option>
                <option value="Experto" <?php if ($nivel=="Experto") echo "selected"; ?>>Experto</option>
            </select>

            <label>Especialidad</label>
            <input type="text" name="especialidad" placeholder="Escalada" value="<?php echo $especialidad; ?>">

            <label>Provincia</label>
            <input type="text" name="provincia" placeholder="Zaragoza" value="<?php echo $provincia; ?>">

            <button type="submit">Registrarse</button>
        </form>
    </div>
<?php include('../includes/footer.php'); ?>