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
        text-decoration: none !important;
        color: white;
    }
</style>

<style>
    .swal2-confirm,
    .swal2-cancel {
        margin: 0;
    }

    .swal-confirm-button {
        margin-right: 10px;
    }

    .swal2-actions-custom {
        margin: 0 !important;
    }
</style>

<body class="g-sidenav-show bg-gray-100">
    <div class="bg-gradient-dark">
        <div class="page-header min-vh-50" style="background-image: url('../../dash/img/photo-form6.jpg');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center mx-auto my-auto">
                        <h1 class="text-white mb-4" style="margin-top: -40px;">Respuestas de la evaluación</h1>
                        <a onclick="window.history.back();" class="btn bg-white text-dark mt-4">Volver atrás</a>
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
                            </div>
                            <form id="formulario" method="POST">
                                <div class="card-body pt-1 pb-0">
                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Título:</label>
                                                <input type="hidden" name="idevaluacion" id="idevaluacion">
                                                <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Cargando título..." maxlength="300" disabled>
                                            </div>
                                        </div>
                                        <div id="container" class="contenedor row p-0 m-0">
                                            <h6 class="mb-4 fw-bold text-center">Cargando preguntas y respuestas...</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="row p-4 pt-0">
                                    <div class="col-md-6 text-end ms-auto">
                                        <button type="submit" id="btnEvaluar" class="btn bg-gradient-info mb-0">Cargando...</button>
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
            cambiarTitulo('TopiTop | Detalles Respuestas')
        }
    </script>

    <?php
    require '../layout/footer.php';
    ob_end_flush();
    ?>

    <script src="../../../config/scripts/postulantes18.js"></script>

    <script>
        $(document).ready(function() {
            $("#formulario").on("submit", function(e) {
                calificarEvaluacionPostulante(e);
            });
            mostrarRespuestasPostulante();
        });
    </script>