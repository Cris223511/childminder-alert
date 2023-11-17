<?php
ob_start();
require '../layout/header.php';

if (!isset($_SESSION["idusuario"])) {
    session_destroy(); // Cierre de sesión adecuado.
    header("Location: ../../auth/error.php");
    exit(); // Y detenemos la ejecución después de la redirección.
}
?>

<body class="g-sidenav-show bg-gray-100">
    <div class="bg-gradient-dark">
        <div class="page-header min-vh-50" style="background-image: url('../../assets/img/photo-form6.jpg');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center mx-auto my-auto">
                        <h1 class="text-white mb-4" style="margin-top: -40px;">Detalles del dispositivo</h1>
                        <a href="dispositivos.php" class="btn bg-white text-dark mt-4">Volver al inicio</a>
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
                                <p class="lead">Los siguientes datos son los detalles del dispositivo que seleccionaste, solo puedes visualizarlo.</p>
                            </div>
                            <form id="formulario" method="POST">
                                <div class="card-body pt-1 pb-0">
                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Dispositivo:</label>
                                                <input type="text" class="form-control" name="titulo" id="titulo" maxlength="17" placeholder="Ingrese el nombre del dispositivo." disabled>
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
                        <strong>© 2023</strong> Childminder Alert, todos los derechos reservados.
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        window.onload = function() {
            cambiarTitulo('Childminder Alert | Detalles Dispositivo')
        }
    </script>

    <?php
    require '../layout/footer.php';
    ob_end_flush();
    ?>

    <script src="../../scripts/dispositivos3.js"></script>

    <script>
        $(document).ready(function() {
            mostrar();
            document.getElementById("titulo").focus();
        });
    </script>