<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--CONTROLADOR COOKIES-->

<!--El controlador de cookies crea las cookies cuando el usuario accede como invitado desde acceso.php-->

<?php

if (!isset($_COOKIE['nombre_invitado']) && !isset($_COOKIE['carrito_invitado'])) {

    $nombre_usuario = $_POST['nombre_invitado'];
    $carrito_invitado = array();
    setcookie('nombre_invitado', $nombre_usuario, time() + 3600, "/");
    setcookie('carrito_invitado', serialize($carrito_invitado), time() + 3600, "/");
} else {
    $nombre_usuario = $_COOKIE['nombre_invitado'];
    $carrito_invitado = $_COOKIE['carrito_invitado'];
}
