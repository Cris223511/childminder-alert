// Mostramos el título del puesto en la vista.
const urlParams = new URLSearchParams(window.location.search);
const titulo = urlParams.get('titulo');

const tituloElement = document.getElementById("titulo-postulantes");
if (tituloElement) {
    tituloElement.innerHTML = `Postulantes del puesto: <strong>${capitalizarPalabras(titulo)}</strong>`;
}

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

let selectEvaluacionesData = "";

function selectEvaluaciones() {
    $.post("../../../config/ajax/postulantes.php?op=selectEvaluaciones", function (r) {
        console.log(r);
        selectEvaluacionesData = r;
    });
}

function listarPuestosActivos() {
    $.ajax({
        url: '../../../config/ajax/postulantes.php?op=listarPuestosActivos',
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
                data.forEach(function (puesto) {
                    var row = `
                        <tr>
                            <td>
                                <div class="d-flex px-2 py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <p class="text-xs  mb-0 ps-2">${capitalizarPalabras(puesto.titulo)}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="text-xs mb-0">${capitalizarPalabras(puesto.usuario)}</p>
                            </td>
                            <td>
                                <p class="text-xs mb-0">${puesto.empresa}</p>
                            </td>
                            <td>
                                <p class="text-xs mb-0">${recortar2(puesto.descripcion)}</p>
                            </td>
                            <td>
                                <p class="text-xs mb-0">${puesto.fecha_hora}.</p>
                            </td>
                            <td class="align-middle text-sm text-center">
                                <span class="badge badge-sm bg-gradient-success">
                                ${puesto.estado === 'publicado' ? 'Publicado' : 'Pendiente'}
                                </span>
                            </td>
                            <td class="align-middle text-sm">${puesto.botones}</td>
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

function listarPostulantesDePuesto() {
    // Intentamos recoger el id de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const idpuesto = urlParams.get('idpuesto');
    console.log("a mostrar =)")
    // si el "idpuesto" existe y es numérico, hago el POST para mostrar los datos, de lo contrario, no hace nada.
    if (idpuesto && !isNaN(idpuesto)) {
        $.post("../../../config/ajax/postulantes.php?op=listarPostulantesDePuesto", { idpuesto: idpuesto }, function (data, status) {

            $('#myTable tbody').empty();

            data = JSON.parse(data);
            console.log(data);

            if (data != false) {
                console.log("todo bien =), traigo datos!");
                data.forEach(function (postulante) {
                    var row = `
                        <tr>
                            <td>
                                <div class="d-flex px-2 py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <p class="text-xs  mb-0 ps-2">${capitalizarPalabras(postulante.nombres)}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="text-xs mb-0">${capitalizarPalabras(postulante.apellidos)}</p>
                            </td>
                            <td>
                                <p class="text-xs mb-0">${postulante.tipo_documento}</p>
                            </td>
                            <td>
                                <p class="text-xs mb-0">${postulante.num_documento}</p>
                            </td>
                            <td>
                                <p class="text-xs mb-0" style="color: #1171ef"><strong>${postulante.puntaje1}</strong> de 50 puntos.</p>
                            </td>
                            <td>
                                <p class="text-xs mb-0" style="color: #1171ef"><strong>${postulante.puntaje2}</strong> de 25 puntos.</p>
                            </td>
                            <td>
                                <p class="text-xs mb-0" style="color: #1171ef"><strong>${postulante.puntaje3}</strong> de 25 puntos.</p>
                            </td>
                            <td>
                                <div class="d-flex align-items-center justify-content-start">
                                    <span class="me-2 text-xs font-weight-bold">${postulante.puntaje_total}%</span>
                                    <div>
                                        <div class="progress">
                                            <div class="progress-bar ${postulante.puntaje_total >= 0 && postulante.puntaje_total <= 25 ? 'bg-gradient-danger' : (postulante.puntaje_total >= 26 && postulante.puntaje_total <= 50 ? 'bg-gradient-warning' : (postulante.puntaje_total >= 51 && postulante.puntaje_total <= 75 ? 'bg-gradient-primary' : (postulante.puntaje_total >= 76 && postulante.puntaje_total <= 100 ? 'bg-gradient-success' : '')))}" role="progressbar" aria-valuenow="${postulante.puntaje_total}" aria-valuemin="0" aria-valuemax="100" style="width: ${postulante.puntaje_total}%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-xs text-center mb-0">
                                <img src="../../../files/${postulante.imagen}" width="50px" height="50px" style="border-radius: 50%;" />
                            </td>
                            <td class="align-middle text-sm text-center">
                                <span class="badge badge-sm ${postulante.estado === 'finalizado' ? 'bg-gradient-primary' : (postulante.estado === 'aprobado' ? 'bg-gradient-success' : (postulante.estado === 'rechazado' ? 'bg-gradient-danger' : 'bg-gradient-warning'))}">
                                    ${postulante.estado === 'finalizado' ? 'Finalizado' : (postulante.estado === 'aprobado' ? 'Aprobado' : (postulante.estado === 'rechazado' ? 'Rechazado' : 'Pendiente'))}
                                </span>
                            </td>
                            <td class="align-middle text-sm">${postulante.botones}</td>
                        </tr>
                    `;

                    $('#myTable tbody').append(row);
                });
            } else {
                console.log("no hago nada tampoco =).");
                var row = `
                    <tr>
                        <td colspan="16" class="align-middle text-sm text-center pt-3">
                            Sin datos por mostrar.
                        </td>
                    </tr>
                `;
                $('#myTable tbody').append(row);
            }
        });
    } else {
        console.log("no hago nada =).")
        $('#myTable tbody').empty();
        var row = `
            <tr>
                <td colspan="16" class="align-middle text-sm text-center pt-3">
                    Sin datos por mostrar.
                </td>
            </tr>
        `;
        $('#myTable tbody').append(row);
    }
}

function mostrarDatosPostulante() {
    // Intentamos recoger el id de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const idpostulante = urlParams.get('idpostulante');
    console.log("a mostrar =)")

    $(".btnDescargar").css("color", "white")
        .css("opacity", 0.7)
        .css("cursor", "default")
        .text("Cargando...");

    $('.btnDescargar').click(function (e) {
        e.preventDefault();
    });

    // si el "idpostulante" existe y es numérico, hago el POST para mostrar los datos, de lo contrario, no hace nada.
    if (idpostulante && !isNaN(idpostulante)) {

        $.post("../../../config/ajax/postulantes.php?op=mostrarDatosPostulante", { idpostulante: idpostulante }, function (data, status) {
            data = JSON.parse(data);
            console.log(data);
            if (data != false) {
                if (data.archivo_cv == "") {
                    $(".btnDescargar")
                        .text("Sin datos");
                    $("#archivo_cvmuestra").attr('placeholder', 'Sin archivo por mostrar.');
                } else {
                    $(".btnDescargar").css("color", "white")
                        .css("opacity", 1)
                        .css("cursor", "pointer")
                        .attr("download", "")
                        .attr("href", "../../../files_cv/" + data.archivo_cv)
                        .text("Descargar CV")

                    $('.btnDescargar').off('click');
                    $("#archivo_cvmuestra").val(data.archivo_cv);
                }

                $("#imagenmuestra").attr("src", "../../../files/" + data.imagen);
                $("#imagenactual").val(data.imagen);
                $("#nombres").val(data.nombres);
                $("#apellidos").val(data.apellidos);
                $("#tipo_documento").val(data.tipo_documento);
                $("#tipo_documento").trigger("change");
                $("#num_documento").val(data.num_documento);
                $("#fecha_nac").val(data.fecha_nac);
                $("#genero").val(data.genero);
                $("#telefono").val(data.telefono);
                $("#email").val(data.email);
                $("#direccion").val(data.direccion);
                $("#titulo").val(data.titulo);
                $("#carrera").val(data.carrera);
                $("#descripcion").val(data.descripcion);
                $("#idiomas").val(data.idiomas);
                $("#sueldo_estimado").val(data.sueldo_estimado);
                $("#estudios").val(data.estudios);
                $("#conocimientos").val(data.conocimientos);
                $("#experiencias").val(data.experiencias);
            } else {
                console.log("no hago nada tampoco =).")
                $(".btnDescargar").css("color", "white")
                    .css("opacity", 0.7)
                    .css("cursor", "default")
                    .text("Sin datos");
            }
        })
    } else {
        console.log("no hago nada =).")
        $(".btnDescargar").css("color", "white")
            .css("opacity", 0.7)
            .css("cursor", "default")
            .text("Sin datos");
    }
}

/* ========================== CAMBIOS FINALES ========================== */

function rechazar(idpostulante, idpuesto, nombre) {
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
        title: 'Rechazar postulante',
        html: `
            <form id="rechazarForm">
                <h6>¿Estás seguro que deseas rechazar al postulante <strong>${nombre}</strong>?</h6>
                <div class="form-group">
                    <label for="titulo">Comentarios:</label>
                    <textarea class="swal-input form-control" name="comentario" id="comentario" rows="3" maxlength="500" placeholder="Ingrese un comentario indicando el motivo de su rechazo." required></textarea>
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
                'El postulante fue rechazado correctamente.',
                'success'
            );
            $(".botones button").prop("disabled", true);
            $(".botones button").css("color", "white");
            $.post("../../../config/ajax/postulantes.php?op=rechazarPostulante", { idpostulante: idpostulante, idpuesto: idpuesto, comentario: comentario }, function (e) {
                console.log("el servidor responde: " + e)
                /* ----------------- Y volvemos a listar =) ----------------- */
                listarPostulantesDePuesto();
            });
        }
    })
    document.getElementById("comentario").focus();
}

/* ========================== PUNTAJE 1 ========================== */

function puntaje(idpostulante, idpuesto) {
    $(".botones button").prop("disabled", true);
    $(".botones button").css("color", "white");

    $(".botones .puntaje_" + idpostulante).text("Calculando...");
    console.log(idpostulante, idpuesto)
    $.post("../../../config/ajax/postulantes.php?op=calcularPuntajeDelPostulante", { idpostulante: idpostulante, idpuesto: idpuesto }, function (data, status) {
        data = JSON.parse(data);
        console.log(data);
        listarPostulantesDePuesto();
    })
}

function aceptarSubfase1(idpostulante, idpuesto, nombre) {
    /* ----------------- Mostramos el modal =) ----------------- */
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn bg-gradient-success swal-confirm-button',
            cancelButton: 'btn bg-gradient-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Aprobar evaluación',
        html: "¿Estás seguro que deseas aprobar la evaluación de conocimientos del postulante <strong> " + nombre + "</strong>?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Aprobar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Aceptado.',
                'El postulante fue aprobado correctamente.',
                'success'
            );
            $(".botones button").prop("disabled", true);
            $(".botones button").css("color", "white");
            $.post("../../../config/ajax/postulantes.php?op=aceptarSubfase1", { idpostulante: idpostulante, idpuesto: idpuesto }, function (e) {
                console.log("el servidor responde: " + e)
                /* ----------------- Y volvemos a listar =) ----------------- */
                listarPostulantesDePuesto();
            });
        }
    })
}

/* ========================== PUNTAJE 2 ========================== */

function darEvalucion(idpostulante, idpuesto, nombre) {
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
        title: 'Asignar evaluación',
        html: `
            <form id="evaluacionForm">
                <h6>Selecciona la evaluación que desea asignar al postulante <strong>${nombre}</strong>.</h6>
                <div class="form-group">
                    <label for="titulo">Evaluaciones:</label>
                    <select class="form-control" name="idevaluacion" id="idevaluacion" required>
                        <option value="">- Seleccione -</option>
                    </select>
                </div>
            </form>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Asignar',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            const form = document.getElementById('evaluacionForm');
            if (!form.reportValidity()) {
                return false;
            }
            return true;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const idevaluacion = $('#idevaluacion').val();

            Swal.fire(
                'Asignado.',
                'La evaluación fue asignada al postulante correctamente.',
                'success'
            );
            $(".botones button").prop("disabled", true);
            $(".botones button").css("color", "white");
            $.post("../../../config/ajax/postulantes.php?op=asignarEvaluacionPostulante", { idpostulante: idpostulante, idpuesto: idpuesto, idevaluacion: idevaluacion }, function (e) {
                console.log("el servidor responde: " + e)
                /* ----------------- Y volvemos a listar =) ----------------- */
                listarPostulantesDePuesto();
            });
        }
    })
    $("#idevaluacion").html(selectEvaluacionesData);
    document.getElementById("idevaluacion").focus();
}

function mostrarRespuestasPostulante() {
    // Intentamos recoger el id de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const idpostulante = urlParams.get('idpostulante');
    const idpuesto = urlParams.get('idpuesto');

    // si el "idevaluacion" existe y es numérico, hago el POST para mostrar los datos en los form, de lo contrario, no hace nada.
    if (idpostulante && !isNaN(idpostulante) && idpuesto && !isNaN(idpuesto)) {
        $("#btnEvaluar").prop("disabled", true);
        $("#btnEvaluar").text("Cargando...").css("color", "white");

        $.post("../../../config/ajax/postulantes.php?op=mostrarRespuestasPostulante", { idpostulante: idpostulante, idpuesto: idpuesto }, function (data, status) {
            if (data != false) {
                console.log(data);
                let result = JSON.parse(data);
                console.log(result);
                $("#titulo").val(result.titulo);

                /* ================= Vamos a generar los texarea dinámicamente ================= */

                /* ----------------- Limpiamos el contenido ----------------- */

                $("#container").empty();

                /* ----------------- Parseamos el objeto y obtenemos su longitud ----------------- */

                let preguntas = JSON.parse(result.preguntas);
                let keys = Object.keys(preguntas);
                let longitud = keys.length;

                contador = longitud;
                limite = 100 - longitud;

                /* ----------------- Y recorremos el objeto y pintamos en pantalla =) ----------------- */

                for (let i = 0; i < longitud; i++) {
                    let key = keys[i];
                    let pregunta = preguntas[key];
                    let preguntasHTML = '';

                    if (i > 0 && i % 2 === 0) {
                        preguntasHTML += '<hr class="horizontal dark my-1 mb-2">'; // Agregar el <hr> después de cada segundo bucle
                    }

                    if (longitud > 1) {
                        console.log("tienes varios datos =)")
                        preguntasHTML += `
                            <div class="col-md-6 mb-3 agregado">
                                <div class="form-group">
                                    <label for="pregunta${pregunta.id}">Pregunta N° ${pregunta.id}:</label>
                                    <textarea class="form-control mb-2" id="pregunta${pregunta.id}" rows="2" maxlength="300" disabled>${pregunta.valor}</textarea>
                
                                    <label for="respuesta">Respuesta:</label>
                                    <textarea class="form-control" id="respuesta${pregunta.id}" rows="2" maxlength="300" disabled></textarea>
                                </div>
                            </div>
                        `;
                    } else {
                        console.log("tienes un dato =(")
                        preguntasHTML += `
                            <div class="col-md-12 mb-3 evaluacion-principal">
                                <div class="form-group">
                                    <label for="pregunta${pregunta.id}">Pregunta N° ${pregunta.id}:</label>
                                    <textarea class="form-control mb-2" id="pregunta${pregunta.id}" rows="2" maxlength="300" disabled>${pregunta.valor}</textarea>
                
                                    <label for="respuesta">Respuesta:</label>
                                    <textarea class="form-control" id="respuesta${pregunta.id}" rows="2" maxlength="300" disabled></textarea>
                                </div>
                            </div>
                        `;
                    }
                    $("#container").append(preguntasHTML);
                }

                let respuestas = result.respuestas;

                for (let key in respuestas) {
                    let respuesta = respuestas[key];
                    let preguntaId = respuesta.id;
                    let preguntaValor = respuesta.valor;
                    let inputId = "#respuesta" + preguntaId;

                    $(inputId).val(preguntaValor);
                }

                $(".agregado:first").addClass("evaluacion-principal");
                $(".agregado:first").removeClass("agregado");

                $("#btnEvaluar").prop("disabled", false);
                $("#btnEvaluar").text("Calificar");
            } else {
                console.log("no hago nada tampoco =).")
                $('#container').empty();
                var card = `
                    <h6 class="mb-4 fw-bold text-center">Sin datos por mostrar.</h6>
                `;
                $('#container').append(card);
                $("#btnEvaluar").prop("disabled", true);
                $("#btnEvaluar").text("Calificar");
            }
        });
    } else {
        console.log("no hago nada =).")
        $('#container').empty();
        var card = `
                    <h6 class="mb-4 fw-bold text-center">Sin datos por mostrar.</h6>
                `;
        $('#container').append(card);
        $("#btnEvaluar").prop("disabled", true);
        $("#btnEvaluar").text("Calificar");
    }
}

function calificarEvaluacionPostulante(e) {
    e.preventDefault();

    // Intentamos recoger el id de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const idpostulante = urlParams.get('idpostulante');
    const idpuesto = urlParams.get('idpuesto');

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
        title: 'Calificar evaluación',
        html: `
            <form id="rechazarForm">
                <h6>Coloque una calificación entre 0 y 25 puntos.</h6>
                <div class="form-group">
                    <label for="titulo">calificación:</label>
                    <input class="form-control" type="number" name="puntaje2" id="puntaje2" min="0" max="99" 
                        onkeydown="if (event.key === '-') event.preventDefault();"
                        oninput="javascript: 
                            if (this.value > 25 || this.value < 0) this.value = this.value.slice(0, this.value.length - 1);
                            if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                        maxlength="2" onpaste="return false;" onDrop="return false;" placeholder="Ingrese la calificación." required/>
                </div>
            </form>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Calificar',
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
            const puntaje2 = $('#puntaje2').val();

            Swal.fire(
                'Calificado.',
                'El postulante fue calificado correctamente.',
                'success'
            );
            $("#btnEvaluar").prop("disabled", true);
            $("#btnEvaluar").text("Cargando...").css("color", "white");
            $.post("../../../config/ajax/postulantes.php?op=aceptarSubfase2", { idpostulante: idpostulante, idpuesto: idpuesto, puntaje2: puntaje2 }, function (e) {
                console.log("el servidor responde: " + e)
                /* ----------------- Y volvemos a listar =) ----------------- */
                mostrarRespuestasPostulante();
            });
        }
    })
    document.getElementById("puntaje2").focus();
}

/* ========================== PUNTAJE 3 ========================== */

function reunionZoom(idpostulante, idpuesto, nombre) {
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
        title: 'Enviar reunión',
        html: `
            <form id="rechazarForm">
                <h6>Adjunte el enlace zoom o meet de su reunión para el postulante <strong>${nombre}</strong></h6>
                <div class="form-group">
                    <label for="titulo">Enlace de reunión:</label>
                    <textarea class="swal-input form-control" name="reunion" id="reunion" rows="3" maxlength="500" placeholder="Ingrese el enlace de su reunión." required></textarea>
                </div>
            </form>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Enviar',
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
            const reunion = $('#reunion').val();

            Swal.fire(
                'Enviado.',
                'El enlace de su reunión fue enviado correctamente.',
                'success'
            );
            $(".botones button").prop("disabled", true);
            $(".botones button").css("color", "white");
            $.post("../../../config/ajax/postulantes.php?op=enviarEnlacePostulante", { idpostulante: idpostulante, idpuesto: idpuesto, reunion: reunion }, function (e) {
                console.log("el servidor responde: " + e)
                /* ----------------- Y volvemos a listar =) ----------------- */
                listarPostulantesDePuesto();
            });
        }
    })
    document.getElementById("reunion").focus();
}

function calificarEntrevista(idpostulante, idpuesto) {
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
        title: 'Calificar entrevista',
        html: `
            <form id="rechazarForm">
                <h6>Coloque una calificación entre 0 y 25 puntos.</h6>
                <div class="form-group">
                    <label for="titulo">calificación:</label>
                    <input class="form-control" type="number" name="puntaje3" id="puntaje3" min="0" max="99" 
                        onkeydown="if (event.key === '-') event.preventDefault();"
                        oninput="javascript: 
                            if (this.value > 25 || this.value < 0) this.value = this.value.slice(0, this.value.length - 1);
                            if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                        maxlength="2" onpaste="return false;" onDrop="return false;" placeholder="Ingrese la calificación." required/>
                </div>
            </form>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Calificar',
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
            const puntaje3 = $('#puntaje3').val();

            Swal.fire(
                'Calificado.',
                'El postulante fue calificado correctamente.',
                'success'
            );
            $(".botones button").prop("disabled", true);
            $(".botones button").css("color", "white");
            $.post("../../../config/ajax/postulantes.php?op=aceptarSubfase3", { idpostulante: idpostulante, idpuesto: idpuesto, puntaje3: puntaje3 }, function (e) {
                console.log("el servidor responde: " + e)
                /* ----------------- Y volvemos a listar =) ----------------- */
                listarPostulantesDePuesto();
            });
        }
    })
    document.getElementById("puntaje3").focus();
}

/* ========================== SELECCIONADOS ========================== */

function seleccionarPostulante(idpostulante, idpuesto, nombre) {
    /* ----------------- Mostramos el modal =) ----------------- */
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn bg-gradient-success swal-confirm-button',
            cancelButton: 'btn bg-gradient-danger'
        },
        buttonsStyling: false
    })

    swalWithBootstrapButtons.fire({
        title: 'Seleccionar postulante?',
        html: "¿Estás seguro que deseas seleccionar al postulante <strong> " + nombre + "</strong> para este puesto de trabajo?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Seleccionar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Seleccionado.',
                'El postulante fue seleccionado correctamente.',
                'success'
            );
            $(".botones button").prop("disabled", true);
            $(".botones button").css("color", "white");
            $.post("../../../config/ajax/postulantes.php?op=seleccionarPostulante", { idpostulante: idpostulante, idpuesto: idpuesto }, function (e) {
                console.log("el servidor responde: " + e)
                /* ----------------- Y volvemos a listar =) ----------------- */
                listarPostulantesDePuesto();
            });
        }
    })
}