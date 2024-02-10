<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--CONTROLADOR DE ACCESO PRINCIPAL-->

<!--El controlador de acceso procesa la información que llega de la vista/acceso.php
para decidir a qué controlador dirigir al usuario, según la opción de acceso que seleccione: login, registro o invitado-->

<?php

//Inicio sesión
session_start();

//USUARIO SIN SESIÓN INICIADA PERO CON COOKIES (INVITADO)
//Si no hay sesión pero hay cookies de invitado creadas, redirige al controlador de tiendaInvitado
if (!isset($_SESSION['nombre']) && isset($_COOKIE['nombre_invitado'])) {

    header('location:invitado/c.tiendaInvitado.php');

    //USUARIO SIN SESIÓN INICIADA NI COOKIES
    //Si no hay un sesión creada y si no se ha seleccionado una opción de acceso muestro el menú de acceso principal
} elseif (!isset($_SESSION['nombre'])) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        //ACCESO COMO USUARIO REGISTRADO
        if (isset($_POST['login'])) {
            header('location:c.login.php');

            //ACCESO POR REGISTRO
        } elseif (isset($_POST['registro'])) {
            header('location:c.registro.php');

            //ACCESO INVITADO
        } elseif (isset($_POST['invitado']) && !isset($_COOKIE['nombre_invitado'])) {

            //Creo cookies de invitado para almacenar nombre y un array para el carrito
            //Uso el método trim() para eliminar espacios en blanco al principio y final del nombre
            $nombre_usuario = trim($_POST['nombre_invitado']);
            $productos_carrito_invitado = array();
            //Utilizo la función serialize() para poder introducir la información del array en la cookie
            $carrito_invitado = serialize($productos_carrito_invitado);
            setcookie('nombre_invitado', $nombre_usuario, time() + 3600 * 24 * 30, "/");
            setcookie('carrito_invitado', $carrito_invitado, time() + 3600 * 24 * 30, "/");
            //Redirecciono hacia el controlador de tienda de invitado
            header('location:invitado/c.tiendaInvitado.php');

            //Los datos de invitado permanecerán en el navegador del cliente 
            //mientras no se borren las cookies o hasta que expiren después de 30 días desde la última actualización del carrito
        }
    } else {

        include '../view/acceso.php';
    }

    //USUARIO CON SESIÓN INICIADA

} else {

    //Una vez que el usuario ha iniciado sesión, paso el mando al controlador de tienda
    header('location:c.tienda.php');
}

//Si el usuario con sesión iniciada cierra la sesión, se muestra a la página de acceso principal
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['salir'])) {

        session_destroy();
        include '../view/acceso.php';
    }
}
