<?php
include('../../includes/header.php');
if (!isset($_GET['nombre'])) {
    header("Location: ../profile.php");
}

$nombreFerra = $_GET['nombre'];

// Buscar la ferrata en la sesión por nombre
$ferra = null;
foreach ($_SESSION['ferra'] as $key => $f) {
    if ($f['nombre'] === $nombreFerra) {
        $ferra = $f;
    }
}

if (!$ferra) {
    echo "Ferrata no encontrada.";
}

$mensaje = "";

// Si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevoNombre = htmlspecialchars($_POST['nombre']);
    $dificultad = $_POST['dificultad'];
    $distancia = $_POST['distancia'];
    $desnivel = $_POST['desnivel'];
    $duracion = $_POST['duracion'];
    $provincia = $_POST['provincia'];
    $epoca = $_POST['epoca'] ?? [];
    $descripcion = htmlspecialchars($_POST['descripcion']);
    $nivel_tecnico = $_POST['nivel_tecnico'];
    $nivel_fisico = $_POST['nivel_fisico'];

    // Mantener las fotos actuales
    $fotos = $ferra['fotos'] ?? [];

    // Si sube nuevas fotos, se añaden
    if (isset($_FILES['fotos']) && !empty($_FILES['fotos']['name'][0])) {
        $total = count($_FILES['fotos']['name']);
        for ($i = 0; $i < $total; $i++) {
            $tmpName = $_FILES['fotos']['tmp_name'][$i];
            $name = basename($_FILES['fotos']['name'][$i]);
            $size = $_FILES['fotos']['size'][$i];
            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

            if (in_array($ext, ['jpg', 'jpeg', 'png']) && $size <= 2 * 1024 * 1024) {
                $nuevoNombreFoto = uniqid('foto_', true) . "." . $ext;
                $destino = __DIR__ . "/../../uploads/photos/" . $nuevoNombreFoto;
                if (move_uploaded_file($tmpName, $destino)) {
                    $fotos[] = $nuevoNombreFoto;
                }
            }
        }
    }

    // Actualizar la ferrata en la sesión
    foreach ($_SESSION['ferra'] as &$f) {
        if ($f['nombre'] === $nombreFerra) {
            $f = [
                "creador" => $f['creador'],
                "nombre" => $nuevoNombre,
                "dificultad" => $dificultad,
                "distancia" => $distancia,
                "desnivel" => $desnivel,
                "duracion" => $duracion,
                "provincia" => $provincia,
                "epoca" => $epoca,
                "descripcion" => $descripcion,
                "nivel_tecnico" => $nivel_tecnico,
                "nivel_fisico" => $nivel_fisico,
                "fotos" => $fotos
            ];
        }
    }

    header("Location: ../profile.php");
}
?>

<link rel="stylesheet" href="/pinga/assets/css/register.css">

<div class="containerDef">
<form action="" method="POST" enctype="multipart/form-data">
    <h2>Editar ferrata: <?php echo htmlspecialchars($ferra['nombre']); ?></h2>

    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?php echo htmlspecialchars($ferra['nombre']); ?>"><br>

    <label>Dificultad:</label>
    <select name="dificultad">
        <?php 
        $niveles = ["Fácil", "Moderada", "Difícil", "Muy difícil"];
        foreach ($niveles as $n) {
            $sel = ($ferra['dificultad'] === $n) ? 'selected' : '';
            echo "<option value='$n' $sel>$n</option>";
        }
        ?>
    </select><br>

    <label>Distancia (km):</label>
    <input type="number" min="0" step="0.1" name="distancia" value="<?php echo $ferra['distancia']; ?>"><br>

    <label>Desnivel (m):</label>
    <input type="number" min="0" name="desnivel" value="<?php echo $ferra['desnivel']; ?>"><br>

    <label>Duración (h):</label>
    <input type="number" min="0" step="0.1" name="duracion" value="<?php echo $ferra['duracion']; ?>"><br>

    <label>Provincia:</label>
    <input type="text" name="provincia" value="<?php echo htmlspecialchars($ferra['provincia']); ?>"><br>

    <label>Época recomendada:</label><br>
    <?php 
    $epocas = ["Primavera", "Verano", "Otoño", "Invierno"];
    foreach ($epocas as $e) {
        $checked = in_array($e, $ferra['epoca']) ? 'checked' : '';
        echo "<input type='checkbox' name='epoca[]' value='$e' $checked> $e<br>";
    }
    ?>

    <label>Descripción:</label><br>
    <input type="text" name="descripcion" value="<?php echo htmlspecialchars($ferra['descripcion']); ?>"><br>

    <label>Nivel técnico:</label>
    <input type="number" min="1" max="5" name="nivel_tecnico" value="<?php echo $ferra['nivel_tecnico']; ?>"><br>

    <label>Nivel físico:</label>
    <input type="number" min="1" max="5" name="nivel_fisico" value="<?php echo $ferra['nivel_fisico']; ?>"><br>

    <label>Fotos actuales:</label><br>
    <?php foreach ($ferra['fotos'] as $foto): ?>
        <img src="/pinga/uploads/photos/<?php echo htmlspecialchars($foto); ?>" width="100" style="margin:5px;">
    <?php endforeach; ?>
    <label>Añadir nuevas fotos:</label>
    <input type="file" name="fotos[]" multiple><br><br>

    <button type="submit">Guardar cambios</button>
    <a href="../profile.php"><button type="button">Cancelar</button></a>
</form>
</div>
<?php include('../../includes/footer.php'); ?>
