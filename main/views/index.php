<?php
ob_start();
if (strlen(session_id()) < 1)
  session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="apple-touch-icon" sizes="76x76" href="../img/logo2.png">
  <link rel="icon" type="image/png" href="../img/logo2.png">

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" asp-append-version="true">
  <link href="../vendor/animate.css/animate.min.css" rel="stylesheet" asp-append-version="true">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" asp-append-version="true">
  <link href="../vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" asp-append-version="true">
  <link href="../vendor/boxicons/css/boxicons.min.css" rel="stylesheet" asp-append-version="true">
  <link href="../vendor/glightbox/css/glightbox.min.css" rel="stylesheet" asp-append-version="true">
  <link href="../vendor/remixicon/remixicon.css" rel="stylesheet" asp-append-version="true">
  <link href="../vendor/swiper/swiper-bundle.min.css" rel="stylesheet" asp-append-version="true">

  <!-- Template Main CSS File -->
  <link href="../css/style9.css" rel="stylesheet" asp-append-version="true">
  <link href="../css/main.css" rel="stylesheet" asp-append-version="true">
  <!-- avoid cache -->
  <meta http-equiv="Expires" content="0">
  <meta http-equiv="Last-Modified" content="0">
  <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <title>Childminder Alert | Inicio</title>
</head>

<body>

  <!-- ======= Top Bar ======= -->
  <div id="topbar" class="d-flex align-items-center position-sticky sticky-top">
    <div class="container d-flex justify-content-between">
      <div class="contact-info d-flex align-items-center">
        <i class="bi bi-envelope"></i> <a href="mailto:childminderCompany@hotmail.com">childminder-company@hotmail.com</a>
        <i class="bi bi-phone"></i> <a href="whatsapp://send?text=¡Hola!, mucho gusto 🤝, me interesa saber más información 🙂.&phone=+51 973 182 294">+51
          973 182 294</a>
      </div>
      <div class="d-none d-lg-flex social-links align-items-center">
        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
      </div>
    </div>
  </div>

  <!-- ======= Header ======= -->
  <header id="header" class="position-sticky sticky-top">
    <div class="container d-flex align-items-center">

      <h1 class="logo me-auto" style="font-weight: 900 !important;"><a>Childminder<span>Alert</span></a></h1>

      <nav id="navbar" class="navbar order-last order-lg-0" style="box-shadow: none !important">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Inicio</a></li>
          <li><a class="nav-link scrollto" href="#about">Nosotros</a></li>
          <li><a class="nav-link scrollto" href="#services">Servicios</a></li>
          <li><a class="nav-link scrollto" href="#objetivos">Objetivos</a></li>
          <li><a class="nav-link scrollto" href="#contact">Contacto</a></li>
          <li><a class="nav-link scrollto" href="signUp.php">Regístrate</a></li>
          <li class="login"><a class="nav-link scrollto" href="signIn.php">Iniciar Sesión</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
      <a href="signIn.php" class="appointment-btn scrollto"><span>Iniciar Sesión</span></a>
    </div>
  </header><!-- End Header -->

  <!--sección loader Start-->
  <div class="preloader">
    <img src="../img/logo2.png" class="imagen" width="30%">
  </div>
  <!-- sección loader End -->

  <!-- sección cookies Start -->
  <div class="cookies">
    <div class="principal d-flex flex-sm-row flex-column">
      <div class="uno d-flex flex-sm-row flex-column col-sm-8 col-12 justify-content-between pb-sm-0 pb-3">
        <i class="fa-sharp fa-solid fa-cookie-bite d-flex align-items-center justify-content-center pr-sm-4 pb-sm-0 pb-2 pr-0"></i>
        <p class="pr-2 text-sm-start text-center">
          En <span class="bold-text">Childminder Alert</span> queremos que tengas la mejor experiencia posible,
          por eso utilizamos cookies para personalizar contenidos y mejorar la navegación. Para más
          información, lea nuestra política de cookies <span class="bold-text"><a href="https://privacy.microsoft.com/es-es/privacystatement" target="_blank">aquí.</a></span>
        </p>
      </div>
      <div class="dos d-flex col-sm-4 col-12 flex-lg-row flex-sm-column flex-row justify-content-lg-end justify-content-center align-items-center">
        <button class="btn1 pr-lg-4 pr-sm-0 pr-4 pb-lg-0 pb-sm-2 pb-0">No, gracias</button>
        <button type="button" class="btn2">Aceptar las cookies</button>
      </div>
    </div>
  </div>
  <!-- sección cookies End -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">
    <div class="container">
      <h1>Pasos al aprendizaje</h1>
      <h2>Una alarma inteligente para afrontar el TDAH.</h2>
      <a href="#about" class="btn-get-started scrollto">Introducción</a>
    </div>
  </section><!-- End Hero -->

  <main id="main">
    <!-- ======= Why Us Section ======= -->
    <section id="why-us" class="why-us">
      <div class="container">

        <div class="row">
          <div class="col-lg-4 d-flex align-items-stretch">
            <div class="content">
              <h3 class="text-white">¿Por qué elegir Childminder Alert?</h3>
              <p>
                Elegir Childminder Alert significa optar por una solución innovadora y empática diseñada para mejorar la
                independencia y la calidad de vida de los niños con TDAH. Nuestra alarma inteligente ofrece
                recordatorios amigables y la seguridad que los padres necesitan. Confía en nosotros para brindar
                tranquilidad y apoyo a tu familia.
              </p>
              <div class="text-center">
                <a href="#about" class="more-btn">Leer más <i class="bx bx-chevron-right"></i></a>
              </div>
            </div>
          </div>
          <div class="col-lg-8 d-flex align-items-stretch">
            <div class="icon-boxes d-flex flex-column justify-content-center">
              <div class="row">
                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box mt-4 mt-xl-0">
                    <i class="bx bx-receipt"></i>
                    <h4>Empatía</h4>
                    <p>
                      Mostramos una profunda comprensión y sensibilidad hacia las necesidades de los niños y
                      adolescentes con TDAH y sus cuidadores.
                    </p>
                  </div>
                </div>
                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box mt-4 mt-xl-0">
                    <i class="bx bx-cube-alt"></i>
                    <h4>Confianza</h4>
                    <p>
                      Nos esforzamos por ganarnos la confianza de los padres y cuidadores al proporcionar una alarma
                      inteligente confiable y efectiva.
                    </p>
                  </div>
                </div>
                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box mt-4 mt-xl-0">
                    <i class="bx bx-images"></i>
                    <h4>Innovación</h4>
                    <p>
                      Estamos comprometidos con la constante búsqueda de nuevas formas de ayudar a los niños con TDAH a
                      llevar una vida más independiente y organizada.
                    </p>
                  </div>
                </div>
              </div>
            </div><!-- End .content-->
          </div>
        </div>

      </div>
    </section><!-- End Why Us Section -->
    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container-fluid">

        <div class="row">
          <div class="col-xl-5 col-lg-6 video-box d-flex justify-content-center align-items-stretch position-relative">
          </div>

          <div class="col-xl-7 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5">
            <h3>Nosotros</h3>
            <p>
              En Childminder Alert, somos un grupo de personas apasionadas por la tecnología y la empatía. Nuestra
              diversidad de habilidades, incluyendo programación y diseño, se combina para crear soluciones innovadoras
              que hacen que la vida de los niños con TDAH sea más fácil y satisfactoria. Estamos dedicados a marcar la
              diferencia y brindar apoyo a las familias que confían en nosotros.
            </p>

            <div class="icon-box">
              <div class="icon"><i class="bx bx-fingerprint"></i></div>
              <h4 class="title"><a>Tecnología Innovadora</a></h4>
              <p class="description">
                Nuestra alarma inteligente incorpora tecnología de vanguardia para proporcionar recordatorios precisos y
                monitoreo de las pulsaciones cardíacas, mejorando así la calidad de vida de los niños con TDAH.
              </p>
            </div>

            <div class="icon-box">
              <div class="icon"><i class="bx bx-gift"></i></div>
              <h4 class="title"><a>Accesibilidad</a></h4>
              <p class="description">
                Nos esforzamos por hacer que nuestras soluciones sean accesibles y fáciles de usar para todos,
                garantizando que los niños y sus cuidadores puedan aprovechar al máximo nuestra alarma.
              </p>
            </div>

            <div class="icon-box">
              <div class="icon"><i style="margin-left: 5px; margin-bottom: 4px;" class="fa-solid fa-puzzle-piece"></i>
              </div>
              <h4 class="title"><a>Apoyo a la Independencia</a></h4>
              <p class="description">
                Promovemos la independencia de los niños con TDAH al brindarles las herramientas necesarias para llevar
                a cabo sus actividades diarias de manera autónoma, al tiempo que ofrecemos tranquilidad a los padres y
                cuidadores.
              </p>
            </div>

          </div>
        </div>

      </div>
    </section><!-- End About Section -->
    <!-- ======= Counts Section ======= -->
    <section id="counts" class="counts">
      <div class="container">

        <div class="row">

          <div class="col-lg-3 col-md-6">
            <div class="count-box">
              <i class="fa-solid fa-child"></i>
              <div class="d-flex justify-content-center">
                <span>+</span>
                <span data-purecounter-start="0" data-purecounter-end="350" data-purecounter-duration="5" class="purecounter"></span>
              </div>
              <p>Niños beneficiados</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 mt-5 mt-md-0">
            <div class="count-box">
              <i class="fa-solid fa-shield-heart"></i>
              <div class="d-flex justify-content-center">
                <span>+</span>
                <span data-purecounter-start="0" data-purecounter-end="400" data-purecounter-duration="5" class="purecounter"></span>
              </div>
              <p>Satisfacción de los usuarios</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
            <div class="count-box">
              <i class="fa-solid fa-handshake"></i>
              <span data-purecounter-start="0" data-purecounter-end="20" data-purecounter-duration="5" class="purecounter"></span>
              <p>Colaboración con especialistas</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
            <div class="count-box">
              <i class="fas fa-award"></i>
              <span data-purecounter-start="0" data-purecounter-end="12" data-purecounter-duration="5" class="purecounter"></span>
              <p>Premios o reconocimientos</p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Counts Section -->
    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container">

        <div class="section-title">
          <h2>Servicios</h2>
          <p>
            Nuestro propósito es mejorar la vida de los niños y adolescentes con TDAH y sus cuidadores a través de
            servicios especializados. En Childminder Alert, nos enfocamos en proporcionar soluciones tecnológicas
            innovadoras que facilitan la gestión diaria de esta condición y promueven la autonomía de nuestros usuarios.
          </p>
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
            <div class="icon-box">
              <div class="icon"><i class="fa-solid fa-bell"></i></div>
              <h4><a href="">Recordatorios personalizados</a></h4>
              <p>
                Ofrecemos recordatorios intuitivos y personalizados para actividades diarias, adaptados a las
                necesidades individuales de cada niño con TDAH.
              </p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
            <div class="icon-box">
              <div class="icon"><i class="fa-brands fa-searchengin"></i></div>
              <h4><a href="">Monitoreo de bienestar</a></h4>
              <p>
                Nuestra alarma inteligente monitoriza las pulsaciones cardíacas de manera discreta, proporcionando
                información valiosa sobre el estado de salud y bienestar de los niños.
              </p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4">
            <div class="icon-box">
              <div class="icon"><i class="fa-solid fa-envelope-open-text"></i></div>
              <h4><a href="">Soporte y asistencia</a></h4>
              <p>
                Brindamos asistencia continua y soporte técnico para garantizar que nuestros usuarios aprovechen al
                máximo nuestra tecnología y se sientan respaldados.
              </p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Services Section -->

    <!-- ======= Departments Section ======= -->
    <section id="objetivos" class="departments">
      <div class="container">

        <div class="section-title">
          <h2>Objetivos</h2>
        </div>

        <div class="row gy-4">
          <div class="col-lg-3">
            <ul class="nav nav-tabs flex-column">
              <li class="nav-item">
                <a class="nav-link active show" data-bs-toggle="tab" href="#tab-1" style="background-color: transparent !important;">Visión</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#tab-2" style="background-color: transparent !important;">Misión</a>
              </li>
            </ul>
          </div>
          <div class="col-lg-9">
            <div class="tab-content">
              <div class="tab-pane active show" id="tab-1">
                <div class="row gy-4">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <h3>Visión</h3>
                    <p class="fst-italic mb-3 subtitle">Nuestra aspiración es superarnos constantemente.</p>
                    <p>
                      Buscamos ser reconocidos como líderes en el apoyo a niños y adolescentes con TDAH, ofreciendo
                      soluciones que no solo sean efectivas, sino que también marquen la diferencia en sus vidas y en el
                      mercado. Buscamos marcar la diferencia en el mercado, ofreciendo soluciones que permitan a los niños
                      con TDAH llevar una vida más organizada y satisfactoria.
                    </p>
                  </div>
                  <div class="col-lg-4 text-center order-1 order-lg-2">
                    <img src="../img/img-3.jpg" alt="" class="img-fluid">
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="tab-2">
                <div class="row gy-4">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <h3>Misión</h3>
                    <p class="fst-italic mb-3 subtitle">Nos comprometemos a brindar el mejor apoyo.</p>
                    <p>
                      Ofrecemos atención integral y especializada a niños y adolescentes con TDAH, así como a sus
                      familias. A través de la innovación, la educación continua y la inclusión social, trabajamos
                      incansablemente para mejorar la calidad de vida de nuestros usuarios y asegurar que nadie se quede
                      sin el apoyo que necesita.
                    </p>
                  </div>
                  <div class="col-lg-4 text-center order-1 order-lg-2">
                    <img src="../img/img-4.jpg" alt="" class="img-fluid">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>

    <!-- sección testimonios Start -->
    <section id="testimonios" class="testimonios">
      <div class="section-title">
        <h2>Testimonios</h2>
      </div>
      <div class="container">
        <div class="testimonios-slider swiper" data-aos="fade-up" data-aos-delay="100">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <div class="testimonial-wrap">
                <div class="testimonial-item">
                  <img src="../img/testimonials-1.jpeg" class="testimonial-img">
                  <h3>María Lopez C.</h3>
                  <h4>Madre de familia</h4>
                  <p>
                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                    Childminder Alert ha aliviado nuestras preocupaciones diarias. Mi hijo con TDAH se siente más seguro y capaz de gestionar su rutina gracias a esta alarma. Ha mejorado su independencia y autoconfianza.
                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                  </p>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="testimonial-wrap">
                <div class="testimonial-item">
                  <img src="../img/testimonials-2.jpg" class="testimonial-img">
                  <h3>Mateo Serna B.</h3>
                  <h4>Psicólogo</h4>
                  <p>
                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                    Como profesional de la salud mental, recomiendo Childminder Alert a las familias de mis pacientes con TDAH. La tecnología de monitoreo y los recordatorios personalizados son una combinación poderosa para mejorar la calidad de vida de los niños.
                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                  </p>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="testimonial-wrap">
                <div class="testimonial-item">
                  <img src="../img/testimonials-3.jpg" class="testimonial-img">
                  <h3>Eduardo Mario G.</h3>
                  <h4>Psicólogo</h4>
                  <p>
                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                    Childminder Alert se ha convertido en una herramienta esencial en mi trabajo con niños con TDAH. Facilita la transición entre actividades y permite una mayor participación en el aprendizaje. Es un recurso valioso en el aula.
                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                  </p>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="testimonial-wrap">
                <div class="testimonial-item">
                  <img src="../img/testimonials-4.jpg" class="testimonial-img">
                  <h3>Christian Bernal H.</h3>
                  <h4>Padre de familia</h4>
                  <p>
                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                    Childminder Alert ha hecho una gran diferencia en la vida de mi hijo. Los recordatorios personalizados y el monitoreo de sus pulsaciones cardíacas nos han ayudado a establecer una rutina efectiva y a reducir la ansiedad. Estamos muy agradecidos
                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                  </p>
                </div>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="testimonial-wrap">
                <div class="testimonial-item">
                  <img src="../img/testimonials-5.jpg" class="testimonial-img">
                  <h3>Alessio Ferrera N.</h3>
                  <h4>Educador</h4>
                  <p>
                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                    Como maestra de un niño con TDAH, he visto de cerca el impacto positivo de Childminder Alert en el aula. La alarma ayuda a mantener al niño enfocado en las actividades escolares y promueve su independencia. ¡Es una herramienta valiosa.
                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-pagination"></div>
        </div>
      </div>
    </section>
    <!-- sección testimonios End -->

    <!-- ======= Departments Section ======= -->
    <section id="galleria" class="galleria">
      <div class="section-title">
        <h2>Galería</h2>
        <p>
          Presentamos algunos avances de nuestro prototipo.
        </p>
      </div>
      <div class="container pt-4">
        <div class="row g-0 gallery-container">
          <div class="col-lg-4 col-md-4 col-sm-4 d-none">
            <div class="galleria-item">
              <a href="../img/alert-1.jpeg" class="galleria-lightbox">
                <img src="../img/alert-1.jpeg" class="img-fluid">
              </a>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 d-none">
            <div class="galleria-item">
              <a href="../img/alert-2.jpeg" class="galleria-lightbox">
                <img src="../img/alert-2.jpeg" class="img-fluid">
              </a>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 d-none">
            <div class="galleria-item">
              <a href="../img/alert-3.jpeg" class="galleria-lightbox">
                <img src="../img/alert-3.jpeg" class="img-fluid">
              </a>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 d-none">
            <div class="galleria-item">
              <a href="../img/alert-4.jpeg" class="galleria-lightbox">
                <img src="../img/alert-4.jpeg" class="img-fluid">
              </a>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 d-none">
            <div class="galleria-item">
              <a href="../img/alert-5.jpeg" class="galleria-lightbox">
                <img src="../img/alert-5.jpeg" class="img-fluid">
              </a>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 d-none">
            <div class="galleria-item">
              <a href="../img/alert-6.jpeg" class="galleria-lightbox">
                <img src="../img/alert-6.jpeg" class="img-fluid">
              </a>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 d-none">
            <div class="galleria-item">
              <a href="../img/alert-7.jpeg" class="galleria-lightbox">
                <img src="../img/alert-7.jpeg" class="img-fluid">
              </a>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 d-none">
            <div class="galleria-item">
              <a href="../img/alert-8.jpeg" class="galleria-lightbox">
                <img src="../img/alert-8.jpeg" class="img-fluid">
              </a>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 d-none">
            <div class="galleria-item">
              <a href="../img/alert-9.jpeg" class="galleria-lightbox">
                <img src="../img/alert-9.jpeg" class="img-fluid">
              </a>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 d-none">
            <div class="galleria-item">
              <a href="../img/alert-10.jpeg" class="galleria-lightbox">
                <img src="../img/alert-10.jpeg" class="img-fluid">
              </a>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 d-none">
            <div class="galleria-item">
              <a href="../img/alert-11.jpeg" class="galleria-lightbox">
                <img src="../img/alert-11.jpeg" class="img-fluid">
              </a>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 d-none">
            <div class="galleria-item">
              <a href="../img/alert-12.jpeg" class="galleria-lightbox">
                <img src="../img/alert-12.jpeg" class="img-fluid">
              </a>
            </div>
          </div>
          <div class="col-lg-4 col-md-4 col-sm-4 d-none">
            <div class="galleria-item">
              <a href="../img/alert-13.jpeg" class="galleria-lightbox">
                <img src="../img/alert-13.jpeg" class="img-fluid">
              </a>
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-center gap-3">
          <button class="btn btn-primary boton_ver_mas">Ver más</button>
          <button class="btn btn-primary boton_ver_menos d-none">Ver menos</button>
        </div>
      </div>
    </section>

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container">
        <div class="section-title">
          <h2>Contacto</h2>
          <p>Si quieres contactarte con nosotros, te presentamos a continuación nuestros medios de contacto.
          </p>
        </div>
      </div>
      <div>
        <iframe style="border:0; width: 100%; height: 350px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15606.292929944639!2d-76.951602!3d-12.0728573!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9105c6fadcaf64a7%3A0x91a8066253ed53de!2sUniversidad%20San%20Ignacio%20de%20Loyola%20(USIL)!5e0!3m2!1ses-419!2spe!4v1696620195498!5m2!1ses-419!2spe" width="600" height="450" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" frameborder="0"></iframe>
      </div>
      <div class="container">
        <div class="row info mt-5" style="background-color: transparent !important;">
          <div class="col-lg-4 pb-2 d-flex justify-content-sm-start justify-content-lg-center align-items-center align-content-center">
            <div class="address" style="margin: 0 !important;">
              <i class="bi bi-geo-alt"></i>
              <h4>Ubicación:</h4>
              <p>Av. La Fontana 550, La Molina Location, La Molina.</p>
            </div>
          </div>
          <div class="col-lg-4 pb-2 d-flex justify-content-sm-start justify-content-lg-center align-items-center align-content-center">
            <div class="email" style="margin: 0 !important;">
              <i class="bi bi-envelope"></i>
              <h4>Correo:</h4>
              <p><a href="mailto:childminder-company@hotmail.com">childminder-company@hotmail.com</a></p>
            </div>
          </div>
          <div class="col-lg-4 pb-2 d-flex justify-content-sm-start justify-content-lg-center align-items-center align-content-center">
            <div class="phone" style="margin: 0 !important;">
              <i class="bi bi-phone"></i>
              <h4>Teléfono:</h4>
              <p><a href="whatsapp://send?text=¡Hola Childminder Alert!, me interesa saber más información de tu producto 🙂.&phone=+51 973 182 294">+51
                  973 182 294</a></p>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->
  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-contact">
            <h3>Childminder Alert</h3>
            <p>
              Av. La Fontana 550, La Molina Location, La Molina.<br>
              <strong>Teléfono:</strong> <a href="whatsapp://send?text=¡Hola!, mucho gusto 🤝, me interesa saber más información 🙂.&phone=+51 973 182 294">+51
                973 182 294</a><br>
              <strong>Correo:</strong> <a href="mailto:childminder-company@hotmail.com">childminder-company@hotmail.com</a><br>
            </p>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Enlaces</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#hero">Inicio</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#about">Nosotros</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#services">Servicios</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#objetivos">Objetivos</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#contact">Contacto</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Aplicativo</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="signIn.php">Iniciar Sesión</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="signUp.php">Registrarse</a></li>
            </ul>
          </div>

          <div class="col-lg-4 col-md-6 footer-newsletter">
            <h4>Contácate con nosotros</h4>
            <p>Envíanos un correo electrónico para que nos llegue tu solicitud.</p>
            <form action="" method="">
              <input type="email" name="email" autocomplete="off" required><input type="submit" value="Enviar">
            </form>
          </div>

        </div>
      </div>
    </div>

    <div class="container d-md-flex py-4">

      <div class="me-md-auto text-center text-md-start">
        <div class="copyright">
          &copy; 2023 <strong><span>Childminder Alert</span></strong>. Todos los derechos reservados.
        </div>
      </div>
      <div class="social-links text-center text-md-right pt-3 pt-md-0">
        <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
        <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
        <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../js/main.js"></script>
  <script src="../js/index4.js"></script>
</body>

</html>

<?php
ob_end_flush();
?>