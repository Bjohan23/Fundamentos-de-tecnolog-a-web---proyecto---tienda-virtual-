<?php
include_once("../config/conexion.php");
// Verifica si se ha pasado el ID del producto a eliminar a través de la URL
if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id_carrito = $_GET["id"];
    

    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }
    
    // Consulta SQL para eliminar el producto del carrito
    $sql = "DELETE FROM carrito_compras WHERE id_carrito = ?";
    
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_carrito);
    
    if (mysqli_stmt_execute($stmt)) {
        // Producto eliminado con éxito
        header("Location: ver_carrito.php"); // Redirige de vuelta a la página del carrito
        exit();
    } else {
        echo "Error al eliminar el producto del carrito: " . mysqli_error($conexion);
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
} else {
    // El ID del producto no es válido, redirige a la página del carrito
    header("Location: ver_carrito.php");
    exit();
}
?>
