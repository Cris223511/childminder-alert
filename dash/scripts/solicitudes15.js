function limpiar() {
    $(':input').not(':button, :submit, :reset, :hidden')
        .not('#fecha_hora')
        .prop('checked', false)
        .prop('selected', false)
        .not(':checkbox, :radio, select').val('');

    $("select").each(function (index) {
        $(this).val($(`#${this.id} option:first`).val());
    });

    document.getElementById("idtienda").focus();
}

function selectTiendasEditDetails() {
    $("#btnGuardar").prop("disabled", true);
    $("#btnGuardar").text("Cargando...").css("color", "white");
    $.post("../../../config/ajax/solicitudes.php?op=selectTiendas", function (r) {
        console.log(r);
        $("#idtienda").html(r);
        mostrar();
    });
}

function selectTiendas() {
    $.post("../../../config/ajax/solicitudes.php?op=selectTiendas", function (r) {
        console.log(r);
        $("#idtienda").html(r);
    });
}

function agregar(e) {
    e.preventDefault();
    $("#btnGuardar").prop("disabled", true);
    $("#btnGuardar").text("Agregando...").css("color", "white");

    $("#fecha_hora").prop("disabled", false);
    var formData = new FormData($("#formulario")[0]);
    $("#fecha_hora").prop("disabled", true);

    $.ajax({
        url: "../../../config/ajax/solicitudes.php?op=agregaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            limpiar();
            Swal.fire({
                icon: 'success',
                title: 'Solicitud registrada',
                text: 'La solicitud fue registrada correctamente, yendo a la página principal...'
            })
            $("#btnGuardar").prop("disabled", false);
            $("#btnGuardar").text("Agregar");

            setTimeout(function () {
                $(location).attr("href", "../../../assets/views/solicitudes/solicitudes.php");
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
        url: "../../../config/ajax/solicitudes.php?op=agregaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            limpiar();
            Swal.fire({
                icon: 'success',
                title: 'Solicitud actualizada',
                text: 'La solicitud fue actualizada correctamente.'
            })
            $("#btnGuardar").prop("disabled", false);
            $("#btnGuardar").text("Enviar");
            mostrar();
        }
    });
}

function mostrar() {
    // Intentamos recoger el id de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const idsolicitud = urlParams.get('idsolicitud');

    // si el "idsolicitud" existe y es numérico, hago el POST para mostrar los datos en los form, de lo contrario, no hace nada.
    if (idsolicitud && !isNaN(idsolicitud)) {
        $.post("../../../config/ajax/solicitudes.php?op=mostrar", { idsolicitud: idsolicitud }, function (data, status) {
            data = JSON.parse(data);
            console.log(data);
            if (data != null) {
                $("#idsolicitud").val(data.idsolicitud);
                $("#idtienda").val(data.idtienda);
                $("#puesto").val(data.puesto);
                $("#cant_vacantes").val(data.cant_vacantes);
                $("#salario_neto").val(data.salario_neto);
                $("#tiempo_contrato").val(data.tiempo_contrato);
                $("#fecha_hora").val(data.fecha_hora);
                $("#motivo").val(data.motivo);

                if (data.comentario != "")
                    $("#comentario").val(data.comentario);
                else
                    $("#comentario").val("Aún no hay comentarios por mostrar.");

                $("#btnGuardar").prop("disabled", false);
                $("#btnGuardar").text("Enviar");
            } else {
                $("#btnGuardar").prop("disabled", true);
                $("#btnGuardar").text("Enviar");
            }
        });
    } else {
        console.log("no hago nada =).")
        $("#btnGuardar").prop("disabled", true);
        $("#btnGuardar").text("Enviar");
    }
}

function listar() {
    $.ajax({
        url: '../../../config/ajax/solicitudes.php?op=listar',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);

            /* ----------------- PINTAMOS LA DATA =) ----------------- */

            $('#myTable tbody').empty();
            // Primero validamos si hay data. si no hay, mistramos esta fila.

            if (data.length == 0) {
                var row = `
                    <tr>
                        <td colspan="16" class="align-middle text-sm text-center pt-3">
                            Sin datos por mostrar.
                        </td>
                    </tr>
                `
                $('#myTable tbody').append(row);
            } else {
                data.forEach(function (solicitud) {
                    var row = `
                        <tr>
                            <td>
                                <div class="d-flex px-2 py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <p class="text-xs  mb-0 ps-2">${solicitud.tienda}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="text-xs mb-0">${capitalizarPalabras(solicitud.usuario)}</p>
                            </td>
                            <td>
                                <p class="text-xs mb-0">${capitalizarPalabras(solicitud.puesto)}</p>
                            </td>
                            <td>
                                <p class="text-xs mb-0">${solicitud.cant_vacantes} vacantes</p>
                            </td>
                            <td>
                                <p class="text-xs mb-0">${solicitud.salario_neto} S/.</p>
                            </td>
                            <td>
                                <p class="text-xs mb-0">${solicitud.tiempo_contrato}</p>
                            </td>
                            <td>
                                <p class="text-xs mb-0">${solicitud.fecha_hora}</p>
                            </td>
                            <td class="align-middle text-sm text-center">
                                <span class="badge badge-sm bg-gradient-${solicitud.estado === 'pendiente' ? 'warning' : (solicitud.estado === 'aceptado' ? 'success' : 'danger')}">
                                    ${solicitud.estado === 'pendiente' ? 'Pendiente' : (solicitud.estado === 'aceptado' ? 'Aceptado' : 'Rechazado')}
                                </span>
                            </td>
                            <td class="align-middle text-sm">${solicitud.botones}</td>
                        </tr>
                    `;

                    $('#myTable tbody').append(row);
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

function eliminar(idsolicitud) {
    /* ----------------- Mostramos el modal =) ----------------- */
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn bg-gradient-success swal-confirm-button',
            cancelButton: 'btn bg-gradient-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: '¿Eliminar solicitud?',
        html: '¿Estás seguro que deseas eliminar a la solicitud? Recuerda que esta acción es irreversible.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Eliminado.',
                'La solicitud fue eliminada correctamente.',
                'success'
            );
            $(".botones button").prop("disabled", true);
            $(".botones button").css("color", "white");
            $.post("../../../config/ajax/solicitudes.php?op=eliminar", { idsolicitud: idsolicitud }, function (e) {
                console.log("el servidor responde: " + e)
                /* ----------------- Y volvemos a listar =) ----------------- */
                listar();
            });
        }
    })
}

function aceptarSolicitud(idsolicitud) {
    /* ----------------- Mostramos el modal =) ----------------- */
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn bg-gradient-success swal-confirm-button',
            cancelButton: 'btn bg-gradient-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Aceptar solicitud',
        text: "¿Estás seguro que deseas aceptar a la solicitud?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Aceptado.',
                'La solicitud fue aceptada correctamente.',
                'success'
            );
            $(".botones button").prop("disabled", true);
            $(".botones button").css("color", "white");
            $.post("../../../config/ajax/solicitudes.php?op=aceptar", { idsolicitud: idsolicitud }, function (e) {
                console.log("el servidor responde: " + e)
                /* ----------------- Y volvemos a listar =) ----------------- */
                listar();
            });
        }
    })
}

function rechazarSolicitud(idsolicitud) {
    /* ----------------- Mostramos el modal =) ----------------- */
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn bg-gradient-success swal-confirm-button',
            cancelButton: 'btn bg-gradient-danger'
        },
        buttonsStyling: false,
        willOpen: () => {
            // Agregamos la clase 'swal2-actions' al abrir el modal
            $('.swal2-actions').addClass('swal2-actions-custom');
        },
        willClose: () => {
            // Eliminamos la clase 'swal2-actions' al cerrar el modal
            $('.swal2-actions').removeClass('swal2-actions-custom');
        }
    })

    swalWithBootstrapButtons.fire({
        title: 'Rechazar solicitud',
        html: `
            <form id="rechazarForm">
                <div class="form-group">
                    <label for="titulo">Comentarios:</label>
                    <textarea class="swal-input form-control" name="comentario" id="comentario" rows="5" maxlength="500" placeholder="Ingrese un comentario sobre el rechazo de la solicitud." required></textarea>
                </div>
            </form>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Rechazar',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            const form = document.getElementById('rechazarForm');
            if (!form.reportValidity()) {
                return false;
            }
            return true;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const comentario = $('#comentario').val();

            Swal.fire(
                'Rechazado.',
                'La solicitud fue rechazada correctamente.',
                'success'
            );
            $(".botones button").prop("disabled", true);
            $(".botones button").css("color", "white");
            $.post("../../../config/ajax/solicitudes.php?op=rechazar", { idsolicitud: idsolicitud, comentario: comentario }, function (e) {
                console.log("el servidor responde: " + e)
                /* ----------------- Y volvemos a listar =) ----------------- */
                listar();
            });
        }
    })
    document.getElementById("comentario").focus();
}

function verComentario(idsolicitud) {
    /* ----------------- Mostramos el modal =) ----------------- */
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn bg-gradient-success swal-confirm-button',
            cancelButton: 'btn bg-gradient-danger'
        },
        buttonsStyling: false,
        willOpen: () => {
            // Agregamos la clase 'swal2-actions' al abrir el modal
            $('.swal2-actions').addClass('swal2-actions-custom');
        },
        willClose: () => {
            // Eliminamos la clase 'swal2-actions' al cerrar el modal
            $('.swal2-actions').removeClass('swal2-actions-custom');
        }
    });

    swalWithBootstrapButtons.fire({
        title: 'Detalles del comentario',
        html: `
            <div class="form-group">
                <label for="titulo">Comentarios por parte de RRHH:</label>
                <textarea class="swal-input form-control" name="comentario" id="comentario" rows="5" maxlength="500" placeholder="Cargando..." disabled></textarea>
            </div>
        `,
        confirmButtonText: 'Aceptar',
    });

    $.post("../../../config/ajax/solicitudes.php?op=verComentario", { idsolicitud: idsolicitud }, function (data, status) {
        data = JSON.parse(data);
        console.log(data);
        $("#comentario").val(data.comentario);
    });
}
