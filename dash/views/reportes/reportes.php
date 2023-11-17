<?php
ob_start();
require '../layout/header.php';

if (!isset($_SESSION["idusuario"])) {
    session_destroy(); // Cierre de sesión adecuado.
    header("Location: ../auth/error.php");
    exit(); // Y detenemos la ejecución después de la redirección.
}
?>

<style>
    .loader {
        width: 400px;
        height: 115px;
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
            linear-gradient(#DDD 50px, transparent 0),
            linear-gradient(#DDD 16px, transparent 0),
            linear-gradient(#DDD 50px, transparent 0);
        background-repeat: no-repeat;
        background-size: 75px 175px, 100% 40px, 100% 46px, 100% 30px;
        background-position: -185px 0, center 0, center 115px, center 142px;
        box-sizing: border-box;
        animation: animloader 1s linear infinite;
    }

    @keyframes animloader {
        to {
            background-position: 360px 0, center 0, center 115px, center 142px;
        }
    }

    .loader2 {
        width: 400px;
        height: 210px;
        display: block;
        position: relative;
        background: #FFF;
        box-sizing: border-box;
        border-radius: 20px;
    }

    .loader2::after {
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
        background-size: 75px 175px, 100% 100px, 100% 46px, 100% 30px;
        background-position: -185px 0, center 0, center 115px, center 142px;
        box-sizing: border-box;
        animation: animloader2 1s linear infinite;
    }

    @keyframes animloader2 {
        to {
            background-position: 210px 0, center 0, center 115px, center 142px;
        }
    }
</style>

<body class="g-sidenav-show bg-gray-100" id="contain-body" onload="cambiarTitulo('Childminder Alert | Reportes')">
    <div class="min-height-400 bg-primary position-absolute w-100"></div>
    <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 panel" id="sidenav-main">
        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer  opacity-5 position-absolute end-0 top-0 d-xl-none d-block" aria-hidden="true" id="iconSidenav"></i>
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
                    <a href="../home/dashboard.php" class="nav-link">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-spaceship text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../actividades/actividades.php" class="nav-link">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-puzzle-piece text-primary text-sm opacity-10 mb-1"></i>
                        </div>
                        <span class="nav-link-text ms-1">Actividades</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../dispositivos/dispositivos.php" class="nav-link">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-mobile text-primary text-sm opacity-10 mb-1"></i>
                        </div>
                        <span class="nav-link-text ms-1">Dispositivos</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="reportes.php" class="nav-link active">
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
                        <a href="../usuarios/usuarios.php" class="nav-link">
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
                    <a href="../home/perfil.php" class="nav-link">
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
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">Reportes</li>
                    </ol>
                    <h6 class="font-weight-bolder text-white mb-0">Reportes</h6>
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
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center col-xl-3 col-lg-5 col-6">
                    </div>
                    <ul class="navbar-nav  justify-content-end">
                        <li class="nav-item d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white font-weight-bold px-0">
                                <i class="fa fa-user me-md-1"></i>
                                <span class="d-md-inline d-none">Bienvenido: <?php echo ucwords($_SESSION['usuario']); ?> - <?php echo $_SESSION['rol_descripcion']; ?></span>
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
        <div class="container-fluid py-4">
            <div class="row fila1">
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card" style="height: 100% !important;">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold" style="font-size: 12.5px !important;">Cantidad de actividades</p>
                                        <h5 class="font-weight-bolder">
                                            4
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                        <i class="ni ni-planet text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card" style="height: 100% !important;">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold" style="font-size: 12.5px !important;">Cantidad de hijos</p>
                                        <h5 class="font-weight-bolder">
                                            2
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                        <i class="fa fa-child text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card" style="height: 100% !important;">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold" style="font-size: 12.5px !important;">Cantidad de dispositivos</p>
                                        <h5 class="font-weight-bolder">
                                            1
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                        <i class="fa fa-mobile text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card" style="height: 100% !important;">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold" style="font-size: 12.5px !important;">Cantidad de trabajadores</p>
                                        <h5 class="font-weight-bolder">
                                            2
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                        <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 mb-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row fila2">
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <div class="card-header mx-4 p-3 text-center">
                                            <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                                <i class="fas fa-heart-pulse opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <div class="card-body pt-0 p-3 text-center">
                                            <h6 class="text-center mb-0">Mayor puslo cardiaco del niño</h6>
                                            <span class="text-xs">Máximo alcanzado</span>
                                            <hr class="horizontal dark my-3">
                                            <h5 class="mb-0">95</h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <div class="card-header mx-4 p-3 text-center">
                                            <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                                <i class="fas fa-temperature-half opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <div class="card-body pt-0 p-3 text-center">
                                            <h6 class="text-center mb-0">Mayor temperatura del niño</h6>
                                            <span class="text-xs">Máximo alcanzado</span>
                                            <hr class="horizontal dark my-3">
                                            <h5 class="mb-0">38°</h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <div class="card-header mx-4 p-3 text-center">
                                            <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                                <i class="fas fa-list-check opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <div class="card-body pt-0 p-3 text-center">
                                            <h6 class="text-center mb-0">Actividades culminadas del niño</h6>
                                            <span class="text-xs">Cantidad total</span>
                                            <hr class="horizontal dark my-3">
                                            <h5 class="mb-0">3</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header pb-0 px-3">
                                    <h6 class="mb-0">Actividades del niño</h6>
                                </div>
                                <div class="card-body pt-4 p-3">
                                    <ul class="list-group fila3">
                                        <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-3 text-sm">Miguel Antonhy PS</h6>
                                                <span class="mb-2 text-xs"><span style="font-weight: 800;">Título de la actividad: </span><span class="font-weight-normal ms-sm-1">AYUDAR A RECOGER LA ROPA</span></span>
                                                <span class="mb-2 text-xs"><span style="font-weight: 800;">Padre de familia: </span><span class="font-weight-normal ms-sm-1">Christopher PS</span></span>
                                                <span class="mb-2 text-xs"><span style="font-weight: 800;">Agregado el: </span><span class="font-weight-normal ms-sm-1">4 de noviembre del 2023, a las 2:04 pm</span></span>
                                                <span class="mb-2 text-xs"><span style="font-weight: 800;">Estado: </span><span class="font-weight-normal ms-sm-1">Pendiente</span></span>
                                            </div>
                                            <div class="ms-auto text-end">
                                                <a class="text-sm mb-0 font-weight-bold" href="../actividades/actividades-detail.php?idactividad=4"><i class="fas fa-eye text-sm mb-0 me-2" aria-hidden="true"></i>Detalles</a>
                                            </div>
                                        </li>
                                        <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-3 text-sm">Mateo Jhordan PS</h6>
                                                <span class="mb-2 text-xs"><span style="font-weight: 800;">Título de la actividad: </span><span class="font-weight-normal ms-sm-1">VER PROGRAMAS EDUCATIVOS</span></span>
                                                <span class="mb-2 text-xs"><span style="font-weight: 800;">Padre de familia: </span><span class="font-weight-normal ms-sm-1">Christopher PS</span></span>
                                                <span class="mb-2 text-xs"><span style="font-weight: 800;">Agregado el: </span><span class="font-weight-normal ms-sm-1">4 de noviembre del 2023, a las 2:04 pm</span></span>
                                                <span class="mb-2 text-xs"><span style="font-weight: 800;">Estado: </span><span class="font-weight-normal ms-sm-1">Pendiente</span></span>
                                            </div>
                                            <div class="ms-auto text-end">
                                                <a class="text-sm mb-0 font-weight-bold" href="../actividades/actividades-detail.php?idactividad=3"><i class="fas fa-eye text-sm mb-0 me-2" aria-hidden="true"></i>Detalles</a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 mb-lg-0 mb-4" style="height: min-content;">
                    <div class="row fila4">
                        <div class="col-12 mb-4">
                            <div class="card z-index-2">
                                <div class="card-header pb-0 pt-3 bg-transparent">
                                    <h6>Cantidad de personas registrados en nuestra app</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="chart">
                                        <canvas id="chart-line1" class="chart-canvas" height="300" style="display: block; box-sizing: border-box; height: 300px; width: 432px;" width="432"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card z-index-2">
                                <div class="card-header pb-0 pt-3 bg-transparent">
                                    <h6>Cantidad de personas que visitaron la página</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="chart">
                                        <canvas id="chart-line2" class="chart-canvas" height="300" style="display: block; box-sizing: border-box; height: 300px; width: 432px;" width="432"></canvas>
                                    </div>
                                </div>
                            </div>
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
    <script src="../../../dash/assets/js/plugins/chartjs.min.js"></script>
    <script src="../../scripts/reportes15.js"></script>