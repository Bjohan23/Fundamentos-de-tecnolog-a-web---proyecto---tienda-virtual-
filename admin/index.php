<?php
session_start();
if (!empty($_SESSION['active'])) {
    header('location: productos.php');
} else {
    if (!empty($_POST)) {
        $alert = '';
        if (empty($_POST['usuario']) || empty($_POST['clave'])) {
            $alert = '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                        Ingrese usuario y contraseña
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        } else {
            require_once "../config/conexion.php";
            $user = mysqli_real_escape_string($conexion, $_POST['usuario']);
$clave = mysqli_real_escape_string($conexion, $_POST['clave']);

            $query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario = '$user' AND clave = '$clave'");
            mysqli_close($conexion);
            $resultado = mysqli_num_rows($query);
            if ($resultado > 0) {
                $dato = mysqli_fetch_array($query);
                $_SESSION['active'] = true;
                $_SESSION['id'] = $dato['id'];
                $_SESSION['nombre'] = $dato['nombre'];
                $_SESSION['user'] = $dato['usuario'];
                header('Location: productos.php');
            } else {
                $alert = '<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                        Contraseña incorrecta
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                session_destroy();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/sb-admin-2.min.css">
    <link rel="shortcut icon" href="../assets/img/favicon.ico" />
    <link rel="stylesheet" href="./includes/estilos.css">
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image">
                                <img class="img-thumbnail" src="assets/img/logo.png" alt="">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">¡Bienvenido de nuevo!</h1>
                                        <?php echo (isset($alert)) ? $alert : ''; ?>
                                    </div>
                                    <form class="user" method="POST" action="" autocomplete="off">
                                        <!-- <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="usuario" name="usuario" placeholder="Usuario...">
                                        </div> -->
                                        <div class="inputContainer">
                                            <input required="required" id="usuario" name="usuario" placeholder="Usuario.." type="text">
                                            <label class="usernameLabel" for="usuario">Usuario</label>
                                            <svg viewBox="0 0 448 512" class="userIcon"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"></path></svg>
                                        </div>
                                        
                                        <!--  -->
                                        <style>
                                            
                                            .inputContainer {
                                                position: relative;
                                                display: flex;
                                                flex-direction: column;
                                                gap: 10px;
                                                margin: 3px;
                                                }

                                                #usuario {
                                                border: 2px solid white;
                                                background-color: transparent;
                                                border-radius: 10px;
                                                padding: 12px 15px;
                                                color: black;
                                                font-weight: 500;
                                                outline: none;
                                                caret-color: rgb(155, 78, 255);
                                                transition-duration: .3s;
                                                font-family: Whitney, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
                                                }

                                                .userIcon {
                                                position: absolute;
                                                fill: rgb(155, 78, 255);
                                                width: 12px;
                                                top: -23px;
                                                left: -15px;
                                                opacity: 0;
                                                transition: .2s linear;
                                                }

                                                .usernameLabel {
                                                position: absolute;
                                                top: -25px;
                                                left: 5px;
                                                color: black;
                                                font-size: 14px;
                                                font-weight: 400;
                                                font-family: Whitney, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica, Arial, sans-serif;
                                                overflow: hidden;
                                                transition: .2s linear;
                                                opacity: 0;
                                                }

                                                #usuario:focus ~ .usernameLabel,
                                                #usuario:valid ~ .usernameLabel {
                                                transform: translateX(20px);
                                                opacity: 1;
                                                }

                                                #usuario:focus ~ .userIcon,
                                                #usuario:valid ~ .userIcon {
                                                transform: translateX(20px);
                                                opacity: 1;
                                                }

                                                #usuario:focus,
                                                #usuario:valid {
                                                background-color: #ddd;
                                                transition-duration: .3s;
                                                }

                                        </style>

                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="clave" name="clave" placeholder="Password">
                                        </div>
                                        <button class="btn btn-1" type="submit">Iniciar session!</button>
                                        
                                        <hr>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/js/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>

</body>

</html>
<style>
    /* .btn {
  text-decoration: none;
  padding: 20px 40px;
  font-size: 1em;
  position: relative;
  margin: 32px;
  border: none;
  background-color: #26caf8;
  font-weight: 600;
}

.btn-1 {
  overflow: hidden;
  color: #fff;
  border-radius: 30px;
  box-shadow: 0 0 0 0 rgba(143, 64, 248, 0.5), 0 0 0 0 rgba(39, 200, 255, 0.5);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.btn-1::after {
  content: "";
  width: 400px;
  height: 400px;
  position: absolute;
  top: -50px;
  left: -100px;
  background-color: #ff3cac;
  background-image: linear-gradient(225deg, #27d86c 0%, #26caf8 50%, #c625d0 100%);
  z-index: -1;
  transition: transform 0.5s ease;
}

.btn-1:hover {
  transform: translate(0, -6px);
  box-shadow: 10px -10px 25px 0 rgba(143, 64, 248, 0.5),  -10px 10px 25px 0 rgba(39, 200, 255, 0.5);
}

.btn-1:hover::after {
  transform: rotate(150deg);
} */
</style>