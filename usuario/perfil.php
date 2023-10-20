<?php
session_start();
include("../config/conexion.php");

// Obtener el ID de usuario de la URL
if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id_usuario = $_GET["id"];
} else {
    // Si no se proporciona un ID válido en la URL, redirigir o mostrar un mensaje de error
    // Puedes redirigir al usuario o mostrar un mensaje de error aquí según tus necesidades.
    echo "Error: ID de usuario no válido.";
    exit;
}

// Consulta SQL para obtener los datos del usuario
$sql = "SELECT nombre, contraseña FROM clientes WHERE id_cliente = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_usuario);

// Variables para almacenar los datos del usuario
$nombre = "";
$contraseña = "";

// Ejecutar la consulta
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre = $row["nombre"];
        $contraseña = $row["contraseña"];
    } else {
        echo "No se encontraron datos de usuario.";
    }
} else {
    echo "Error al obtener los datos de usuario: " . $stmt->error;
}

// Cerrar la conexión
$stmt->close();
$conexion->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Datos de la Cuenta</title>
    <!-- Agregar el enlace al archivo CSS de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Agregar una etiqueta meta viewport para la adaptabilidad móvil -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Estilos personalizados (opcional) */
        .form-container {
            max-width: 400px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="form-container">
            <h2>Datos de la Cuenta</h2>
            <form action="actualizar_datos.php" method="post">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>">
                </div>
                <div class="form-group">
                    <label for="contraseña">Contraseña:</label>
                    <input type="text" class="form-control" id="contraseña" name="contraseña" value="<?php echo $contraseña; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>
            <a href="salir.php" class="btn btn-danger mt-3">Salir</a>
            <a href="../index.php" class="btn btn-secondary mt-3">Página de Inicio</a>
            <!-- Puedes mostrar más información del usuario aquí según tus necesidades -->
        </div>
    </div>

</body>
</html>
