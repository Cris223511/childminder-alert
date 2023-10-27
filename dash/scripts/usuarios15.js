function limpiar() {
    $(':input').not(':button, :submit, :reset, :hidden')
        .not('#fecha_hora')
        .prop('checked', false)
        .prop('selected', false)
        .not(':checkbox, :radio, select').val('');

    $("select").each(function (index) {
        $(this).val($(`#${this.id} option:first`).val());
    });

    document.getElementById("nombres").focus();
}

function agregar(e) {
    e.preventDefault();
    $("#btnGuardar").prop("disabled", true);
    $("#btnGuardar").text("Agregando...").css("color", "white");
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../../ajax/usuarios.php?op=agregaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            limpiar();
            Swal.fire({
                icon: 'success',
                title: 'Usuario registrado',
                text: 'El usuario fue registrado correctamente, yendo a la página principal...'
            })
            $("#btnGuardar").prop("disabled", false);
            $("#btnGuardar").text("Agregar");

            setTimeout(function () {
                $(location).attr("href", "../../views/usuarios/usuarios.php");
            }, 2500);
        }
    });
}

function editar(e) {
    e.preventDefault();
    $("#btnGuardar").prop("disabled", true);
    $("#btnGuardar").text("Cargando...").css("color", "white");
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../../ajax/usuarios.php?op=agregaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            limpiar();
            Swal.fire({
                icon: 'success',
                title: 'Usuario actualizado',
                text: 'El usuario fue actualizado correctamente.'
            })
            $("#btnGuardar").prop("disabled", false);
            $("#btnGuardar").text("Editar");
            mostrar();
        }
    });
}

function editarRol(e) {
    e.preventDefault();
    $("#btnGuardar").prop("disabled", true);
    $("#btnGuardar").text("Guardando...").css("color", "white");
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../../ajax/usuarios.php?op=editarRol",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            limpiar();
            Swal.fire({
                icon: 'success',
                title: 'Rol actualizado',
                text: 'El rol del usuario fue actualizado correctamente.'
            })
            $("#btnGuardar").prop("disabled", false);
            $("#btnGuardar").text("Asignar");
            mostrar();
        }
    });
}

function mostrar() {
    // Intentamos recoger el id de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const idusuario = urlParams.get('idusuario');

    // si el "idusuario" existe y es numérico, hago el POST para mostrar los datos en los form, de lo contrario, no hace nada.
    if (idusuario && !isNaN(idusuario)) {
        $("#btnGuardar").prop("disabled", true);
        $("#btnGuardar").text("Cargando...").css("color", "white");

        $.post("../../ajax/usuarios.php?op=mostrar", { idusuario: idusuario }, function (data, status) {
            data = JSON.parse(data);
            console.log(data);
            if (data != null) {
                $("#idusuario").val(data.idusuario);
                $("#nombres").val(data.nombres);
                $("#apellidos").val(data.apellidos);
                $("#rol").val(data.rol);
                $("#usuario").val(data.usuario);
                $("#clave").val(data.clave);
                $("#email").val(data.email);
                $("#imagenmuestra").attr("src", "../../files/" + data.imagen);
                $("#imagenactual").val(data.imagen);
                $("#fecha_nac").val(data.fecha_nac);
                $("#tipo_documento").val(data.tipo_documento);
                $("#tipo_documento").trigger("change");
                $("#num_documento").val(data.num_documento);
                $("#telefono").val(data.telefono);
                $("#direccion").val(data.direccion);
                $("#descripcion").val(data.descripcion);

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
        url: '../../ajax/usuarios.php?op=listar',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);

            /* ----------------- PINTAMOS LA DATA =) ----------------- */

            $('#myTable tbody').empty();
            data.forEach(function (usuario) {
                var row = `
                    <tr>
                        <td>
                            <div class="d-flex px-2 py-1">
                                <div class="d-flex flex-column justify-content-center">
                                    <p class="text-xs mb-0 ps-2">${capitalizarPalabras(usuario.nombres)}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <p class="text-xs mb-0">${capitalizarPalabras(usuario.apellidos)}</p>
                        </td>
                        <td class="align-middle text-sm">
                            <p class="text-xs mb-0">${usuario.usuario}</p>
                        </td>
                        <td>
                            <p class="text-xs mb-0">${usuario.tipo_documento}</p>
                        </td>
                        <td>
                            <p class="text-xs mb-0">${usuario.num_documento}</p>
                        </td>
                        <td>
                            <p class="text-xs mb-0">${usuario.telefono.match(/.{1,3}/g).join(' ')}</p>
                        </td>
                        <td>
                            <p class="text-xs mb-0">${usuario.fecha_nac}</p>
                        </td>
                        <td>
                            <p class="text-xs mb-0">${usuario.email}</p>
                        </td>
                        <td class="align-middle text-sm">
                            <p class="text-xs mb-0">${usuario.rol}</p>
                        </td>
                        <td class="align-middle text-sm text-center">
                            <span class="badge badge-sm bg-gradient-${usuario.estado === '1' ? 'success' : 'danger'}">
                                ${usuario.estado === '1' ? 'En línea' : 'Desconectado'}
                            </span>
                        </td>
                        <td class="text-xs text-center mb-0">
                            <img src="../../files/${usuario.imagen}" width="50px" height="50px" style="border-radius: 50%;" />
                        </td>
                        <td class="align-middle">
                            <div class="row d-flex flex-column justify-content-center p-0 m-0 botones">
                                <div class="d-flex justify-content-center p-0 m-0">
                                    <button onclick="window.location.href='usuarios-edit.php?idusuario=${usuario.idusuario}'" class="btn bg-gradient-warning col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                        Editar
                                    </button>
                                    <button onclick="window.location.href='usuarios-detail.php?idusuario=${usuario.idusuario}'" class="btn bg-gradient-primary col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                        Detalles
                                    </button>
                                </div>
                                <div class="d-flex justify-content-center p-0 m-0">
                                    <button onclick="eliminar('${usuario.idusuario}', '${usuario.nombres}')" id="btnEliminar" class="btn bg-gradient-danger col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px; cursor: pointer;">
                                        Eliminar
                                    </button>
                                    <button onclick="window.location.href='usuarios-rol-edit.php?idusuario=${usuario.idusuario}'" class="btn bg-gradient-success col-6 boton text-center p-0 pt-1 pb-1 m-1 align-items-center" style="font-size: 13px; width: 100px;">
                                        Asignar
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                `;

                $('#myTable tbody').append(row);
            });
        },
        error: function (xhr, status, error) {
            console.log(error);
        }
    });
}

function eliminar(idusuario, nombres) {
    /* ----------------- Mostramos el modal =) ----------------- */
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn bg-gradient-success swal-confirm-button',
            cancelButton: 'btn bg-gradient-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: '¿Eliminar usuario?',
        html: '¿Estás seguro que deseas eliminar al usuario <strong>' + nombres + '</strong>? Recuerda que esta acción es irreversible.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Eliminado.',
                'El usuario fue eliminado correctamente.',
                'success'
            );

            $(".botones button").prop("disabled", true);
            $(".botones button").css("color", "white");

            $.post("../../ajax/usuarios.php?op=eliminar", { idusuario: idusuario }, function (e) {
                console.log("el servidor responde: " + e)
                /* ----------------- Limpiamos la data y agregamos la fila por defecto =) ----------------- */
                $('#myTable tbody').empty();
                var row = `
                    <tr>
                        <td colspan="16" class="align-middle text-sm text-center pt-3">
                            Cargando datos...
                        </td>
                    </tr>
                `;

                $('#myTable tbody').append(row);

                /* ----------------- Y volvemos a listar =) ----------------- */
                listar();
            });
        }
    })
}