<?php
require_once "../config/conexion.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establece la conexión a la base de datos (reemplaza con tus propios datos de conexión)
    // Verifica la conexión
    if ($conexion->connect_error) {
        die("Error en la conexión: " . $conexion->connect_error);
    }

    // Obtiene la descripción y la URL de la imagen desde el formulario
    $descripcion = $conexion->real_escape_string($_POST["descripcion"]);
    $enlaceImagen = $conexion->real_escape_string($_POST["enlace_imagen"]);
    
    // Inicializa el nombre de la imagen
    $nombreImagen = "";

    // Verifica si se cargó una imagen a través del campo "imagen1"
    if(isset($_FILES["imagen1"]) && $_FILES["imagen1"]["error"] == 0){
        // Directorio de destino para las imágenes (debes configurarlo correctamente)
        $directorioDestino = "../assets/img/";

        // Nombre de archivo aleatorio
        $nombreImagen = uniqid() . '_' . $_FILES["imagen1"]["name"];
        $rutaImagen = $directorioDestino . $nombreImagen;

        // Mueve la imagen al directorio de destino
        if (move_uploaded_file($_FILES["imagen1"]["tmp_name"], $rutaImagen)) {
            // Inserta el registro en la tabla
            $sql = "INSERT INTO imagenes (descripcion, enlace_imagen, nombre_imagen) VALUES ('$descripcion', '$enlaceImagen', '$nombreImagen')";
            if ($conexion->query($sql) === TRUE) {
                echo "Registro agregado correctamente.";
                header('Location: mostrar_img.php');
            } else {
                echo "Error al agregar el registro: " . $conexion->error;
            }
        } else {
            echo "Error al subir la imagen al servidor.";
        }
    } else {
        echo "No se seleccionó ninguna imagen o hubo un error al cargarla.";
    }

    $conexion->close();
}
?>
