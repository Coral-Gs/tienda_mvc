<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--CONTROLADOR DE ACCESO-->


<!--El controlador de acceso procesa la información que llega de la vista/acceso.php
para decidir qué vista mostrar al usuario, según haya escogido la opción de acceder con login o registrarse-->

<?php

session_start();

//Incluyo los modelos
include_once '../model/Producto.php';
include_once '../model/Carrito.php';

//Si el usuario cierra la sesión se redirige a la página de acceso principal
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['salir'])) {

        session_destroy();
        header('location:../view/acceso.php');
    }
}

//USUARIO SIN SESIÓN INICIADA PERO CON COOKIES (INVITADO)
//Si no hay sesión creada pero hay cookies de invitado, redirige al controlador de tiendaInvitado
if (!isset($_SESSION['nombre']) && isset($_COOKIE['nombre_invitado'])) {


    header('location:c.tiendaInvitado.php');


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
            $nombre_usuario = $_POST['nombre_invitado'];
            $productos_carrito_invitado = array();
            $carrito_invitado = serialize($productos_carrito_invitado);
            setcookie('nombre_invitado', $nombre_usuario, time() + 3600 * 24 * 30, "/");
            setcookie('carrito_invitado', $carrito_invitado, time() + 3600 * 24 * 30, "/");
            //Toma el mando el controlador de tienda de invitado
            header('location:c.tiendaInvitado.php');
        }
    } else {

        include '../view/acceso.php';
    }

    //USUARIO CON SESIÓN INICIADA

} else {

    //Una vez que el usuario ha iniciado sesión, paso el mando al controlador de tienda/carrito
    header('location:c.tienda.php');
}
