<?php

session_start();

if (isset($_SESSION['id_usuario'])) {
    echo 'La sesion está inciciada ' . $_SESSION['nombre'] . '. El ID es ' .
        $_SESSION['id_usuario'];
} else {
    echo 'La sesión NO está iniciada';
}

echo '<br>';
if (!isset($_COOKIE['nombre_invitado']) && !isset($_COOKIE['carrito_invitado'])) {
    echo 'Las COOKIES NO están creadas';
} else {
    echo 'Las COOKIES están creadas ' . $_COOKIE['nombre_invitado'];
    echo 'Las COOKIES están creadas ' . $_COOKIE['carrito_invitado'];
}
