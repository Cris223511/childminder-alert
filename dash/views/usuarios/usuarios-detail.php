<?php
ob_start();
require '../layout/header.php';

if (!isset($_SESSION["idusuario"]) || $_SESSION['rol'] != "admin") {
    session_destroy(); // Cierre de sesión adecuado.
    header("Location: ../auth/error.php");
    exit(); // Y detenemos la ejecución después de la redirección.
}
?>

<body class="g-sidenav-show bg-gray-100">
    <div class="bg-gradient-dark">
        <div class="page-header min-vh-50" style="background-image: url('../../dash/img/photo-form6.jpg');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center mx-auto my-auto">
                        <h1 class="text-white mb-4" style="margin-top: -40px;">Detalles del usuario</h1>
                        <a href="usuarios.php" class="btn bg-white text-dark mt-4">Volver al inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-body blur shadow-blur mx-3 mx-md-4 mt-n6 mb-4">
        <section class="py-sm-4 position-relative mt-5">
            <div class="container">
                <div class="card box-shadow-xl overflow-hidden mb-5">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-header px-4 py-sm-4 py-3">
                                <h2 class="mb-3">Formulario</h2>
                                <p class="lead">Los siguientes datos son los detalles del usuario que seleccionaste, solo puedes visualizarlo.</p>
                            </div>
                            <form id="formulario" method="POST">
                                <div class="card-body pt-1 pb-0">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Nombres:</label>
                                                <input type="hidden" name="idusuario" id="idusuario">
                                                <input type="text" class="form-control" name="nombres" id="nombres" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Apellidos:</label>
                                                <input type="text" class="form-control" name="apellidos" id="apellidos" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Tipo de documento:</label>
                                                <select class="form-control" name="tipo_documento" id="tipo_documento" disabled>
                                                    <option value="">- Seleccione -</option>
                                                    <option value="DNI">DNI</option>
                                                    <option value="RUC">RUC</option>
                                                    <option value="cedula">Cédula</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Número de documento:</label>
                                                <input type="number" class="form-control" name="num_documento" id="num_documento" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Dirección:</label>
                                                <input type="text" class="form-control" name="direccion" id="direccion" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Teléfono:</label>
                                                <input type="number" class="form-control" name="telefono" id="telefono" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Correo electrónico:</label>
                                                <input type="email" class="form-control" name="email" id="email" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="ubicacion">Fecha de nacimiento:</label>
                                                <input type="date" class="form-control" name="fecha_nac" id="fecha_nac" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Usuario:</label>
                                                <input type="text" class="form-control" name="usuario" id="usuario" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Contraseña:</label>
                                                <input type="password" class="form-control" name="clave" id="clave" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Foto:</label>
                                                <input type="file" class="form-control" name="imagen" id="imagen" disabled>
                                                <input type="hidden" name="imagenactual" id="imagenactual">
                                                <img class="mt-2" src="../../dash/img/profile.jpg" id="imagenmuestra" style="height: 150px; border-radius: 22px;">
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <label for="descripcion">Descripción:</label>
                                                <textarea type="text" class="form-control" name="descripcion" id="descripcion" rows="4" placeholder="Sin descripción." disabled></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <footer class="footer pt-4 pb-4">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-lg-between">
                <div class="col-lg-12 mb-lg-0 mb-4">
                    <div class="copyright text-center text-sm text-muted text-lg-center">
                        <strong>© 2023</strong> TopiTop, todos los derechos reservados.
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        window.onload = function() {
            cambiarTitulo('TopiTop | Detalles Usuarios')
        }
    </script>

    <?php
    require '../layout/footer.php';
    ob_end_flush();
    ?>

    <script src="../../../config/scripts/usuarios15.js"></script>

    <script>
        $(document).ready(function() {
            mostrar();
            document.getElementById("nombres").focus();
        });
    </script>