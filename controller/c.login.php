<!--PROYECTO EXAMEN DESARROLLO ENTORNO SERVIDOR - TIENDA ONLINE - CORAL GUTIÉRREZ SÁNCHEZ-->
<!--CONTROLADOR DE LOGIN-->

<?php
//El controlador de login valida y procesa los datos del formulario que viene de la vista de usuario view/login.php
//Después devuelve la vista correspondiente, es decir, de nuevo la vista de login con errores si hay fallos
//en el proceso de autenticación o, si accede con éxito, redirige al controlador de tienda para mostrar la vista de tienda.

//Iniciamos la sesión de usuario
session_start();

//Incluyo los modelos que voy a necesitar
include_once '../model/Usuario.php';

//Creo variables globales de sesión 
if (!isset($_SESSION['id_usuario'])) {
    $_SESSION['id_usuario'] = null;
}

if (!isset($_SESSION['nombre'])) {
    $_SESSION['nombre'] = null;
}

if (!isset($_SESSION['email'])) {
    $_SESSION['email'] = null;
}

//Creo array de mensajes al usuario y enlace de volver
$mensajes = array();
$enlace_volver = '';

//Si exiten cookies, el enlace 'volver' del formulario redirige a la tienda de invitado, si no, al acceso principal
if (!empty($_COOKIE['nombre_invitado'])) {
    $enlace_volver = '<a href="invitado/c.tiendaInvitado.php">Volver</a>';
} else {
    $enlace_volver = '<a href="c.index.php">Volver</a>';
}

//Si se ha enviado el formulario y he recibido los datos por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['submit'])) {
        //Uso el método trim() para eliminar espacios en blanco al principio y final de los datos
        $email = trim($_POST['email']);
        $contrasenia = trim($_POST['pass']);

        //Valido si los campos de email y password están vacíos
        if (!empty($email) && !empty($contrasenia)) {

            //Compruebo que la contraseña introducida coincide con el hash asignado en BD, según el email
            $datos_validos = Usuario::comprobarContraseniaHash($contrasenia, $email);

            if ($datos_validos) {

                //Si el email y la contraseña son correctos, recorro datos de usuario y asigno a variables globables de sesión
                $datos_usuario = Usuario::mostrarDatosUsuario($email);
                foreach ($datos_usuario as $dato) {
                    $_SESSION['id_usuario'] = $dato->getIdUsuario();
                    $_SESSION['nombre'] = $dato->getNombreUsuario();
                    $_SESSION['email'] = $dato->getEmail();
                }
                //Toma el mando el controlador de tienda para mostrarle los datos y vista de la tienda
                header('location:c.tienda.php');
            } else {
                //De lo contrario, lanzo un mensaje de error
                $mensajes[] = '¡El usuario o la contraseña no son válidos!';
            }
        } else if (empty($email) && empty($contrasenia)) {
            $mensajes[] = '¡Por favor, introduce tu email y contraseña!';
        }
    }
}

//MUESTRO LA INFORMACIÓN EN LA VISTA EN CASO DE QUE HAYA HABIDO ALGÚN ERROR
//Si el proceso se ha completado correctamente, se habría redirigido al usuario a c.tienda.php

include_once '../view/login.php';
