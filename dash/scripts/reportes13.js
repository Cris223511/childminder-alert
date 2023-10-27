let mes1;
let cantidad1;
let postuladosData;

let mes2;
let cantidad2;
let postulantesData;

function mostrarDatosReporte() {
    $.ajax({
        url: '../../ajax/reportes.php?op=mostrarDatosReporte',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);

            /* ----------------- Primero borralos los loaders ----------------- */

            $('.fila1').empty();
            $('.fila2').empty();
            $('.fila3').empty();
            $('.fila4').empty();

            /* ----------------- Si los datos vienen vacíos en cada fila, mostramos estos textos, de lo contrario, mostramos la data ----------------- */

            data.fila1.forEach(function (datos1) {
                var fila1 = `
                        <div class="col-xl-3 col-sm-6 mb-4">
                            <div class="card" style="height: 100% !important;">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-uppercase font-weight-bold" style="font-size: 12.5px !important;">${datos1.titulo}</p>
                                                <h5 class="font-weight-bolder">
                                                    ${datos1.cantidad}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape ${datos1.color} text-center rounded-circle">
                                                <i class="${datos1.icon} text-lg opacity-10" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                $('.fila1').append(fila1);
            });

            data.fila2.forEach(function (datos2) {
                var fila2 = `
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-header mx-4 p-3 text-center">
                                    <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                        <i class="${datos2.icon} opacity-10"></i>
                                    </div>
                                </div>
                                <div class="card-body pt-0 p-3 text-center">
                                    <h6 class="text-center mb-0">${datos2.titulo}</h6>
                                    <span class="text-xs">Cantidad total</span>
                                    <hr class="horizontal dark my-3">
                                    <h5 class="mb-0">${datos2.cantidad}</h5>
                                </div>
                            </div>
                        </div>
                    `;

                $('.fila2').append(fila2);
            });

            if (data.fila3.length == 0) {
                var fila3 = `
                    <div class="d-flex justify-content-center align-items-center">
                        <h6 class="mb-2 loading-data">Sin datos por mostrar.</h6>
                    </div>
                `;
                $('.fila3').append(fila3);
            } else {
                data.fila3.forEach(function (datos3) {
                    var fila3 = `
                        <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                            <div class="d-flex flex-column">
                                <h6 class="mb-3 text-sm">${capitalizarPalabras(datos3.nombres)} ${capitalizarPalabras(datos3.apellidos)}</h6>
                                <span class="mb-2 text-xs"><span style="font-weight: 800;">Título del puesto: </span><span class="font-weight-normal ms-sm-1">${datos3.titulo}</span></span>
                                <span class="mb-2 text-xs"><span style="font-weight: 800;">Empresa: </span><span class="font-weight-normal ms-sm-1">${datos3.empresa}</span></span>
                                <span class="mb-2 text-xs"><span style="font-weight: 800;">Dirección: </span><span class="font-weight-normal ms-sm-1">${datos3.ubicacion}</span></span>
                                <span class="mb-2 text-xs"><span style="font-weight: 800;">Puntaje total: </span><span class="font-weight-normal ms-sm-1">${datos3.puntaje_total} de 100</span></span>
                                <span class="text-xs"><span style="font-weight: 800;">Fecha de postulado: </span><span class="font-weight-normal ms-sm-1">${datos3.fecha}</span></span>
                            </div>
                            <div class="ms-auto text-end">
                                ${datos3.boton}
                            </div>
                        </li>
                    `;

                    $('.fila3').append(fila3);
                });
            }

            postuladosData = Array(12).fill(0);

            var promise1 = new Promise(function (resolve, reject) {
                data.fila4_postulados.forEach(function (datos4, index, array) {
                    mes1 = parseInt(datos4.mes_postulado);
                    cantidad1 = parseInt(datos4.cantidad_postulados);
                    postuladosData[mes1 - 1] = cantidad1;

                    console.log(postuladosData);

                    if (index === array.length - 1) {
                        resolve();
                    }
                });
            });

            promise1.then(function () {
                var fila4_postulados = `
                    <div class="col-12 mb-4">
                        <div class="card z-index-2">
                            <div class="card-header pb-0 pt-3 bg-transparent">
                                <h6>Cantidad de postulados por mes</h6>
                            </div>
                            <div class="card-body p-3">
                                <div class="chart">
                                    <canvas id="chart-line1" class="chart-canvas" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                $('.fila4').append(fila4_postulados);

                graficoReporte1();
            });

            postulantesData = Array(12).fill(0);

            var promise2 = new Promise(function (resolve, reject) {
                data.fila4_postulantes.forEach(function (datos4, index, array) {
                    mes2 = parseInt(datos4.mes_registro);
                    cantidad2 = parseInt(datos4.cantidad_postulantes);
                    postulantesData[mes2 - 1] = cantidad2;

                    console.log(postulantesData);

                    if (index === array.length - 1) {
                        resolve();
                    }
                });
            });

            promise2.then(function () {
                var fila4_postulantes = `
                    <div class="col-12">
                        <div class="card z-index-2">
                            <div class="card-header pb-0 pt-3 bg-transparent">
                                <h6>Cantidad de postulantes registrados por mes</h6>
                            </div>
                            <div class="card-body p-3">
                                <div class="chart">
                                    <canvas id="chart-line2" class="chart-canvas" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                $('.fila4').append(fila4_postulantes);

                graficoReporte2();
            });
        },
        error: function (xhr, status, error) {
            console.log(error);
        }
    });
}

function graficoReporte1() {
    var ctx1 = document.getElementById("chart-line1").getContext("2d");

    if (window.chart1) {
        window.chart1.destroy(); // Destruir instancia anterior si existe
    }

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);
    gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');

    window.chart1 = new Chart(ctx1, {
        type: "bar",
        data: {
            labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            datasets: [{
                label: "Cantidad de postulados por mes",
                tension: 0.4,
                borderWidth: 0,
                pointRadius: 0,
                borderColor: "#5e72e4",
                backgroundColor: gradientStroke1,
                borderWidth: 3,
                fill: true,
                data: postuladosData,
                maxBarThickness: 6
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
            scales: {
                y: {
                    grid: {
                        drawBorder: false,
                        display: true,
                        drawOnChartArea: true,
                        drawTicks: false,
                        borderDash: [5, 5]
                    },
                    ticks: {
                        display: true,
                        padding: 10,
                        color: '#fbfbfb',
                        font: {
                            size: 11,
                            family: "Open Sans",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
                x: {
                    grid: {
                        drawBorder: false,
                        display: false,
                        drawOnChartArea: false,
                        drawTicks: false,
                        borderDash: [5, 5]
                    },
                    ticks: {
                        display: true,
                        color: '#ccc',
                        padding: 20,
                        font: {
                            size: 11,
                            family: "Open Sans",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
            },
        },
    });
}

function graficoReporte2() {
    var ctx2 = document.getElementById("chart-line2").getContext("2d");

    if (window.chart2) {
        window.chart2.destroy(); // Destruir instancia anterior si existe
    }

    var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);
    gradientStroke2.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
    gradientStroke2.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
    gradientStroke2.addColorStop(0, 'rgba(94, 114, 228, 0)');

    window.chart2 = new Chart(ctx2, {
        type: "bar",
        data: {
            labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            datasets: [{
                label: "Cantidad de postulados por mes",
                tension: 0.4,
                borderWidth: 0,
                pointRadius: 0,
                borderColor: "#5e72e4",
                backgroundColor: gradientStroke2,
                borderWidth: 3,
                fill: true,
                data: postulantesData,
                maxBarThickness: 6
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
            scales: {
                y: {
                    grid: {
                        drawBorder: false,
                        display: true,
                        drawOnChartArea: true,
                        drawTicks: false,
                        borderDash: [5, 5]
                    },
                    ticks: {
                        display: true,
                        padding: 10,
                        color: '#fbfbfb',
                        font: {
                            size: 11,
                            family: "Open Sans",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
                x: {
                    grid: {
                        drawBorder: false,
                        display: false,
                        drawOnChartArea: false,
                        drawTicks: false,
                        borderDash: [5, 5]
                    },
                    ticks: {
                        display: true,
                        color: '#ccc',
                        padding: 20,
                        font: {
                            size: 11,
                            family: "Open Sans",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
            },
        },
    });
}