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

<body class="g-sidenav-show bg-gray-100" onload="cambiarTitulo('Childminder Alert | Registro')">
    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('../img/fondo-register.jpg'); background-position: start start;">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7 text-center mx-auto">
                        <h1 class="text-white mb-2 mt-3 fs-3">¡Bienvenido!</h1>
                        <p class="pb-4 text-white">Registra tus datos para acceder al panel administrativo y comiences a usar a <span class="fst-italic">Childminder Alert</span>.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-lg-n12 mt-md-n11 mt-n10 pb-4 justify-content-center">
                <div class="col-xl-6 col-lg-7 col-md-10 mx-auto">
                    <div class="card z-index-0">
                        <div class="card-header text-center pt-4 pb-0">
                            <h5>Módulo de registro</h5>
                        </div>
                        <div class="card-body">
                            <form id="formulario" method="POST">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="titulo">Nombres:</label>
                                            <input type="text" class="form-control" name="nombres" id="nombres" autocomplete="off" maxlength="30" placeholder="Ingrese sus nombres completos." required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="titulo">Apellidos:</label>
                                            <input type="text" class="form-control" name="apellidos" id="apellidos" autocomplete="off" maxlength="30" placeholder="Ingrese sus apellidos completos." required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="titulo">Tipo de documento:</label>
                                            <select class="form-control" name="tipo_documento" id="tipo_documento" onchange="changeValue(this);" required>
                                                <option value="">- Seleccione -</option>
                                                <option value="DNI">DNI</option>
                                                <option value="RUC">RUC</option>
                                                <option value="cedula">Cédula</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="titulo">Número de documento:</label>
                                            <input type="number" class="form-control" name="num_documento" id="num_documento" autocomplete="off" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="12" placeholder="Ingrese su N° de documento." required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="titulo">Correo electrónico:</label>
                                            <input type="email" class="form-control" name="email" id="email" autocomplete="off" maxlength="40" placeholder="Ingrese su correo electrónico." required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="titulo">Teléfono:</label>
                                            <input type="number" class="form-control" name="telefono" id="telefono" autocomplete="off" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="9" placeholder="Ingrese su N° de teléfono." required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ubicacion">Fecha de nacimiento:</label>
                                            <input type="date" class="form-control" name="fecha_nac" id="fecha_nac" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="titulo">Usuario:</label>
                                            <input type="text" class="form-control" name="usuario" id="usuario" autocomplete="off" maxlength="20" placeholder="Ingrese su usuario." required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="titulo">Contraseña:</label>
                                            <input type="password" class="form-control" name="clave" id="clave" autocomplete="off" maxlength="50" placeholder="Ingrese su contraseña." required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-check form-check-info text-start">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" required>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Acepto todos los <a class="text-dark font-weight-bolder">Términos y Condiciones</a>.
                                    </label>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-0" id="btnGuardar">Registrarse</button>
                                </div>
                                <div class="text-center">
                                    <a href="index.php" class="btn bg-gradient-info w-100 my-4 mt-2 mb-2">Volver</a>
                                </div>
                                <p class="text-sm mt-3 mb-0 text-center">
                                    ¿Ya tienes una cuenta?
                                    <a href="signIn.php" class="text-primary text-gradient font-weight-bold"><strong>Inicia sesión aquí.</strong></a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>
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

    <script>
        function changeValue(dropdown) {
            var option = dropdown.options[dropdown.selectedIndex].value,
                field = document.getElementById('num_documento');

            if (option == 'DNI') {
                $("#num_documento").val("");
                field.maxLength = 8;
            } else if (option == 'CEDULA') {
                $("#num_documento").val("");
                field.maxLength = 10;
            } else {
                $("#num_documento").val("");
                field.maxLength = 11;
            }
        }
    </script>

    <script src="../js/login-register4.js"></script>

    <script>
        $(document).ready(function() {
            $("#formulario").on("submit", function(e) {
                agregar(e);
            });
            document.getElementById("nombres").focus();
        });
    </script>

</html>