
<?php
// Función para registrar un nuevo usuario en la base de datos
function registrarNuevoUsuario($nombre, $contraseña) {


    include("../config/conexion.php");

    // Consulta SQL para insertar el nuevo usuario en la base de datos
    $sql = "INSERT INTO clientes (nombre,  contraseña) VALUES (?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $nombre, $contraseña);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Registro exitoso
        $stmt->close();
        $conexion->close();
        return true;
    } else {
        // Error en el registro
        $stmt->close();
        $conexion->close();
        return false;
    }
}
?>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Aquí debes agregar la lógica para crear una nueva cuenta de usuario
    // Recopilar los datos del formulario y agregarlos a la base de datos

    // Si el registro es exitoso, puedes redirigir al usuario a la página de inicio de sesión o a su perfil
    // Si hay un error en el registro, muestra un mensaje de error
    // Ejemplo:
    if (registrarNuevoUsuario($_POST["nombre"], $_POST["contraseña"])) {
        // Registro exitoso
        header("Location: login.php"); // Redirige al inicio de sesión
        exit;
    } else {
        echo "Error al crear la cuenta de usuario.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Crear Cuenta de Usuario</title>
    <!-- Incluye los archivos CSS de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Crear Cuenta de Usuario</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="contraseña">Contraseña:</label>
                <input type="password" class="form-control" name="contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary">Crear Cuenta</button>
        </form>
    </div>

    <!-- Incluye los archivos JavaScript de Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
