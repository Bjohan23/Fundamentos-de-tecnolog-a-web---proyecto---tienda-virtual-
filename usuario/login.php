<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>

</head>
<body>
    <div class="container mt-5">
        <h2>Iniciar Sesión</h2>
        <form action="loguear.php" method="POST">
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" class="form-control" name="usuario" required>
            </div>
            <div class="form-group">
                <label for="contraseña">Contraseña</label>
                <input type="password" class="form-control" name="clave" required>
            </div>
            <button type="submit" class="btn btn-primary">Entrar</button>
            <a href="crear_cuenta_cliente.php" target="_blank" rel="noopener noreferrer">Crear cuenta</a>
        </form>
    </div>

    
<?php 
include("boostrap.php")
?>

</body>
</html>
