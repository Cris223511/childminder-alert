$("#frmAcceso").on('submit', function (e) {
    e.preventDefault();
    $("#btnGuardar").prop("disabled", true);

    usuario = $("#usuario").val();
    clave = $("#clave").val();

    $.post('../../../config/ajax/usuarios.php?op=verificar', { "usuario": usuario, "clave": clave },
        function (data) {
            console.log(data);
            var parsedData = JSON.parse(data);
            console.log(parsedData);
            if (parsedData != false) {
                Swal.fire({
                    icon: 'success',
                    title: 'Acceso correcto',
                    text: 'Te estamos redireccionando al sistema, espere un momento...'
                })
                setTimeout(function () {
                    $(location).attr("href", "../../../assets/views/home/dashboard.php");
                }, 2500);
            } else {
                $("#btnGuardar").prop("disabled", false);
                Swal.fire({
                    icon: 'error',
                    title: 'Sin acceso',
                    text: 'Usuario y/o contraseña incorrectos.',
                })
            }
        });
})