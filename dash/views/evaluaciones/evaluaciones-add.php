<?php
ob_start();
require '../layout/header.php';

if (!isset($_SESSION["idusuario"]) || $_SESSION['rol'] != "admin" && $_SESSION['rol'] != "jefe_rrhh" && $_SESSION['rol'] != "psicologo") {
    session_destroy(); // Cierre de sesión adecuado.
    header("Location: ../auth/error.php");
    exit(); // Y detenemos la ejecución después de la redirección.
}
?>

<style>
    .agregar,
    .eliminar {
        display: flex;
        justify-content: center;
        width: 45px;
        height: 45px;
        font-weight: bold;
        font-size: 15px;
        cursor: pointer;
    }
</style>

<body class="g-sidenav-show bg-gray-100">
    <div class="bg-gradient-dark">
        <div class="page-header min-vh-50" style="background-image: url('../../dash/img/photo-form6.jpg');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center mx-auto my-auto">
                        <h1 class="text-white mb-4" style="margin-top: -40px;">Crear evaluación</h1>
                        <a href="evaluaciones.php" class="btn bg-white text-dark mt-4">Volver al inicio</a>
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
                                <p class="lead">Completa todos los datos requeridos para proceder con la solicitud correctamente.</p>
                            </div>
                            <form id="formulario" method="POST">
                                <div class="card-body pt-1 pb-0">
                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Título:</label>
                                                <input type="text" class="form-control" id="titulo" maxlength="300" placeholder="Ingrese el título de su test." required>
                                            </div>
                                        </div>
                                        <div id="container" class="contenedor">
                                            <div class="col-md-12 mb-2 evaluacion-principal">
                                                <div class="form-group">
                                                    <label for="titulo">Pregunta N° 1:</label>
                                                    <textarea class="form-control" id="pregunta1" rows="2" maxlength="300" placeholder="Ingrese su pregunta." required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-2 d-flex justify-content-center gap-2">
                                            <span class="badge badge-sm bg-gradient-success agregar"><i class="fa fa-plus py-2"></i></span>
                                            <span class="badge badge-sm bg-gradient-danger d-none eliminar"><i class="fa fa-trash py-2"></i></span>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Fecha de creación:</label>
                                                <input type="datetime-local" class="form-control" id="fecha_hora" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row p-4 pt-0">
                                    <div class="col-md-6 text-end ms-auto">
                                        <a onclick="limpiar()" class="btn bg-gradient-warning mb-0">Limpiar</a>
                                        <button type="submit" id="btnGuardar" class="btn bg-gradient-info mb-0">Agregar</button>
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
            cambiarTitulo('TopiTop | Crear Evaluación')
        }
    </script>

    <?php
    require '../layout/footer.php';
    ob_end_flush();
    ?>

    <script src="../../../config/scripts/evaluaciones16.js"></script>

    <script>
        $(document).ready(function() {
            $("#formulario").on("submit", function(e) {
                agregar(e);
            });
            input_fecha(1);
            document.getElementById("titulo").focus();
        });
    </script>