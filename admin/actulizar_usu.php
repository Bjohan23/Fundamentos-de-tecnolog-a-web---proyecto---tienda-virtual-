<!-- SweetAlert CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- SweetAlert JS y jQuery (si es necesario) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Solo si SweetAlert lo requiere -->

<?php

include("../config/conexion.php"); // Asegúrate de incluir el archivo de conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST["id_usuario"];
    $nombre = $_POST["usuario_nombre"];
    $usuario = $_POST["usuario_usuario"];
    $clave_1 = $_POST["usuario_clave_1"];
    $clave_2 = $_POST["usuario_clave_2"];

    // Verificar que las contraseñas coincidan
    if ($clave_1 != $clave_2) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    

    // Consulta SQL para actualizar los datos del usuario
    $consulta = "UPDATE usuarios SET nombre = '$nombre', usuario = '$usuario', clave = '$clave_1' WHERE id = $id_usuario";

    if (mysqli_query($conexion, $consulta)) {
        // tiene errores . no muestra 
        // Mostrar la alerta SweetAlert
        
        echo " ";
        ?>
        <style>
                body {
                    font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", Helvetica, Arial, sans-serif; 
                }
            </style>
            <script>
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Usuario actualizado correctamente",
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>
        <?php
    } else {
        echo "Error al actualizar el usuario: " . mysqli_error($conexion);
    }
} else {
    echo "Acceso no permitido.";
}

mysqli_close($conexion);

?>
