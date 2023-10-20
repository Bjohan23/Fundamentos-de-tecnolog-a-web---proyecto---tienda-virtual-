<?php
include("../config/conexion.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    // El usuario no ha iniciado sesión, redirígelo al formulario de inicio de sesión o al registro.
    header("Location: ../usuario/login.php");
    exit();
}

// Obtener el ID del producto desde la URL
if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id_productos = $_GET["id"];

    // Consulta SQL para agregar el producto al carrito
    $id_clientes = $_SESSION["user_id"];
    $cantidad = 1; // Puedes ajustar la cantidad según tus necesidades

    $sql = "INSERT INTO carrito_compras (id_clientes, id_productos, cantidad) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("iii", $id_clientes, $id_productos, $cantidad);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Producto agregado al carrito con éxito.";
    } else {
        echo "Error al agregar el producto al carrito: " . $stmt->error;
    }

    // Cerrar la conexión
    $stmt->close();
} else {
    echo "ID de producto no válido.";
}

// Redirigir al usuario de vuelta a la lista de productos
header("Location: ../index.php");
exit;
?>
