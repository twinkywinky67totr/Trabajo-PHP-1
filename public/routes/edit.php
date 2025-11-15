<?php
include('../../includes/header.php');
if (!isset($_GET['nombre'])) {
    header("Location: ../profile.php");
}

$nombreRuta = $_GET['nombre'];

// Buscar la ruta en la sesión por nombre
$ruta = null;
foreach ($_SESSION['rutas'] as $key => $r) {
    if ($r['nombre'] === $nombreRuta) {
        $ruta = $r;
    }
}

if (!$ruta) {
    echo "Ruta no encontrada.";
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
    $fotos = $ruta['fotos'] ?? [];

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

    // Actualizar la ruta en la sesión
    foreach ($_SESSION['rutas'] as &$r) {
        if ($r['nombre'] === $nombreRuta) {
            $r = [
                "creador" => $r['creador'],
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
    <h2>Editar ruta: <?php echo htmlspecialchars($ruta['nombre']); ?></h2>

    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?php echo htmlspecialchars($ruta['nombre']); ?>"><br>

    <label>Dificultad:</label>
    <select name="dificultad">
        <?php 
        $niveles = ["Fácil", "Moderada", "Difícil", "Muy difícil"];
        foreach ($niveles as $n) {
            $sel = ($ruta['dificultad'] === $n) ? 'selected' : '';
            echo "<option value='$n' $sel>$n</option>";
        }
        ?>
    </select><br>

    <label>Distancia (km):</label>
    <input type="number" min="0" step="0.1" name="distancia" value="<?php echo $ruta['distancia']; ?>"><br>

    <label>Desnivel (m):</label>
    <input type="number"min="0"  name="desnivel" value="<?php echo $ruta['desnivel']; ?>"><br>

    <label>Duración (h):</label>
    <input type="number" min="0" step="0.1" name="duracion" value="<?php echo $ruta['duracion']; ?>"><br>

    <label>Provincia:</label>
    <input type="text" name="provincia" value="<?php echo htmlspecialchars($ruta['provincia']); ?>"><br>

    <label>Época recomendada:</label><br>
    <?php 
    $epocas = ["Primavera", "Verano", "Otoño", "Invierno"];
    foreach ($epocas as $e) {
        $checked = in_array($e, $ruta['epoca']) ? 'checked' : '';
        echo "<input type='checkbox' name='epoca[]' value='$e' $checked> $e<br>";
    }
    ?>

    <label>Descripción:</label><br>
    <input type="text" name="descripcion" value="<?php echo htmlspecialchars($ruta['descripcion']); ?>"><br>

    <label>Nivel técnico:</label>
    <input type="number" min="1" max="5" name="nivel_tecnico" value="<?php echo $ruta['nivel_tecnico']; ?>"><br>

    <label>Nivel físico:</label>
    <input type="number" min="1" max="5" name="nivel_fisico" value="<?php echo $ruta['nivel_fisico']; ?>"><br>

    <label>Fotos actuales:</label><br>
    <?php foreach ($ruta['fotos'] as $foto): ?>
        <img src="/pinga/uploads/photos/<?php echo htmlspecialchars($foto); ?>" width="100" style="margin:5px;">
    <?php endforeach; ?>
    <button type="submit">Guardar cambios</button>
    <a href="../profile.php"><button type="button">Cancelar</button></a>
</div>
<?php include('../../includes/footer.php'); ?>

