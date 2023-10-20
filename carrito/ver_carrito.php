<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    // El usuario no ha iniciado sesión, redirígelo al formulario de inicio de sesión o al registro.
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <!-- Incluye los archivos CSS de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Carrito de Compras</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include("../config/conexion.php");

                if (!$conexion) {
                    die("Error de conexión: " . mysqli_connect_error());
                }

                $sql = "SELECT c.id_carrito, p.nombre, p.precio_rebajado, c.cantidad FROM carrito_compras c
                        JOIN productos p ON c.id_productos = p.id
                        WHERE c.id_clientes = ?";
                
                $id_usuario = $_SESSION['user_id'];

                $stmt = mysqli_prepare($conexion, $sql);
                mysqli_stmt_bind_param($stmt, "i", $id_usuario);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                $total_pedido = 0; // Inicializa el total en 0

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["nombre"] . "</td>";
                    echo "<td>S/." . $row["precio_rebajado"] . "</td>";
                    echo "<td>" . $row["cantidad"] . "</td>";
                    $subtotal = $row["precio_rebajado"] * $row["cantidad"];
                    echo "<td>S/." . $subtotal . "</td>";
                    echo "<td>
                            <a href='editar_carrito.php?id=" . $row["id_carrito"] . "' class='btn btn-primary'>Editar</a>
                            <a href='eliminar_carrito.php?id=" . $row["id_carrito"] . "' class='btn btn-danger'>Eliminar</a>
                          </td>";
                    echo "</tr>";
                    
                    $total_pedido += $subtotal; // Suma el subtotal al total
                }

                mysqli_stmt_close($stmt);
                mysqli_close($conexion);
                ?>
            </tbody>
        </table>
        <h3>Total del Pedido: S/.<?php echo $total_pedido; ?></h3> <!-- Muestra el total del pedido -->
        <a href="../index.php" class="btn btn-primary">Seguir comprando</a>
        <?php 
            if($total_pedido == 0){
                ?>
                <h5>agregue productos para debloquear botones</h5>
                <?php
            }else{
            ?>
                <a href="realizar_pedido.php" class="btn btn-success">Realizar Pedido</a>
                 <a href="generar_pdf.php" class="btn btn-success">Generar PDF</a>
            <?php
            }
            
        ?>
    </div>

    <!-- Incluye los archivos JavaScript de Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
