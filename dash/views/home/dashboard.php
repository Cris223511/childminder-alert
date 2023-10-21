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
    .principal img {
        width: 100%;
        height: auto;
        border-radius: 10px 10px 0 0;
    }

    @supports(object-fit: cover) {
        .principal img {
            height: 100%;
            object-fit: cover;
            object-position: center center;
        }
    }

    .loader {
        width: 400px;
        height: 310px;
        display: block;
        position: relative;
        background: #FFF;
        box-sizing: border-box;
        border-radius: 20px;
    }

    .loader::after {
        content: '';
        width: calc(100% - 30px);
        height: calc(100% - 15px);
        top: 15px;
        left: 15px;
        position: absolute;
        background-image: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5) 50%, transparent 100%),
            linear-gradient(#DDD 100px, transparent 0),
            linear-gradient(#DDD 16px, transparent 0),
            linear-gradient(#DDD 50px, transparent 0);
        background-repeat: no-repeat;
        background-size: 75px 175px, 100% 100px, 100% 16px, 100% 30px;
        background-position: -185px 0, center 0, center 115px, center 142px;
        box-sizing: border-box;
        animation: animloader 1s linear infinite;
    }

    @keyframes animloader {
        to {
            background-position: 285px 0, center 0, center 115px, center 142px;
        }
    }

    .titulo {
        font-size: 1.1rem;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<body class="g-sidenav-show bg-gray-100" id="contain-body" onload="cambiarTitulo('Childminder Alert | Dashboard')">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
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
                    <a href="dashboard.php" class="nav-link active">
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
                <?php if ($_SESSION["rol"] == "admin") { ?>
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
                <?php } ?>
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Personal</h6>
                </li>
                <li class="nav-item">
                    <a href="perfil.php" class="nav-link">
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
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Inicio</a></li>
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Dashboard</li>
                    </ol>
                    <h6 class="font-weight-bolder text-white mb-0">Dashboard</h6>
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
                        <div class="input-group">
                            <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                            <input type="text" class="form-control" id="txtBuscar2" name="txtBuscar2" placeholder="Buscar actividad.">
                        </div>
                    </div>
                    <ul class="navbar-nav justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white font-weight-bold px-0">
                                <i class="fa fa-user me-md-1"></i>
                                <span class="d-md-inline d-none">Bienvenido: <?php echo ucwords($_SESSION['nombres']); ?> - <?php echo $_SESSION['rol_descripcion']; ?></span>
                            </a>
                        </li>
                        <li class="nav-item px-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0" id="mostrar-ajustes">
                                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid py-2">
            <div class="row">
                <div class="col-12 mb-xl-0">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8 d-flex align-items-center">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">TUS ACTIVIDADES REGISTRADAS</p>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-info shadow-danger text-center rounded-circle">
                                        <i class="ni ni-satisfied text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Start Card -->
            <div class="mt-5">
                <h6 class="mb-4 fw-bold" id="noResults" style="color: white; display: none;">¡Opps!... La actividad que usted buscó no existe.</h6>
                <!-- <div class="row puestos">
                    <div class="col-lg-4 col-md-6">
                        <span class="w-100 card loader"></span>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <span class="w-100 card loader"></span>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <span class="w-100 card loader"></span>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-lg-4 col-md-6 mt-4 mb-4 tarjetaGeneral">
                        <div class="card z-index-2">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                                <div class="bg-gradient-success shadow-primary border-radius-lg py-3 pe-1" style="background-image: url('../../assets/img/img-1.jpg'); background-size: cover; background-position: center center;">
                                    <div class="chart">
                                        <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="mb-2 titulo">Título</h6>
                                <div class="row">
                                    <div class="col-lg-8 d-flex justify-content-start">
                                        <div><span class="text-sm">Autor: Christopher PS</span><span> | </span><span class="text-sm">20/10/23, 16:40 p.m.</span></div>
                                    </div>
                                    <div class="col-lg-4 d-flex justify-content-end">
                                        <span class="badge badge-sm bg-gradient-warning" style="height: 25px">
                                            Pendiente
                                        </span>
                                    </div>
                                </div>
                                <div class="row d-flex flex-column justify-content-center p-0 m-0 pt-3">
                                    <div class="d-flex justify-content-center p-0 m-0 botones">
                                        <a href="" class="btn bg-gradient-warning w-100 boton text-center p-0 pt-2 pb-2 m-1 align-items-center" style="font-size: 13px; width: 100px; margin-left: 0px !important;">
                                            Ver más
                                        </a>
                                        <a href="" class="btn bg-gradient-primary w-100 boton text-center p-0 pt-2 pb-2 m-1 align-items-center" style="font-size: 13px; width: 100px; margin-right: 0px !important;">
                                            Detalles
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mt-4 mb-4 tarjetaGeneral">
                        <div class="card z-index-2">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                                <div class="bg-gradient-success shadow-primary border-radius-lg py-3 pe-1" style="background-image: url('../../assets/img/img-1.jpg'); background-size: cover; background-position: center center;">
                                    <div class="chart">
                                        <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="mb-2 titulo">Título</h6>
                                <div class="row">
                                    <div class="col-lg-8 d-flex justify-content-start">
                                        <div><span class="text-sm">Autor: Christopher PS</span><span> | </span><span class="text-sm">20/10/23, 16:40 p.m.</span></div>
                                    </div>
                                    <div class="col-lg-4 d-flex justify-content-end">
                                        <span class="badge badge-sm bg-gradient-warning" style="height: 25px">
                                            Pendiente
                                        </span>
                                    </div>
                                </div>
                                <div class="row d-flex flex-column justify-content-center p-0 m-0 pt-3">
                                    <div class="d-flex justify-content-center p-0 m-0 botones">
                                        <a href="" class="btn bg-gradient-warning w-100 boton text-center p-0 pt-2 pb-2 m-1 align-items-center" style="font-size: 13px; width: 100px; margin-left: 0px !important;">
                                            Ver más
                                        </a>
                                        <a href="" class="btn bg-gradient-primary w-100 boton text-center p-0 pt-2 pb-2 m-1 align-items-center" style="font-size: 13px; width: 100px; margin-right: 0px !important;">
                                            Detalles
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mt-4 mb-4 tarjetaGeneral">
                        <div class="card z-index-2">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                                <div class="bg-gradient-success shadow-primary border-radius-lg py-3 pe-1" style="background-image: url('../../assets/img/img-1.jpg'); background-size: cover; background-position: center center;">
                                    <div class="chart">
                                        <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="mb-2 titulo">Título</h6>
                                <div class="row">
                                    <div class="col-lg-8 d-flex justify-content-start">
                                        <div><span class="text-sm">Autor: Christopher PS</span><span> | </span><span class="text-sm">20/10/23, 16:40 p.m.</span></div>
                                    </div>
                                    <div class="col-lg-4 d-flex justify-content-end">
                                        <span class="badge badge-sm bg-gradient-warning" style="height: 25px">
                                            Pendiente
                                        </span>
                                    </div>
                                </div>
                                <div class="row d-flex flex-column justify-content-center p-0 m-0 pt-3">
                                    <div class="d-flex justify-content-center p-0 m-0 botones">
                                        <a href="" class="btn bg-gradient-warning w-100 boton text-center p-0 pt-2 pb-2 m-1 align-items-center" style="font-size: 13px; width: 100px; margin-left: 0px !important;">
                                            Ver más
                                        </a>
                                        <a href="" class="btn bg-gradient-primary w-100 boton text-center p-0 pt-2 pb-2 m-1 align-items-center" style="font-size: 13px; width: 100px; margin-right: 0px !important;">
                                            Detalles
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Card -->
            <div class="row mt-4 mb-4">
                <div class="col-lg-7 mb-4">
                    <div class="card">
                        <div class="card-header pb-0 p-3 pt-4">
                            <div class="d-flex justify-content-center">
                                <h6 class="mb-2 loading-data">Dispositivos vinculados</h6>
                            </div>
                        </div>
                        <!-- <hr class="horizontal dark my-1 mb-0"> -->
                        <div class="table-responsive">
                            <table id="myTable" class="table align-items-center">
                                <thead></thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card principal card-carousel overflow-hidden h-100 p-0" style="height: 380px !important;">
                        <div id="carouselExampleCaptions" class="carousel slide h-100" data-bs-ride="carousel">
                            <div class="carousel-inner border-radius-lg h-100">
                                <div class="carousel-item h-100 active" style="background-image: url('../../assets/img/trabajo-dash-2.jpg'); background-size: cover; background-repeat: no-repeat;">
                                    <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                        <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                            <i class="ni ni-camera-compact text-dark opacity-10"></i>
                                        </div>
                                        <h5 class="text-white mb-1">Childminder Alert.</h5>
                                        <p>Facilitando la gestión del TDAH para una vida más organizada.</p>
                                    </div>
                                </div>
                                <div class="carousel-item h-100" style="background-image: url('../../assets/img/trabajo-dash-3.jpg'); background-size: cover; background-repeat: no-repeat;">
                                    <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                        <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                            <i class="ni ni-bulb-61 text-dark opacity-10"></i>
                                        </div>
                                        <h5 class="text-white mb-1">Trabajo en equipo.</h5>
                                        <p>Trabajamos codo a codo con expertos en TDAH y familias para ofrecer soluciones efectivas. Nuestro enfoque es colaborativo, centrado en el bienestar de los niños.</p>
                                    </div>
                                </div>
                                <div class="carousel-item h-100" style="background-image: url('../../assets/img/trabajo-dash-1.jpg'); background-size: cover; background-repeat: no-repeat;">
                                    <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                        <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                            <i class="ni ni-trophy text-dark opacity-10"></i>
                                        </div>
                                        <h5 class="text-white mb-1">Cada vez mejorando.</h5>
                                        <p>Nos esforzamos constantemente para ofrecer tecnología de vanguardia que ayude a los niños y adolescentes con TDAH a vivir de manera más independiente y organizada.</p>
                                    </div>
                                </div>
                            </div>
                            <button class="carousel-control-prev w-5 me-3" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next w-5 me-3" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="fixed-plugin" id="ajustes">
        <a class="fixed-plugin-button text-dark position-fixed px-3 py-2" id="mostrar-ajustes2">
            <i class="fa fa-cog py-2"> </i>
        </a>
        <div class="card shadow-lg">
            <div class="card-header pb-0 pt-3 ">
                <div class="float-start">
                    <h5 class="mt-3 mb-0">Configuraciones</h5>
                    <p>Modifica la interfaz a tu preferencia.</p>
                </div>
                <div class="float-end mt-4" id="ocultar-ajustes">
                    <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                        <i class="fa fa-close"></i>
                    </button>
                </div>
                <!-- End Toggle Button -->
            </div>
            <hr class="horizontal dark my-1">
            <div class="card-body pt-sm-3 pt-0 overflow-auto">
                <!-- Sidebar Backgrounds -->
                <div>
                    <h6 class="mb-0">Colores de la barra lateral</h6>
                </div>
                <a href="javascript:void(0)" class="switch-trigger background-color">
                    <div class="badge-colors my-2 text-start">
                        <span class="badge filter bg-gradient-primary active" data-color="primary" onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-dark" data-color="dark" onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
                    </div>
                </a>
                <!-- Sidenav Type -->
                <hr class="horizontal dark my-sm-4">
                <div class="mt-2 mb-5 d-flex">
                    <h6 class="mb-0">Claro / Oscuro</h6>
                    <div class="form-check form-switch ps-0 ms-auto my-auto">
                        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this); cabecera(this);">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    require '../layout/footer.php';
    ob_end_flush();
    ?>

    <!-- <script src="../../../config/scripts/dashboard4.js"></script>

    <script>
        $(document).ready(function() {
            listarPuestos();
            listarTabla();
        });
    </script> -->