<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/childminder-logo.png">
    <link rel="icon" type="image/png" href="../assets/img/childminder-logo.png">
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/argon-dashboard13.css?v=2.0.4" />
</head>

<style>
    @media (max-width: 880px) {
        .error {
            text-align: left !important;
        }
    }

    body {
        background-color: white;
    }
</style>

<body class="g-sidenav-show bg-gray-100" onload="cambiarTitulo('Childminder Alert | Error 404')">
    <main class="main-content mt-0">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-7 mx-auto w-90" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                    <div class="card z-index-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 mx-auto my-auto pt-4">
                                    <div class="col-md-12 mb-3 mt-3 d-flex pt-4 align-items-center justify-content-start">
                                        <p>
                                        <div class="text-primary fw-bold">¡Oops!... la página no ha sido encontrada o quizás no tengas acceso.</div>
                                        </p>
                                    </div>
                                    <div class="col-md-12 mb-3 mt-3 d-flex align-items-center justify-content-start w-sm-50 w-lg-25">
                                        <button class="btn bg-gradient-info w-100 my-4 mt-2 mb-2" id="volver">Volver</button>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3 mt-3 d-flex align-items-center justify-content-sm-start justify-content-lg-end">
                                    <p>
                                    <div class="text-primary error" style="font-size: 150px; font-weight: 900; line-height : 150px; text-align: right;">Error 404.</div>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function cambiarTitulo(nuevoTitulo) {
            document.title = nuevoTitulo;
        }
        document.getElementById("volver").addEventListener("click", function() {
            window.history.back();
        });
    </script>