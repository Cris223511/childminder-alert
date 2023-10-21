<?php
ob_start();
require '../layout/header.php';

if (!isset($_SESSION["idusuario"])) {
    session_destroy(); // Cierre de sesión adecuado.
    header("Location: ../../auth/error.php");
    exit(); // Y detenemos la ejecución después de la redirección.
}
?>

<style>
    .card img {
        width: 100%;
        height: auto;
        border-radius: 10px 10px 0 0;
    }

    html {
        scroll-behavior: smooth !important;
    }

    @supports(object-fit: cover) {
        .card img {
            height: 100%;
            object-fit: cover;
            object-position: center center;
        }
    }
</style>

<body class="g-sidenav-show bg-gray-100" id="contain-body" onload="cambiarTitulo('Childminder Alert | Perfil')">
    <div class="position-absolute w-100 min-height-300 top-0" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/profile-layout-header.jpg'); background-position-y: 50%;">
        <span class="mask bg-primary opacity-6"></span>
    </div>
    <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 panel" id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer position-absolute end-0 top-0 d-xl-none d-block" aria-hidden="false" id="iconSidenav"></i>
            <a class="navbar-brand m-0">
                <img src="../../assets/img/childminder-logo.png" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-2 font-weight-bold">Childminder Alert</span>
            </a>
        </div>
        <hr class="horizontal dark mt-0">
        <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main" style="height: max-content !important">
            <ul class="navbar-nav">
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Principal</h6>
                </li>
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-spaceship text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-puzzle-piece text-primary text-sm opacity-10 mb-1"></i>
                        </div>
                        <span class="nav-link-text ms-1">Actividades</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-mobile text-primary text-sm opacity-10 mb-1"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dispositivos</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-book-bookmark text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Reportes</span>
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Admin</h6>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-single-02 text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Usuarios</span>
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Personal</h6>
                </li>
                <li class="nav-item">
                    <a href="perfil.php" class="nav-link active">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-settings-gear-65 text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Mi Perfil</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a id="logout" class="nav-link" style="cursor: pointer;">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-arrow-right-to-bracket text-info text-sm opacity-10 mb-1"></i>
                        </div>
                        <span class="nav-link-text ms-1">Cerrar sesión</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <main class="main-content position-relative border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Personal</a></li>
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Mi Perfil</li>
                    </ol>
                    <h6 class="font-weight-bolder text-white mb-0">Mi Perfil</h6>
                </nav>
                <div id="iconNavbarSidenav">
                    <li class="nav-item d-xl-none p-3 pt-0 pb-0 d-flex align-items-start">
                        <a href="javascript:;" class="nav-link text-white p-0">
                            <div class="sidenav-toggler-inner text-center">
                                <i style="margin-top: -5px;" class="sidenav-toggler-line fa-solid fa-bars color-white"></i>
                            </div>
                        </a>
                    </li>
                </div>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 gap-2" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center col-xl-3 col-lg-5 col-6">
                    </div>
                    <ul class="navbar-nav justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white font-weight-bold px-0">
                                <i class="fa fa-user me-md-1"></i>
                                <span class="d-md-inline d-none">Bienvenido: <?php echo ucwords($_SESSION['nombres']); ?> - <?php echo $_SESSION['rol_descripcion']; ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="main-content position-relative max-height-vh-100 h-100">
            <div class="card shadow-lg mx-4 card-profile-bottom">
                <div class="card-body p-3">
                    <div class="row gx-4">
                        <div class="col-8 my-auto">
                            <div class="h-100">
                                <h5 class="mb-1 nombre_usuario">
                                    Hola, <?php echo ucwords(strtolower($_SESSION['nombres'])); ?>.
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-info shadow-danger text-center rounded-circle">
                                <i class="ni ni-satisfied text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-md-8">
                        <form method="POST" id="formulario">
                            <div class="card mb-4">
                                <div class="card-header pb-0">
                                    <div class="d-flex align-items-center">
                                        <p class="mb-0">Editar perfil</p>
                                        <button type="submit" class="btn btn-primary btn-sm ms-auto" id="btnGuardar">Guardar cambios</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="text-uppercase text-sm">Información personal:</p>
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Nombres:</label>
                                                <input type="text" class="form-control" name="nombres" id="nombres" maxlength="30" placeholder="Ingrese sus nombres completos." required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Apellidos:</label>
                                                <input type="text" class="form-control" name="apellidos" id="apellidos" maxlength="30" placeholder="Ingrese sus apellidos completos." required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Rol:</label>
                                                <input type="text" class="form-control" id="rol" maxlength="20" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Usuario:</label>
                                                <input type="text" class="form-control" name="usuario" id="usuario" maxlength="20" placeholder="Ingrese su usuario." required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Correo electrónico:</label>
                                                <input type="email" class="form-control" name="email" id="email" autocomplete="honorific-suffix" maxlength="40" placeholder="Ingrese su correo electrónico." required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Foto de perfil:</label>
                                                <input type="file" class="form-control" name="imagen" id="imagen" accept="image/x-png,image/gif,image/jpeg">
                                                <input type="hidden" name="imagenactual" id="imagenactual">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="example-text-input" class="form-control-label">Fecha nacimiento:</label>
                                                <input type="date" class="form-control" name="fecha_nac" id="fecha_nac" required>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="horizontal dark">
                                    <p class="text-uppercase text-sm">Información de contacto:</p>
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Tipo de documento:</label>
                                                <select class="form-control" name="tipo_documento" id="tipo_documento" onchange="changeValue(this);" required>
                                                    <option>- Seleccione -</option>
                                                    <option value="DNI">DNI</option>
                                                    <option value="RUC">RUC</option>
                                                    <option value="cedula">Cédula</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Número de documento:</label>
                                                <input type="number" class="form-control" name="num_documento" id="num_documento" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="9" placeholder="Ingrese el N° de documento." required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Teléfono:</label>
                                                <input type="number" class="form-control" name="telefono" id="telefono" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="9" placeholder="Ingrese el N° de teléfono." required>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <label for="titulo">Dirección:</label>
                                                <input type="text" class="form-control" name="direccion" id="direccion" maxlength="60" placeholder="Ingrese la dirección." required>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="horizontal dark">
                                    <p class="text-uppercase text-sm">Acerca de tí:</p>
                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <label for="descripcion">Descripción:</label>
                                                <textarea type="text" class="form-control" name="descripcion" id="descripcion" maxlength="300" rows="4" placeholder="Ingrese una descripción (opcional)." style="resize: none;"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card card-profile">
                            <img src="../../assets/img/profile.jpg" id="imagenmuestra" style="height: 300px;">
                            <div class="row justify-content-center">

                            </div>
                            <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3">
                            </div>
                            <div class="card-body pt-0 cargando-datos d-block">
                                <div class="text-center mt-0">
                                    <h5>
                                        <span class="font-weight-bold">Cargando...</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="card-body pt-0 datos-personales d-none">
                                <div class="text-center mt-0">
                                    <h5>
                                        <span class="font-weight-light"><span class="nombres"></span> <span class="apellidos"></span></span>
                                    </h5>
                                    <div class="h6 mt-2">
                                        <span class="email"></span>
                                    </div>
                                    <div class="h6 mt-2 font-weight-light">
                                        <i class="fa fa-phone"></i>&nbsp; &nbsp;<span class="telefono"></span>
                                    </div>
                                    <div class="h6 mt-2">
                                        <i class="fa fa-map-marker"></i>&nbsp; &nbsp;<span class="direccion"></span>
                                    </div>
                                    <div class="h6 mt-2">
                                        <span class="font-weight-light descripcion"></span>
                                    </div>
                                    <div class="h6 mt-2">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-xxl-6 text-center mt-2 mb-2">
                                                <i class="fa fa-address-card"></i>&nbsp; &nbsp;<span class="tipo_documento"></span>: <span class="num_documento"></span>
                                            </div>
                                            <div class="col-xxl-6 text-center mt-2 mb-2">
                                                <i class="fa fa-calendar"></i>&nbsp; &nbsp;<span class="fecha_nac"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="footer pb-4">
                    <div class="container-fluid">
                        <div class="row align-items-center justify-content-lg-between">
                            <div class="col-lg-12 mb-lg-0 mb-4">
                                <div class="copyright text-center text-sm text-muted text-lg-start">
                                    <strong>© 2023</strong> Childminder Alert, todos los derechos reservados.
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </main>

    <?php
    require '../layout/footer.php';
    ob_end_flush();
    ?>

    <script src="../../scripts/perfil5.js"></script>