<?php

if (!isset($_SESSION['nombre'])) {
    echo 'La sesión NO está iniciada';
} else {
    echo 'La sesion está inciciada ' . $_SESSION['nombre'] . '. El ID es ' .
        $_SESSION['id_usuario'];
}
echo '<br>';
if (!isset($_COOKIE['nombre_invitado']) && !isset($_COOKIE['carrito_invitado'])) {
    echo 'Las COOKIES NO están creadas';
} else {
    echo 'Las COOKIES están creadas ' . $_COOKIE['nombre_invitado'];
    echo 'Las COOKIES están creadas ' . $_COOKIE['carrito_invitado'];
}
