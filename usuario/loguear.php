<?php
include("../config/conexion.php");
session_start();

$usuario = $_POST['usuario'];
$clave = $_POST['clave'];

$q = "SELECT id_cliente FROM clientes WHERE nombre = '$usuario' AND contraseña = '$clave'";
$consulta = mysqli_query($conexion, $q);
$array = mysqli_fetch_array($consulta);

if ($array) {
    $_SESSION['username'] = $usuario;
    $_SESSION['user_id'] = $array['id_cliente']; // Almacena la ID del usuario en una variable de sesión
    header("location: ../index.php");
} else {
    echo "DATOS INCORRECTOS";
}

// Cerrar la conexión a la base de datos
// mysqli_close($conexion);
?>
