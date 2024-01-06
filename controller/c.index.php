<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--CONTROLADOR DE ACCESO-->


<!--El controlador de acceso procesa la información que llega de la vista/acceso.php
para decidir qué vista mostrar al usuario, según haya escogido la opción de acceder con login o registrarse-->

<?php

session_start();

//Incluyo los modelos
include_once '../model/Producto.php';
include_once '../model/Carrito.php';

//Si el usuario la cierra con el botón salir se redirige a la página de acceso
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['salir'])) {

        session_destroy();
        header('location:../view/acceso.php');
    }
}

//Si no hay un sesión creada y si no se ha seleccionado una opción muestro el menú de acceso principal
if (!isset($_SESSION['nombre'])) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        //ACCESO COMO USUARIO REGISTRADO
        if (isset($_POST['login'])) {
            include '../view/login.php';

            //ACCESO POR REGISTRO
        } elseif (isset($_POST['registro'])) {
            include '../view/registro.php';
        }
    } else {

        include '../view/acceso.php';
    }
} else {

    //Una vez que el usuario ha iniciado sesión, paso el mando al controlador de tienda/carrito
    header('location:c.tienda.php');
}

/* METER COOKIES AQUÍ

/*
if (!isset($_SESSION['nombre'] && !isset($_COOKIE['nombre_invitado']) {

    $nombre_usuario = $_POST['nombre_invitado'];
    $carrito_invitado = array();
    setcookie('nombre_invitado', $nombre_usuario, time() + 3600, "/");
    setcookie('carrito_invitado', serialize($carrito_invitado), time() + 3600, "/");
    header('location:');
} else {
    $nombre_usuario = $_COOKIE['nombre_invitado'];
    $carrito_invitado = $_COOKIE['carrito_invitado'];
}
*/
