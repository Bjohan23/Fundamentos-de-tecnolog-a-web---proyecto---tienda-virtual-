<?php
require_once "../config/conexion.php";?>


<?php
// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $descripcion = $_POST["descripcion"];
    $enlace = $_POST["enlace"];

    // Verifica si se ha subido un nuevo archivo
    if (isset($_FILES["nombre_imagen"]) && $_FILES["nombre_imagen"]["name"]) {
        // Obtiene la información del archivo subido
        $nombreImagen = $_FILES["nombre_imagen1"]["name"];
        $tipoImagen = $_FILES["nombre_imagen1"]["type"];
        $tamanioImagen = $_FILES["nombre_imagen1"]["size"];
        $tempImagen = $_FILES["nombre_imagen1"]["tmp_name"];

        // Directorio donde se guardarán las imágenes
        $directorio = "../assets/img/";

        // Verifica si el archivo es una imagen
        if (exif_imagetype($tempImagen)) {
            // Genera un nombre único para el archivo de imagen
            $nombreArchivo = uniqid() . "_" . $nombreImagen;

            // Ruta completa para guardar la imagen en el directorio
            $rutaImagen = $directorio . $nombreArchivo;

            // Mueve el archivo de la ubicación temporal al directorio de destino
            if (move_uploaded_file($tempImagen, $rutaImagen)) {
                // Consulta SQL para actualizar los datos en la base de datos
                $consulta = "UPDATE imagenes SET nombre_imagen = '$nombreArchivo', descripcion = '$descripcion', enlace_imagen = '$enlace' WHERE id = $id";

                if (mysqli_query($conexion, $consulta)) {
                    // Los datos se han actualizado correctamente
                    echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Los datos se han actualizado correctamente.",
                        showConfirmButton: false,
                        timer: 1500
                    });
                  </script>';
                 
                } else {
                    // Manejar errores si la consulta no se ejecuta correctamente
                    echo '<div class="alert alert-danger" role="alert">Error al actualizar los datos en la base de datos.</div>';
                }
            } else {
                // Manejar errores si no se pudo mover el archivo
                echo '<div class="alert alert-danger" role="alert">Error al subir la imagen.</div>';
            }
        } else {
            // Manejar errores si el archivo no es una imagen válida
            echo '<div class="alert alert-danger" role="alert">El archivo seleccionado no es una imagen válida.</div>';
        }
    } else {
        // Consulta SQL para actualizar los datos en la base de datos sin cambiar la imagen
        $consulta = "UPDATE imagenes SET descripcion = '$descripcion', enlace_imagen = '$enlace' WHERE id = $id";

        if (mysqli_query($conexion, $consulta)) {
            // Los datos se han actualizado correctamente
            echo '<script>
            Swal.fire({
                icon: "success",
                title: "Los datos se han actualizado correctamente.",
                showConfirmButton: false,
                timer: 1500
            });
          </script>';
        } else {
            // Manejar errores si la consulta no se ejecuta correctamente
            echo '<div class="alert alert-danger" role="alert">Error al actualizar los datos en la base de datos.</div>';
        }
    
    }
    
}


header('location: mostrar_img.php');

?>


