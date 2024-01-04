<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--CONTROLADOR DE ACCESO-->


<!--El controlador de acceso procesa la información que llega de la vista/acceso.php
para decidir qué vista mostrar al usuario, según haya escogido la opción de acceder con login o registrarse-->

<?php

session_start();

//Incluyo los modelos
include_once '../model/Producto.php';
include_once '../model/Carrito.php';


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $modo = '';
    //Compruebo si ya hay creada una cookie para almacenar el modo
    if (!isset($_COOKIE['modo'])) {
        //Creo una cookie que almacena el modo día por defecto
        setcookie('modo', $modo, time() + 2592000); // Expira en 30 días
    }

    if (isset($_GET['dia'])) {

        $modo = 'dia';
    } elseif (isset($_GET['noche'])) {

        $modo = 'noche';
    }
    // Actualizo la cookie en caso de que haya habido cambios
    setcookie('modo', $modo, time() + 2592000);
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

        //Si existe la cookie del modo de navegación de mostrará una vista u otra
        /*
        if (
            $_COOKIE['modo'] == 'noche'
        ) {
            $estilos = '<link rel="stylesheet" type="text/css" href="../assets/estilos-noche.css">';
        } else {
            $estilos =
                '<link rel="stylesheet" type="text/css" href="../assets/estilos.css">';
        }*/

        include '../view/acceso.php';
    }
} else {

    //Una vez que el usuario ha iniciado sesión, paso el mando al controlador de tienda/carrito
    header('location:c.carrito.php');
}
