<!-- Font Awesome Icons -->
<script src="https://kit.fontawesome.com/4d529f15e3.js" crossorigin="anonymous"></script>

<!-- Core JS Files -->
<script src="../../assets/js/core/popper.min.js"></script>
<script src="../../assets/js/core/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- <script src="../../assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="../../assets/js/plugins/smooth-scrollbar.min.js"></script> -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="../../assets/js/argon-dashboard3.min.js?v=2.0.4"></script>
<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>

<script>
  // Obtener el estado del modo oscuro desde el Local Storage al cargar la página
  var darkVersionCheckbox = document.getElementById('dark-version');
  var $tr = $('#myTable thead tr');
  var darkModeEnabled = localStorage.getItem('darkModeEnabled');

  // paginador
  var $paginator = document.querySelector('.paginador');
  let links;
  if ($paginator) {
    links = $paginator.getElementsByClassName('page-btn');
  }

  function updateColorsPaginator() {
    if ($paginator != null) {
      for (var i = 0; i < links.length; i++) {
        if (!links[i].classList.contains('active-paginador')) {
          links[i].style.color = "#757575";
        }
      }
    }
  }

  document.addEventListener('DOMContentLoaded', function() {
    if (darkVersionCheckbox) {
      // El elemento existe, puedes realizar las operaciones relacionadas con él
      console.log(darkModeEnabled);
      if (darkModeEnabled === 'true') {
        darkVersionCheckbox.checked = true;
        darkMode(darkVersionCheckbox);
        $tr.removeClass('bg-white');
        $tr.addClass('dark-version');
        updateColorsPaginator();
      } else {
        darkVersionCheckbox.checked = false;
        $tr.removeClass('dark-version');
        $tr.addClass('bg-white');
        updateColorsPaginator();
      }

      darkVersionCheckbox.addEventListener('change', function() {
        if (this.checked) {
          $tr.removeClass('bg-white');
          $tr.addClass('dark-version');
          localStorage.setItem('darkModeEnabled', 'true');
          updateColorsPaginator();
        } else {
          $tr.removeClass('dark-version');
          $tr.addClass('bg-white');
          localStorage.setItem('darkModeEnabled', 'false');
          elementsidenavMain.classList.add("bg-white");
          updateColorsPaginator();
        }
      });
    }
  });
</script>

<script>
  function cabecera(el) {
    console.log(el);
    var $tr = $('#myTable thead tr');

    if ($(el).attr('checked')) {
      $tr.removeClass('bg-white');
      $tr.addClass('dark-version');
    } else {
      $tr.removeClass('dark-version');
      $tr.addClass('bg-white');
    }
  }
</script>

<script>
  var elementoMostrar1 = document.getElementById("mostrar-ajustes");
  var elementoMostrar2 = document.getElementById("mostrar-ajustes2");
  var elementoOcultar = document.getElementById("ocultar-ajustes");

  if (elementoMostrar1 !== null) {
    elementoMostrar1.addEventListener("click", function() {
      var elemento = document.getElementById("ajustes");
      if (elemento !== null) {
        elemento.classList.add("show");
      }
    });
  }

  if (elementoMostrar2 !== null) {
    elementoMostrar2.addEventListener("click", function() {
      var elemento = document.getElementById("ajustes");
      if (elemento !== null) {
        elemento.classList.add("show");
      }
    });
  }

  if (elementoOcultar !== null) {
    elementoOcultar.addEventListener("click", function() {
      var elemento = document.getElementById("ajustes");
      if (elemento !== null) {
        elemento.classList.remove("show");
      }
    });
  }

  var elementoNavbarSidenav = document.getElementById("iconNavbarSidenav");
  var elementoSidenav = document.getElementById("contain-body");
  var elementoSidenavIcon = document.getElementById("iconSidenav");
  var elementsidenavMain = document.getElementById("sidenav-main");

  if (elementoNavbarSidenav !== null && elementoSidenav !== null) {
    elementoNavbarSidenav.addEventListener("click", function() {
      if (elementoSidenav.classList.contains("g-sidenav-pinned")) {
        elementoSidenav.classList.add("g-sidenav-pinned");
        elementsidenavMain.classList.add("bg-white");
        if (darkVersionCheckbox != null) {
          if (darkVersionCheckbox.checked === true) {
            elementsidenavMain.classList.remove("bg-white"); // Remover la clase "bg-white" si existe
          } else {
            elementsidenavMain.classList.add("bg-white");
          }
        }
      } else {
        elementoSidenav.classList.remove("g-sidenav-pinned");
      }
    });
  }

  if (elementoSidenavIcon !== null && elementoSidenav !== null) {
    elementoSidenavIcon.addEventListener("click", function() {
      elementoSidenav.classList.remove("g-sidenav-pinned");
    });
  }
</script>

<script>
  function input_fecha(number) {
    switch (number) {
      case 1:
        var hoy = new Date();
        var fecha = hoy.getFullYear() + '-' + ('0' + (hoy.getMonth() + 1)).slice(-2) + '-' + ('0' + hoy.getDate()).slice(-2);
        var hora = ('0' + hoy.getHours()).slice(-2) + ':' + ('0' + hoy.getMinutes()).slice(-2);

        var fecha_hora = fecha + 'T' + hora;
        document.getElementById('fecha_hora').value = fecha_hora;
        break;
      case 2:
        var fecha = new Date();
        var mes = fecha.getMonth() + 1;
        var dia = fecha.getDate();
        var ano = fecha.getFullYear();
        if (dia < 10)
          dia = '0' + dia;
        if (mes < 10)
          mes = '0' + mes;
        document.getElementById('fecha').value = ano + "-" + mes + "-" + dia;
        break;
    }
  }
</script>

<script>
  function cambiarTitulo(nuevoTitulo) {
    document.title = nuevoTitulo;
  }
  // para buscar filas de la tabla.
  $(document).ready(function() {
    $("#txtBuscar").on("keyup", function() {
      var value = $(this).val().toLowerCase();

      var rowCount = 0; // Variable para contar las filas que coinciden con la búsqueda

      $("#myTable tbody tr").each(function() {
        var rowText = $(this).text().toLowerCase();
        $(this).toggle(rowText.indexOf(value) > -1);
        if ($(this).is(":visible")) {
          rowCount++;
        }
      });

      // Aquí eliminamos la fila de "#sin_resultados" si existe.
      $("#sin_resultados").remove();

      if (rowCount === 0 && value.length > 0) {
        var row = `
        <tr id="sin_resultados">
          <td colspan="16" class="align-middle text-sm text-center pt-3">
            Sin resultados.
          </td>
        </tr>
      `;
        $('#myTable tbody').append(row);
        document.getElementById("tabla").style.overflowY = "hidden";
      } else {
        document.getElementById("tabla").style.overflowY = "auto";
      }
    });
  });
</script>

<script>
  // para buscar cards y contenidos.
  $(document).ready(function() {
    $('#txtBuscar2').keyup(function() {
      var nombres = $('.titulo');
      var buscando = $(this).val().toLowerCase();
      for (var i = 0; i < nombres.length; i++) {
        item = $(nombres[i]).html().toLowerCase();
        for (var x = 0; x < item.length; x++) {
          if (buscando.length == 0 || item.indexOf(buscando) > -1) {
            $(nombres[i]).parents('.tarjetaGeneral').show();
          } else {
            $(nombres[i]).parents('.tarjetaGeneral').hide();
          }
        }
      }
      if (nombres.length == $('.tarjetaGeneral:hidden').length) {
        $('#noResults').show();
        $('.footer').hide();
      } else {
        $('#noResults').hide();
        $('.footer').show();
      }
    });
  });
</script>

<script>
  function changeValue(dropdown) {
    var option = dropdown.options[dropdown.selectedIndex].value,
      field = document.getElementById('num_documento');

    if (option == 'DNI') {
      $("#num_documento").val("");
      field.maxLength = 8;
    } else if (option == 'CEDULA') {
      $("#num_documento").val("");
      field.maxLength = 10;
    } else {
      $("#num_documento").val("");
      field.maxLength = 11;
    }
  }
</script>

<script>
  function capitalizarPalabras(palabra) {
    return palabra.charAt(0).toUpperCase() + palabra.slice(1);
  }

  function capitalizarTodasLasPalabras(palabra) {
    return palabra.toUpperCase();
  }
</script>

<script>
  function recortar(palabra) {
    let data = '' + palabra;
    if (data.length > 100) {
      return data.substring(0, 100) + '...';
    } else {
      return data;
    }
  }
</script>

<script>
  function recortar2(palabra) {
    let data = '' + palabra;
    if (data.length > 80) {
      return data.substring(0, 80) + '...';
    } else {
      return data;
    }
  }
</script>

<script>
  $("#logout").on('click', function(e) {
    $.post("../../ajax/logout.php?op=logout", function(e) {
      window.location.href = "../../config/logout.php";
    });
  })
</script>

</body>

</html>