<?php
$nombre_usuario = 'Pepe';
$productos_carrito_invitado = array();
$carrito_invitado = serialize($productos_carrito_invitado);
setcookie('nombre_invitado', $nombre_usuario, time() - 3600, "/");
setcookie('carrito_invitado', $carrito_invitado, time() - 3600, "/");
