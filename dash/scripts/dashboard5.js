function listarActividades() {
    $.ajax({
        url: '../../ajax/actividades.php?op=listarDashboard',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);

            /* ----------------- PINTAMOS LA DATA =) ----------------- */

            $('.actividades').empty();

            // Primero validamos si hay data. si no hay, mistramos este card.
            if (data.length == 0) {
                var card = `
                    <h6 class="mb-4 fw-bold" style="color: white;">Sin datos por mostrar.</h6>
                `
                $('.actividades').append(card);
            } else {
                data.forEach(function (actividad) {
                    // actividad.estado
                    var card = `
                        <div class="col-lg-4 col-md-6 mt-4 mb-4 tarjetaGeneral">
                            <div class="card z-index-2">
                                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                                    <div class="bg-gradient-success shadow-primary border-radius-lg py-3 pe-1" style="background-image: url('../../files/${actividad.imagen}'); background-size: cover; background-position: center center;">
                                        <div class="chart">
                                            <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h6 class="mb-2 titulo">${capitalizarTodasLasPalabras(actividad.titulo)}</h6>
                                    <div class="row">
                                        <div class="col-lg-8 d-flex justify-content-start">
                                            <div><span class="text-sm">Autor: ${capitalizarPalabras(actividad.usuario)}</span><span> | </span><span class="text-sm">${actividad.fecha_hora}</span></div>
                                        </div>
                                        <div class="col-lg-4 d-flex justify-content-end">
                                            <span class="badge badge-sm bg-gradient-${actividad.estado === 'pendiente' ? 'warning' : 'success'}" style="height: 25px">
                                                ${actividad.estado === 'pendiente' ? 'Pendiente' : 'Publicado'}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row d-flex flex-column justify-content-center p-0 m-0 pt-3">
                                        ${actividad.botones}
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    $('.actividades').append(card);
                });
            };
        },
        error: function (xhr, status, error) {
            console.log(error);
        }
    });
}

function listarTabla() {
    $.ajax({
        url: '../../ajax/dispositivos.php?op=listarTabla',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);

            /* ----------------- PINTAMOS LA DATA =) ----------------- */

            $('#myTable tbody').empty();

            // Pintamos la cabecera dinámica

            // Primero validamos si hay data. si no hay, mostramos este texto.
            if (data.length == 0) {
                $('.loading-data').empty().append('Sin datos por mostrar.');
                $('#myTable thead').empty();
            } else {
                $('.card-header').removeClass('pt-4');
                $('.table-responsive').before('<hr class="horizontal dark my-1 mb-0">');
                $('.loading-data').empty().append("Dispositivos vinculados");
                data.forEach(function (dispositivos) {
                    var row = `
                        <tr>
                            ${dispositivos.filas}
                        </tr>
                    `;

                    $('#myTable tbody').append(row);
                });
            };
        },
        error: function (xhr, status, error) {
            console.log(error);
        }
    });
}