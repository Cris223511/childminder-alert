function limpiar() {
    $(':input').not(':button, :submit, :reset, :hidden')
        .prop('checked', false)
        .prop('selected', false)
        .not(':checkbox, :radio, select').val('');

    $("select").each(function (index) {
        $(this).val($(`#${this.id} option:first`).val());
    });
    document.getElementById("titulo").focus();
}

function noType() {
    $("#titulo").val("");
}

// Función para generar una cadena aleatoria de longitud especificada
function generarCadenaAleatoria(longitud) {
    const caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let resultado = '';
    for (let i = 0; i < longitud; i++) {
        const indice = Math.floor(Math.random() * caracteres.length);
        resultado += caracteres.charAt(indice);
    }
    return resultado;
}

function vincular() {
    $("#btnBuscar").text("Buscando...");
    $("#btnBuscar").prop("disabled", true);

    setTimeout(() => {
        $('#titulo').removeAttr('oninput');
        $('#titulo').val('CHILDMIND-' + generarCadenaAleatoria(6));
        $('#titulo').prop("disabled", true);
        $("#btnBuscar").addClass("d-none");
        $("#btnVinculado").removeClass("d-none");
        $('#btnGuardar').prop("disabled", false);
    }, 2000);
}

function agregar(e) {
    e.preventDefault();
    $("#btnGuardar").prop("disabled", true);
    $("#btnGuardar").text("Vinculando...").css("color", "white");

    $("#titulo").prop("disabled", false);
    var formData = new FormData($("#formulario")[0]);
    $("#titulo").prop("disabled", true);

    $.ajax({
        url: "../../ajax/dispositivos.php?op=agregaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            limpiar();
            Swal.fire({
                icon: 'success',
                title: 'Dispositivo registrado',
                text: 'El dispositivo fue registrado correctamente, yendo a la página principal...'
            })
            $("#btnGuardar").prop("disabled", false);
            $("#btnGuardar").text("Agregar");

            setTimeout(function () {
                $(location).attr("href", "../../views/dispositivos/dispositivos.php");
            }, 1500);
        }
    });
}

function editar(e) {
    e.preventDefault();
    $("#btnGuardar").prop("disabled", true);
    $("#btnGuardar").text("Cargando...").css("color", "white");

    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../../ajax/dispositivos.php?op=agregaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            limpiar();
            Swal.fire({
                icon: 'success',
                title: 'Dispositivo actualizado',
                text: 'El dispositivo fue actualizado correctamente.'
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
    const iddispositivo = urlParams.get('iddispositivo');
    console.log("a mostrar =)")
    // si el "iddispositivo" existe y es numérico, hago el POST para mostrar los datos en los form, de lo contrario, no hace nada.
    if (iddispositivo && !isNaN(iddispositivo)) {
        $("#btnGuardar").prop("disabled", true);
        $("#btnGuardar").text("Cargando...").css("color", "white");

        $.post("../../ajax/dispositivos.php?op=mostrar", { iddispositivo: iddispositivo }, function (data, status) {
            // console.log(data);
            data = JSON.parse(data);
            console.log(data);
            if (data != null) {
                $("#iddispositivo").val(data.iddispositivo);
                $("#titulo").val(data.titulo);

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
        url: '../../ajax/dispositivos.php?op=listar',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);

            /* ----------------- PINTAMOS LA DATA =) ----------------- */

            $('#myTable tbody').empty();

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

                data.forEach(function (dispositivos) {
                    var row = `
                        <tr>
                            <td>
                                <div class="d-flex px-2 py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <p class="text-xs mb-0 ps-2">${capitalizarPalabras(dispositivos.usuario)}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle text-sm">
                                <p class="text-xs mb-0">${dispositivos.titulo}</p>
                            </td>
                            <td>
                                <p class="text-xs mb-0">${dispositivos.fecha_hora}</p>
                            </td>
                            <td class="align-middle text-sm text-center">
                                <span class="badge badge-sm bg-gradient-${dispositivos.estado === 'activado' ? 'success' : 'danger'}">
                                    ${dispositivos.estado === 'activado' ? 'Activado' : 'Desactivado'}
                                </span>
                            </td>
                            <td class="align-middle">
                                <div class="row d-flex flex-column justify-content-center p-0 m-0 botones">
                                    ${dispositivos.botones}
                                </div>
                            </td>
                        </tr>
                    `;

                    $('#myTable tbody').append(row);
                });
            }
            $(".botones button").prop("disabled", false);
            $(".botones button").css("color", "white");
        },
        error: function (xhr, status, error) {
            console.log(error);
        }
    });
}

function eliminar(iddispositivo, titulo) {
    /* ----------------- Mostramos el modal =) ----------------- */
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn bg-gradient-success swal-confirm-button',
            cancelButton: 'btn bg-gradient-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: '¿Eliminar dispositivo?',
        html: '¿Estás seguro que deseas eliminar al dispositivo <strong>' + titulo + '</strong>? Recuerda que esta acción es irreversible.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Eliminado',
                'El dispositivo fue eliminado correctamente.',
                'success'
            );

            $(".botones button").prop("disabled", true);
            $(".botones button").css("color", "white");

            $.post("../../ajax/dispositivos.php?op=eliminar", { iddispositivo: iddispositivo }, function (e) {
                console.log("el servidor responde: " + e)
                /* ----------------- Y volvemos a listar =) ----------------- */
                listar();
            });
        }
    })
}

function activar(iddispositivo, nombre) {
    /* ----------------- Mostramos el modal =) ----------------- */
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn bg-gradient-success swal-confirm-button',
            cancelButton: 'btn bg-gradient-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Activar dispositivo',
        html: "¿Estás seguro que deseas activar al dispositivo <strong> " + nombre + "</strong>?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Activado.',
                'El dispositivo fue activado correctamente.',
                'success'
            );
            $(".botones button").prop("disabled", true);
            $(".botones button").css("color", "white");
            $.post("../../ajax/dispositivos.php?op=activar", { iddispositivo: iddispositivo }, function (e) {
                console.log("el servidor responde: " + e)
                /* ----------------- Y volvemos a listar =) ----------------- */
                listar();
            });
        }
    })
}

function desactivar(iddispositivo, nombre) { 
    /* ----------------- Mostramos el modal =) ----------------- */
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn bg-gradient-success swal-confirm-button',
            cancelButton: 'btn bg-gradient-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Desactivar dispositivo',
        html: "¿Estás seguro que deseas desactivar al dispositivo <strong> " + nombre + "</strong>?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Desactivado.',
                'El dispositivo fue desactivado correctamente.',
                'success'
            );
            $(".botones button").prop("disabled", true);
            $(".botones button").css("color", "white");
            $.post("../../ajax/dispositivos.php?op=desactivar", { iddispositivo: iddispositivo }, function (e) {
                console.log("el servidor responde: " + e)
                /* ----------------- Y volvemos a listar =) ----------------- */
                listar();
            });
        }
    })
}