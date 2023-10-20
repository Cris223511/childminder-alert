function limpiar() {
    $(':input').not(':button, :submit, :reset, :hidden')
        .not('#fecha_hora')
        .prop('checked', false)
        .prop('selected', false)
        .not(':checkbox, :radio, select').val('');

    $("select").each(function (index) {
        $(this).val($(`#${this.id} option:first`).val());
    });

    document.getElementById("nombre").focus();
}

function agregar(e) {
    e.preventDefault();
    $("#btnGuardar").prop("disabled", true);
    $("#btnGuardar").text("Agregando...").css("color", "white");

    $("#fecha_hora").prop("disabled", false);
    var formData = new FormData($("#formulario")[0]);
    $("#fecha_hora").prop("disabled", true);

    $.ajax({
        url: "../../../config/ajax/tiendas.php?op=agregaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            limpiar();
            Swal.fire({
                icon: 'success',
                title: 'Tienda registrada',
                text: 'La tienda fue registrada correctamente, yendo a la página principal...'
            })
            $("#btnGuardar").prop("disabled", false);
            $("#btnGuardar").text("Agregar");

            setTimeout(function () {
                $(location).attr("href", "../../../assets/views/tiendas/tiendas.php");
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
        url: "../../../config/ajax/tiendas.php?op=agregaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            limpiar();
            Swal.fire({
                icon: 'success',
                title: 'Tienda actualizada',
                text: 'La tienda fue actualizada correctamente.'
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
    const idtienda = urlParams.get('idtienda');

    // si el "idtienda" existe y es numérico, hago el POST para mostrar los datos en los form, de lo contrario, no hace nada.
    if (idtienda && !isNaN(idtienda)) {
        $("#btnGuardar").prop("disabled", true);
        $("#btnGuardar").text("Cargando...").css("color", "white");

        $.post("../../../config/ajax/tiendas.php?op=mostrar", { idtienda: idtienda }, function (data, status) {
            data = JSON.parse(data);
            console.log(data);
            if (data != null) {
                $("#idtienda").val(data.idtienda);
                $("#nombre").val(data.nombre);
                $("#direccion").val(data.direccion);
                $("#telefono").val(data.telefono);
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
        url: '../../../config/ajax/tiendas.php?op=listar',
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
                data.forEach(function (tienda) {
                    var row = `
                        <tr>
                            <td>
                                <div class="d-flex px-2 py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <p class="text-xs  mb-0 ps-2">${tienda.nombre}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="text-xs mb-0">${capitalizarPalabras(tienda.usuario)}</p>
                            </td>
                            <td>
                                <p class="text-xs mb-0">${tienda.direccion}</p>
                            </td>
                            <td>
                                <p class="text-xs mb-0">${tienda.telefono}</p>
                            </td>
                            <td>
                                <p class="text-xs mb-0">${tienda.fecha_hora}</p>
                            </td>
                            <td class="align-middle text-sm text-center">
                                <span class="badge badge-sm bg-gradient-${tienda.estado === 'activado' ? 'success' : 'danger'}">
                                ${tienda.estado === 'activado' ? 'Activado' : 'Desactivado'}
                                </span>
                            </td>
                            <td class="align-middle text-sm">${tienda.botones}</td>
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

function activar(idtienda, nombre) {
    /* ----------------- Mostramos el modal =) ----------------- */
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn bg-gradient-success swal-confirm-button',
            cancelButton: 'btn bg-gradient-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Activar tienda',
        html: "¿Estás seguro que deseas activar a la tienda <strong> " + nombre + "</strong>?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Activado.',
                'La tienda fue activado correctamente.',
                'success'
            );
            $(".botones button").prop("disabled", true);
            $(".botones button").css("color", "white");
            $.post("../../../config/ajax/tiendas.php?op=activar", { idtienda: idtienda }, function (e) {
                console.log("el servidor responde: " + e)
                /* ----------------- Y volvemos a listar =) ----------------- */
                listar();
            });
        }
    })
}

function desactivar(idtienda, nombre) {
    /* ----------------- Mostramos el modal =) ----------------- */
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn bg-gradient-success swal-confirm-button',
            cancelButton: 'btn bg-gradient-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Desactivar tienda',
        html: "¿Estás seguro que deseas desactivar a la tienda <strong> " + nombre + "</strong>?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Desactivado.',
                'La tienda fue desactivado correctamente.',
                'success'
            );
            $(".botones button").prop("disabled", true);
            $(".botones button").css("color", "white");
            $.post("../../../config/ajax/tiendas.php?op=desactivar", { idtienda: idtienda }, function (e) {
                console.log("el servidor responde: " + e)
                /* ----------------- Y volvemos a listar =) ----------------- */
                listar();
            });
        }
    })
}