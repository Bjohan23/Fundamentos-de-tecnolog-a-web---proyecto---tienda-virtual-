<?php
require_once "../config/conexion.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si se envió el formulario correctamente

    if (isset($_POST['accion']) && $_POST['accion'] === 'pro' && isset($_POST['id'])) {
        // Obtiene el ID del elemento a eliminar desde el formulario
        $id = $_POST['id'];

        // Consulta de eliminación
        $sql = "DELETE FROM imagenes WHERE id = $id";

        if ($conexion->query($sql) === TRUE) {

            echo "El elemento ha sido eliminado exitosamente.";
            header('Location: mostrar_img.php');
        } else {
            
            echo "Error al eliminar el elemento: " . $conexion->error;
        }

        // Cierra la conexión a la base de datos
        $conexion->close();
    } else {
        echo "Parámetros incorrectos en la solicitud de eliminación.";
    }
} 
?>
