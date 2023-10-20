<?php
session_start(); // Iniciamos la sesión existente.
session_unset(); // Luego eliminamos las variables de sesión.
session_destroy(); // Luego destruimos la sesión.
header('Location: ../assets/views/auth/signIn.php'); // Y por último nos redirigimos a la página de inicio de sesión.
exit();
