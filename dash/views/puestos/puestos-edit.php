<?php
ob_start();
require '../layout/header.php';

if (!isset($_SESSION["idusuario"]) || $_SESSION['rol'] != "admin" && $_SESSION['rol'] != "jefe_tienda" && $_SESSION['rol'] != "jefe_rrhh") {
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
                        <h1 class="text-white mb-4" style="margin-top: -40px;">Editar puesto de trabajo</h1>
                        <a href="puestos.php" class="btn bg-white text-dark mt-4">Volver al inicio</a>
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
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Solicitud:</label>
                                                <input type="hidden" name="idpuesto" id="idpuesto">
                                                <select class="form-control" name="idsolicitud" id="idsolicitud" disabled>
                                                    <option value="">- Seleccione -</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Título:</label>
                                                <input type="text" class="form-control" name="titulo" id="titulo" maxlength="40" placeholder="Ingrese el título de su puesto." required>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Descripción:</label>
                                                <textarea class="form-control" name="descripcion" id="descripcion" rows="5" maxlength="300" placeholder="Ingrese la descripción de su puesto." required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Ubicación:</label>
                                                <input type="text" class="form-control" name="ubicacion" id="ubicacion" maxlength="50" placeholder="Ingrese la ubicación de su puesto." required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Horario:</label>
                                                <input type="text" class="form-control" name="horario" id="horario" maxlength="80" placeholder="Ingrese el horario disponible de su puesto." required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Empresa:</label>
                                                <input type="text" class="form-control" name="empresa" id="empresa" maxlength="25" placeholder="Ingrese el nombre o marca de su empresa." required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Imagen:</label>
                                                <input type="file" class="form-control" name="imagen" id="imagen" accept="image/x-png,image/gif,image/jpeg">
                                                <input type="hidden" name="imagenactual" id="imagenactual">
                                                <img class="mt-2" src="../../dash/img/profile.jpg" id="imagenmuestra" style="height: 150px; border-radius: 22px;">
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Modalidad:</label>
                                                <select class="form-control" name="modalidad" id="modalidad" required>
                                                    <option value="">- Seleccione -</option>
                                                    <option value="1">Presencial</option>
                                                    <option value="2">Semi presencial</option>
                                                    <option value="3">Remoto</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Área:</label>
                                                <input type="text" class="form-control" name="area" id="area" maxlength="40" placeholder="Ingrese el área donde pertenece su puesto." required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Género:</label>
                                                <select class="form-control" name="genero" id="genero" required>
                                                    <option value="">- Seleccione -</option>
                                                    <option value="masculino">Masculino</option>
                                                    <option value="femenino">Femenino</option>
                                                    <option value="cualquiera">Cualquiera</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Fecha de creación:</label>
                                                <input type="datetime-local" class="form-control" name="fecha_hora" id="fecha_hora" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Conocimientos:</label>
                                                <textarea class="form-control" name="conocimientos" id="conocimientos" rows="7" maxlength="1000" placeholder="Ingrese los conocimientos requeridos en su puesto." required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Beneficios:</label>
                                                <textarea class="form-control" name="beneficios" id="beneficios" rows="7" maxlength="1000" placeholder="Ingrese los beneficios de su puesto." required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Requisitos:</label>
                                                <textarea class="form-control" name="requisitos" id="requisitos" rows="7" maxlength="1000" placeholder="Ingrese los requisitos de su puesto." required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Ofrecemos:</label>
                                                <textarea class="form-control" name="ofrendas" id="ofrendas" rows="7" maxlength="1000" placeholder="Ingrese qué ofrece en su puesto." required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row p-4 pt-0">
                                    <div class="col-md-6 text-end ms-auto">
                                        <button type="submit" id="btnGuardar" class="btn bg-gradient-info mb-0">Editar</button>
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
            cambiarTitulo('TopiTop | Editar Puestos')
        }
    </script>

    <?php
    require '../layout/footer.php';
    ob_end_flush();
    ?>

    <script src="../../../config/scripts/puestos12.js"></script>

    <script>
        $(document).ready(function() {
            $("#formulario").on("submit", function(e) {
                editar(e);
            });
            selectSolicitudesEditDetails();
            document.getElementById("titulo").focus();
        });
    </script>