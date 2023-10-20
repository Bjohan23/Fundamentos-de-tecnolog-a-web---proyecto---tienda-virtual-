<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Incluye la configuración de la base de datos
include("../config/conexion.php");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

$id_cliente = $_SESSION['user_id'];

// Iniciar una transacción para asegurar la consistencia de los datos
mysqli_autocommit($conexion, FALSE);

// Insertar un nuevo registro en la tabla de pedidos
$sql_insert_pedido = "INSERT INTO pedidos (id_cliente) VALUES (?)";
$stmt_insert_pedido = mysqli_prepare($conexion, $sql_insert_pedido);
mysqli_stmt_bind_param($stmt_insert_pedido, "i", $id_cliente);

if (mysqli_stmt_execute($stmt_insert_pedido)) {
    // Obtener el ID del pedido recién insertado
    $id_pedido = mysqli_insert_id($conexion);

    // Obtener los productos en el carrito de compras
    $sql_carrito = "SELECT id_productos, cantidad FROM carrito_compras WHERE id_clientes = ?";
    $stmt_carrito = mysqli_prepare($conexion, $sql_carrito);
    mysqli_stmt_bind_param($stmt_carrito, "i", $id_cliente);
    mysqli_stmt_execute($stmt_carrito);
    $result_carrito = mysqli_stmt_get_result($stmt_carrito);

    // Recorrer los productos en el carrito y actualizar el stock
    while ($row_carrito = mysqli_fetch_assoc($result_carrito)) {
        $id_producto = $row_carrito['id_productos'];
        $cantidad = $row_carrito['cantidad'];

        // Consulta para restar la cantidad del producto vendido al stock
        $sql_actualizar_stock = "UPDATE productos SET cantidad = cantidad - ? WHERE id= ?";
        $stmt_actualizar_stock = mysqli_prepare($conexion, $sql_actualizar_stock);
        mysqli_stmt_bind_param($stmt_actualizar_stock, "ii", $cantidad, $id_producto);

        if (!mysqli_stmt_execute($stmt_actualizar_stock)) {
            // Si ocurre un error al actualizar el stock, deshacer la transacción y mostrar un mensaje de error
            mysqli_rollback($conexion);
            echo "Error al actualizar el stock: " . mysqli_error($conexion);
        }

        mysqli_stmt_close($stmt_actualizar_stock);
    }

    // Eliminar los productos del carrito de compras después de realizar el pedido
    $sql_eliminar_carrito = "DELETE FROM carrito_compras WHERE id_clientes = ?";
    $stmt_eliminar_carrito = mysqli_prepare($conexion, $sql_eliminar_carrito);
    mysqli_stmt_bind_param($stmt_eliminar_carrito, "i", $id_cliente);
    mysqli_stmt_execute($stmt_eliminar_carrito);
    mysqli_stmt_close($stmt_eliminar_carrito);

    // Confirmar la transacción
    mysqli_commit($conexion);

    // Mostrar un mensaje de éxito y redirigir al usuario
    ?>
    <script>
        alert("Pedido realizado con éxito. Gracias por tu compra.");
    </script>
    <?php
   header("Location: ../index.php"); // Cambia esto a la página adecuada
   
} else {
    // Si ocurre un error al insertar el pedido, deshacer la transacción y mostrar un mensaje de error
    mysqli_rollback($conexion);
    echo "Error al realizar el pedido: " . mysqli_error($conexion);
}

// Cerrar la conexión
mysqli_close($conexion);
?>
 