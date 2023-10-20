function limpiar() {
    $(':input').not(':button, :submit, :reset, :hidden')
        .not('#fecha_hora')
        .prop('checked', false)
        .prop('selected', false)
        .not(':checkbox, :radio, select').val('');

    $("select").each(function (index) {
        $(this).val($(`#${this.id} option:first`).val());
    });

    document.getElementById("idsolicitud").focus();
}

function agregar(e) {
    e.preventDefault();
    $("#btnGuardar").prop("disabled", true);
    $("#btnGuardar").text("Agregando...").css("color", "white");

    $("#fecha_hora").prop("disabled", false);
    var formData = new FormData($("#formulario")[0]);
    $("#fecha_hora").prop("disabled", true);

    $.ajax({
        url: "../../../config/ajax/puestos.php?op=agregaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            limpiar();
            Swal.fire({
                icon: 'success',
                title: 'Puesto registrado',
                text: 'El puesto de trabajo fue registrado correctamente, yendo a la página principal...'
            })
            $("#btnGuardar").prop("disabled", false);
            $("#btnGuardar").text("Agregar");

            setTimeout(function () {
                $(location).attr("href", "../../../assets/views/puestos/puestos.php");
            }, 2500);
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
        url: "../../../config/ajax/puestos.php?op=agregaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            limpiar();
            Swal.fire({
                icon: 'success',
                title: 'Puesto actualizado',
                text: 'El puesto de trabajo fue actualizado correctamente.'
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
    const idpuesto = urlParams.get('idpuesto');
    console.log("a mostrar =)")
    // si el "idpuesto" existe y es numérico, hago el POST para mostrar los datos en los form, de lo contrario, no hace nada.
    if (idpuesto && !isNaN(idpuesto)) {
        $("#btnGuardar").prop("disabled", true);
        $("#btnGuardar").text("Cargando...").css("color", "white");

        $.post("../../../config/ajax/puestos.php?op=mostrar", { idpuesto: idpuesto }, function (data, status) {
            data = JSON.parse(data);
            console.log(data);
            if (data != null) {
                $("#idpuesto").val(data.idpuesto);
                $("#idsolicitud").val(data.idsolicitud);
                $("#idusuario").val(data.idusuario);
                $("#titulo").val(data.titulo);
                $("#descripcion").val(data.descripcion);
                $("#ubicacion").val(data.ubicacion);
                $("#horario").val(data.horario);
                $("#empresa").val(data.empresa);
                $("#imagenmuestra").attr("src", "../../../files/" + data.imagen);
                $("#imagenactual").val(data.imagen);
                $("#modalidad").val(data.modalidad);
                $("#area").val(data.area);
                $("#genero").val(data.genero);
                $("#beneficios").val(data.beneficios);
                $("#requisitos").val(data.requisitos);
                $("#ofrendas").val(data.ofrendas);
                $("#conocimientos").val(data.conocimientos);
                $("#fecha_hora").val(data.fecha_hora);
                // $("#estado").val(data.estado);

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
        url: '../../../config/ajax/puestos.php?op=listar',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);

            /* ----------------- PINTAMOS LA DATA =) ----------------- */

            $('.puestos').empty();

            // Primero validamos si hay data. si no hay, mistramos este card.
            if (data.length == 0) {
                var card = `
                    <h6 class="mb-4 fw-bold" style="color: white;">Sin datos por mostrar.</h6>
                `
                $('.puestos').append(card);
            } else {
                var promise = new Promise(function (resolve, reject) {
                    data.forEach(function (puesto, index, array) {
                        // puesto.estado
                        var card = `
                            <div class="col-lg-4 col-md-6 mt-4 mb-4 div-oculto">
                                <div class="col-lg-4 col-md-6 mt-4 mb-4">
                                    <div class="tarjetaGeneral">
                                        <div class="card z-index-2">
                                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                                                <div class="bg-gradient-success shadow-primary border-radius-lg py-3 pe-1" style="background-image: url('../../../files/${puesto.imagen}'); background-size: cover; background-position: center center;">
                                                    <div class="chart">
                                                        <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <h6 class="mb-2 titulo">${capitalizarTodasLasPalabras(puesto.titulo)}</h6>
                                                <div class="row">
                                                    <div class="col-lg-8 d-flex justify-content-start">
                                                        <div><span class="text-sm">Autor: ${capitalizarPalabras(puesto.usuario)}</span><span> | </span><span class="text-sm">${puesto.fecha_hora}</span></div>
                                                    </div>
                                                    <div class="col-lg-4 d-flex justify-content-end">
                                                        <span class="badge badge-sm bg-gradient-${puesto.estado === 'pendiente' ? 'warning' : 'success'}" style="height: 25px">
                                                            ${puesto.estado === 'pendiente' ? 'Pendiente' : 'Publicado'}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="row d-flex flex-column justify-content-center p-0 m-0 pt-3">
                                                    ${puesto.botones}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;

                        $('.puestos').append(card);

                        if (index === array.length - 1) {
                            resolve();
                        }
                    });
                });

                promise.then(function () {
                    $.getScript("../../../config/scripts/paginador4.js");
                    setTimeout(() => {
                        updateColorsPaginator();
                    }, 200);
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

function eliminar(idpuesto, idsolicitud) {
    /* ----------------- Mostramos el modal =) ----------------- */
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn bg-gradient-success swal-confirm-button',
            cancelButton: 'btn bg-gradient-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: '¿Eliminar puesto?',
        html: '¿Estás seguro que deseas eliminar al puesto de trabajo? Recuerda que esta acción es irreversible.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Eliminado',
                'El puesto de trabajo fue eliminado correctamente.',
                'success'
            );

            $(".botones button").prop("disabled", true);
            $(".botones button").css("color", "white");

            $.post("../../../config/ajax/puestos.php?op=eliminar", { idpuesto: idpuesto, idsolicitud: idsolicitud }, function (e) {
                console.log("el servidor responde: " + e)
                /* ----------------- Limpiamos la data y mostramos la carga por defecto =) ----------------- */
                $('.puestos').empty();
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

                $('.puestos').append(row);

                /* ----------------- Y volvemos a listar =) ----------------- */
                listar();
            });
        }
    })
}

function publicar(idpuesto, titulo) {
    /* ----------------- Mostramos el modal =) ----------------- */
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn bg-gradient-success swal-confirm-button',
            cancelButton: 'btn bg-gradient-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: '¿Publicar puesto?',
        html: "¿Estás seguro que deseas publicar al puesto de trabajo <strong> " + titulo + "</strong> en el sitio web?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Publicado',
                'El puesto fue publicado correctamente.',
                'success'
            );
            $(".botones button").prop("disabled", true);
            $(".botones button").css("color", "white");
            $.post("../../../config/ajax/puestos.php?op=publicar", { idpuesto: idpuesto }, function (e) {
                console.log("el servidor responde: " + e)
                /* ----------------- Y volvemos a listar =) ----------------- */
                listar();
            });
        }
    })
}

function remover(idpuesto, titulo) {
    /* ----------------- Mostramos el modal =) ----------------- */
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn bg-gradient-success swal-confirm-button',
            cancelButton: 'btn bg-gradient-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: '¿Remover puesto?',
        html: "¿Estás seguro que deseas remover al puesto de trabajo <strong> " + titulo + "</strong> del sitio web?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Removido',
                'El puesto fue removido correctamente.',
                'success'
            );
            $(".botones button").prop("disabled", true);
            $(".botones button").css("color", "white");
            $.post("../../../config/ajax/puestos.php?op=remover", { idpuesto: idpuesto }, function (e) {
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
    $.post("../../../config/ajax/puestos.php?op=selectSolicitudes", function (r) {
        console.log(r);
        $("#idsolicitud").html(r);
        mostrar();
    });
}

function selectSolicitudesDisponibles() {
    $.post("../../../config/ajax/puestos.php?op=selectSolicitudesDisponibles", function (r) {
        console.log(r);
        $("#idsolicitud").html(r);
    });
}