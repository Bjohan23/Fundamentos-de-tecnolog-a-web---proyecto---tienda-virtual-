<?php
include_once("../config/conexion.php");
// Verifica si se ha pasado el ID del producto a editar y la nueva cantidad a través del formulario
if (isset($_POST["id"]) && isset($_POST["cantidad"])) {
    $id_carrito = $_POST["id"];
    $nueva_cantidad = $_POST["cantidad"];
    
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }
    
    // Consulta SQL para actualizar la cantidad del producto en el carrito
    $sql = "UPDATE carrito_compras SET cantidad = ? WHERE id_carrito = ?";
    
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $nueva_cantidad, $id_carrito);
    
    if (mysqli_stmt_execute($stmt)) {
        // Cantidad actualizada con éxito
        header("Location: ver_carrito.php"); // Redirige de vuelta a la página del carrito
        exit();
    } else {
        echo "Error al actualizar la cantidad del producto en el carrito: " . mysqli_error($conexion);
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
} elseif (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    // Si no se ha enviado el formulario, pero se ha pasado un ID válido a través de la URL,
    // puedes mostrar un formulario para que el usuario ingrese la nueva cantidad
    $id_carrito = $_GET["id"];
    
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }
    
    // Consulta SQL para obtener la cantidad actual del producto en el carrito
    $sql = "SELECT cantidad FROM carrito_compras WHERE id_carrito = ?";
    
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_carrito);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $cantidad_actual = $row["cantidad"];
        mysqli_stmt_close($stmt);
        mysqli_close($conexion);
    } else {
        // Si no se encuentra el producto en el carrito, redirige a la página del carrito
        header("Location: ver_carrito.php");
        exit();
    }
} else {
    // Si no se ha pasado un ID válido, redirige a la página del carrito
    header("Location: ver_carrito.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cantidad en el Carrito</title>
    <!-- Incluye los archivos CSS de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Editar Cantidad en el Carrito</h2>
        <form method="post" action="editar_carrito.php">
            <input type="hidden" name="id" value="<?php echo $id_carrito; ?>">
            <div class="form-group">
                <label for="cantidad">Nueva Cantidad:</label>
                <input type="number" class="form-control" name="cantidad" value="<?php echo $cantidad_actual; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
        <a href="ver_carrito.php" class="btn btn-secondary mt-3">Cancelar</a>
    </div>

    <!-- Incluye los archivos JavaScript de Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
