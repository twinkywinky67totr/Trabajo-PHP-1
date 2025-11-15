<?php
session_start();
unset($_SESSION['usuario_actual']);
header("Location: index.php");
exit();
?>