$(".cargando-datos").addClass("d-block");
$(".datos-personales").addClass("d-none");

function init() {
    llenarFormulario();
    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    });
    document.getElementById("nombres").focus();
}

function llenarFormulario() {
    $("#btnGuardar").prop("disabled", true);
    $("#btnGuardar").text("Cargando...").css("color", "white");
    $.ajax({
        url: '../../../config/ajax/perfil.php?op=listar',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $(".cargando-datos").removeClass("d-block");
            $(".datos-personales").removeClass("d-none");
            $(".cargando-datos").addClass("d-none");
            $(".datos-personales").addClass("d-block");

            // INPUTS
            $("#nombres").val(data.nombres);
            $("#apellidos").val(data.apellidos);
            $("#rol").val(data.rol === "admin" ? "Administrador" : (data.rol === "jefe_tienda" ? "Jefe de Tiendas" : (data.rol === "jefe_rrhh" ? "Jefe de RRHH" : "")));
            $("#usuario").val(data.usuario);
            $("#email").val(data.email);
            $("#imagenmuestra").attr("src", "../../../files/" + data.imagen);
            $("#imagenactual").val(data.imagen);
            $("#fecha_nac").val(data.fecha_nac);
            $("#tipo_documento").val(data.tipo_documento);
            $("#tipo_documento").trigger("change");
            $("#num_documento").val(data.num_documento);
            $("#telefono").val(data.telefono);
            $("#direccion").val(data.direccion);
            $("#descripcion").val(data.descripcion);

            $("#btnGuardar").prop("disabled", false);
            $("#btnGuardar").text("Guardar cambios");

            // TARJETA
            $(".nombres").text(capitalizarPalabras(data.nombres));
            $(".apellidos").text(capitalizarPalabras(data.apellidos));
            $(".telefono").text(data.telefono.match(/.{1,3}/g).join(' '));
            $(".direccion").text(data.direccion);
            $(".descripcion").text(data.descripcion);
            $(".num_documento").text(data.num_documento);
            $(".tipo_documento").text(data.tipo_documento);

            let fecha = data.fecha_nac;
            let fecha_iso = fecha.split('-').reverse().join('/');
            $(".fecha_nac").text(fecha_iso);
        },
        error: function (xhr, status, error) {
            console.log(error);
        }
    });
}

function guardaryeditar(e) {
    e.preventDefault();
    $("#btnGuardar").prop("disabled", true);
    $("#btnGuardar").text("Guardando...").css("color", "white");
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../../../config/ajax/perfil.php?op=editar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            Swal.fire({
                icon: 'success',
                title: 'Datos actualizados',
                text: 'Tus datos fueron actualizados correctamente.'
            })
            $("#btnGuardar").prop("disabled", false);
            $("#btnGuardar").text("Guardar cambios");
            actualizarInfoUsuario();
            llenarFormulario();
        }
    });
}

// función para actualizar la información del usuario en sesión en tiempo real
function actualizarInfoUsuario() {
    $.ajax({
        url: "../../../config/ajax/perfil.php?op=actualizarSession",
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data)
            // actualizar la imagen y el nombre del usuario en la cabecera
            $('.nombre_usuario').html('Hola, ' + capitalizarPalabras(data.nombres) + '.');
        }
    });
}

init();