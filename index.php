<?php require_once "config/conexion.php"; ?>
<?php 
        session_start();
        error_reporting(0);
        $usuario = $_SESSION['username'];
        $id = $_SESSION['user_id']; // Debes usar 'user_id' en lugar de 'id_usuario'

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Carrito de Compras</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <!-- Core theme CSS (includes Bootstrap) -->
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link href="assets/css/estilos.css" rel="stylesheet" />
</head>
<body>
    <!-- id="btnCarrito" id="carrito"  <span class="badge bg-success" >0</span>-->
    <a href="carrito/ver_carrito.php" class="btn-flotante" >Carrito </a>
    <!-- Navigation -->
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Funcos</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a href="#" class="nav-link text-info" category="all">Todo</a></li>
                        <?php
                        $query = mysqli_query($conexion, "SELECT * FROM categorias");
                        while ($data = mysqli_fetch_assoc($query)) { ?>
                            <li class="nav-item"><a href="#" class="nav-link" category="<?php echo $data['categoria']; ?>"><?php echo $data['categoria']; ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
                <ul class="nav justify-content-end">
                    <li class="nav-item">
                    <?php 
                                    if(!isset($usuario)){
                                        ?>
                                        <a href="usuario/login.php " class="nav-link text-info" category="al">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                                        </svg>
                                        Iniciar sesión 
                                    </a>
                                    <?php }else{
                                        
                                        ?>
                                        
                                        <a href="usuario/perfil.php?id=<?php echo $_SESSION['user_id']; ?>" class="nav-link text-info" category="al">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                                            </svg>
                                            Perfil
                                        </a>

                                   <?php }
                                ?>
                    </li>
                </ul>   
                
            </div>
            
        </nav>
    </div>

    
    <!-- Carrusel de Imágenes -->
    <header class="bg-dark py-5 ">
            <div id="carouselExampleInterval" class="carousel slide c1" data-bs-ride="carousel" >
        <div class="carousel-inner c1">
        <?php
                    $sql = "SELECT * FROM imagenes";
                    $result = $conexion->query($sql);

                    $indice = 0;

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $imagenSrc = $row["nombre_imagen"];
                            $imagenUrl = $row["enlace_imagen"];
                            $descripcion = $row["descripcion"];
                            $activo = $indice === 0 ? 'active' : '';

                            echo '<div class="c1 carousel-item ' . $activo . '" data-bs-interval="10000 ">';
                            echo '<img src="./assets/img/' . $imagenSrc . '" class="d-block w-100 " alt="' . $imagenUrl . '">';
                            echo '<div class="carousel-caption d-none d-md-block">';

                            echo '<h5 class="descripcion-negra">' . $descripcion . '</h5>';
                            // 
                            echo '<p> </p>';
                            echo '</div>';

                            echo '</div>';
                            $indice++;
                        }
                    }
                    ?>
                    <style>
                        .descripcion-negra {
                            color: #000; 
                        }
                    </style>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        </div>
                        
    </header>

    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                $query = mysqli_query($conexion, "SELECT p.*, c.id AS id_cat, c.categoria FROM productos p INNER JOIN categorias c ON c.id = p.id_categoria");
                $result = mysqli_num_rows($query);
                if ($result > 0) {
                    while ($data = mysqli_fetch_assoc($query)) { ?>
                        <div class="col mb-5 productos" category="<?php echo $data['categoria']; ?>">
                            <div class="card h-100">
                                <div class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem"><?php echo ($data['precio_normal'] > $data['precio_rebajado']) ? 'Oferta' : ''; ?></div>
                                <img class="card-img-top" src="assets/img/<?php echo $data['imagen']; ?>" alt="..." />
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <h5 class="fw-bolder"><?php echo $data['nombre'] ?></h5>
                                        <p><?php echo $data['descripcion']; ?></p>
                                        <div class="d-flex justify-content-center small text-warning mb-2">
                                            <div class="bi-star-fill"></div>
                                            <div class="bi-star-fill"></div>
                                            <div class="bi-star-fill"></div>
                                            <div class="bi-star-fill"></div>
                                            <div class="bi-star-fill"></div>
                                        </div>
                                        <span class="text-muted text-decoration-line-through"><?php echo $data['precio_normal'] ?></span>
                                        <?php echo $data['precio_rebajado'] ?>
                                    </div>
                                </div>
                                
                                <!-- agregar al carrito 2 -->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto "  href="carrito/agregar_al_carrito.php?id=<?php echo $data['id'];  ?>" >Agregar</a></div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Your Website 2025 [Bjohan23 ]</p>
        </div>
    </footer>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS -->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>
</html>

