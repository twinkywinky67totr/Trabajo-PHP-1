<?php
    include('../../includes/header.php');
    if (!isset($_SESSION['ferra'])) {
        $_SESSION['ferra'] = [];
    }
    $nombreUsuario = $_SESSION['usuario_actual']['user'];
    $nombre = $nombre ?? "";
    $dificultad = $dificultad ?? "";
    $distancia = $distancia ?? "";
    $desnivel = $desnivel ?? "";
    $duracion = $duracion ?? "";
    $provincia = $provincia ?? "";
    $epoca = $epoca ?? []; // Array de checkboxes
    $descripcion = $descripcion ?? "";
    $nivel_tecnico = $nivel_tecnico ?? "";
    $nivel_fisico = $nivel_fisico ?? "";
    $fotos_subidas = $fotos_subidas ?? [];

    $mensaje = "";


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre = htmlspecialchars($_POST['nombre'] ?? '');
        $dificultad = $_POST['dificultad'] ?? '';
        $distancia = $_POST['distancia'] ?? '';
        $desnivel = $_POST['desnivel'] ?? '';
        $duracion = $_POST['duracion'] ?? '';
        $provincia = $_POST['provincia'] ?? '';
        $epoca = $_POST['epoca'] ?? [];
        $descripcion = htmlspecialchars($_POST['descripcion'] ?? '');
        $nivel_tecnico = $_POST['nivel_tecnico'] ?? '';
        $nivel_fisico = $_POST['nivel_fisico'] ?? '';
        
        $fotos_subidas = [];

        if (!$nombre || !$dificultad || !$distancia || !$desnivel || !$duracion || !$provincia || !$descripcion || !$nivel_tecnico || !$nivel_fisico || empty($epoca)) {
            $mensaje = "Todos los campos son obligatorios";
        } else {
            if (isset($_FILES['fotos'])) {
                $total = count($_FILES['fotos']['name']);
                for ($i=0; $i<$total; $i++) {
                    $tmpName = $_FILES['fotos']['tmp_name'][$i];
                    $name = basename($_FILES['fotos']['name'][$i]);
                    $size = $_FILES['fotos']['size'][$i];
                    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                    
                    if (!in_array($ext, ['jpg','jpeg','png'])) {
                        $mensaje = "Solo se permiten imágenes JPG, JPEG o PNG";
                        break;
                    }
                    
                    if ($size > 2*1024*1024) {
                        $mensaje = "Cada imagen no puede superar 2MB";
                        break;
                    }
                    
                    $nuevoNombre = uniqid('foto_', true).".".$ext;
                    $destino = __DIR__."/../../uploads/photos/".$nuevoNombre;
                    if (!move_uploaded_file($tmpName, $destino)) {
                        $mensaje = "Error al subir las imágenes";
                        break;
                    }
                    $fotos_subidas[] = $nuevoNombre;
                }
            }

            if (!$mensaje) {
                $_SESSION['ferra'][] = [
                    "creador"=> $nombreUsuario,
                    "nombre" => $nombre,
                    "dificultad" => $dificultad,
                    "distancia" => $distancia,
                    "desnivel" => $desnivel,
                    "duracion" => $duracion,
                    "provincia" => $provincia,
                    "epoca" => $epoca,
                    "descripcion" => $descripcion,
                    "nivel_tecnico" => $nivel_tecnico,
                    "nivel_fisico" => $nivel_fisico,
                    "fotos" => $fotos_subidas
                ];
                header("Location: list.php");
            }
        }
    }
?>
    <link rel="stylesheet" href="/pinga/assets/css/register.css">
    
    

    <div class="container">
    <form action="" method="POST" enctype="multipart/form-data">
        <h2>Crear ruta de escalada</h2>
            <?php if (!empty($mensaje)): ?>
                <div class="msg <?php echo (strpos($mensaje, 'Subido Correcta') === 0) ? 'ok' : 'error'; ?>">
                    <?php echo $mensaje; ?>
                </div>
            <?php endif; ?>
        
        <label>Nombre de la ferrata:</label>
        <input type="text" name="nombre" value="<?php echo $_POST['nombre'] ?? ''; ?>"><br>

        <label>Dificultad:</label>
        <select name="dificultad">
            <option value="">Selecciona</option>
            <option value="Fácil" <?php if(($_POST['dificultad'] ?? '')=='Fácil') echo 'selected'; ?>>Fácil</option>
            <option value="Moderada" <?php if(($_POST['dificultad'] ?? '')=='Moderada') echo 'selected'; ?>>Moderada</option>
            <option value="Difícil" <?php if(($_POST['dificultad'] ?? '')=='Difícil') echo 'selected'; ?>>Difícil</option>
            <option value="Muy difícil" <?php if(($_POST['dificultad'] ?? '')=='Muy difícil') echo 'selected'; ?>>Muy difícil</option>
        </select><br>

        <label>Distancia (km):</label>
        <input type="number" min="0" step="0.1" name="distancia" value="<?php echo $_POST['distancia'] ?? ''; ?>"><br>

        <label>Desnivel positivo (m):</label>
        <input type="number" min="0" name="desnivel" value="<?php echo $_POST['desnivel'] ?? ''; ?>"><br>

        <label>Duración estimada (h):</label>
        <input type="number" min="0" step="0.1" name="duracion" value="<?php echo $_POST['duracion'] ?? ''; ?>"><br>

        <label>Localización / Provincia:</label>
        <input type="text" name="provincia" placeholder="Ej: Zaragoza" value="<?php echo $_POST['provincia'] ?? ''; ?>"><br>

        <label>Época recomendada:</label><br>
        <input type="checkbox" name="epoca[]" value="Primavera" <?php if(in_array('Primavera', $_POST['epoca'] ?? [])) echo 'checked'; ?>> Primavera<br>
        <input type="checkbox" name="epoca[]" value="Verano" <?php if(in_array('Verano', $_POST['epoca'] ?? [])) echo 'checked'; ?>> Verano<br>
        <input type="checkbox" name="epoca[]" value="Otoño" <?php if(in_array('Otoño', $_POST['epoca'] ?? [])) echo 'checked'; ?>> Otoño<br>
        <input type="checkbox" name="epoca[]" value="Invierno" <?php if(in_array('Invierno', $_POST['epoca'] ?? [])) echo 'checked'; ?>> Invierno<br>

        <label>Descripción:</label><br>
        <input type="text" name="descripcion"><?php echo $_POST['descripcion'] ?? ''; ?></input><br>

        <label>Nivel técnico:</label>
        <select name="nivel_tecnico">
            <option value="">Selecciona</option>
            <option value="1" <?php if(($_POST['nivel_tecnico'] ?? '')=='1') echo 'selected'; ?>>1</option>
            <option value="2" <?php if(($_POST['nivel_tecnico'] ?? '')=='2') echo 'selected'; ?>>2</option>
            <option value="3" <?php if(($_POST['nivel_tecnico'] ?? '')=='3') echo 'selected'; ?>>3</option>
            <option value="4" <?php if(($_POST['nivel_tecnico'] ?? '')=='4') echo 'selected'; ?>>4</option>
            <option value="5" <?php if(($_POST['nivel_tecnico'] ?? '')=='5') echo 'selected'; ?>>5</option>
        </select><br>
        <label>Nivel físico:</label>
        <select name="nivel_fisico">
            <option value="">Selecciona</option>
            <option value="1" <?php if(($_POST['nivel_fisico'] ?? '')=='1') echo 'selected'; ?>>1</option>
            <option value="2" <?php if(($_POST['nivel_fisico'] ?? '')=='2') echo 'selected'; ?>>2</option>
            <option value="3" <?php if(($_POST['nivel_fisico'] ?? '')=='3') echo 'selected'; ?>>3</option>
            <option value="4" <?php if(($_POST['nivel_fisico'] ?? '')=='4') echo 'selected'; ?>>4</option>
            <option value="5" <?php if(($_POST['nivel_fisico'] ?? '')=='5') echo 'selected'; ?>>5</option>
        </select><br>
        <label>Fotos:</label>
        <input type="file" name="fotos[]" multiple><br><br>

        <button type="submit">Crear ferrata</button>

    </form>
    <a href="list.php"><button>Volver al listado</button></a>
    </div>
<?php include('../../includes/footer.php'); ?>