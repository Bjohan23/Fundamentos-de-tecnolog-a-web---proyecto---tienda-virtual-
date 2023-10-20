<?php
require_once "../config/conexion.php";
include("includes/header.php"); ?>




<?php
$id = null;
// Verificamos si el formulario se ha enviado por POST y si se proporciona una ID
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    // Asignamos la ID del formulario a la variable $id
    $id = $_POST["id"];

    // Creamos una consulta SQL para seleccionar todos los datos de la imagen con la ID proporcionada
    $consulta = "SELECT * FROM imagenes WHERE id = $id";

    // Ejecutamos la consulta SQL en la base de datos
    $resultado = mysqli_query($conexion, $consulta);

    // Verificamos si la consulta fue exitosa y si se encontró al menos una fila
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        // Extraemos los datos de la imagen y los almacenamos en un arreglo asociativo
        $imagen = mysqli_fetch_assoc($resultado);

        // Extraemos los campos específicos de la imagen
        $nombreImg = $imagen["nombre_imagen"];
        $descripcion = $imagen["descripcion"];
        $enlaceImg = $imagen["enlace_imagen"];
    } else {
        // Si no se encuentra la imagen, mostramos un mensaje de error
        echo "La imagen con ID $id no existe.";
    }
}
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
                    title: "Datos obtenidos con exito",
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>

<?php

mysqli_close($conexion);

?>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css">

    
<div class="container mt-5">
<h1 class="animate__animated animate__fadeInRight">Editar Datos </h1>
    <form action="guardar_act_img.php" method="POST">
    <div id="alerta" style="display: none;"></div>
        <!-- Aquí puedes utilizar las variables $nombreImg, $descripcion y $enlaceImg
             para prellenar el formulario de edición -->
             <div class="form-group" >
                <label for="id">ID:</label>
                <input type="text" class="form-control" id="id" name="id" value="<?php echo $id; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="nombre_imagen">Imagen actual:</label>
                <img src="../assets/img/<?php echo $nombreImg; ?>" alt="Imagen actual" width="100">
            </div>

            <div class="form-group dropzone">
            <label for="nombre_imagen1">Seleccionar nueva imagen:</label>
            <input type="file" id="nombre_imagen1" name="nombre_imagen1">
            <div class="dz-message" data-dz-message><span>Arrastra y suelta archivos aquí o haz clic para seleccionar archivos</span></div>

            </div>


        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo $descripcion; ?>">
        </div>

        <div class="form-group">
            <label for="enlace">Enlace de la Imagen:</label>
            <input type="url" class="form-control" id="enlace" name="enlace" placeholder="opcional" value="<?php echo $enlaceImg; ?>">
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>

<script>


//   Dropzone.autoDiscover = false;
//   var myDropzone = new Dropzone(".dropzone", { url: "/upload" });

  // Cuando se hace clic en el botón "Guardar Cambios"
  $("#guardarCambios").click(function() {
            // Envía los datos del formulario mediante AJAX
            $.ajax({
                type: "POST",
                url: "guardar_act_img.php",
                data: new FormData($("#editarForm")[0]),
                processData: false,
                contentType: false,
                success: function(response) {
                    // Muestra la respuesta en el div de alerta
                    $("#alerta").html(response).fadeIn();
                }
            });
        });

        // Configura Dropzone
        Dropzone.autoDiscover = false;
        const myDropzone = new Dropzone(".dropzone", {
            paramName: "nombre_imagen",
            maxFilesize: 2, // Tamaño máximo en MB
            acceptedFiles: "image/*", // Acepta solo archivos de imagen
            dictDefaultMessage: "Arrastra y suelta archivos aquí o haz clic para seleccionar archivos",
            addRemoveLinks: true
        });
</script>



    

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php include("includes/footer.php"); ?>



