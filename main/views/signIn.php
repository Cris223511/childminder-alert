<?php
if (strlen(session_id()) < 1)
    session_start();

session_unset(); // Eliminamos las variables de sesión.
session_destroy(); // Destruimos la sesión.
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../img/logo2.png">
    <link rel="icon" type="image/png" href="../img/logo2.png">
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="../css/argon/nucleo-icons.css" rel="stylesheet" />
    <link href="../css/argon/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link rel="stylesheet" href="../css/argon/argon-dashboard13.css?v=2.0.4" />
</head>

<body class="g-sidenav-show bg-gray-100" onload="cambiarTitulo('Childminder Alert | Iniciar Sesión')">
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto bg-white border-radius-lg tarjetita">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start">
                                    <h4 class="font-weight-bolder">Iniciar sesión</h4>
                                    <p class="mb-0">Bienvenido, registra tus datos para ingresar al panel administrativo.</p>
                                </div>
                                <div class="card-body">
                                    <form method="POST" id="frmAcceso">
                                        <div class="mb-3">
                                            <input type="text" class="form-control form-control-lg" placeholder="Usuario" aria-label="Usuario" maxlength="20" name="usuario" id="usuario" autocomplete="honorific-suffix" required>
                                        </div>
                                        <div class="mb-3">
                                            <input type="password" class="form-control form-control-lg" placeholder="Contraseña" aria-label="Contraseña" maxlength="50" name="clave" id="clave" autocomplete="honorific-suffix" required>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="rememberMe">
                                            <label class="form-check-label" for="rememberMe">Recuérdame</label>
                                        </div>
                                        <div class="p-2 text-center">
                                            <p class="m-0">
                                                ¿Aún no tienes una cuenta?
                                                <a href="signUp.php" class="text-primary text-gradient font-weight-bold"><strong>Regístrate aquí.</strong></a>
                                            </p>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-0" id="btnGuardar">Iniciar sesión</button>
                                            <a href="index.php" class="btn bg-gradient-info w-100 my-4 mt-2 mb-2">Volver</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('../img/fondo-login.jpg'); background-size: cover; background-position: center center;">
                                <span class="mask bg-gradient-primary opacity-6"></span>
                                <h2 class="mt-5 text-white font-weight-bolder position-relative">Panel administrativo</h2>
                                <p class="text-white position-relative" style="font-style: italic;">"La terapia puede brindar estrategias para mejorar la autorregulación, la organización y la concentración."</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/4d529f15e3.js" crossorigin="anonymous"></script>

    <!-- Core JS Files -->
    <script src="../js/argon/core/popper.min.js"></script>
    <script src="../js/argon/core/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="../js/argon/argon-dashboard3.min.js?v=2.0.4"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>

    <script>
        function cambiarTitulo(nuevoTitulo) {
            document.title = nuevoTitulo;
        }
    </script>

    <script src="../js/login-register.js"></script>
</body>

</html>