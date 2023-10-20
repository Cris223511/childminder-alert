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

let idevaluacion = '';
let titulo = '';
let preguntas = {};
let fecha_hora = '';

function obtenerDatos() {
    if (document.getElementById("idevaluacion")) {
        idevaluacion = document.getElementById("idevaluacion").value;
    }

    titulo = document.getElementById("titulo").value;

    $("#fecha_hora").prop("disabled", false);
    fecha_hora = document.getElementById("fecha_hora").value;
    $("#fecha_hora").prop("disabled", true);

    preguntas = {};

    let campos = document.querySelectorAll("textarea");
    campos.forEach(function (textarea) {
        let id = textarea.id.replace("pregunta", "");
        preguntas[id] = { id: id, valor: textarea.value };
    });

    console.log(idevaluacion);
    console.log(titulo);
    console.log(preguntas);
    console.log(fecha_hora);
}

function agregar(e) {
    e.preventDefault();
    $("#btnGuardar").prop("disabled", true);
    $("#btnGuardar").text("Agregando...").css("color", "white");
    obtenerDatos();

    $.ajax({
        url: "../../../config/ajax/evaluaciones.php?op=agregaryeditar",
        type: "POST",
        data: { idevaluacion: idevaluacion, titulo: titulo.toString(), preguntas: JSON.stringify(preguntas), fecha_hora: fecha_hora.toString() },
        success: function (data) {
            console.log(data);
            limpiar();
            Swal.fire({
                icon: 'success',
                title: 'Evaluación registrada',
                text: 'La evaluación fue registrada correctamente, yendo a la página principal...'
            })
            $("#btnGuardar").prop("disabled", false);
            $("#btnGuardar").text("Agregar");

            setTimeout(function () {
                $(location).attr("href", "../../../assets/views/evaluaciones/evaluaciones.php");
            }, 2500);
        }
    });
}

function editar(e) {
    e.preventDefault();
    $("#btnGuardar").prop("disabled", true);
    $("#btnGuardar").text("Cargando...").css("color", "white");
    obtenerDatos();

    $.ajax({
        url: "../../../config/ajax/evaluaciones.php?op=agregaryeditar",
        type: "POST",
        data: { idevaluacion: idevaluacion, titulo: titulo.toString(), preguntas: JSON.stringify(preguntas), fecha_hora: fecha_hora.toString() },
        success: function (data) {
            console.log(data);
            limpiar();
            Swal.fire({
                icon: 'success',
                title: 'Evaluación actualizada',
                text: 'La evaluación fue actualizada correctamente.'
            })

            $(".botones").remove();
            $(".contenedor").empty();
            $(".contenedor").append(`<h6 class="mb-4 fw-bold text-center">Cargando preguntas...</h6>`);

            $("#btnGuardar").prop("disabled", false);
            $("#btnGuardar").text("Agregar");

            mostrar();
        }
    });
}

function mostrar() {
    // Intentamos recoger el id de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const idevaluacion = urlParams.get('idevaluacion');

    // si el "idevaluacion" existe y es numérico, hago el POST para mostrar los datos en los form, de lo contrario, no hace nada.
    if (idevaluacion && !isNaN(idevaluacion)) {
        $("#btnGuardar").prop("disabled", true);
        $("#btnGuardar").text("Cargando...").css("color", "white");

        $.post("../../../config/ajax/evaluaciones.php?op=mostrar", { idevaluacion: idevaluacion }, function (data, status) {
            data = JSON.parse(data);
            console.log(data);
            console.log(JSON.parse(data.preguntas));
            if (data != null) {
                $("#idevaluacion").val(data.idevaluacion);
                $("#titulo").val(data.titulo);
                $("#fecha_hora").val(data.fecha_hora);

                /* ================= Vamos a generar los texarea dinámicamente ================= */

                /* ----------------- Limpiamos el contenido ----------------- */

                $("#container").empty();

                /* ----------------- Parseamos el objeto y obtenemos su longitud ----------------- */

                let preguntas = JSON.parse(data.preguntas);
                let keys = Object.keys(preguntas);
                let longitud = keys.length;

                contador = longitud;
                limite = 100 - longitud; // actualizo el límite.

                /* ----------------- Y recorremos el objeto y pintamos en pantalla =) ----------------- */

                for (let i = 0; i < longitud; i++) {
                    let key = keys[i];
                    let pregunta = preguntas[key];
                    let preguntasHTML = '';

                    if (longitud > 1) {
                        console.log("tienes varios datos =)")
                        preguntasHTML += `
                            <div class="col-md-6 mb-2 agregado">
                                <div class="form-group">
                                    <label for="pregunta${pregunta.id}">Pregunta N° ${pregunta.id}:</label>
                                    <textarea class="form-control" id="pregunta${pregunta.id}" rows="2" maxlength="300" placeholder="Ingrese su pregunta." required>${pregunta.valor}</textarea>
                                </div>
                            </div>
                        `;
                        var botonesHTML = `
                            <div class="col-md-12 mb-2 d-flex justify-content-center gap-2 botones">
                                <a onclick="addDynamicTextArea()" class="badge badge-sm text-white bg-gradient-success agregar"><i class="fa fa-plus py-2"></i></a>
                                <a onclick="removeDynamicTextArea()" class="badge badge-sm text-white bg-gradient-danger eliminar"><i class="fa fa-trash py-2"></i></a>
                            </div>
                        `;
                    } else {
                        console.log("tienes un dato =(")
                        preguntasHTML += `
                            <div class="col-md-12 mb-2 evaluacion-principal">
                                <div class="form-group">
                                    <label for="pregunta${pregunta.id}">Pregunta N° ${pregunta.id}:</label>
                                    <textarea class="form-control" id="pregunta${pregunta.id}" rows="2" maxlength="300" placeholder="Ingrese su pregunta." required>${pregunta.valor}</textarea>
                                </div>
                            </div>
                        `;
                        var botonesHTML = `
                            <div class="col-md-12 mb-2 d-flex justify-content-center gap-2 botones">
                                <a onclick="addDynamicTextArea()" class="badge badge-sm text-white bg-gradient-success agregar"><i class="fa fa-plus py-2"></i></a>
                                <a onclick="removeDynamicTextArea()" class="badge badge-sm text-white bg-gradient-danger eliminar d-none"><i class="fa fa-trash py-2"></i></a>
                            </div>
                        `;
                    }

                    $("#container").append(preguntasHTML);
                }

                $(botonesHTML).insertAfter("#container");

                $(".agregado:first").addClass("evaluacion-principal");
                $(".agregado:first").removeClass("agregado");

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

function mostrarDetalles() {
    // Intentamos recoger el id de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const idevaluacion = urlParams.get('idevaluacion');

    // si el "idevaluacion" existe y es numérico, hago el POST para mostrar los datos en los form, de lo contrario, no hace nada.
    if (idevaluacion && !isNaN(idevaluacion)) {
        $("#btnGuardar").prop("disabled", true);
        $("#btnGuardar").text("Cargando...").css("color", "white");

        $.post("../../../config/ajax/evaluaciones.php?op=mostrar", { idevaluacion: idevaluacion }, function (data, status) {
            data = JSON.parse(data);
            console.log(data);
            console.log(JSON.parse(data.preguntas));
            if (data != null) {
                $("#idevaluacion").val(data.idevaluacion);
                $("#titulo").val(data.titulo);
                $("#fecha_hora").val(data.fecha_hora);

                /* ================= Vamos a generar los texarea dinámicamente ================= */

                /* ----------------- Limpiamos el contenido ----------------- */

                $("#container").empty();

                /* ----------------- Parseamos el objeto y obtenemos su longitud ----------------- */

                let preguntas = JSON.parse(data.preguntas);
                let keys = Object.keys(preguntas);
                let longitud = keys.length;

                contador = longitud;
                limite = 100 - longitud;

                /* ----------------- Y recorremos el objeto y pintamos en pantalla =) ----------------- */

                for (let i = 0; i < longitud; i++) {
                    let key = keys[i];
                    let pregunta = preguntas[key];
                    let preguntasHTML = '';

                    if (longitud > 1) {
                        console.log("tienes varios datos =)")
                        preguntasHTML += `
                            <div class="col-md-6 mb-2 agregado">
                                <div class="form-group">
                                    <label for="pregunta${pregunta.id}">Pregunta N° ${pregunta.id}:</label>
                                    <textarea class="form-control" id="pregunta${pregunta.id}" rows="2" maxlength="300" disabled>${pregunta.valor}</textarea>
                                </div>
                            </div>
                        `;
                    } else {
                        console.log("tienes un dato =(")
                        preguntasHTML += `
                            <div class="col-md-12 mb-2 evaluacion-principal">
                                <div class="form-group">
                                    <label for="pregunta${pregunta.id}">Pregunta N° ${pregunta.id}:</label>
                                    <textarea class="form-control" id="pregunta${pregunta.id}" rows="2" maxlength="300" disabled>${pregunta.valor}</textarea>
                                </div>
                            </div>
                        `;
                    }
                    
                    // Modelo de preguntas con respuestas.

                    // if (longitud > 1) {
                    //     console.log("tienes varios datos =)")
                    //     preguntasHTML += `
                    //         <div class="col-md-6 agregado">
                    //             <div class="form-group mb-2">
                    //                 <label for="pregunta${pregunta.id}">Pregunta N° ${pregunta.id}:</label>
                    //                 <textarea class="form-control" id="pregunta${pregunta.id}" rows="2" maxlength="300" disabled>${pregunta.valor}</textarea>

                    //                 <label for="respuesta">Respuesta:</label>
                    //                 <textarea class="form-control" rows="2" maxlength="300" disabled></textarea>
                    //             </div>
                    //         </div>
                    //     `;
                    // } else {
                    //     console.log("tienes un dato =(")
                    //     preguntasHTML += `
                    //         <div class="col-md-12 evaluacion-principal">
                    //             <div class="form-group mb-2">
                    //                 <label for="pregunta${pregunta.id}">Pregunta N° ${pregunta.id}:</label>
                    //                 <textarea class="form-control" id="pregunta${pregunta.id}" rows="2" maxlength="300" disabled>${pregunta.valor}</textarea>

                    //                 <label for="respuesta">Respuesta:</label>
                    //                 <textarea class="form-control" rows="2" maxlength="300" disabled></textarea>
                    //             </div>
                    //         </div>
                    //     `;
                    // }

                    $("#container").append(preguntasHTML);
                }

                $(".agregado:first").addClass("evaluacion-principal");
                $(".agregado:first").removeClass("agregado");

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
        url: '../../../config/ajax/evaluaciones.php?op=listar',
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
                data.forEach(function (evaluacion) {
                    var row = `
                        <tr>
                            <td>
                                <div class="d-flex px-2 py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <p class="text-xs  mb-0 ps-2">${capitalizarPalabras(evaluacion.usuario)}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="text-xs mb-0">${evaluacion.rol}</p>
                            </td>
                            <td>
                                <p class="text-xs mb-0">${capitalizarPalabras(evaluacion.titulo)}</p>
                            </td>
                            <td>
                                <p class="text-xs mb-0">${evaluacion.fecha_hora}</p>
                            </td>
                            <td class="align-middle text-sm">${evaluacion.botones}</td>
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

function eliminar(idevaluacion) {
    /* ----------------- Mostramos el modal =) ----------------- */
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn bg-gradient-success swal-confirm-button',
            cancelButton: 'btn bg-gradient-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: '¿Eliminar evaluación?',
        html: '¿Estás seguro que deseas eliminar a la evaluación? Recuerda que esta acción es irreversible.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Eliminado',
                'La evaluación fue eliminada correctamente.',
                'success'
            );

            $(".botones button").prop("disabled", true);
            $(".botones button").css("color", "white");

            $.post("../../../config/ajax/evaluaciones.php?op=eliminar", { idevaluacion: idevaluacion }, function (e) {
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