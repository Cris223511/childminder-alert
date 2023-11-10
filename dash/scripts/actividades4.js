function limpiar() {
    $(':input').not(':button, :submit, :reset, :hidden')
        .not('#fecha_hora')
        .prop('checked', false)
        .prop('selected', false)
        .not(':checkbox, :radio, select').val('');

    $("select").each(function (index) {
        $(this).val($(`#${this.id} option:first`).val());
    });
    document.getElementById("titulo").focus();
}

function agregar(e) {
    e.preventDefault();
    $("#btnGuardar").prop("disabled", true);
    $("#btnGuardar").text("Agregando...").css("color", "white");

    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../../ajax/actividades.php?op=agregaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            limpiar();
            Swal.fire({
                icon: 'success',
                title: 'Actividad registrada',
                text: 'La actividad fue registrada correctamente, yendo a la página principal...'
            })
            $("#btnGuardar").prop("disabled", false);
            $("#btnGuardar").text("Agregar");

            setTimeout(function () {
                $(location).attr("href", "../../views/actividades/actividades.php");
            }, 1500);
        }
    });
}

function editar(e) {
    e.preventDefault();
    $("#btnGuardar").prop("disabled", true);
    $("#btnGuardar").text("Cargando...").css("color", "white");

    $("#fecha_hora").prop("disabled", false);
    var formData = new FormData($("#formulario")[0]);
    $("#fecha_hora").prop("disabled", true);

    $.ajax({
        url: "../../ajax/actividades.php?op=agregaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            limpiar();
            Swal.fire({
                icon: 'success',
                title: 'Actividad actualizada',
                text: 'La actividad fue actualizada correctamente.'
            })
            $("#btnGuardar").prop("disabled", false);
            $("#btnGuardar").text("Editar");
            mostrar();
        }
    });
}

function mostrar() {
    // Intentamos recoger el id de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const idactividad = urlParams.get('idactividad');
    console.log("a mostrar =)")
    // si el "idactividad" existe y es numérico, hago el POST para mostrar los datos en los form, de lo contrario, no hace nada.
    if (idactividad && !isNaN(idactividad)) {
        $("#btnGuardar").prop("disabled", true);
        $("#btnGuardar").text("Cargando...").css("color", "white");

        $.post("../../ajax/actividades.php?op=mostrar", { idactividad: idactividad }, function (data, status) {
            // console.log(data);
            data = JSON.parse(data);
            console.log(data);
            if (data != null) {
                $("#idactividad").val(data.idactividad);
                $("#titulo").val(data.titulo);
                $("#descripcion").val(data.descripcion);
                $("#empresa").val(data.empresa);
                $("#imagenmuestra").attr("src", "../../files/" + data.imagen);
                $("#imagenactual").val(data.imagen);
                $("#fecha_hora").val(data.fecha_hora);

                $("#btnGuardar").prop("disabled", false);
                $("#btnGuardar").text("Editar");
            } else {
                $("#btnGuardar").prop("disabled", true);
                $("#btnGuardar").text("Editar");
            }
        });
    } else {
        console.log("no hago nada =).")
        $("#btnGuardar").prop("disabled", true);
        $("#btnGuardar").text("Editar");
    }
}

function listar() {
    $.ajax({
        url: '../../ajax/actividades.php?op=listar',
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
                var promise = new Promise(function (resolve, reject) {
                    data.forEach(function (actividad, index, array) {
                        var card = `
                            <div class="col-lg-4 col-md-6 mt-4 mb-4">
                                <div class="tarjetaGeneral">
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
                                                        ${actividad.estado === 'pendiente' ? 'Pendiente' : 'Finalizado'}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row d-flex flex-column justify-content-center p-0 m-0 pt-3">
                                                ${actividad.botones}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;

                        $('.actividades').append(card);

                        if (index === array.length - 1) {
                            resolve();
                        }
                    });
                });
            };

            $(".botones button").prop("disabled", false);
            $(".botones button").css("color", "white");
        },
        error: function (xhr, status, error) {
            console.log(error);
        }
    });
}

function eliminar(idactividad, idsolicitud) {
    /* ----------------- Mostramos el modal =) ----------------- */
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn bg-gradient-success swal-confirm-button',
            cancelButton: 'btn bg-gradient-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: '¿Eliminar actividad?',
        html: '¿Estás seguro que deseas eliminar a la actividad? Recuerda que esta acción es irreversible.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Eliminado',
                'La actividad fue eliminada correctamente.',
                'success'
            );

            $(".botones button").prop("disabled", true);
            $(".botones button").css("color", "white");

            $.post("../../ajax/actividades.php?op=eliminar", { idactividad: idactividad, idsolicitud: idsolicitud }, function (e) {
                console.log("el servidor responde: " + e)
                /* ----------------- Limpiamos la data y mostramos la carga por defecto =) ----------------- */
                $('.actividades').empty();
                var row = `
                    <div class="col-lg-4 col-md-6">
                        <span class="w-100 card loader"></span>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <span class="w-100 card loader"></span>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <span class="w-100 card loader"></span>
                    </div>
                `;

                $('.actividades').append(row);

                /* ----------------- Y volvemos a listar =) ----------------- */
                listar();
            });
        }
    })
}

function finalizar(idactividad, titulo) {
    /* ----------------- Mostramos el modal =) ----------------- */
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn bg-gradient-success swal-confirm-button',
            cancelButton: 'btn bg-gradient-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: '¿Finalizar actividad?',
        html: "¿Estás seguro que deseas finalizar a la actividad <strong> " + titulo + "</strong>?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Finalizado',
                'La actividad fue finalizada correctamente.',
                'success'
            );
            $(".botones button").prop("disabled", true);
            $(".botones button").css("color", "white");
            $.post("../../ajax/actividades.php?op=finalizar", { idactividad: idactividad }, function (e) {
                console.log("el servidor responde: " + e)
                /* ----------------- Y volvemos a listar =) ----------------- */
                listar();
            });
        }
    })
}

function activar(idactividad, titulo) {
    /* ----------------- Mostramos el modal =) ----------------- */
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn bg-gradient-success swal-confirm-button',
            cancelButton: 'btn bg-gradient-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: '¿Activar actividad?',
        html: "¿Estás seguro que deseas activar a la actividad <strong> " + titulo + "</strong>?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Activado',
                'La actividad fue activada correctamente.',
                'success'
            );
            $(".botones button").prop("disabled", true);
            $(".botones button").css("color", "white");
            $.post("../../ajax/actividades.php?op=activar", { idactividad: idactividad }, function (e) {
                console.log("el servidor responde: " + e)
                /* ----------------- Y volvemos a listar =) ----------------- */
                listar();
            });
        }
    })
}

function selectSolicitudesEditDetails() {
    $("#btnGuardar").prop("disabled", true);
    $("#btnGuardar").text("Cargando...").css("color", "white");
    $.post("../../ajax/actividades.php?op=selectSolicitudes", function (r) {
        console.log(r);
        $("#idsolicitud").html(r);
        mostrar();
    });
}

function selectSolicitudesDisponibles() {
    $.post("../../ajax/actividades.php?op=selectSolicitudesDisponibles", function (r) {
        console.log(r);
        $("#idsolicitud").html(r);
    });
}